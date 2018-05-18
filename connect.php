fick<?php
ini_set('date.timezone', 'America/New_York');
// server info
$server = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'edgeclient';

// connect to the database
$con = mysqli_connect("localhost", "root", "", "edgeclient");

// show errors (remove this line if on a live site)
mysqli_report(MYSQLI_REPORT_ERROR);

?>