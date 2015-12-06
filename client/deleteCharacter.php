<?php
require("config.php");

// get the info from the post
$charToDelete = $_POST['charToDelete'];

// prepare the query and bind the variables
//starting stats derivred from class selected and the characterClass table
$stmt = $mysqli->prepare("
	DELETE FROM playerCharacter WHERE id = ?;
");
$stmt->bind_param('i', $charToDelete);

// execute and report the result
$status = $stmt->execute();
if($status) {
	echo "Deleted " . $stmt->affected_rows . " rows from playerCharacter.";
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
		<input type="submit" value="Return to Character Table"/>
	</form>
</body>
</html>
