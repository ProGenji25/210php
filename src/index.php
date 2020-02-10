<?php

include 'config/settings.php';

session_start();
$_SESSION['test'] = 'Hello World';

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
echo '<h3>Feel free to overwrite this file. A copy can be found at <a href=\'/php/status.php\'>php/status.php</a></h3>';
