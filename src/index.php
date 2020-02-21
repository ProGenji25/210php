<?php
error_reporting(0);
include 'config/settings.php';

session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
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
			<a href="index.php" class="brand-logo">IT&amp;C 210</a>
			<ul id="nav-mobile" class="right hide-on-med-and-down">
				<li><?php echo htmlspecialchars($_SESSION["username"]); ?></li>
				<li><a href="/actions/logout-action.php">Logout</a></li>
			</ul>
		</div>
	</nav>

	<!--To-do list-->
	<h2>To-do-List</h2>
	<div class="container">
		<div class="row">
			<div class="col s12">
				<form action="/actions/create-action.php" method="post">
					<div class="input-field col s6">
						<input type="text" class="taskform" name="inputtext" value="<?php echo $task ?>" placeholder="Add Task:" required>
					</div>
					<div class="input-field col s5">
						<input type="date" class="dateform" name="dueDate" value="<?php echo $date ?>" placeholder="MM/DD/YYYY" required>
					</div>
					<div class="input-field col s1">
						<button type="submit" class="waves-effect waves-light btn" id ="submit-btn" value="Submit">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php
		// Create connection
		$conn = new mysqli($servername, $mysql_user, $mysql_password, $mysql_database);
		// Check connection
		if ($conn->connect_error) {
 			die('Connection failed: ' . $conn->connect_error);
		} 
		else {
			$sql = "SELECT * FROM items WHERE user_id = ? ";
			$value = 0;
			switch($_POST['sort']) {
 			case 1:
    			$value = 2;
    			$sql .= "ORDER BY date DESC";
  				break;
 			case 0:
  				$value = 1;
    			$sql .= "ORDER BY date ASC";
  				break;
 			default:
  				break; 
			}

	 		if($stmt = $conn->prepare($sql)) {
				// Bind variables to the prepared statement as parameters
				$stmt->bind_param("i", $param_userid);
				// Set parameters
				$param_userid = $_SESSION["id"];

				// Attempt to execute the prepared statement
				if($stmt->execute()){
					if($result = $stmt->get_result()){
                        if($result->num_rows > 0){
							echo "<div class='container'>";
							echo "<ul class='collection' id='myUL'>";
                            while($row = $result->fetch_assoc()){
								echo "<li class ='collection-item' id='".$row['id']."'>";
									echo "<div class='row'>";
										echo "<div class='col s8'>";
											echo "<input type='checkbox' class ='check' ";
											if($row['done'] == 1){
												echo "checked";
											}
											echo " />";
											echo "<span class='task'>" . htmlspecialchars($row['text']) . "</span>";
										echo "</div>";
										echo "<div class='col s2'>";
											echo "<span>Due on: " . $row['date'] . "</span>";
										echo "</div>";
										echo "<div class='col s1'>";
											echo "<form action='/actions/update-action.php' method='post' id='update'>";
												echo "<input name='id' value='".$row['id']."' hidden/>";
												echo "<input name='done' value='".$row['done']."' hidden/>";
												echo "<button type='submit' class ='waves-effect waves-light btn'>done?</button>";
											echo "</form>";
										echo "</div>";
										echo "<div class='col s1'>";
											echo "<form action='/actions/delete-action.php' method='post'>";
												echo "<input name='id' value='".$row['id']."' hidden/>";
												echo "<button type='submit' class ='waves-effect waves-light btn'>Delete</button>";
											echo "</form>";
										echo "</div>";
									echo "</div>";
								echo "</li>";
							}
							echo "</ul>";
							echo "</div>";
                            // Free result set
                            $result->free();
                        }
					} 
				}
				else {
                    echo "ERROR: Could not execute $sql. " . $conn->error;
                }
                // Close connection
                $conn->close();
			}
		}
	?>

	<div class="container">
		<div class="row">
			<div class="col s1 push-s11">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<button type="submit" name="sort" class="waves-effect waves-light btn" id="sort-btn" value="<?php echo $value; ?>">Sort</button>
				</form>
			</div>
		</div>
	</div>
	<!-- Compiled and minified JavaScript -->
	<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<!--script src="js/script.js"></script-->
</body>

</html>