<?php
require("config.php");
checkSession();
?>
<!DOCTYPE html>
<html>
<head>
	<meta content="text/html; charset=utf-8"/>
	<title>Game Database | <?php echo $_GET['cName'] ?></title>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
	<p><a href="players.php">Players</a> | <a href="playerCharacters.php"> Characters </a></p>
	<p> Logged in as: <?php echo $_SESSION["userName"] ?>   | <a href="logout.php">Log out</a> </p>

<!-- character details table -->
	<table>
		<caption> <?php echo $_GET['cName'] ?></caption>
		<tr>
			<th>Character Name</th>
			<th>Belongs to Player</th>
			<th>Class</th>				
			<th>Level</th>
			<th>Health</th>
			<th>Strength</th>
			<th>Skill Count</th>
			<th>Item Count</th>
		</tr>

<?php
/* Get character details with a query and show to user  */
	$stmt = $mysqli->prepare("
	SELECT p.userName,
		pc.characterName, 
		cClass.className,
		pc.level, 
		pc.health, 
		pc.strength, 
		IFNULL(cSkl.skillCount, 0) skillCount,
		IFNULL(cItm.itemCount, 0) itemCount
	from player p
	inner join playerCharacter pc on p.id = pc.playerId
	inner join characterClass cClass on cClass.id = pc.classId
	left join(
		SELECT pc.id, count(pc.characterName) skillCount
		FROM playerCharacter pc,
			pCharSkill pcs,
			skill s
		WHERE pcs.pCharId = pc.id
		and s.id = pcs.skillId
		GROUP BY pc.id
	) cSkl on p.id = cSkl.id
	left join(
		SELECT pc.id, count(pc.characterName) itemCount
		FROM playerCharacter pc,
			itemInstance itmI,
			itemClass itmC
		WHERE pc.id= itmI.owner
		and itmC.id = itmI.classID
		GROUP BY pc.id
	) cItm on cItm.id = p.id
	WHERE pc.id = ?");
	
	if(!$stmt) {
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if(!$stmt->bind_param('i', $_GET['cId']))
	{
		echo "Bind param failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
	if(!$stmt->execute()) {
		echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	$stmt->bind_result($player, $cName, $cClass, $level, $Health, $Strength, $skillCount, $itemCount);
	if(!($stmt)) {
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
	//display all this info
	if($stmt->fetch())
	{
		echo "<tr>" . 
		"<td>" . $cName . "</td>" .
		"<td>" . $player . "</td>" .
		"<td>" . $cClass . "</td>" .
		"<td>" . 	$level . "</td>" .
		"<td>" . 	$Health . "</td>" .
		"<td>" . 	$Strength . "</td>" .
		"<td>" . 	$skillCount . "</td>" .
		"<td>" . 	$itemCount . "</td>" .
		"</tr>";
	}
	$stmt->close();
?>
	</table>
