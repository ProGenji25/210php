<?php
error_reporting(-1);
require_once "../config/settings.php";
// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 


// Create connection
$conn = new mysqli($servername, $mysql_user, $mysql_password, $mysql_database);

// Check connection
if ($conn->connect_error) {
	die('Connection failed: ' . $conn->connect_error);
}
else{
    $sql = "UPDATE users SET logged_in=0";

    if($conn->query($sql) === true){
        // Close connection
        $conn->close();
    } 
    else {
        echo "ERROR: Could not able to execute $sql. " . $conn->error;
    }
}

// Destroy the session.
session_destroy();

// Redirect to login page
header("location: ../login.php");
exit;
?>