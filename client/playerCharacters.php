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

<!-- table of characters -->
	<div id="playersTable">
		<table>
			<caption>Characters</caption>
			<tr>
				<th>Character ID</th>
				<th>Name</th>
				<th>Belongs to Player</th>				
				<th>Class</th>
				<th>Level</th>
				<th>Health</th>
				<th>Strength</th>
				<th>Skills</th>
				<th>Items</th>
			</tr>
			
<!-- Now, populate the table -->
<?php
	// prepare statement to get the contents of 'player'
	$stmt = $mysqli->prepare("
		SELECT pc.id, characterName, p.userName, cc.className, level, health, strength
		FROM playerCharacter pc INNER JOIN player p ON pc.playerId = p.id
		INNER JOIN characterClass cc ON pc.classId = cc.id
		ORDER BY p.userName;
	");
	
	if(!$stmt) {
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	// execute the statement
	if(!$stmt->execute()) {
		echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	// bind the results to variables and display the results
	$stmt->bind_result($cId, $cName, $cOwner, $cClass, $cLevel, $cHealth, $cStrength);	
	if(!($stmt)) {
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	while($stmt->fetch()){
		echo "<tr>\n<td>\n" . 
			$cId . "</td>\n<td>" . 
			$cName . "</td>\n<td>" . 
			$cOwner . "</td>\n<td>" . 
			$cClass . "</td>\n<td>" . 
			$cLevel . "</td>\n<td>" . 
			$cHealth . "</td>\n<td>" . 
			$cStrength . "</td>\n<td>" .
			"<a href=\"skills.php?cId=" . $cId . "&cName=" . $cName . 
			"\">See Skills</a>" . "</td>\n<td>" .
			"<a href=\"pCharItems.php?cId=" . $cId . "&cName=" . $cName . 
			"\">See Items</a>" . "</td>\n" .	
			"</tr>";
	}
	$stmt->close();
?>
		</table>
	</div>
	
<!-- form to add new characters -->	
	<div id="addCharacterForm">
		<form method="post" action="addCharacter.php">
			<fieldset>
				<legend>Add New Character for <?php echo $_SESSION["userName"] ?> </legend>
				<p>
					<select name="classRef">

<?php
	// get a list of classes
	$stmt = $mysqli->prepare("SELECT id, className FROM characterClass ORDER BY id;");
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
	 echo "<option value=\"" . $classId . "\">" . $classId . ":  " .  $className . "</option>";
	}
	$stmt->close();
?>

					</select>
				</p>
				
				<p>Character Name: <input type="text" name="name" required/></p>
<!--				
				<p>Level: <input type="text" name="level" required/></p>
				<p>Health: <input type="text" name="health" required/></p>		
				<p>Strength: <input type="text" name="strength" required></p>		
-->				
				<p><input type="submit" name="addNew" value="Add Character" /></p>
				
			</fieldset>
		</form>
	</div>
</body>
</html>
