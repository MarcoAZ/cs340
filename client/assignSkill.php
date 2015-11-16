<?php require("config.php");

$skillId = $_POST['skill'];

// prepare the query and bind the variables
$stmt = $mysqli->prepare("INSERT INTO pCharSkill (pCharId, skillId) VALUES (1, ?);");
$stmt->bind_param('i', $skillId);

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
</body>
