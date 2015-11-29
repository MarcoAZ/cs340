<?php
require("config.php");

// get the info from the post
$class = $_POST['classToDelete'];

// prepare the query and bind the variables
$stmt = $mysqli->prepare("DELETE FROM characterClass WHERE id = ?;");
if(!$stmt) echo "Error: prepare failed";
$stmt->bind_param("i", $class);
if(!$stmt) echo "Error: bind_param failed";

// execute and report the result
$status = $stmt->execute();
if($status) {
	echo "Deleted " . $stmt->affected_rows . " rows from characterClass.";
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
	<form method="GET" action="cClasses.php">
		<input type="submit" value="Return to Character Classes"/>
	</form>
</body>
</html>
