<?php

require("config.php");

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
