<?php
require("config.php");
checkSession();
?>

<!DOCTYPE html>
<html>
<head>
	<meta content="text/html; charset=utf-8"/>
	<title>Game Database</title>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
	<p><a href="players.php">Players</a> | <a href="playerCharacters.php"> Characters </a></p>
	<p> Logged in as: <?php echo $_SESSION["userName"] ?>   | <a href="logout.php">Log out</a> </p>

<!-- table of Character Classes -->
	<div id="itemClassesTable">
		<table>
			<caption>Item Classes</caption>
			<tr>
				<th>Item ID</th>
				<th>Item Name</th>
			</tr>
			
<!-- Now, populate the table -->
<?php
	// prepare statement to get the contents of 'player'
	$stmt = $mysqli->prepare("SELECT id, itemName FROM itemClass;");
	if(!$stmt) {
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	// execute the statement
	if(!$stmt->execute()){
		echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	// bind the results to variables and display the results
	if(!$stmt->bind_result($classId, $className)){
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	while($stmt->fetch()){
	 echo "<tr>\n<td>" . $classId . "\n</td>\n<td>\n" . $className . "</td>\n</tr>\n";
	}
	$stmt->close();
?>

		</table>		
	</div>
	<br />
	
<!-- a form to delete class info -->
	<div id=deleteIClassForm">
		<form method="post" action="deleteIClass.php">
			<fieldset>
				<legend>Delete Item Class</legend>
				<p>
					<select name="classToDelete">
<?php
	// get a list of classes

	$stmt = $mysqli->prepare("SELECT id, itemName FROM itemClass;");
	if(!$stmt) {
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	// execute the statement
	if(!$stmt->execute()){
		echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	// bind the results to variables and display the results
	if(!$stmt->bind_result($classId, $className)){
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	$numRows = 0;
	while($stmt->fetch()){
		$numRows++;
		echo "<option value=\"" . $classId . "\">" . $classId . ": " . $className . "</option>";
	}
	if(!$numRows) {
		echo "<option value=\"\">No more classes left!</option>";
	}
	$stmt->close();
?>
					
				</p>			
				<p><input type="submit" name="delete" value="Delete Class"></p>
			</fieldset>
		</form>
	</div>
	
<!-- form to add a class -->	
	<div id="addIClassForm">
		<form method="post" action="addIClass.php">
			<fieldset>
				<legend>Add a new item class</legend>
				
				<p>New class name: <input type="text" name="className" required /></p>
				<p><input type="submit" name="addClass" value="Add Class"></p>
			</fieldset>
		</form>
	</div>

</body>
</html>
