
<?php
session_start();
echo $_SESSION["ErrorEmail"]; 
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Forgot Password</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="login">
			<form action="sendEmail.php" <?php $_SESSION["ErrorEmail"]=NULL;?> method="post">
			
				<input type="text" name="Forgot" placeholder="Email or Username" id="email" autocomplete="email" required>
				<input type="submit" value="Reset">
			</form>
		</div>
	</body>
</html>