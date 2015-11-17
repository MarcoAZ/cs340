<!DOCTYPE html>
<html>
<head>
	<meta content="text/html; charset=utf-8"/>
	<title>Game Database: Welcome</title>
</head>

<body>
	<h1> WELCOME PAGE </h1>
	<form method="post" action="login.php">
		<fieldset>
				<legend>Log in</legend>
				<p>User Name: <input type="text" name="userName" required/></p>
				<p><input type="submit" name="loginButton" value="Login" /></p>
		</fieldset>
	</form>

	<div id="userInfoForm">
		<form method="post" action="addPlayer.php">
			<fieldset>
				<legend>New users register here!</legend>
				<p>User Name: <input type="text" name="newUserName" required/></p>
				<p>E-mail Address: <input type="text" name="newEmail" required/></p>
				<p><input type="submit" name="addNew" value="Add Player" /></p>
			</fieldset>
		</form>
	</div>

</body>

</html>