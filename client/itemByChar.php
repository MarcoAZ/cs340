<?php
require("config.php");
checkSession();
?>
<!DOCTYPE html>
<html>
<head>
	<meta content="text/html; charset=utf-8"/>
	<title>Game Database | <?php echo $_GET['cName'] ?></title>
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

<!-- skill-player table -->
	<table>
		<caption><?php echo $_GET["itemName"]; ?>
		</caption>
		<tr>
			<th>Player ID</th>
			<th>Player Name</th>
		</tr>

<?php
// Get list of characters with this skill  
	$stmt = $mysqli->prepare("
		SELECT pc.id, pc.characterName FROM playerCharacter pc
		INNER JOIN itemInstance ii ON pc.id = ii.owner
		WHERE ii.classId = ?;
	");
	if(!$stmt) {
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if(!$stmt->bind_param('i', $_GET["itemId"]))
	{
		echo "Bind param failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
	if(!$stmt->execute()) {
		echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	$stmt->bind_result(
			$playerId,
			$playerName
	);
	if(!($stmt)) {
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	//display all this info
	while($stmt->fetch())
	{
		echo "<tr>" . 
		"<td>" . $playerId . "</td>" .
		"<td>" . $playerName . "</td>" .
		"</tr>";
	}
	$stmt->close();
?>
	</table>
</body>
