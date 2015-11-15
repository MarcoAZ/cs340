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
?>

<!DOCTYPE html>
<html>
<head>
	<meta content="text/html; charset=utf-8"/>
	<title>Game Database</title>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>

<!-- table of players -->
	<div id="skillsTable">
		<table>
			<caption><?php echo $_GET['cName'] . "'s Skills"; ?></caption>
			<tr>
				<td>Skill ID</td>
				<td>Skill Name</td>
			</tr>
			
<!-- Now, populate the table -->
<?php
	$charId = $_GET['cId'];
	
	// prepare statement to get the contents of 'player'
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


