<?php
// Sign up page for a basic account
session_start();
echo $_SESSION["Error"]; ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Sign-Up</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="signUp">
			<form action="addBasAccount.php"
			<?php $_SESSION["Error"]=NULL;?>
			method="post"> <!--Makes sure that the same errors are not presented if the user goes to a different page-->
				<div>
					<input type="text" name="Username" placeholder="Username" id="username" required>
					<input type="password" name="Password1" placeholder="Password" id="password" required>
					<input type="password" name="Password2" placeholder="Confirm Password" id="password" required>
					<input type="email" name="Email" placeholder="Email" id="email" required>
					<input type="submit" value="Sign-Up">
				</div>
			</form>
		</div>
	</body>
</html>
