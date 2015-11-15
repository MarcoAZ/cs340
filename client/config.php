<?php
	// turn error reporting on
	ini_set('display_errors', 'On');
	
	//database details
	$cFile = fopen("credentials.txt", "r");
	$cInfo = fscanf($cFile, "%s\t%s\t%s\t%s");
	
	// create a new mysqli object that connects to the database
	$mysqli = new mysqli($cInfo[0], $cInfo[1], $cInfo[2], $cInfo[3]);
	// if there's an error, report it:
	if($mysqli->connect_errno) {
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

    // enable sessions
    session_start();

    // require authentication for most pages
	//this checks that the current page is one of the three listed, otherwise it redirects
    // if (!preg_match("{(?:login|logout|register)\.php$}", $_SERVER["PHP_SELF"]))
    // {
        // if (empty($_SESSION["id"]))
        // {
            // redirect("login.php");
        // }
    // }

?>