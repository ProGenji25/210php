<?php
include '../config/settings.php';

session_start();

// Create connection
$conn = new mysqli($servername, $mysql_user, $mysql_password, $mysql_database);

// Check connection
if ($conn->connect_error) {
	die('Connection failed: ' . $conn->connect_error);
}
else {
	echo 'Database Connection Success';
}

// Print to the browser
echo '<hr></hr>';
echo 'SESSION VARIABLES <br>';
var_dump($_SESSION);
echo '<hr></hr>';
