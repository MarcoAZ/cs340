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
		SELECT p.id,
			pc.id, 
			p.userName,
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
			SELECT pc.id, count(pcs.skillId) skillCount
			FROM playerCharacter pc
				left join pCharSkill pcs on pc.id=pcs.pCharId
				left join skill s on s.id = pcs.skillId
			GROUP BY pc.id
		) cSkl on pc.id = cSkl.id
		left join(
			SELECT pc.id, count(itmI.id) itemCount
			FROM playerCharacter pc
				left join itemInstance itmI on pc.id = itmI.owner
				left join itemClass itmC on itmI.classId = itmC.id
		
			GROUP BY pc.id
		) cItm on cItm.id = pc.id
		WHERE pc.id = ?
	");
	
	if(!$stmt) {
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	if(!$stmt->bind_param('i', $_GET['cId'])) {
		echo "Bind param failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
	if(!$stmt->execute()) {
		echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	$stmt->bind_result(
			$pId, 
			$charId, 
			$player, 
			$cName, 
			$cClass, 
			$level, 
			$Health, 
			$Strength, 
			$skillCount, 
			$itemCount
	);
	if(!($stmt)) {
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
	//display all this info
	if($stmt->fetch()) {
		echo "<tr>" . 
		"<td>" . $cName . "</td>" .
		"<td><a href=\"viewPlayer.php?pId=" . 
				$pId . "&pName=" . $player . "\">" .
				$player . "</a></td>" .
		"<td>" . $cClass . "</td>" .
		"<td>" . $level . "</td>" .
		"<td>" . $Health . "</td>" .
		"<td>" . $Strength . "</td>" .
		"<td><a href=\"skills.php?cId=" . $charId . "&cName=" . $cName . "\">" .
				$skillCount . "</a></td>" .
		"<td><a href=\"pCharItems.php?cId=" . $charId . "&cName=" . $cName . "\">" .
				$itemCount . "</a></td>" .
		"</tr>";
	}
	$stmt->close();
?>
	</table>
	
	<fieldset>
		<legend>Edit Attributes</legend>
		<form action="editCharacter.php" method="POST">
<?php
	echo "Level: <input type=\"text\" name=\"level\" value=\"" . $level . "\"><br>" .
			"Health: <input type=\"text\" name=\"health\" value=\"" . $Health . "\"><br>" .
			"Strength: <input type=\"text\" name=\"strength\" value=\"" . $Strength . "\">" .
			"<input type=\"hidden\" name=\"id\" value=\"" . $charId . "\"><br><br>" . 
			"<input type=\"submit\" value=\"Save Changes\">";		
?>
		</form>
	</fieldset>
	<fieldset>
	<legend>Skills and Items</legend>
<?php
	echo "<a href=\"skills.php?cId=" . $charId . "&cName=" . $cName . "\">Edit Skills</a><br><br>" .
			"<a href=\"pCharItems.php?cId=" . $charId . "&cName=" . $cName . "\">Edit Items</a>";
?>
	</fieldset>
</body>

