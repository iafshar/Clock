
<?php
// <!-- adds a comment to the DB -->
session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();

if(isset($_POST['clockID']) && isset($_POST['comment']) && $_SESSION["Premium"] == 1 && strlen($_POST['comment']) > 0){
  $ClockID = $_POST['clockID'];
  $Date = date("Y-m-d H:i:s");
  $Comment = mysqli_real_escape_string($conn, $_POST['comment']);
  $AddComment = "INSERT INTO Comments (ClockID, Comment, Date)
    VALUES ('$ClockID','$Comment', '$Date')";

  mysqli_query($conn, $AddComment);
}
echo 1;
?>
