<?php
error_reporting(0);

require_once "func.php";

require_once "websockets.php";

class Server extends WebSocketServer
{
    private $_connecting = 'Connecting to server..';
    private $_welcome = 'Hello, welcome to edge client server!';
	
    private $lastMsgArray = array();
    
    protected function connected($user)
    {
        $this->SendStatusToClient($user);
    }    
    
    protected function processFromServer($message) {
    	try {
	    	// parse xml document
	    	$xml = simplexml_load_string($message);
	    	// convert xml object to array 
	        $msgArr = json_decode(json_encode($xml), TRUE);
	        
	        $timestamp = $msgArr['@attributes']['timestamp'];
	        // 1. login ok response
	        if ($msgArr['@attributes']['status'] == "loginok") {
	        	$this->isLogin = true;
	        	foreach ($this->users as $user) {
	        		$this->SendStatusToClient($user);
	        	}
	        	$this->DoMessageLog("LoginOk", $timestamp);
	        	file_put_contents("loginuser", $this->loginUserId); 
	        	
	        	// find rows for winner is null
	        	$sql = "SELECT EventID FROM edgeclient.SessionLogs where winner is null";
	        	$res = db_fetch($sql);
	        	$eventIdList = array();
	        	foreach ($res as $row) {
	        		$eventIdList[] = $row['EventID'];
	        		
	        	}
	        	$eventIdS = implode(",", $eventIdList);
	        	
	        	// send meta request to server
	        	$metaXML = '<UserStatus type="meta" userid="' .$this->loginUserId. '" eventIds="'.$eventIdS.'"></UserStatus>';
    			fwrite($this->serverSocket, $metaXML, strlen($metaXML));
	        } 
	        // 2. login failed response
	        else if ($msgArr['@attributes']['status'] == "loginfailed"){
	        	$this->isLogin = false;
	        	foreach ($this->users as $user) {
	        		$this->SendStatusToClient($user);
	        	}
	        	$this->DoMessageLog("LoginFailed", $timestamp);
	        } 
	        // 3. logout response
	        else if ($msgArr['@attributes']['status'] == "logout"){
	        	$this->isLogin = false;
	        	foreach ($this->users as $user) {
	        		$this->SendStatusToClient($user);
	        	}
	        	$this->DoMessageLog("LogOut", $timestamp);
	        } 
	        // 4. alive message
	        else if (substr($message, 1, 5) == "Alive") {
	        	echo "Alive message received\n";
	        	$this->DoMessageLog("Alive", $timestamp);
	        	
	        	$eventList = $msgArr['Event'];
	        	foreach ($eventList as $eventInfo) {
	        		$sessionId = $eventInfo['@attributes']['sessionid'];
	        		$eventId = $eventInfo['@attributes']['eventid'];
	        		$betStatus = $eventInfo['@attributes']['BetStatus'];
	        		$eventStatus = $eventInfo['@attributes']['EventStatus'];
	        		$activeStatusId = $eventInfo['@attributes']['activestatusid'];
	        		
	        		$sql = "update SessionLogs set EventStatus = '{$eventStatus}', BetStatus= '{$betStatus}', ActiveStatus = '{$activeStatusId}' where EventID = '{$eventId}'";
	        		db_query($sql);
	        	}
	        }
	        // 5. meta message
	        else if (substr($message, 1, 4) == "Meta") {
	        	echo "Meta message received\n";
	        	$this->DoMessageLog("Meta", $timestamp);
	        	
	        	$eventList = $msgArr['Event'];
	        	foreach ($eventList as $eventInfo) {
	        		$sessionId = $eventInfo['@attributes']['sessionid'];
	        		$eventId = $eventInfo['@attributes']['eventid'];
	        		$betStatus = $eventInfo['@attributes']['BetStatus'];
	        		$eventStatus = $eventInfo['@attributes']['EventStatus'];
	        		$winner = $eventInfo['@attributes']['Winner'];
	        		//$activeStatusId = $eventInfo['@attributes']['activestatusid'];
	        		
	        		$sql = "update SessionLogs set EventStatus = '{$eventStatus}', BetStatus= '{$betStatus}', Winner='{$winner}' where EventID = '{$eventId}'";
	        		db_query($sql);
	        	}
	        }
	        // 6. create session 
	        else if (substr($message, 1, 13) == "CreateSession") {
	        	echo "CreateSession message received\n";
	        	$this->DoMessageLog("CreateSession", $timestamp);
	        	db_query("update SessionLogs set ActiveStatus = 0 ");
	        	
	        	$eventList = $msgArr['Event'];
	        	
	        	foreach ($eventList as $eventInfo) {
	        		$sessionId = $eventInfo['@attributes']['sessionid'];
	        		$eventId = $eventInfo['@attributes']['eventid'];
	        		$betStatus = $eventInfo['@attributes']['BetStatus'];
	        		$eventStatus = $eventInfo['@attributes']['EventStatus'];
	        		$sessioncreated = $eventInfo['@attributes']['sessioncreated'];
	        		$activeStatusId = $eventInfo['@attributes']['activestatusid'];
	        		$Opponent1 = $eventInfo['@attributes']['Opponent1'];
	        		$Opponent2 = $eventInfo['@attributes']['Opponent2'];
	        		$OddsA = $eventInfo['@attributes']['OddsA'];
	        		$OddsB = $eventInfo['@attributes']['OddsB'];
	        		$SlotID = $eventInfo['@attributes']['SlotID'];
	        		
	        		$sql = "insert into SessionLogs set EventStatus = '{$eventStatus}', BetStatus= '{$betStatus}', ActiveStatus = '{$activeStatusId}'
	        			, SessionCreated = '{$sessioncreated}', SessionID='{$sessionId}',  EventID = '{$eventId}', 
	        			OddsA = '{$OddsA}', OddsB = '{$OddsB}', Opponent1 = '{$Opponent1}', Opponent2 = '{$Opponent2}', SlotID = '{$SlotID}'";
	        		db_query($sql);
	        	}
	        	
	        	$this->SendEventRefreshToClient();
	        }
	        // 7. bet stop
    		else if (substr($message, 1, 7) == "BetStop") {
	        	echo "BetStop message received\n";
	        	$this->DoMessageLog("BetStop", $timestamp);
	        	
	        	$eventInfo = $msgArr['Event'];
	        	$sessionId = $eventInfo['@attributes']['sessionid'];
        		$eventId = $eventInfo['@attributes']['eventid'];
        		$betStatus = $eventInfo['@attributes']['BetStatus'];
        		$eventStatus = $eventInfo['@attributes']['EventStatus'];
        		$sql = "update SessionLogs set EventStatus = '{$eventStatus}', BetStatus= '{$betStatus}' where EventID = '{$eventId}'";
        		
        		$this->SendEventRefreshToClient();
        		
	        }
    		// 8. event start
    		else if (substr($message, 1, 10) == "EventStart") {
	        	echo "EventStart message received\n";
	        	$this->DoMessageLog("EventStart", $timestamp);
	        	
	        	$eventInfo = $msgArr['Event'];
	        	$sessionId = $eventInfo['@attributes']['sessionid'];
        		$eventId = $eventInfo['@attributes']['eventid'];
        		$betStatus = $eventInfo['@attributes']['BetStatus'];
        		$eventStatus = $eventInfo['@attributes']['EventStatus'];
        		$sessioncreated = $eventInfo['@attributes']['sessioncreated'];
        		$eventStart = $eventInfo['@attributes']['eventstart'];
        		$sql = "update SessionLogs set EventStatus = '{$eventStatus}', BetStatus= '{$betStatus}', SessionCreated = '{$sessioncreated}', EventStart='{$eventStart}'  where EventID = '{$eventId}'";
        		db_query($sql);
        		
        		$this->SendEventRefreshToClient();
        		$this->SendBetSlipConfirmToClient();
	        }
    		// 9. EventStop
    		else if (substr($message, 1, 9) == "EventStop") {
	        	echo "EventStop message received\n";
	        	$this->DoMessageLog("EventStop", $timestamp);
	        	
	        	$eventInfo = $msgArr['Event'];
	        	$sessionId = $eventInfo['@attributes']['sessionid'];
        		$eventId = $eventInfo['@attributes']['eventid'];
        		$betStatus = $eventInfo['@attributes']['BetStatus'];
        		$eventStatus = $eventInfo['@attributes']['EventStatus'];
        		$winner = $eventInfo['@attributes']['Winner'];
        		$sql = "update SessionLogs set EventStatus = '{$eventStatus}', BetStatus= '{$betStatus}', Winner='{$winner}' where EventID = '{$eventId}'";
        		db_query($sql);
        		
        		$this->SendEventRefreshToClient();
        		$this->SendBetConfirmToClient();
	        }
    		// 10. BetCancel
    		else if (substr($message, 1, 9) == "BetCancel") {
	        	echo "BetCancel message received\n";
	        	$this->DoMessageLog("BetCancel", $timestamp);
	        	
	        	$this->SendEventRefreshToClient();
	        }
	        /*array_unshift($this->lastMsgArray, htmlspecialchars($message));
	        if (count($this->lastMsgArray) > 10) array_pop($this->lastMsgArray);
	        
	        $lastMsgCont = "<LastMessage>";
	        $lastMsgCont .= implode($this->lastMsgArray, "<br/><br/>");
	        $lastMsgCont .= "</LastMessage>";
    		foreach ($this->users as $user) {
	        	$this->send($user, $lastMsgCont);
	        }*/
	        
    	} catch (Exception $e) {
    	}
        
    }
    
