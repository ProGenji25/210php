<?php 
error_reporting(-1);

// Include config file
require_once "../config/settings.php";
 
session_start();

// Create connection
$conn = new mysqli($servername, $mysql_user, $mysql_password, $mysql_database);

// Check connection
if ($conn->connect_error) {
	die('Connection failed: ' . $conn->connect_error);
}
else {
    $task = $date = "";
    $user_id = $_SESSION["id"];

    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $task = trim($_POST["inputtext"]);
        $date = trim($_POST["dueDate"]);

        $sql = "INSERT INTO items (user_id, text, date, done) VALUES (?, ?, ?, ?)";
        if($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("issi", $param_userid, $param_text, $param_date, $param_done);
            $param_userid = $user_id;
            $param_text = $task;
            $param_date = $date;
            $param_done = false;

            if($stmt->execute()) {
                // Redirect to main page
                header("location: ../index.php");
                exit();
            }
            else {
                echo $stmt->error;
                echo "Something went wrong!";
            }
        }
        //Close stmt
        $stmt->close();
    }
    // Close connection
    $conn->close();
}
?>