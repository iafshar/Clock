<?php
// adds a reply to the DB
session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();

if(isset($_POST['reply']) && isset($_POST['CommentID']) && $_SESSION["Premium"] == 1 && strlen($_POST['reply']) > 0){

  $CommentID = $_POST['CommentID'];
  $Reply = mysqli_real_escape_string($conn, $_POST['reply']);

  $Date = date("Y-m-d H:i:s");
  $AddReply = "INSERT INTO Replies (CommentID,Reply,Date)
      VALUES ('$CommentID','$Reply','$Date')";
      
  mysqli_query($conn, $AddReply);

}
?>
