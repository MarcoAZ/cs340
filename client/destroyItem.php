<?php require("config.php");
checkSession();

$itemId = $_GET['iId'];
$charId = $_GET['cId'];
$charName = $_GET['cName'];

// prepare the query and bind the variables
$stmt = $mysqli->prepare("DELETE FROM itemInstance WHERE id = ?;");
$stmt->bind_param('i', $itemId);

// execute and report the result
$status = $stmt->execute();
if($status) {
	echo "Removed " . $stmt->affected_rows . " rows from itemInstance.";
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
