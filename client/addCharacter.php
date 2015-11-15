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
$creator = $_POST['creator'];
$class = $_POST['classRef'];
$name = $_POST['name'];
// $level = $_POST['level'];
// $health = $_POST['health'];
// $strength = $_POST['strength'];

echo "creator = " . $creator . "\nclassRef = ". $class;

// prepare the query and bind the variables
//starting stats derivred from class selected and the characterClass table
$stmt = $mysqli->prepare("
	INSERT INTO playerCharacter (characterName, level, health, strength, playerId, classId) 
	VALUES (?,
	(SELECT startLevel FROM characterClass WHERE id = ?), 
	(SELECT startHealth FROM characterClass WHERE id = ?),
	(SELECT startStrength FROM characterClass WHERE id = ?),
	?, ?);");
$stmt->bind_param('siiiii', $name, $class, $class, $class, $creator, $class);


// execute and report the result
$status = $stmt->execute();
if($status) {
	echo "Added " . $stmt->affected_rows . " rows to playerCharacter.";
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
