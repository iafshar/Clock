<?php
// <!-- Adds the account to the DB -->
session_start();
$_SESSION["Error"] = "";
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();


if (isset($_POST['Username']) and isset($_POST['Password1']) and isset($_POST['Email']) and isset($_POST['Premium'])){

  $Username = mysqli_real_escape_string($conn, $_REQUEST['Username']);
  $Password = mysqli_real_escape_string($conn, $_REQUEST['Password1']); // first enetered password
  $Password2 = mysqli_real_escape_string($conn, $_REQUEST['Password2']); // confirm password
  $Email = mysqli_real_escape_string($conn, $_REQUEST['Email']);
  $Premium = mysqli_real_escape_string($conn, $_REQUEST['Premium']);;

  $_SESSION["Premium"] = $Premium;
  $_SESSION["Username"] = $Username;
  $_SESSION["Email"] = $Email;

  $ExistingUser = "SELECT * FROM `Users` WHERE Username='$Username'"; // checks if there is already a user with the same username
  $resultUser = mysqli_query($conn, $ExistingUser) or die(mysqli_error($conn));
  $countUser = mysqli_num_rows($resultUser); 

  $ExistingEmail = "SELECT * FROM `Users` WHERE Email='$Email'"; // checks if there is already a user with the same email
  $resultEmail = mysqli_query($conn, $ExistingEmail) or die(mysqli_error($conn));
  $countEmail = mysqli_num_rows($resultEmail);

  $num = 0; // number of digits in the password
  $alpha = 0; // number of alphabetical chars in the password
  $special = 0; // number of special chars in the password

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
  $invalid = FALSE; // a variable that will be true if anything about the user's signup details is invalid
  if (strlen($Password) < 6){
    $invalid = TRUE;
    $_SESSION["lengthClass"] = "invalid"; // makes the checkbox for length have a red X
  }
  else {
    $_SESSION["lengthClass"] = "valid"; // makes the checkbox for length have a green tick
  }
  if ($countUser != 0){ // if there already is a user with the username
    $invalid = TRUE;
    $Suggest = "SELECT * FROM `Users` WHERE Username LIKE '%$Username%'";
    $resultSuggest = mysqli_query($conn, $Suggest) or die(mysqli_error($conn));
    $countSuggest = mysqli_num_rows($resultSuggest);
    for ($i = 0;$i < $countSuggest;$i ++){
      $Suggestion = $Username . "$i"; // temporary suggestion
      $ExistingSuggestion = "SELECT * FROM `Users` WHERE Username='$Suggestion'"; // checks if a user with the suggestion as their username exists
      $resultSuggestion = mysqli_query($conn, $ExistingSuggestion) or die(mysqli_error($conn));
      $countSuggestion = mysqli_num_rows($resultSuggestion);
      if($countSuggestion == 0){ // if the suggestion is not an existing username in the database, it will be used as the suggestion
        break;
      }
    }

    $_SESSION["usernameClass"] = "invalid";
    $_SESSION["usernameSuggestion"] = $Suggestion;
  }
  else {
    $_SESSION['usernameSuggestion'] = NULL;
    $_SESSION["usernameClass"] = "valid";
  }
  if ($countEmail != 0){
    $invalid = TRUE;
    $_SESSION["emailClass"] = "invalid";
  }
  else {
    $_SESSION["emailClass"] = "valid";
  }
  if ($num == 0){
    $invalid = TRUE;
    $_SESSION["numberClass"] = "invalid";
  }
  else {
    $_SESSION["numberClass"] = "valid";
  }
  if ($alpha == 0){
    $invalid = TRUE;
    $_SESSION["letterClass"] = "invalid";
  }
  else {
    $_SESSION["letterClass"] = "valid";
  }
  if ($special == 0){
    $invalid = TRUE;
    $_SESSION["specialClass"] = "invalid";
  }
  else {
    $_SESSION["specialClass"] = "valid";
  }
  if ($Password != $Password2){
    $invalid = TRUE;
    $_SESSION["matchClass"] = "invalid";
  }
  else {
    $_SESSION["matchClass"] = "valid";
  }
  if($invalid) { // if anything is invalid display the checklist and link back to signup
    $_SESSION["messageDisplay"] = "block";

    header("Location:https://clockdrum.000webhostapp.com/signUp.php");
  }
  else{
    // hash password here and set session["Password"] to it
    $hashedPassword = mysqli_real_escape_string($conn, password_hash($Password, PASSWORD_DEFAULT));
    $_SESSION["Password"] = $hashedPassword;
    header("Location:https://clockdrum.000webhostapp.com/sendEmail.php");
  }
}


?>