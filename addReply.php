<?php
// adds a reply to the DB
session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();

$ClockID = "";
if(isset($_POST['reply'])){
  if($_SESSION["Premium"] == 1){
    $CommentID = $_POST['CommentID'];
    $Reply = $_POST['reply'];
    if (isset($_POST['ClockID'])) {
      $ClockID = $_POST['ClockID'];
    }

    if(strlen($Reply) != 0){
        $Date = date("Y-m-d H:i:s");
        $AddReply = "INSERT INTO Replies (CommentID,Reply,Date)
          VALUES ('$CommentID','$Reply','$Date')";
      }
      mysqli_query($conn, $AddReply);
      header("Location:comments.html?".$ClockID);
  }
  else{
    $_SESSION["Error"] = "You need to upgrade to premium to be able to reply to comments.";
    header("Location:myClocks.php");
  }
}
?>
