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
	<div id="nav">
		<fieldset>
			<a href="players.php">Players</a> | 
			<a href="playerCharacters.php">Characters</a> |
			<a href="cClasses.php">Classes</a> |
			<a href="itemClasses.php">Items</a> |
			<a href="skillClasses.php">Skills</a>
		</fieldset>
	</div>
	
<p> Logged in as: <?php echo $_SESSION["userName"] ?>   | <a href="logout.php">Log out</a> </p>

<!-- Create table of characters -->
	<div id="playersTable">
		<table>
			<caption>Characters</caption>
			<tr>
				<th>Character ID</th>
				<th>Name</th>
				<th>Belongs to <a href="players.php">Player</a></th>				
				<th><a href="cClasses.php">Class</a></th>
				<th>Level</th>
				<th>Health</th>
				<th>Strength</th>
				<th><a href="skillClasses.php">Skills</a></th>
				<th><a href="itemClasses.php">Items</a></th>
			</tr>
			
<!-- Now, populate the table with some details -->
<?php
	// prepare statement to get the contents of 'player'
	$stmt = $mysqli->prepare("
		SELECT p.id,
			pc.id, 
			p.userName,
			pc.characterName, 
			cClass.className,
			pc.level, 
			pc.health, 
			pc.strength, 
			IFNULL(cSkl.skillCount, 0) skillCount,
			IFNULL(cItm.itemCount, 0) itemCount
		from player p
		inner join playerCharacter pc on p.id = pc.playerId
		inner join characterClass cClass on cClass.id = pc.classId
		left join(
			SELECT pc.id, count(pcs.skillId) skillCount
			FROM playerCharacter pc
				left join pCharSkill pcs on pc.id=pcs.pCharId
				left join skill s on s.id = pcs.skillId
			GROUP BY pc.id
		) cSkl on pc.id = cSkl.id
		left join(
			SELECT pc.id, count(itmI.id) itemCount
			FROM playerCharacter pc
				left join itemInstance itmI on pc.id = itmI.owner
				left join itemClass itmC on itmI.classId = itmC.id
		
			GROUP BY pc.id
		) cItm on cItm.id = pc.id	
	");
	
	if(!$stmt) {
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	// execute the statement
	if(!$stmt->execute()) {
		echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	// bind the results to variables and display the results
	$stmt->bind_result($pId, $cId, $cOwner, $cName, $cClass, $cLevel, $cHealth, $cStrength,
			$skillCount, $itemCount );	
	if(!($stmt)) {
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	while($stmt->fetch()){
		echo "<tr>\n<td>\n" . 
			"<a href=\"viewCharacter.php?cId=" . $cId . "&cName=" . 
			$cName ."\">" . $cId . "</a></td>\n<td>" . 
			"<a href=\"viewCharacter.php?cId=" . $cId . "&cName=" . 
			$cName ."\">" . $cName . "</a></td>\n<td>" . 
			$cOwner . "</td>\n<td>" . 
			$cClass . "</td>\n<td>" . 
			$cLevel . "</td>\n<td>" . 
			$cHealth . "</td>\n<td>" . 
			$cStrength . "</td>\n<td>" .
			"<a href=\"skills.php?cId=" . $cId . "&cName=" . $cName . 
			"\">" . $skillCount . "</a>" . "</td>\n<td>" .
			"<a href=\"pCharItems.php?cId=" . $cId . "&cName=" . $cName . 
			"\">" . $itemCount . "</a>" . "</td>\n" .	
			"</tr>";
	}
	$stmt->close();
?>
		</table>
	</div>
	
<!-- form to add new character for this user -->	
	<div id="addCharacterForm">
		<form method="post" action="addCharacter.php">
			<fieldset>
				<legend>Add New Character for <?php echo $_SESSION["userName"] ?> </legend>
				<p>
					<select name="classRef">

<?php
	// get a list of classes
	$stmt = $mysqli->prepare("SELECT id, className FROM characterClass ORDER BY className;");
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
//	 echo "<option value=\"" . $classId . "\">" . $classId . ":  " .  $className . "</option>";
	 echo "<option value=\"" . $classId . "\">" . $className . "</option>";
	}
	$stmt->close();
?>

					</select>
				</p>
				<p>Character Name: <input type="text" name="name" required/></p>			
				<p><input type="submit" name="addNew" value="Add Character" /></p>
				
			</fieldset>
		</form>
	</div>

<!-- form to delete a character belonging to this user -->	
	<div id="deleteCharacterForm">
		<form action="deleteCharacter.php" method="POST">
			<fieldset>
				<legend>Delete Character from <?php echo $_SESSION["userName"] ?> </legend>
				<select name="charToDelete">
				
<?php
	// get a list of characters belonging to this user
	$stmt = $mysqli->prepare("
		SELECT pc.id, pc.characterName FROM playerCharacter pc
		INNER JOIN player p ON pc.playerId = p.id
		WHERE p.id = ?;
	");
	if(!$stmt) {
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	$stmt->bind_param("i", $_SESSION['id']);
	if(!$stmt) {
		echo "bind_param failed: "  . $stmt->errno . " " . $stmt->error;
	}
	// execute the statement
	if(!$stmt->execute()){
		echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	// bind the results to variables and display the results
	if(!$stmt->bind_result($charId, $charName)){
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	while($stmt->fetch()){
	 echo "<option value=\"" . $charId . "\">" . $charName . "</option>";
	}
	$stmt->close();
?>
				</select>
				<br><br>
				<input type="submit" value="Delete Character">
			</fieldset>
		</form>
	</div>
</body>
</html>
