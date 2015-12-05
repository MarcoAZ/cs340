<?php require("config.php");
checkSession();

$charId = $_POST['cId'];
$charName = $_POST['cName'];
$skillId = $_POST['skill'];

// prepare the query and bind the variables
$stmt = $mysqli->prepare("INSERT INTO pCharSkill (pCharId, skillId) VALUES (?, ?);");
$stmt->bind_param('ii', $charId, $skillId);

// execute and report the result
$status = $stmt->execute();
if($status) {
	echo "Added " . $stmt->affected_rows . " rows to player.";
} else {
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
}
	
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
	<meta content="text/html; charset=utf-8"/>
	<title>Game Database</title>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
	<form method="GET" action="playerCharacters.php">
		<input type="submit" value="Return to Characters Table"/>
	</form>
	<form method="GET" action="skills.php">
	
<?php
	echo "<input type=\"hidden\" name=\"cId\" value=\"" . $charId . "\" />";
	echo "<input type=\"hidden\" name=\"cName\" value=\"" . $charName . "\" />";
	echo "<input type=\"submit\" value=\"Return to Character's Skills\">"; 
?>
	</form>
</body>
