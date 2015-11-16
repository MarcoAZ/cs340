<?php require("config.php"); 
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
<!-- table of skills -->
	<div id="skillsTable">
		<table>
			<caption><?php echo $_GET['cName'] . "'s Skills"; ?></caption>
			<tr>
				<td>Skill ID</td>
				<td>Skill Name</td>
			</tr>
			
<!-- populate the table -->
<?php
	$charId = $_GET['cId'];
	$_SESSION['cId'] = $charId;
	
	// prepare statement to get the contents of 'pCharSkill'
	$stmt = $mysqli->prepare("SELECT s.id, s.skillName 
								FROM skill s INNER JOIN pCharSkill ps ON s.id = ps.skillId
								WHERE ps.pCharId = ?;");
	if(!$stmt) {
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	$stmt->bind_param("i", $charId);	
	if(!$stmt) {
		echo "bind_param failed: "  . $stmt->errno . " " . $stmt->error;
	}
	// execute the statement
	if(!$stmt->execute()){
		echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	// bind the results to variables and display the results
	if(!$stmt->bind_result($skillId, $skillName)){
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	while($stmt->fetch()){echo "<tr><td>" . $skillId . "\n</td>\n<td>\n" . $skillName . "\n</td>\n</tr>";
	}
	$stmt->close();
?>

		</table>		
	</div>
	<br />

<!-- form to add a skill -->
	<div id=addSkill">
		<form method="post" action="assignSkill.php">
			<fieldset>
				<legend>Assign a new skill</legend>
				<p>
					Skill
					<select name="skill">

<?php
	// get a list of skills
	$stmt = $mysqli->prepare("SELECT s.id, s.skillName FROM skill s
								WHERE s.id NOT IN (
									SELECT skillId FROM pCharSkill
									WHERE pCharId = ?);");
	if(!$stmt) {
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	$stmt->bind_param('i', $charId);
	// execute the statement
	if(!$stmt->execute()){
		echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	// bind the results to variables and display the results
	if(!$stmt->bind_result($skillId, $skillName)){
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	while($stmt->fetch()){
	 echo "<option value=\"" . $skillId . "\">" . $skillId . ": " . $skillName . "</option>";
	}
	$stmt->close();
?>

					</select>
				</p>			
				<p><input type="submit" name="Assign Skill" value="Assign Skill"></p>
			</fieldset>
		</form>
	</div>
</body>
</html>
