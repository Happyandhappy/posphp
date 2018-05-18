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

// get the form data
if (isset($_POST['UserType']))
	{
	$UserType = "Admin";
	}
	else {
	$UserType = "User";
}	

$UserName = htmlentities($_POST['UserName'], ENT_QUOTES);
$FirstName = htmlentities($_POST['FirstName'], ENT_QUOTES);
$LastName = htmlentities($_POST['LastName'], ENT_QUOTES);
$Password = htmlentities($_POST['Password'], ENT_QUOTES);
$Location =  htmlentities($_POST['Location'], ENT_QUOTES);
$MaxPayout =  htmlentities($_POST['MaxPayout'], ENT_QUOTES);

// Perform queries and GET LocationID
$query = "SELECT * FROM Locations WHERE Location = '".$Location."'";
$result = mysqli_query($con,$query);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
$LocationID = $row['LocationID'];
}

// Query & insert new User
$query = "INSERT INTO `Users` (UserName, Password, FirstName, LastName, LocationID, UserType, UserStatus, Max) VALUES ('".$UserName."', '".md5($Password)."', '".$FirstName."', '".$LastName."', '".$LocationID."', '".$UserType."', 'Active', '".$MaxPayout."')";
mysqli_query($con, $query);

// Free result set
mysqli_free_result($result);
mysqli_close($con);

header('Location: adduser.php'); 
?>