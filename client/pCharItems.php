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
	<div id="itemsTable">
		<table>
			<caption>
<?php 
	echo "<a href=\"viewCharacter.php?cId=" . $_GET['cId'] . "&cName=" . $_GET['cName'] . "\">" . 
			$_GET['cName'] . "</a>" . "'s Items"; 
?>			
			</caption>
			<tr>
				<th>Item Instance ID</th>
				<th><a href="itemClasses.php">Item Class Name</a></th>
				<th>Available Actions</th>
			</tr>
			
<!-- populate the table -->
<?php
	$charId = $_GET['cId'];
	$charName = $_GET['cName'];
	
	// prepare statement to get a list of items the player character has
	$stmt = $mysqli->prepare(
		"SELECT ii.id, ic.itemName 
		FROM itemInstance ii 
		INNER JOIN itemClass ic ON ii.classId = ic.id
		INNER JOIN playerCharacter pc ON ii.owner = pc.id
		WHERE pc.id = ?;"
	);
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
	if(!$stmt->bind_result($itemId, $itemName)) {
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	while($stmt->fetch()) {
		echo "<tr><td>" . $itemId . "\n</td>\n<td>\n" . $itemName . "\n</td>\n" .
		"<td><a href=\"destroyItem.php?iId=" . $itemId . "&cId=" . $charId . "&cName=" . 
		$charName . "\">Remove Item</a></td></tr>";
	}
	$stmt->close();
?>

		</table>		
	</div>
	<br />

<!-- form to add an item -->
	<div id=addItem">
		<form method="post" action="instantiateItem.php">
		
<?php
// add the character ID to the form
echo "<input type=\"hidden\" name=\"cId\" value=" . $_GET['cId'] . "\"/>";
echo "<input type=\"hidden\" name=\"cName\" value=" . $_GET['cName'] . "\"/>";
?>
			<fieldset>
				<legend>Give a new item to <?php echo $_GET['cName'];?></legend>
				<p>
					Item
					<select name="item">

<?php 
	// get a list of items
	$stmt = $mysqli->prepare(
		"SELECT itemName, id FROM itemClass;"
	);
	if(!$stmt) {
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	// execute the statement
	if(!$stmt->execute()){
		echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	// bind the results to variables and display the results
	if(!$stmt->bind_result($itemName, $iClassId)){
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	while($stmt->fetch()){
	 echo "<option value=\"" . $iClassId . "\">" . $iClassId . ": " . $itemName . "</option>";
	}
	$stmt->close();
?>

					</select>
				</p>			
				<p><input type="submit" name="giveItem" value="Give Item"></p>
			</fieldset>
		</form>
	</div>

</body>
</html>
