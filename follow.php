
<?php
// <!-- edits the database so that the user is either following or unfollowing another user -->
session_start();
$FollowedID = $_SESSION["SearchedUserID"];
$FollowerID = $_SESSION["UserID"];

require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();


$Select = "SELECT * FROM Followings WHERE FollowerID='$FollowerID' AND FollowedID='$FollowedID'"; 
$result = mysqli_query($conn, $Select) or die(mysqli_error($conn)); // checks if the user is following the other user
$count = mysqli_num_rows($result);

$Delete = "DELETE FROM Followings Where FollowerID='$FollowerID' AND FollowedID='$FollowedID'";
$Insert = "INSERT INTO Followings (FollowerID,FollowedID)
  VALUES ('$FollowerID','$FollowedID')";

if ($count != 0){ // if the user already is following, delete the interaction from the database
  mysqli_query($conn, $Delete);
  echo json_encode("Follow"); // "follow" will be displayed on the button
}

else { // if the user is not following, add the interaction to the database
  mysqli_query($conn, $Insert);
  echo json_encode("Unfollow"); // "unfollow" will be displayed on the button
}
 ?>
