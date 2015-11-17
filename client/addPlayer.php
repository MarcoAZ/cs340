<?php

require("config.php");

// get the info from the post
$un = $_POST['newUserName'];
$em = $_POST['newEmail'];

// prepare the insert query and bind the variables
$stmt = $mysqli->prepare("INSERT INTO player (userName, email) VALUES (?, ?);");
$stmt->bind_param('ss', $un, $em);

// execute and report the result
$status = $stmt->execute();
if($status) {
	echo "Added " . $stmt->affected_rows . " rows to player.";
	
	//create the session parameters
	// query database for user id of newly created user
	$stmt2 = $mysqli->prepare("SELECT id FROM player WHERE userName = ?;");
	if(!$stmt2) {
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	
	if(!$stmt2->bind_param('s', $un))
	{
		echo "Bind param failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
	// execute the statement
	if(!$stmt2->execute()){
		echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
	// bind the result to variable
	if(!$stmt2->bind_result($id)){
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
	//if everything goes well, we have a new session
	if($stmt2->fetch())
	{
		$_SESSION["id"] = $id; 
		$_SESSION["userName"] = $un;
	}
	$stmt2->close();
}
else {
	//echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
	redirect("welcome.php?register=false"); //pass parameters in url to use for error reporting
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
