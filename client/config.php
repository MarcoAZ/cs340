<?php
    // enable sessions
    session_start();
	
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

	
/*     require authentication for most pages
	we don't want to redirect from the welcome page! loop de loop */
	function checkSession()
	{
        if (empty($_SESSION["id"]))
        {
            redirect("welcome.php");
        }
    }
	
/*	handles redirects
	http://php.net/manual/en/function.header.php */
	function redirect($url)
	{
		/* Redirect to a different page in the current directory that was requested */
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		header("Location: http://$host$uri/$url");
		exit;
	}

/* 	destroys sessions */
	function logout()
    {
        // unset any session variables
        $_SESSION = [];

        session_destroy();
    }
	

?>