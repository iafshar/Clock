
<?php
// <!-- adds a comment to the DB -->
session_start();
require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

require_once __DIR__ . '/db_config.php';
// Create connection
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if(isset($_POST['location'])){
  if($_SESSION["Premium"] == 1){
    if(isset($_POST['Maker'])){
      $Maker = $_POST['Maker'];
      $GetUserID = "SELECT * FROM Users Where Username='$Maker'";
      $resultUser = $db->get_con()->query($GetUserID);

      if ($resultUser->num_rows > 0) {
          while ($row = $resultUser->fetch_assoc()) {
              $UserID = $row["UserID"];
          }
      }
    }
    else{
      $UserID = $_SESSION["SearchedUserID"];
    }
    if(isset($_POST['clockName']) && strlen($_POST['comment']) > 0){

      $clockName = $_POST['clockName'];
      $GetClockID = "SELECT * FROM Clocks WHERE UserID='$UserID' AND Name='$clockName'";
      $resultClock = $db->get_con()->query($GetClockID);

      if ($resultClock->num_rows > 0) {
          while ($row = $resultClock->fetch_assoc()) {
              $ClockID = $row["ClockID"];
          }
      }

      $Comment = $_POST['comment'];
      $AddComment = "INSERT INTO Comments (ClockID, Comment)
        VALUES ('$ClockID','$Comment')";

      mysqli_query($conn, $AddComment);
    }
    header("Location:".$_POST['location']);
  }
  else{
    $_SESSION["Error"] = "You need to upgrade to premium to be able to comment.";
    header("Location:MyClocks.php");
  }
}

 ?>
