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

$user_id = 0;
if (isset($_POST['UserID'])) {
    $user_id = $_POST['UserID'];
}
if ($user_id <= 0){
    echo 'Invalid user id.';
    die;
}
if (isset($_POST['IsDelete'])){
    //Request for deleting user.
    $query = "UPDATE `Users` SET `UserStatus`='Deleted' WHERE `UserID`='$user_id'";
    mysqli_query($con, $query);
    mysqli_free_result($result);
    mysqli_close($con);
} else {
    //Request for editing user.

    if (isset($_POST['UserType'])) {
        $UserType = "Admin";
    } else {
        $UserType = "User";
    }

    $UserName = htmlentities($_POST['UserName'], ENT_QUOTES);
    $FirstName = htmlentities($_POST['FirstName'], ENT_QUOTES);
    $LastName = htmlentities($_POST['LastName'], ENT_QUOTES);
    $Password = htmlentities($_POST['Password'], ENT_QUOTES);
    $Location = htmlentities($_POST['Location'], ENT_QUOTES);
    $MaxPayout = htmlentities($_POST['MaxPayout'], ENT_QUOTES);

    if ($Password == ''){
        $query = sprintf("UPDATE `Users` SET `UserName`='%s',`FirstName`='%s',`LastName`='%s',`LocationID`='%s',`UserType`='%s',`Max`='%s' WHERE `UserID`='%s'", $UserName, $FirstName, $LastName, $Location, $UserType, $MaxPayout, $user_id);
    } else {
        $query = sprintf("UPDATE `Users` SET `UserName`='%s',`Password`='%s',`FirstName`='%s',`LastName`='%s',`LocationID`='%s',`UserType`='%s',`Max`='%s' WHERE `UserID`='%s'", $UserName, md5($Password), $FirstName, $LastName, $Location, $UserType, $MaxPayout, $user_id);
    }
    mysqli_query($con, $query);
    mysqli_free_result($result);
    mysqli_close($con);
}
header('Location: edituser.php');
?>