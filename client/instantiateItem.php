<?php require("config.php");
checkSession();

$charId = $_POST['cId'];
$itemId = $_POST['item'];
$charName = $_POST['cName'];

// prepare the query and bind the variables
$stmt = $mysqli->prepare("INSERT INTO itemInstance (classId, owner) VALUES (?, ?);");
$stmt->bind_param('ii', $itemId, $charId);

// execute and report the result
$status = $stmt->execute();
if($status) {
	echo "Added " . $stmt->affected_rows . " rows to itemInstance.";
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
	<form method="GET" action="pCharItems.php">
<?php
echo "<input type=\"hidden\" name=\"cId\" value=\"" . $charId . "\"/>";
echo "<input type=\"hidden\" name=\"cName\" value=\"" . $charName . "\"/>";
?>
		<input type="submit" value="Return to Character's Items Table"/>
	</form>
</body>
</html>
