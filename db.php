<?php

$timeoffset = '-4:00';

list($hours, $minutes) = explode(':', $timeoffset);
$seconds = $hours * 60 * 60 + $minutes * 60;

$tz = timezone_name_from_abbr('', $seconds, 1);

if($tz === false) $tz = timezone_name_from_abbr('', $seconds, 0);
// Set timezone
date_default_timezone_set($tz);

	function response($code, $str){
		echo json_encode(array('code' => $code, 'data' => $str));
		exit;
	}
	function mylog($msg){
		$log_file = '1.log';
		$time = date('Y-m-d H:i:s', time());
		error_log("[".$time."] ".$msg . "\n", 3, $log_file);
	}
//0 : operation success
//1 : mysql connect error
//2 : no active session
//3 : illegal bet
//4 : db query fail
	if ($_POST != null){
		$action = $_POST['action'];
		if ($action == 'active_session') {
			include("connect.php");
			// connect to the database
			$con = mysqli_connect($server, $user, $pass, $dbname);
			// Check connection
			if (mysqli_connect_errno()) {
				response(1, "Failed to connect : " . mysqli_connect_error());
			}
			// Query
			$query = "SELECT * FROM SessionLogs WHERE ActiveStatus = 1 ORDER BY SlotID";
			$result = mysqli_query($con, $query);
			$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
			if (count($rows) < 10) {
				response(2, "<h4>There's no active session.</h4>");
			}
			// Free result set
			mysqli_free_result($result);
			mysqli_close($con);
			response(0, $rows);
		} else if ($action == 'add_ticket'){
			include("connect.php");
			// connect to the database
			$con = mysqli_connect($server, $user, $pass, $dbname);
			// Check connection
			if (mysqli_connect_errno()) {
				response(1, "Failed to connect : " . mysqli_connect_error());
			}
			$data = $_POST['data'];
			$user_name = $_POST['user'];
			$location_id = '';
			$location = '';

			$query = "SELECT * FROM Users WHERE `UserName`='$user_name'";
			$result = mysqli_query($con, $query);
			if ($result){
				$row = mysqli_fetch_assoc($result);
				if ($row) {
					$location_id = $row['LocationID'];
					mysqli_free_result($result);
				} else {
					response(4, 'failed/1');
				}
			} else {
				response(4, 'failed/2');
			}

			$query = "SELECT * FROM `Locations` WHERE `LocationID`='$location_id'";
			$result = mysqli_query($con, $query);
			if ($result){
				$row = mysqli_fetch_assoc($result);
				if ($row) {
					$location = $row['Location'];
					mysqli_free_result($result);
				} else {
					response(4, 'failed/3');
				}
			} else {
				response(4, 'failed/4');
			}

			$illegal_bet = false;
			foreach ($data as $bet){
				foreach ($bet['bet_event_list'] as $event){
					// Query
					$query = "SELECT * FROM SessionLogs WHERE EventID = '".$event['event_id']."' AND ActiveStatus = 1 ORDER BY SlotID";
					$result = mysqli_query($con, $query);
					if ($result){
						$row = mysqli_fetch_assoc($result);
						if ($row) {
							if ($row['BetStatus'] != 'BetStart'){
								$illegal_bet = true;
								break;
							}
						}
					}
				}
				if ($illegal_bet){
					break;
				}
			}
			if ($illegal_bet){
				response(3, 'Illegal bet');
			}
			$bet_type = 'Single';
			$bet_status = 'Active';
			$total_odds = '';
			$stake = '';
			$event = array();
			for ($i = 0; $i < 10; $i++){
				$event[$i]['pick'] = '';
				$event[$i]['odds'] = '';
				$event[$i]['event'] = '';
			}

			$ticket_status = 'Active';
			$bet_id = array();
			for ($i = 0; $i < 10; $i++){
				$bet_id[$i] = 0;
			}
			
			$timezonetime = date('Y-m-d H:i:s', time());
			mysqli_query($con,"SET time_zone = '-4:00'");
			
			$query = "INSERT INTO `Tickets`(`TicketID`, `TimeDate`, `TicketStatus`, `User`, `Location`, `BetID1`, `BetID2`, `BetID3`, `BetID4`, `BetID5`, `BetID6`, `BetID7`, `BetID8`, `BetID9`, `BetID10`) VALUES ('','".$timezonetime."','".$ticket_status."','".$user_name."','".$location."','".$bet_id[0]."','".$bet_id[1]."','".$bet_id[2]."','".$bet_id[3]."','".$bet_id[4]."','".$bet_id[5]."','".$bet_id[6]."','".$bet_id[7]."','".$bet_id[8]."','".$bet_id[9]."')";
			$result = mysqli_query($con, $query);
			if (!$result){
				response(4, 'failed/5');
			}
			$new_ticket_id = mysqli_insert_id($con);
			$bet_count = 0;
			foreach ($data as $bet){
				if (count($bet['bet_event_list']) > 1){
					$bet_type = 'Multiple';
				} else {
					$bet_type = 'Single';
				}
				$bet_status = 'Active';
				$total_odds = $bet['bet_odds'];
				$stake = $bet['bet_stake'];
				for ($i = 0; $i < 10; $i++){
					$event[$i]['pick'] = '';
					$event[$i]['odds'] = '';
					$event[$i]['event'] = '';
				}
				for ($i = 0; $i < count($bet['bet_event_list']); $i++){
					$ev = $bet['bet_event_list'][$i];
					$event[$i]['pick'] = $ev['event_winner'];
					$event[$i]['odds'] = $ev['event_odds'];
					$event[$i]['event'] = $ev['event_id'];
				}
				$query = "INSERT INTO `Bets`(`BetID`, `TicketID`, `BetType`, `BetStatus`, `Pick1`, `Odds1`, `Event1`, `Pick2`, `Odds2`, `Event2`, `Pick3`, `Odds3`, `Event3`, `Pick4`, `Odds4`, `Event4`, `Pick5`, `Odds5`, `Event5`, `Pick6`, `Odds6`, `Event6`, `Pick7`, `Odds7`, `Event7`, `Pick8`, `Odds8`, `Event8`, `Pick9`, `Odds9`, `Event9`, `Pick10`, `Odds10`, `Event10`, `TotalOdds`, `Stake`) VALUES ('','$new_ticket_id','$bet_type','$bet_status','".$event[0]['pick']."','".$event[0]['odds']."','".$event[0]['event']."','".$event[1]['pick']."','".$event[1]['odds']."','".$event[1]['event']."','".$event[2]['pick']."','".$event[2]['odds']."','".$event[2]['event']."','".$event[3]['pick']."','".$event[3]['odds']."','".$event[3]['event']."','".$event[4]['pick']."','".$event[4]['odds']."','".$event[4]['event']."','".$event[5]['pick']."','".$event[5]['odds']."','".$event[5]['event']."','".$event[6]['pick']."','".$event[6]['odds']."','".$event[6]['event']."','".$event[7]['pick']."','".$event[7]['odds']."','".$event[7]['event']."','".$event[8]['pick']."','".$event[8]['odds']."','".$event[8]['event']."','".$event[9]['pick']."','".$event[9]['odds']."','".$event[9]['event']."','".$total_odds."','".$stake."')";
				$result = mysqli_query($con, $query);
				if ($result){
					$new_bet_id = mysqli_insert_id($con);
					$bet_id[$bet_count] = $new_bet_id;
					$bet_count++;
				}
			}
			$query = "UPDATE `Tickets` SET `BetID1`='%s', `BetID2`='%s', `BetID3`='%s', `BetID4`='%s', `BetID5`='%s', `BetID6`='%s', `BetID7`='%s', `BetID8`='%s', `BetID9`='%s', `BetID10`='%s' WHERE `TicketID`='%s'";
			$query = sprintf($query, $bet_id[0], $bet_id[1], $bet_id[2], $bet_id[3], $bet_id[4], $bet_id[5], $bet_id[6], $bet_id[7], $bet_id[8], $bet_id[9], $new_ticket_id);
			$result = mysqli_query($con, $query);
			if (!$result){
				response(4, 'failed/6');
			}
			// Free result set
			mysqli_close($con);
			response(0, $new_ticket_id);
		} else if ($action == 'cancel_ticket'){
			include("connect.php");
			// connect to the database
			$con = mysqli_connect($server, $user, $pass, $dbname);
			// Check connection
			if (mysqli_connect_errno()) {
				response(1, "Failed to connect : " . mysqli_connect_error());
			}
			$ticket_id_list = $_POST['data'];
			foreach ($ticket_id_list as $ticket_id){
				$query = "SELECT * FROM `Tickets` WHERE `TicketID`='$ticket_id'";
				$result = mysqli_query($con, $query);
				if ($result){
					$row = mysqli_fetch_assoc($result);
					if ($row){
						$query = "UPDATE `Tickets` SET `TicketStatus`='Cancelled' WHERE `TicketID`='$ticket_id'";
						$result = mysqli_query($con, $query);
						if (!$result){
							response(4, 'failed to update ticket');
						}
						if ($row){
							$bet_id_list = array();
							if ($row['BetID1'] != 0){
								array_push($bet_id_list, $row['BetID1']);
							}
							if ($row['BetID2'] != 0){
								array_push($bet_id_list, $row['BetID2']);
							}
							if ($row['BetID3'] != 0){
								array_push($bet_id_list, $row['BetID3']);
							}
							if ($row['BetID4'] != 0){
								array_push($bet_id_list, $row['BetID4']);
							}
							if ($row['BetID5'] != 0){
								array_push($bet_id_list, $row['BetID5']);
							}
							if ($row['BetID6'] != 0){
								array_push($bet_id_list, $row['BetID6']);
							}
							if ($row['BetID7'] != 0){
								array_push($bet_id_list, $row['BetID7']);
							}
							if ($row['BetID8'] != 0){
								array_push($bet_id_list, $row['BetID8']);
							}
							if ($row['BetID9'] != 0){
								array_push($bet_id_list, $row['BetID9']);
							}
							if ($row['BetID10'] != 0){
								array_push($bet_id_list, $row['BetID10']);
							}
							foreach ($bet_id_list as $bet_id){
								$query = "SELECT * FROM `Bets` WHERE `BetID`='$bet_id'";
								$result = mysqli_query($con, $query);
								if ($result){
									if (mysqli_fetch_assoc($result)) {
										$query = "UPDATE `Bets` SET `BetStatus`='Cancelled' WHERE `BetID`='$bet_id'";
										$result = mysqli_query($con, $query);
										if (!$result){
											response(4, 'failed to update bet.');
										}
									}
								}
							}
						}
					}
				}
			}
			// Free result set
			mysqli_close($con);
			response(0, 'success');
		} else if ($action == 'pay_bet'){
			include("connect.php");
			// connect to the database
			$con = mysqli_connect($server, $user, $pass, $dbname);
			// Check connection
			if (mysqli_connect_errno()) {
				response(1, "Failed to connect : " . mysqli_connect_error());
			}
			$bet_id_list = $_POST['data'];
			foreach ($bet_id_list as $bet_id){
				$query = "SELECT * FROM `Bets` WHERE `BetID`='$bet_id'";
				$result = mysqli_query($con, $query);
				if ($result){
					$row = mysqli_fetch_assoc($result);
					if ($row){
						$query = "UPDATE `Bets` SET `BetStatus`='Paid' WHERE `BetID`='$bet_id'";
						$result = mysqli_query($con, $query);
						if (!$result){
							response(4, 'failed to pay bet');
						}
					}
				}
			}
			// Free result set
			mysqli_close($con);
			response(0, 'success');
		} else if ($action == 'get_user'){
		    include("connect.php");
            // connect to the database
            $con = mysqli_connect($server, $user, $pass, $dbname);
            // Check connection
            if (mysqli_connect_errno()) {
                response(1, "Failed to connect : " . mysqli_connect_error());
            }
            $user_id = $_POST['user_id'];
            $query = "SELECT * FROM `Users` WHERE `UserId`='$user_id' AND `UserStatus`='Active'";
            $result = mysqli_query($con, $query);
            if ($result){
                $row = mysqli_fetch_assoc($result);
                if ($row){
                    response(0, $row);
                } else {
                    response(4, 'failed to get user/2');
                }
            } else {
                response(4, 'failed to get user/1');
            }
            // Free result set
            mysqli_close($con);
            response(0, 'success');
        } else if ($action == 'get_location'){
            include("connect.php");
            // connect to the database
            $con = mysqli_connect($server, $user, $pass, $dbname);
            // Check connection
            if (mysqli_connect_errno()) {
                response(1, "Failed to connect : " . mysqli_connect_error());
            }
            $location_id = $_POST['location_id'];
            $query = "SELECT * FROM `Locations` WHERE `LocationID`='$location_id' AND `LocationStatus`='Active'";
            $result = mysqli_query($con, $query);
            if ($result){
                $row = mysqli_fetch_assoc($result);
                if ($row){
                    response(0, $row);
                } else {
                    response(4, 'failed to get location/2');
                }
            } else {
                response(4, 'failed to get location/1');
            }
            // Free result set
            mysqli_close($con);
            response(0, 'success');
        } else if ($action == 'get_max_payout'){
            include("connect.php");
            // connect to the database
            $con = mysqli_connect($server, $user, $pass, $dbname);
            // Check connection
            if (mysqli_connect_errno()) {
                response(1, "Failed to connect : " . mysqli_connect_error());
            }
            $username = $_POST['user'];
            $query = "SELECT * FROM `Users` WHERE UserName='$username'";
            $result = mysqli_query($con, $query);
            if ($result){
                $row = mysqli_fetch_assoc($result);
                if ($row){
                    response(0, $row['Max']);
                } else {
                    response(4, 'failed to get max payout/2');
                }
            } else {
                response(4, 'failed to get max payout/1');
            }
            // Free result set
            mysqli_close($con);
            response(0, 'success');
        } else if ($action == 'check_admin_password'){
            include("connect.php");
            // connect to the database
            $con = mysqli_connect($server, $user, $pass, $dbname);
            // Check connection
            if (mysqli_connect_errno()) {
                response(1, "Failed to connect : " . mysqli_connect_error());
            }
            $username = $_POST['user'];
            $password = md5($_POST['password']);
            $query = "SELECT * FROM `Users` WHERE UserName='$username'";
            $result = mysqli_query($con, $query);
            if ($result){
                $row = mysqli_fetch_assoc($result);
                if ($row){
                    $location_id = $row['LocationID'];
                    $query = "SELECT * FROM `Users` WHERE UserType='Admin' AND LocationID='$location_id' ORDER BY UserID";
                    $result = mysqli_query($con, $query);
                    if ($result){
                        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        if (count($rows) <= 0){
                            response(0, 'no_admin_matching');
                        } else {
                            foreach ($rows as $row){
                                if ($row['Password'] == $password){
                                    response(0, 'ok');
                                }
                            }
                            response(0, 'no_password_matching');
                        }
                    } else {
                        response(4, 'failed to check password/3');
                    }
                } else {
                    response(4, 'failed to check password/2');
                }
            } else {
                response(4, 'failed to check password/1');
            }
            // Free result set
            mysqli_close($con);
            response(0, 'success');
        }
	}
?>