    protected function process($user, $message)
    {	
        /*
    	// parse xml document
    	$xml = simplexml_load_string($message);
    	// convert xml object to array 
        $msgArr = json_decode(json_encode($xml), TRUE);
        
    	// 1. login request
        if ($msgArr['@attributes']['type'] == "login") {
        	echo "request login message\n";
        	$userId = $msgArr['@attributes']['userid'];
        	$userKey = $msgArr['@attributes']['key'];
        	
        	$this->loginUserId = $userId;
        	$this->loginUserKey = $userKey;
        	
        	$this->SendLoginToServer();
        } 
        // 2. meta request 
        else if ($msgArr['@attributes']['type'] == "meta") {
        	if ($this->isLogin) {
        		echo "request meta message\n";
        		$metaXML = '<UserStatus type="meta" userid="' .$this->loginUserId. '"></UserStatus>';
    			fwrite($this->serverSocket, $metaXML, strlen($metaXML));
        	}
        }
        // 3. logout 
        else if ($msgArr['@attributes']['type'] == "logout") {
        	if ($this->isLogin) {
        		echo "request logout message\n";
        		$logoutXML = '<UserStatus type="logout" userid="' .$this->loginUserId. '"></UserStatus>';
    			fwrite($this->serverSocket, $logoutXML, strlen($logoutXML));
        	}
        }*/
    	//echo $message;
    	$reqObj = json_decode($message);
    	if ($reqObj->Type == "AddBetSlip") {
    		$user->AddBetSlip($reqObj->EventID, $reqObj->PlayerID);
    		echo "Request AddBetSlip\n";
    		$this->send($user, $msg);
    	}
    }
	
