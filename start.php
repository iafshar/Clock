<?php session_start();
$_SESSION["Searches"] = array(); // This will contain the user's 5 most recent searches
$_SESSION["Error"] = NULL; // This will be a string containing all the errors the user has made when trying to login or sign-up
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Welcome</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<h1 class="clock">CLOCK</h1>
		<div class="start">
			<form>
				<a href="choose.html" class="signUpBtn">Sign-Up</a>
				<a href="Clock_JS_NoAcc/index.html" class="noAccountBtn">No Account</a>
				<a href="login.php" class="loginBtn">Login</a>
			</form>
		</div>
	</body>
</html>
