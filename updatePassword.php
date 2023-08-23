<?php
// <!-- the profile page of the user -->
session_start();
echo $_SESSION["ErrorReset"]; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="signUp">
			<form action="changeUserPassword.php"
			<?php $_SESSION["ErrorReset"]=NULL;?>
			method="post"> <!--Makes sure that the same errors are not presented if the user goes to a different page-->
				<div>
					<input type="password" name="Password1" placeholder="New Password" id="password" autocomplete="new-password" required>
					<input type="password" name="Password2" placeholder="Confirm Password" id="confirm-password" autocomplete="new-password" required>
					<input type="submit" value="Enter">
				</div>
			</form>
		</div>
</body>
</html>
