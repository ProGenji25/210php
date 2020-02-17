<?php
error_reporting(-1);

// Include config file
require_once "../config/settings.php";

// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../index.php");
    exit;
}
 
// Create connection
$conn = new mysqli($servername, $mysql_user, $mysql_password, $mysql_database);

// Check connection
if ($conn->connect_error) {
	die('Connection failed: ' . $conn->connect_error);
}
else {
    // Define variables and initialize with empty values
    $username = $password = "";
    $username_err = $password_err = "";
 
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
 
        // Check if username is empty
        if(empty(trim($_POST["username"]))) {
            header("location: ../login.php");
            $_SESSION["error"] = "Please enter username.";
            exit();
            
        } 
        else {
            $username = trim($_POST["username"]);
        }
    
        // Check if password is empty
        if(empty(trim($_POST["password"]))) {
            header("location: ../login.php");
            $_SESSION["error"] = "Please enter your password.";
            exit();
        } 
        else {
            $password = trim($_POST["password"]);
            $password = hash("sha256", $password);
        }
    
        // Validate credentials
        if(empty($username_err) && empty($password_err)) {
            // Prepare a select statement
            $sql = "SELECT id, username, password, logged_in FROM users WHERE username = ? AND password = ?";
        
            if($stmt = $conn->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("ss", $param_username, $param_passwd);
            
                // Set parameters
                $param_username = $username;
                $param_passwd = $password;
            
                // Attempt to execute the prepared statement
                //echo "1";
                if($stmt->execute()) {
                    //echo "2";
                    // Store result
                    $stmt->store_result();
                    // Check if username exists, if yes then verify password
                    if($stmt->num_rows == 1) {
                                            
                        // Bind result variables
                        $stmt->bind_result($id, $username, $hashed_password, $login);
                        if($stmt->fetch()) {
                            $sql = "UPDATE users SET logged_in=1 WHERE id = $id";

                            if($conn->query($sql) === true){
                                // Close connection
                                // Redirect user to index page
                                header("location: ../index.php");
                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;
                            }
                        }
                    }
                    else{
                        header("location: ../login.php");
                        $_SESSION["error"] = "No account found with that username or password.";
                        exit();
                    }
                }                        
                            
                            

                            //echo "$password";
                            //echo "$hashed_password";

                            /*if(($password == $hashed_password)) {
                                //echo "4";
                                // Password is correct, so start a new session
                                session_start();
                            
                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;                            
                            
                                // Redirect user to index page
                                header("location: ../index.php");*/
                        
                        /*else {
                                // Display an error message if password is not valid
                                header("location: ../login.php");
                                $_SESSION["error"] = "The password you entered was not valid.";
                                exit();
                            //}
                        }*/
                    
                
                else {
                    // Display an error message if username doesn't exist
                    header("location: ../login.php");
                    $_SESSION["error"] = "No account found with that username or password.";
                    exit();
                }
            }
            else {
                header("location: ../login.php");
                echo "Oops! Something went wrong. Please try again later.";
                exit();
            }
        }
        // Close statement
        $stmt->close();
    }
    // Close connection
    $conn->close();
}
?>