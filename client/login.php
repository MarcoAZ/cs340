<?php
/*Login page for game database*/
require("config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // query database for user
		$stmt = $mysqli->prepare("SELECT id, userName FROM player WHERE userName = ?;");
		if(!$stmt) {
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		
		if(!$stmt->bind_param('s', $_POST["userName"]))
		{
			echo "Bind param failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		
		// execute the statement
		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		
		// bind the result to variable
		if(!$stmt->bind_result($id, $userName)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		
		//check for found user
		if($stmt->fetch())
		{
			$_SESSION["id"] = $id; //remember the player id and name
			$_SESSION["userName"] = $userName;
			redirect("players.php");
		}
		else
		{
			redirect("welcome.php?login=false");
		}
}

?>
