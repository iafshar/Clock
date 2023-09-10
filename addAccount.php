<?php
// <!-- Adds the basic account to the DB -->
session_start();
$_SESSION["Error"] = "";
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();


if (isset($_POST['Username']) and isset($_POST['Password1']) and isset($_POST['Email']) and isset($_POST['Premium'])){

  $Username = mysqli_real_escape_string($conn, $_REQUEST['Username']);
  $Password = mysqli_real_escape_string($conn, $_REQUEST['Password1']);
  $Password2 = mysqli_real_escape_string($conn, $_REQUEST['Password2']);
  $Email = mysqli_real_escape_string($conn, $_REQUEST['Email']);
  $Premium = mysqli_real_escape_string($conn, $_REQUEST['Premium']);;

  $_SESSION["Premium"] = $Premium;
  $_SESSION["Username"] = $Username;
  $_SESSION["Password"] = $Password;
  $_SESSION["Email"] = $Email;

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
    $_SESSION["lengthClass"] = "invalid";
  }
  else {
    $_SESSION["lengthClass"] = "valid";
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
  if($invalid) {
     $_SESSION["messageDisplay"] = "block";

     header("Location:http://localhost:8080/Clock/signUp.php");
  }
  else{
    header("Location:http://localhost:8080/Clock/sendEmail.php");
  }
}


?>