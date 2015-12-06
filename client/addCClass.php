<?php
require("config.php");

// get the info from the post
$session = $_SESSION['id'];
$className = $_POST['className'];

// prepare the query and bind the variables
//starting stats derivred from class selected and the characterClass table
$stmt = $mysqli->prepare("INSERT INTO characterClass (className) VALUES (?);");
$stmt->bind_param('s', $className);


// execute and report the result
$status = $stmt->execute();
if($status) {
	echo "Added " . $stmt->affected_rows . " rows to characterClass.";
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
