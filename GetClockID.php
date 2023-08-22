
<?php
// <!-- gets the unique ID of a clock given certain parameters -->
session_start();

// include db connect class
require_once __DIR__ . '/dbConnect.php';

// connecting to db
$db = new DB_CONNECT();

if($_GET["choose"]==0 || $_GET["choose"]==5){
  $UserID = $_SESSION["UserID"];
  $_SESSION["Location"] = "myClocks.php";
}
else if($_GET["choose"]==1){
  $UserID = $_SESSION["SearchedUserID"];
  $_SESSION["Location"] = "otherProfile.php";
}
else if($_GET["choose"]==7){
  $UserID = $_SESSION["SearchedUserID"];
  $tempo = $_GET["tempo"];
  $_SESSION["tempo"] = $tempo;
}
else if ($_GET["choose"]==4){
  $UserID = $_SESSION["UserID"];
  $tempo = $_GET["tempo"];
  $_SESSION["tempo"] = $tempo;
}
else{
  if($_GET["choose"]==2){$_SESSION["Location"] = "discover.html";}
  else{
    $_SESSION["Location"] = "feed.html";
    if($_GET["choose"]==6){
      $tempo = $_GET["tempo"];
      $_SESSION["tempo"] = $tempo;
    }
  }
  $Username = $_GET["discoverUsername"];
  $GetUserID = "SELECT * FROM Users WHERE Username='$Username'";
  $resultUser = $db->get_con()->query($GetUserID);
  while ($row = $resultUser->fetch_assoc()) {
      $UserID = $row["UserID"];
  }
}
$Name = $_GET["clockName"];
// get all products from products table
$GetClockID = "SELECT * FROM `Clocks` WHERE UserID='$UserID' and Name='$Name'";
$result = $db->get_con()->query($GetClockID);


if ($result->num_rows > 0) {
    // looping through all results

    while ($row = $result->fetch_assoc()) {
        // temp user array
        //$record = array();
        $ClockID = $row["ClockID"];



        // push single record into final response array
    }
    // success

    // echoing JSON response(prints it)
    $_SESSION["ClockID"] = $ClockID;
    $_SESSION["clockName"] = $Name;
}


 ?>
