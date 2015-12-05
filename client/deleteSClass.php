<?php
require("config.php");

// get the info from the post
$skillId = $_POST['skillToDelete'];

// prepare the query and bind the variables
$stmt = $mysqli->prepare("DELETE FROM skill WHERE id = ?;");
if(!$stmt) echo "Error: prepare failed";
$stmt->bind_param("i", $skillId);
if(!$stmt) echo "Error: bind_param failed";

// execute and report the result
$status = $stmt->execute();
if($status) {
	echo "Deleted " . $stmt->affected_rows . " rows from skill.";
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
	<form method="GET" action="skillClasses.php">
		<input type="submit" value="Return to skills"/>
	</form>
</body>
</html>
