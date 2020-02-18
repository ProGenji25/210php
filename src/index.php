<?php
error_reporting(0);
include 'config/settings.php';

session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// $_SESSION['test'] = 'Hello World';

// // Create connection
// $conn = new mysqli($servername, $mysql_user, $mysql_password, $mysql_database);

// // Check connection
// if ($conn->connect_error) {
// 	die('Connection failed: ' . $conn->connect_error);
// } else {
// 	echo 'Database Connection Success';
// }

// // Print to the browser
// echo '<hr></hr>';
// echo 'SESSION VARIABLES <br>';
// var_dump($_SESSION);
// echo '<hr></hr>';
// echo '<h3>Feel free to overwrite this file. A copy can be found at <a href=\'/php/status.php\'>php/status.php</a></h3>';
?>

<!DOCTYPE html>
<html>

<head>
	<title>Lab3</title>
	<meta charset="utf-8" />
	<!--Links to stylesheets-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

	<!-- Compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<body>
	<!--Nav-bar-->
	<nav>
		<div class="nav-wrapper">
			<a href="#" class="brand-logo">IT&amp;C 210</a>
			<ul id="nav-mobile" class="right hide-on-med-and-down">
				<li><?php echo htmlspecialchars($_SESSION["username"]); ?></li>
				<li><a href="/actions/logout-action.php">Logout</a></li>
			</ul>
		</div>
	</nav>

	<!--To-do list-->
	<div class="container">

		<h2>To-do-List</h2>

		<ul class="collection" id="myUL"></ul>

		<div class="row">
			<div class="input-field col s5">
				<input type="text" class="taskform" id="inputtext" value="" placeholder="Add Task:">
			</div>
			<div class="input-field col s5">
				<input type="date" class="dateform" id="dueDate" value="" placeholder="MM/DD/YYYY">
			</div>
			<div class="input-field col s1">
				<button class="waves-effect waves-light btn" id="submit-btn">Submit</button>
			</div>
			<div class="input-field col s1">
				<button class="waves-effect waves-light btn" id="sort-btn">Sort</button>
			</div>
		</div>
	</div>

	<!-- Compiled and minified JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<script src="js/script.js"></script>
</body>

</html>