<?php
require("config.php");
checkSession();
?>

<!DOCTYPE html>
<html>
<head>
	<meta content="text/html; charset=utf-8"/>
	<title>Game Database</title>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
	<p><a href="players.php">Players</a> | <a href="playerCharacters.php"> Characters </a></p>
	<p> Logged in as: <?php echo $_SESSION["userName"] ?>   | <a href="logout.php">Log out</a> </p>
<!-- table of players -->
	<div id="playersTable">
		<table>
			<caption>Players</caption>
			<tr>
				<td>Player ID</td>
				<td>User Name</td>
				<td>E-mail Address</td>
			</tr>
			
<!-- Now, populate the table -->
<?php
	// prepare statement to get the contents of 'player'
	$stmt = $mysqli->prepare("SELECT id, userName, email FROM player;");
	if(!$stmt) {
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	// execute the statement
	if(!$stmt->execute()){
		echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	// bind the results to variables and display the results
	if(!$stmt->bind_result($playerId, $username, $playerEmail)){
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	while($stmt->fetch()){
	 echo "<tr>\n<td>\n" . $playerId . "\n</td>\n<td>\n" . $username . "\n</td>\n<td>\n" . $playerEmail . "\n</td>\n</tr>";
	}
	$stmt->close();
?>

		</table>		
	</div>
	<br />

<!-- a form to add new players -->	
	<div id="userInfoForm">
		<form method="post" action="addPlayer.php">
			<fieldset>
				<legend>Add New Player</legend>
				<p>User Name: <input type="text" name="userName" required/></p>
				<p>E-mail Address: <input type="text" name="email" required/></p>
				<p><input type="submit" name="addNew" value="Add Player" /></p>
			</fieldset>
		</form>
	</div>
	
<!-- a form to delete player info -->
	<div id=deleteUserForm">
		<form method="post" action="deletePlayer.php">
			<fieldset>
				<legend>Delete Player</legend>
				<p>	Player: <?php echo $_SESSION["userName"] ?> </p>			
				<p><input type="submit" name="delete" value="Delete Player"></p>
			</fieldset>
		</form>
	</div>
	
<!-- form to change e-mail address -->	
	<div id="editUserInfoForm">
		<form method="post" action="editPlayer.php">
			<fieldset>
				<legend>Change Player Info</legend>
				<p>	Player: <?php echo $_SESSION["userName"] ?> </p>
				<p>New email address: <input type="text" name="email" required /></p>
				<p><input type="submit" name="changeEmail" value="Change E-mail Address"></p>
			</fieldset>
		</form>
	</div>

</body>
</html>
