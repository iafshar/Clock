<?php
// <!-- Adds the basic account to the DB -->
session_start();
$_SESSION["Error"] = "";
require_once __DIR__ . '/db_config.php';
// Create connection
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['Username']) and isset($_POST['Password1']) and isset($_POST['Email'])){

  $Username = mysqli_real_escape_string($conn, $_REQUEST['Username']);
  $Password = mysqli_real_escape_string($conn, $_REQUEST['Password1']);
  $Password2 = mysqli_real_escape_string($conn, $_REQUEST['Password2']);
  $Email = mysqli_real_escape_string($conn, $_REQUEST['Email']);
  $Premium = 0;

  $_SESSION["Premium"] = $Premium;
  $_SESSION["Username"] = $Username;
  $_SESSION["Password"] = $Password;

  $Insert = "INSERT INTO Users (Username,Password,Email,Premium)
   VALUES ('$Username', '$Password', '$Email', '$Premium')";

  $ExistingUser = "SELECT * FROM `Users` WHERE Username='$Username'";
  $resultUser = mysqli_query($conn, $ExistingUser) or die(mysqli_error($conn));
  $countUser = mysqli_num_rows($resultUser);

  $ExistingEmail = "SELECT * FROM `Users` WHERE Email='$Email'";
  $resultEmail = mysqli_query($conn, $ExistingEmail) or die(mysqli_error($conn));
  $countEmail = mysqli_num_rows($resultEmail);

  $num = 0;
  $alpha = 0;
  $special = 0;

  for ($i = 0; $i < strlen($Password); $i++) { // Counts the number of digits, letters and special characters and stores them respectively in the variables, $num, $alpha and $special
      if (ctype_digit($Password[$i])){
        $num ++;
      }
      elseif (ctype_alpha($Password[$i])){
        $alpha ++;
      }
      else{
        $special ++;
      }
  }
  $invalid = FALSE;
  if (strlen($Password) < 6){
    $invalid = TRUE;
    $_SESSION["Error"] .= "Password must be at least six characters long <br>";
  }
  if ($countUser != 0){
    $invalid = TRUE;
    $Suggest = "SELECT * FROM `Users` WHERE Username LIKE '%$Username%'";
    $resultSuggest = mysqli_query($conn, $Suggest) or die(mysqli_error($conn));
    $countSuggest = mysqli_num_rows($resultSuggest);
    for ($i = 0;$i < $countSuggest;$i ++){
      $Suggestion = $Username . "$i";
      $ExistingSuggestion = "SELECT * FROM `Users` WHERE Username='$Suggestion'";
      $resultSuggestion = mysqli_query($conn, $ExistingSuggestion) or die(mysqli_error($conn));
      $countSuggestion = mysqli_num_rows($resultSuggestion);
      if($countSuggestion == 0){
        break;
      }
    }

    $_SESSION["Error"] .= "Username is Already taken. Try $Suggestion <br>";
  }
  if ($countEmail != 0){
    $invalid = TRUE;
    $_SESSION["Error"] .= "Email is Already taken <br>";
  }
  if ($num == 0){
    $invalid = TRUE;
    $_SESSION["Error"] .= "Password must have at least one number in it <br>";
  }
  if ($alpha == 0){
    $invalid = TRUE;
    $_SESSION["Error"] .= "Password must have at least one letter in it <br>";
  }
  if ($special == 0){
    $invalid = TRUE;
    $_SESSION["Error"] .= "Password must have at least one special character in it <br>";
  }
  if ($Password != $Password2){
    $invalid = TRUE;
    $_SESSION["Error"] .= "The two passwords do not match <br>";
  }
  if($invalid) {
     header("Location:http://localhost:8080/Clock/basSignUp.php");
      }
  else{
     if (mysqli_query($conn, $Insert)) {
          header("Location:http://localhost:8080/Clock/MyClocks.php");
      } else {
          echo "Error: " . $Insert . "<br>" . mysqli_error($conn);
      }
    }
}

mysqli_close($conn);

?>
