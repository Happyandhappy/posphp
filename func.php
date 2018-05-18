<?php


$db_info['HOST'] = "localhost";
$db_info['USER'] = "root";
$db_info['PASSWORD'] = "P@ssword!";		//Client Database Password
$db_info['DATABASE'] = "edgeclient"; 	//Client Database Username

$addr = "172.31.16.250";
$port = "9030";

$serverPort = "9030";
$serverAddr = "52.76.109.119";
//$serverAddr = "172.31.10.140";

$loginUserName = "Client018";
$loginPassword = "rkZxSzph";


	$connected = false;
	$connection = null;
	/**
	 * Commonly used function
	 * @author Alex
	 */
	function db_connect($autocommit = true)
	{
		global $db_info;
		global $connected;
		global $connection;
//		static $connection = null;
		
		$retryCount = 3;
		
//		if($connection) return $connection;

		while(!$connected && $retryCount > 1){
			$connection = new mysqli($db_info['HOST'], $db_info['USER'], $db_info['PASSWORD'], $db_info['DATABASE']);
			//echo $connection;exit();
			
			if($connection && !mysqli_connect_errno()){
				$connection->autocommit($autocommit);
				$connection->query("set names '".$db_info['CHARSET']."'");
				$connected = true;
			}else{
				usleep(500000);
				$retryCount--;
			}
		}
		if($connected) return $connection;
		else print mysqli_connect_error();
	}

	function db_lastID($table, $fld)
	{
		$sql = 'select max(' . $fld . ') as maxid from ' . $table . ' limit 1';
		$list = db_fetch($sql);
		return $list[0]['maxid'];
	}

	function db_fetch($sql)
	{
		if($sql == '') return array();
		
		$db = db_connect();
		$list = array();
		
		if($stmt = $db->prepare($sql)){
			if($stmt->execute()){
				$data = array();
				bind_assoc($stmt, $data);
				while($stmt->fetch()){
					$list[] = $data;
					bind_assoc($stmt, $data);
				}
			}
			$stmt->free_result();
			$stmt->close();
		}
		
		if($db->error != '') echo '<xmp style="color:red">' . $db->error . '</xmp><br />';
		//$db->close();
		return $list;
	}
	
	function db_fetch_item($sql)
	{
		$data = db_fetch($sql);
		if(is_array($data)){
			return $data[0];
		}
		return null;
	}

	function db_query($sql)
	{
		if($sql == '') return false;
		$bool = false;
		$db = db_connect();
//		$sql = sql_injection($sql, $db);
		if($stmt = $db->prepare($sql)){
			if($stmt->execute()){
				$bool = true;
			}
			$stmt->free_result();
			$stmt->close();
		}
		if($db->error != '') echo '<xmp style="color:red">' . $db->error . '</xmp><br />';
		//$db->close();
		return $bool;
	}

	function db_query_lastID($sql)
	{
		if($sql == '') return false;
		$lastID = -1;
		$db = db_connect();
//		$sql = sql_injection($sql, $db);
		if($stmt = $db->prepare($sql)){
			if($stmt->execute()){
				$lastID = $stmt->insert_id;
			}
			$stmt->free_result();
			$stmt->close();
		}
		if($db->error != '') echo '<xmp style="color:red">' . $db->error . '</xmp><br />';
		//$db->close();
		return $lastID;
	}

	function bind_assoc(&$stmt, &$out)
	{
		$data = mysqli_stmt_result_metadata($stmt);
		$fields = array();
		$out = array();
		$fields[0] = $stmt;
		$count = 1;
		while($field = mysqli_fetch_field($data)){
			$fields[$count] = &$out[$field->name];
			$count++;
		}
		call_user_func_array('mysqli_stmt_bind_result', $fields);
	}

?>
