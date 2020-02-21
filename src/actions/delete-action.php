<?php
error_reporting(-1);

require_once "../config/settings.php";

session_start();

// Create connection
$conn = new mysqli($servername, $mysql_user, $mysql_password, $mysql_database);

// Check connection
if ($conn->connect_error) {
	die('Connection failed: ' . $conn->connect_error);
}
else {
    // Process delete operation after confirmation
    if(isset($_POST["id"]) && !empty($_POST["id"])){
        // Prepare a delete statement
        $sql = "DELETE FROM items WHERE id = ?";
    
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);
        
            // Set parameters
            $param_id = trim($_POST["id"]);
        
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records deleted successfully. Redirect to landing page
                header("location: ../index.php");
                exit();
            } 
            else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        $stmt->close();
    }
    // Close connection
    $conn->close();
}
?>