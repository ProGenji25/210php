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
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        //echo $_POST["id"];
        //echo $_POST["done"];
        if(isset($_POST["id"]) && isset($_POST["done"])){
            // Get hidden input value
            $id = trim($_POST["id"]);
            $done = trim($_POST["done"]);
            //echo $id;
            //echo $done;
            //$done === 0 ? $done = 1 : $done = 0; 
            //echo $done;
            if($done == 0) {
                $done = 1;
            }
            else {
                $done = 0;
            }

            // Prepare an update statement
            $sql = "UPDATE items SET done=? WHERE id=?";
            //echo $sql;
            if($stmt = $conn->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("ii", $param_done, $param_id);
            
                // Set parameters
                $param_done = $done;
                $param_id = $id;
            
                // Attempt to execute the prepared statement
                //echo "executing";
                if($stmt->execute()){
                    // Records updated successfully. Redirect to home page
                    header("location: ../index.php");
                    exit();
                } 
                else {
                    echo "Something went wrong. Please try again later.";
                }
            }
            // Close statement
            $stmt->close();
        }
    // Close connection
    $conn->close();
    }
}
?>