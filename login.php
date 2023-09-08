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
				<a href="forgotPassword.php" class="forgot">Forgot your password?</a>
				<input type="submit" value="Login" onclick="save()">
				<a href="choose.html" class="create">Create an account</a>
			</form>
			<script>
				function save() {
					var loginUsername = document.getElementById("username").value;
					localStorage.setItem("loginUsername", loginUsername); 
				}
	
			</script>
			<script>
				document.getElementById("username").value = localStorage.getItem('loginUsername');
			</script>
		</div>
	</body>
</html>
