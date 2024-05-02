<?php
// <!-- the profile page of the user -->
session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clock | Update Email</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	<link href="css/landing.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="signUp">
			<form action="changeUserEmail.php"
			method="post"> <!--Makes sure that the same errors are not presented if the user goes to a different page-->
				<div>
					<input type="email" name="email1" placeholder="Old Email" id="old-email" autocomplete="email" required>
					<input type="email" name="email2" placeholder="New Email" id="new-email" autocomplete="off" required>
                    <input type="submit" value="Enter" onclick="save()">
				</div>
			</form>
			<div id="message" style=
			<?php
				if (isset($_SESSION["messageEmailDisplay"])) {
					echo "display:".$_SESSION["messageEmailDisplay"];
				}
				
			?>
			>
				<p id="wrongEmail" class=
				<?php 
					if (isset($_SESSION["wrongEmail"])) {
						echo $_SESSION["wrongEmail"];
					} 
					else {
						echo "invalid";
					}?>>The old email is not associated with an account</p>
				<p id="uniqueEmail" class=
				<?php 
					if (isset($_SESSION["existingEmail"])) {
						echo $_SESSION["existingEmail"];
					} 
					else {
						echo "invalid";
					}?>>The new email already exists but it must be unique</p>
			</div>
		</div>
		<script>
			function save() {

				
				var oldEmail = document.getElementById("old-email").value;
				localStorage.setItem("oldEmail", oldEmail); 

				var newEmail = document.getElementById("new-email").value;
				localStorage.setItem("newEmail", newEmail); 

			}
		</script>
		<script>
			document.getElementById("old-email").value = localStorage.getItem('oldEmail');
			document.getElementById("new-email").value = localStorage.getItem('newEmail');
		</script>
		<script>
				var oldEmail = document.getElementById("old-email");
				var newEmail = document.getElementById("new-email");

				var wrong = document.getElementById("wrongEmail");
				var unique = document.getElementById("uniqueEmail");

				// When the user starts to type something inside the old email field
				oldEmail.onkeyup = function() {
					document.getElementById("message").style.display = "block";

					// if nothing is entered in any of the boxes dont display the checklist
					if (oldEmail.value.length == 0 && oldEmail.value.length == 0) {
						document.getElementById("message").style.display = "none";
					}

					// Decide whether to display a tick or a cross for the email being recognized or not
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							var response = JSON.parse(this.responseText);

							wrong.classList.remove(response.removeWrongClass);
							wrong.classList.add(response.addWrongClass);
						}
					};
					xmlhttp.open("GET", "checkAccount.php?checkbox=1&email="+oldEmail.value, true);
					xmlhttp.send();
				}

				newEmail.onkeyup = function() {
					// Validate that the new email does not exist in the database
					document.getElementById("message").style.display = "block";

                    // Decide whether to display a tick or a cross for the new email being unique
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							var response = JSON.parse(this.responseText);

							unique.classList.remove(response.removeEmailClass);
							unique.classList.add(response.addEmailClass);
						}
					};
					xmlhttp.open("GET", "checkAccount.php?checkbox=1&email="+newEmail.value, true);
					xmlhttp.send();

					// if nothing is entered in any of the boxes dont display the checklist
					if (oldEmail.value.length == 0 && oldEmail.value.length == 0) {
						document.getElementById("message").style.display = "none";
					}
				}

		</script>
        <script>
			if (document.referrer == window.location.href) {
                document.getElementById("message").style.display = "block";
			}
			else {
                document.getElementById("message").style.display = "none";
			}
		</script>
</body>
</html>