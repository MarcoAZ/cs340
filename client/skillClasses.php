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
	<div id="nav">
		<fieldset>
			<a href="players.php">Players</a> | 
			<a href="playerCharacters.php">Characters</a> |
			<a href="cClasses.php">Classes</a> |
			<a href="itemClasses.php">Items</a> |
			<a href="skillClasses.php">Skills</a>
		</fieldset>
	</div>
	
	<p> Logged in as: <?php echo $_SESSION["userName"] ?>   | <a href="logout.php">Log out</a> </p>

<!-- table of skills -->
	<div id="skillsTable">
		<table>
			<caption>Skills</caption>
			<tr>
				<td>Skill ID</td>
				<td>Skill Name</td>
			</tr>
			
<!-- Now, populate the table -->
<?php
	// prepare statement to get the contents of 'skill'
	$stmt = $mysqli->prepare("SELECT id, skillName FROM skill;");
	if(!$stmt) {
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	// execute the statement
	if(!$stmt->execute()){
		echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	// bind the results to variables and display the results
	if(!$stmt->bind_result($skillId, $skillName)){
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	while($stmt->fetch()){
		echo "<tr>\n<td>\n" . $skillId . "\n</td>\n<td>\n" .
			"<a href=\"skillByPlayer.php?skillId=" . $skillId . "&skillName=" . $skillName . "\">" . 	
	  		$skillName . "</a>\n</td>\n</tr>";
	}
	$stmt->close();
?>

		</table>		
	</div>
	<br />
	
<!-- a form to create a skill -->
	<div id=createSkillForm">
		<form method="post" action="createSkill.php" method="POST">
			<fieldset>
				<legend>Create a New Skill</legend>
				Skill Name:
				<input type="text" name="skillName">
				<input type="submit" name="createSkillButton" value="Create Skill"></input>
			</fieldset>
		</form>
	</div>

<!-- form to delete a skill -->
	<div id=deleteSkillForm">
		<form method="post" action="deleteSClass.php">
			<fieldset>
				<legend>Delete Skill</legend>
				<p>
					<select name="skillToDelete">
<?php
	// get a list of classes

	$stmt = $mysqli->prepare("SELECT id, skillName FROM skill;");
	if(!$stmt) {
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	// execute the statement
	if(!$stmt->execute()){
		echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	// bind the results to variables and display the results
	if(!$stmt->bind_result($skillId, $skillName)){
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	$numRows = 0;
	while($stmt->fetch()){
		$numRows++;
		echo "<option value=\"" . $skillId . "\">" . $skillId . ": " . $skillName . "</option>";
	}
	if(!$numRows) {
		echo "<option value=\"\">No more skills left!</option>";
	}
	$stmt->close();
?>
					
				</p>			
				<p><input type="submit" name="delete" value="Delete Skill"></p>
			</fieldset>
		</form>
	</div>

</body>
</html>
