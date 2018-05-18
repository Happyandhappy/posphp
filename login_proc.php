<?php
if ($_REQUEST['userid'] == "Client018" && $_REQUEST['userpw'] == "rkZxSzph") {
	session_start();
	$_SESSION["userid"] = "Client018";
	echo "ok";
}