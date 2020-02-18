<?php
error_reporting(0);
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
    // Define variables and initialize with empty values
    $username = $password = $confirm_password = "";
 
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST") {
 
        // Validate username
        if(empty(trim($_POST["username"]))) {
            
            header("location: ../register.php");
            $_SESSION["error"] = "Please enter a username.";
            exit();
        } 
        else {
            // Prepare a select statement
            $sql = "SELECT id FROM users WHERE username = ?";
            if($stmt = $conn->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("s", $param_username);
            
                // Set parameters
                $param_username = trim($_POST["username"]);
            
                // Attempt to execute the prepared statement
                if($stmt->execute()) {
                    // store result
                    $stmt->store_result();
                
                    if($stmt->num_rows == 1) {
                        header("location: ../register.php");
                        $_SESSION["error"] =  "This username is already taken.";
                        exit();
                    } 
                    else {
                        $username = trim($_POST["username"]);
                    }
                } 
                else {
                    //echo "Oops! Something went wrong. Please try again later.";
                    header("location: ../register.php");
                    exit();
                }
            }
         
            // Close statement
            $stmt->close();
        }
    
        // Validate password
        if(empty(trim($_POST["password"]))) {
            
            header("location: ../register.php");
            $_SESSION["error"] =  "Please enter a password.";
            exit();  
        } 
        else {
            $password = trim($_POST["password"]);
        }
    
        // Validate confirm password
        if(empty(trim($_POST["confirm_password"]))) {
            header("location: ../register.php");
            $_SESSION["error"] =  "Please confirm password.";
            exit();
        } 
        else {
            $confirm_password = trim($_POST["confirm_password"]);
            if($password !== $confirm_password) {
                header("location: ../register.php");
                $_SESSION["error"] =  "Password did not match.";
                exit();
            }
        }
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, logged_in) VALUES (?, ?, ?)";
         
        if($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_username, $param_password, $param_login);
            
            // Set parameters
            $param_username = $username;
            $param_password = hash("sha256", $password); // Creates a password hash
            $param_login = true;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()) {
                $stmt->close();
                $sql = "SELECT id FROM users WHERE username = ?";
        
                if($stmt = $conn->prepare($sql)) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("s", $param_username);
            
                    // Set parameters
                    $param_username = trim($_POST["username"]);
            
                    // Attempt to execute the prepared statement
                    if($stmt->execute()) {
                        // store result
                        $stmt->store_result();
                
                        if($stmt->num_rows == 1) {
                            $stmt->bind_result($id);
                            if($stmt->fetch()){
                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;
                                // Redirect to main page
                                header("location: ../index.php");
                            }
                        }
                        else {
                            echo "didn't make it";
                        }
                    }
                }
                else {
                    echo "Something went wrong. Please try again later.";
                    header("location: ../register.php");
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