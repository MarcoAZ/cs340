<?php
	// turn error reporting on
	ini_set('display_errors', 'On');
	$cFile = fopen("credentials.txt", "r");
	$cInfo = fscanf($cFile, "%s\t%s\t%s\t%s");
	// create a new mysqli object that connects to the database
	$mysqli = new mysqli($cInfo[0], $cInfo[1], $cInfo[2], $cInfo[3]);
	// if there's an error, report it:
	if($mysqli->connect_errno) {
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

// get the info from the post
$player = $_POST['playerToChange'];
$email = $_POST['email'];

// prepare the query and bind the variables
$stmt = $mysqli->prepare("UPDATE player SET email = ? WHERE id = ?;");
if(!$stmt) echo "Error: prepare failed";
$stmt->bind_param("si", $email, $player);
if(!$stmt) echo "Error: bind_param failed";

// execute and report the result
$status = $stmt->execute();
if($status) {
	echo "Updated " . $stmt->affected_rows . " rows from player.";
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
	<form method="GET" action="players.php">
		<input type="submit" value="Return to Player Table"/>
	</form>
</body>
</html>
