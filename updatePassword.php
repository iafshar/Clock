<?php
// <!-- the profile page of the user -->
session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clock | Update Password</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	<link href="css/landing.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="signUp">
			<form action="changeUserPassword.php"
			<?php $_SESSION["ErrorReset"]=NULL;?>
			method="post"> <!--Makes sure that the same errors are not presented if the user goes to a different page-->
				<div>
					<input type="password" name="Password1" placeholder="New Password" id="password" autocomplete="new-password" required>
					<input type="password" name="Password2" placeholder="Confirm Password" id="confirm-password" autocomplete="new-password" required>
					<input type="submit" value="Enter" onclick="save()">
				</div>
			</form>
			<div id="message" style=
			<?php
				if (isset($_SESSION["messageResetDisplay"])) {
					echo "display:".$_SESSION["messageResetDisplay"];
				}
				
			?>
			>
				<p id="different" class=
				<?php 
					if (isset($_SESSION["differentResetClass"])) {
						echo $_SESSION["differentResetClass"];
					} 
					else {
						echo "invalid";
					}?>>Password must be <b>different</b> from previous passwords</p>
				<p id="letter" class=
				<?php 
					if (isset($_SESSION["letterResetClass"])) {
						echo $_SESSION["letterResetClass"];
					} 
					else {
						echo "invalid";
					}?>>Password must have a <b>letter</b></p>
				<p id="number" class=
				<?php 
					if (isset($_SESSION["numberResetClass"])) {
						echo $_SESSION["numberResetClass"];
					} 
					else {
						echo "invalid";
					}?>>Password must have a <b>number</b></p>
				<p id="special" class=
				<?php 
					if (isset($_SESSION["specialResetClass"])) {
						echo $_SESSION["specialResetClass"];
					} 
					else {
						echo "invalid";
					}?>>Password must have a <b>special character</b></p>
				<p id="length" class=
				<?php 
					if (isset($_SESSION["lengthResetClass"])) {
						echo $_SESSION["lengthResetClass"];
					} 
					else {
						echo "invalid";
					}?>>Password must be at least <b>6 characters</b></p>
				<p id="match" class=
				<?php 
					if (isset($_SESSION["matchResetClass"])) {
						echo $_SESSION["matchResetClass"];
					} 
					else {
						echo "invalid";
					}?>>Passwords <b>must match</b></p>
			</div>
		</div>
		<script>
			function save() {

				
				var resetPassword = document.getElementById("password").value;
				localStorage.setItem("resetPassword", resetPassword); 

				var resetPassword2 = document.getElementById("confirm-password").value;
				localStorage.setItem("resetPassword2", resetPassword2); 

			}
		</script>
		<script>
			document.getElementById("password").value = localStorage.getItem('resetPassword');
			document.getElementById("confirm-password").value = localStorage.getItem('resetPassword2');
		</script>
		<script>
				var password1 = document.getElementById("password");
				var password2 = document.getElementById("confirm-password");

				var different = document.getElementById("different");
				var letter = document.getElementById("letter");
				var special = document.getElementById("special");
				var number = document.getElementById("number");
				var length = document.getElementById("length");
				var match = document.getElementById("match");

				// When the user starts to type something inside the password field
				password1.onkeyup = function() {
					document.getElementById("message").style.display = "block";
					if (password2.value == password1.value) {
						match.classList.remove("invalid");
						match.classList.add("valid");
					}
					else {
						match.classList.remove("valid");
						match.classList.add("invalid");
					}
					
					// Validate letters
					var letters = /[A-Za-z]/g;
					if(password1.value.match(letters)) {
						letter.classList.remove("invalid");
						letter.classList.add("valid");
					} else {
						letter.classList.remove("valid");
						letter.classList.add("invalid");
					}

					// Validate special characters
					var specialChars = /[^A-Za-z0-9]/g;
					if(password1.value.match(specialChars)) {
						special.classList.remove("invalid");
						special.classList.add("valid");
					} else {
						special.classList.remove("valid");
						special.classList.add("invalid");
					}

					// Validate numbers
					var numbers = /[0-9]/g;
					if(password1.value.match(numbers)) {
						number.classList.remove("invalid");
						number.classList.add("valid");
					} else {
						number.classList.remove("valid");
						number.classList.add("invalid");
					}

					// Validate length
					if(password1.value.length >= 6) {
						length.classList.remove("invalid");
						length.classList.add("valid");
					} else {
						length.classList.remove("valid");
						length.classList.add("invalid");
					}

					// if nothing is entered in any of the boxes dont display the checklist
					if (password1.value.length == 0 && password2.value.length == 0) {
						document.getElementById("message").style.display = "none";
					}

					// Decide whether to display a tick or a cross for the password being one the user hasnt used before
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							var response = JSON.parse(this.responseText);

							different.classList.remove(response.removeDifferentClass);
							different.classList.add(response.addDifferentClass);
						}
					};
					xmlhttp.open("GET", "checkAccount.php?checkbox=1&password="+password1.value, true);
					xmlhttp.send();
				}

				password2.onkeyup = function() {
					// Validate that the two passwords match
					document.getElementById("message").style.display = "block";
					if (password2.value == password1.value) {
						match.classList.remove("invalid");
						match.classList.add("valid");
					}
					else {
						match.classList.remove("valid");
						match.classList.add("invalid");
					}

					// if nothing is entered in any of the boxes dont display the checklist
					if (password1.value.length == 0 && password2.value.length == 0) {
						document.getElementById("message").style.display = "none";
					}
				}

		</script>
</body>
</html>
