<?php
// adds a reply to the DB
session_start();
require_once __DIR__ . '/db_config.php';
// Create connection
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if(isset($_POST['reply'])){
  if($_SESSION["Premium"] == 1){
    $CommentID = $_POST['CommentID'];
    $Reply = $_POST['reply'];

    if(strlen($Reply) != 0){
        $AddReply = "INSERT INTO Replies (CommentID,Reply)
          VALUES ('$CommentID','$Reply')";
      }
      mysqli_query($conn, $AddReply);
      header("Location:stats.html");
  }
  else{
    $_SESSION["Error"] = "You need to upgrade to premium to be able to reply to comments.";
    header("Location:MyClocks.php");
  }
}
?>
