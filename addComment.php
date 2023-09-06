
<?php
// <!-- adds a comment to the DB -->
session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();

if(isset($_POST['location'])){
  if($_SESSION["Premium"] == 1){
    if(isset($_POST['Maker'])){
      
      $Maker = $_POST['Maker'];
      $GetUserID = "SELECT * FROM Users Where Username='$Maker'";
      $resultUser = mysqli_query($conn, $GetUserID);
      if ($resultUser->num_rows > 0) {
          while ($row = $resultUser->fetch_assoc()) {
              $UserID = $row["UserID"];
          }
      }
    }
    elseif (isset($_POST['MakerID'])) {
      $UserID = $_POST['MakerID'];
    }
    else {
      $UserID = $_SESSION["SearchedUserID"];
    }
    if(isset($_POST['clockName']) && strlen($_POST['comment']) > 0){
      

      $clockName = $_POST['clockName'];
      $GetClockID = "SELECT * FROM Clocks WHERE UserID='$UserID' AND Name='$clockName'";
      $resultClock = mysqli_query($conn, $GetClockID);
      if ($resultClock->num_rows > 0) {
          while ($row = $resultClock->fetch_assoc()) {
              $ClockID = $row["ClockID"];
          }
      }

      $Date = date("Y-m-d H:i:s");
      $Comment = $_POST['comment'];
      $AddComment = "INSERT INTO Comments (ClockID, Comment, Date)
        VALUES ('$ClockID','$Comment', '$Date')";

      mysqli_query($conn, $AddComment);
    }
    header("Location:".$_POST['location']);
  }
  else{
    $_SESSION["Error"] = "You need to upgrade to premium to be able to comment.";
    header("Location:myClocks.php");
  }
}

 ?>
