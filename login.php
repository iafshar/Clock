<!-- login page -->
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Clock | Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="css/landing.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="login">
			<form action="checkAccount.php"
			method="post">
				<input type="text" name="Username" placeholder="Username" id="username" autocomplete="username" required>
				<input type="password" name="Password" placeholder="Password" id="password" autocomplete="current-password" required>
				<input type="submit" value="Login" onclick="save()">
				<a href="forgotPassword.php" class="forgot">Forgot your password?</a>
				<a href="choose.html" class="create">Create an account</a>
			</form>
			<div id="message" style="display:none">
			<p id="username-checkbox" class="invalid">
				invalid credentials
			</p>
			</div>
			<script>
				function save() {
					// saves the username so that the user doesnt have to reenter it if they get the password wrong
					var loginUsername = document.getElementById("username").value;
					localStorage.setItem("loginUsername", loginUsername);
				}
				
				if (document.referrer == window.location.href) { // if the previous page is the same, i.e. the user entered the wrong credentials
					// display the checklist saying invalid credentials
					document.getElementById("message").style.display = "block";
				}
				else {
					// hide the checklist saying invalid credentials.
					document.getElementById("message").style.display = "none";
				}
			</script>
			<script>
				// if there is something in localStorage[loginUsername] put it in the username field
				// if not it will just put an empty string in that the user can just add to
				document.getElementById("username").value = localStorage.getItem('loginUsername');
			</script>
		</div>
	</body>
</html>
