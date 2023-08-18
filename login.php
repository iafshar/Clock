<?php
// login page
session_start();
echo $_SESSION["Error"] ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="login">
			<form action="checkAccount.php"
			<?php $_SESSION["Error"]=NULL;?>
			method="post">
				<input type="text" name="Username" placeholder="Username" id="username" autocomplete="username" required>
				<input type="password" name="Password" placeholder="Password" id="password" autocomplete="current-password" required>
				<input type="submit" value="Login">
			</form>
		</div>
	</body>
</html>
