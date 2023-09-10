<?php
// <!-- Adds the basic account to the DB -->
session_start();
$_SESSION["ErrorReset"] = "";
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();


if (isset($_POST['Password1'])){
  $invalid = FALSE;

  $Email = $_SESSION["Email"];

  $Password1 = mysqli_real_escape_string($conn, $_REQUEST['Password1']);
  $Password2 = mysqli_real_escape_string($conn, $_REQUEST['Password2']);


  $_SESSION["Password"] = $Password1;


  $findUser = "SELECT * FROM `Users` WHERE Email='$Email'";

  $result = mysqli_query($conn, $findUser);

  while ($row = $result->fetch_assoc()) {
    $_SESSION['UserID'] = $row["UserID"];
    $_SESSION['Username'] = $row["Username"];
    $Password = $row["Password"];
        
  }

  if ($Password == $Password1) {
    $invalid = TRUE;
    $_SESSION["differentResetClass"] = "invalid";
  }
  else {
    $_SESSION["differentResetClass"] = "valid";
  }


  $num = 0;
  $alpha = 0;
  $special = 0;

  for ($i = 0; $i < strlen($Password1); $i++) { // Counts the number of digits, letters and special characters and stores them respectively in the variables, $num, $alpha and $special
      if (ctype_digit($Password1[$i])){
        $num ++;
      }
      elseif (ctype_alpha($Password1[$i])){
        $alpha ++;
      }
      else{
        $special ++;
      }
  }
  if (strlen($Password1) < 6){
    $invalid = TRUE;
    $_SESSION["lengthResetClass"] = "invalid";
  }
  else {
    $_SESSION["lengthResetClass"] = "valid";
  }
  if ($num == 0){
    $invalid = TRUE;
    $_SESSION["numberResetClass"] = "invalid";
  }
  else {
    $_SESSION["numberResetClass"] = "valid";
  }
  if ($alpha == 0){
    $invalid = TRUE;
    $_SESSION["letterResetClass"] = "invalid";
  }
  else {
    $_SESSION["letterResetClass"] = "valid";
  }
  if ($special == 0){
    $invalid = TRUE;
    $_SESSION["specialResetClass"] = "invalid";
  }
  else {
    $_SESSION["specialResetClass"] = "valid";
  }
  if ($Password1 != $Password2){
    $invalid = TRUE;
    $_SESSION["matchResetClass"] = "invalid";
  }
  else {
    $_SESSION["matchResetClass"] = "valid";
  }
  if($invalid) {
     $_SESSION["messageResetDisplay"] = "block";
     header("Location:http://localhost:8080/Clock/updatePassword.php");
  }
  else {
    $UserID = $_SESSION['UserID'];
    $updatePassword = "UPDATE USERS
        SET Password = '$Password1'
        WHERE UserID = '$UserID'";
    if (mysqli_query($conn, $updatePassword)) {
        $deleteHash = $_SESSION['deleteHash'];
        mysqli_query($conn, $deleteHash);
        header("Location:http://localhost:8080/Clock/myClocks.php");
    } else {
        echo "Error: " . $Insert . "<br>" . mysqli_error($conn);
    }
  }
}


?>