    protected function closed($user)
    {
    }
	
    // run every 10 seconds
    protected function alivetimer() {
    	$sql = "SELECT SessionLogs.sessionid, SessionLogs.eventid, BetStatus.BetStatus, EventStatus.EventStatus, SessionLogs.activestatusid
			FROM SessionLogs INNER JOIN
			EventStatus ON SessionLogs.eventstatusid = EventStatus.EventStatusID INNER JOIN
			BetStatus ON SessionLogs.betstatusid = BetStatus.BetStatusID
			where ActiveStatusID = 1
		";
    	$list = db_fetch($sql);
    	
    	$timestamp = time();
    	$returnXML = '<Alive timestamp="'.$timestamp.'">';
    	foreach ($list as $eventInfo) {
    		$returnXML .= '<Event sessionid="'.$eventInfo['sessionid'].'" eventid="'.$eventInfo['eventid'].'" BetStatus="'.$eventInfo['BetStatus'].'" EventStatus="'.$eventInfo['EventStatus'].'" activestatusid="'.$eventInfo['activestatusid'].'"/>';	
    	}
    	$returnXML .= "</Alive>";
    	
    	$sentCnt = 0;
    	foreach ($this->myusers as $user) {
    		$this->send($user, $returnXML);
    		$sentCnt++;
    	}
    	echo "Sent alive message to {$sentCnt} users.\n";
    }
    
    public function SendLoginToServer() {
    	
	  	$loginXML = '<UserStatus timestamp="0" type="login" userid="'.$this->loginUserId.'" key="'.$this->loginUserKey.'"></UserStatus>';
	  	fwrite($this->serverSocket, $loginXML, strlen($loginXML));
	  	echo "Sent login message to server\n";
    }
    
    private function SendStatusToClient($user) {
    	global $serverAddr;
    	$msg = "<ServerStatus>";
    	$msg .= "Server IP : ".$serverAddr."<br/>";
    	$msg .= "Server Status : ";
    	if ($this->serverSocket!=null) {
    		$msg .="Running<br/>";
    	} else {
    		$msg .="Not Running<br/>";
    	}
    	$msg .= "User Logined : ";
    	if ($this->isLogin) {
    		$msg .= "Logined ($this->loginUserId)<br/>";
    	} else {
    		$msg .= "Not Logined<br/>";
    	}
    	$msg .= "</ServerStatus>";
    	$this->send($user, $msg);
    } 
    private function SendEventRefreshToClient() {
    	$msg = "<RefreshEventList></RefreshEventList>";
    	foreach ($this->users as $user) {
        	$this->send($user, $msg);
        }
    }
	private function SendBetConfirmToClient() {
    	$msg = "<BetConfirm></BetConfirm>";
    	foreach ($this->users as $user) {
        	$this->send($user, $msg);
        }
    }
	private function SendBetSlipConfirmToClient() {
    	$msg = "<BetSlipConfirm></BetSlipConfirm>";
    	foreach ($this->users as $user) {
        	$this->send($user, $msg);
        }
    }
    public function __destruct()
    {
        echo "Server destroyed!".PHP_EOL;
    }
    
    // ---- helper functions ------------- 
    private function DoMessageLog($msgType, $timestamp) {
    	$timestamp = date("Y-m-d H:i:s", $timestamp);
    	db_query("insert into MessageLog (MessageType, MessageTimeStamp) values ('{$msgType}', '{$timestamp}')");
    }
    // 
    
    
}


$server = new Server($addr, $port, 2048, $serverAddr, $serverPort, $loginUserName, $loginPassword);

$server->run();
