<?php
error_reporting(E_ALL);
include("connect.php");

// connect to the database
$conn = new mysqli($server, $user, $pass, $dbname);

// get the form data
$Location = htmlentities($_POST['Location'], ENT_QUOTES);
$Region = htmlentities($_POST['Region'], ENT_QUOTES);
$Timezone = htmlentities($_POST['Timezone'], ENT_QUOTES);

// prepare and bind
$stmt = $conn->prepare("INSERT INTO Locations (Location, Region, Timezone, LocationStatus) VALUES (?, ?, ?, 'Active')");
$stmt->bind_param("sss", $Location, $Region, $Timezone);

$stmt->execute();
$stmt->close();
$conn->close();
header('Location: addlocation.php');
?>