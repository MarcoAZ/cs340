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
$un = $_POST['userName'];
$em = $_POST['email'];

// prepare the query and bind the variables
$stmt = $mysqli->prepare("INSERT INTO player (userName, email) VALUES (?, ?);");
$stmt->bind_param('ss', $un, $em);

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
	<form method="GET" action="players.php">
		<input type="submit" value="Return to Player Table"/>
	</form>
</body>
