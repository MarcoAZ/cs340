<?php require("config.php");
checkSession();

$charId = $_POST['id'];
$level = $_POST['level'];
$health = $_POST['health'];
$strength = $_POST['strength'];

// prepare the query and bind the variables
$stmt = $mysqli->prepare("
		UPDATE playerCharacter SET 
			level = ?, 
			health = ?, 
			strength = ?
			WHERE id = ?;
");

$stmt->bind_param('iiii', $level, $health, $strength, $charId);

// execute and report the result
$status = $stmt->execute();
if($status) {
	echo "Changed " . $stmt->affected_rows . " rows in playerCharacter.";
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

</body>
</html>
