<?php
error_reporting(E_ALL);
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
include("connect.php");

// connect to the database
$con = mysqli_connect($server,$user,$pass,$dbname);
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect : " . mysqli_connect_error();
}
$location_id = 0;
if (isset($_POST['LocationID'])) {
    $location_id = $_POST['LocationID'];
}
if ($location_id <= 0){
    echo 'Invalid location id.';
    die;
}
if (isset($_POST['IsDelete'])){
    //Request for deleting location.
    $query = "UPDATE `Users` SET `UserStatus`='Deleted' WHERE `LocationID`='$location_id'";
    mysqli_query($con, $query);

    $query = "UPDATE `Locations` SET `LocationStatus`='Deleted' WHERE `LocationID`='$location_id'";
    mysqli_query($con, $query);
    mysqli_close($con);
} else {
    //Request for editing user.
    $Location = htmlentities($_POST['Location'], ENT_QUOTES);
    $Region = htmlentities($_POST['Region'], ENT_QUOTES);
	$Timezone = htmlentities($_POST['Timezone'], ENT_QUOTES);
	
    $query = sprintf("UPDATE `Locations` SET `Location`='%s',`Region`='%s', `Timezone`='%s' WHERE `LocationID`='%s'", $Location, $Region, $Timezone, $location_id);
    mysqli_query($con, $query);
    mysqli_free_result($result);
    mysqli_close($con);
}
header('Location: editlocation.php');
?>