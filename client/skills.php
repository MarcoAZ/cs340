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
			<caption>
<?php 
	echo "<a href=\"viewCharacter.php?cId=" . $_GET['cId'] . "&cName=" . $_GET['cName'] . "\">" . 
			$_GET['cName'] . "</a>" . "'s Skills"; 
?>			
			
			</caption>
			<tr>
				<td>Skill ID</td>
				<td>Skill Name</td>
			</tr>
			
<!-- populate the table -->
<?php
	$charId = $_GET['cId'];
	// $_SESSION['cId'] = $charId;
	
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
		
<?php
// add the character ID and Name to the form
echo "<input type=\"hidden\" name=\"cId\" value=" . $_GET['cId'] . "\"/>";
echo "<input type=\"hidden\" name=\"cName\" value=" . $_GET['cName'] . "\"/>";
?>
			<fieldset>
				<legend>Assign a new skill</legend>
				<p>
					Skill
					<select name="skill">

<?php
	// get a list of skills
	$stmt = $mysqli->prepare(
		"SELECT s.id, s.skillName FROM skill s
		WHERE s.id NOT IN (
			SELECT skillId FROM pCharSkill
			WHERE pCharId = ?
		);"
	);
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
	$numRows = 0;
	while($stmt->fetch()){
		$numRows++;
		echo "<option value=\"" . $skillId . "\">" . $skillId . ": " . $skillName . "</option>";
	}
	if(!$numRows) {
		echo "<option value=\"\">No more skills left to learn!</option>";
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
