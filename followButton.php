
<?php
// <!-- code that decides what should be the value of the follow button(follow/unfollow) -->
session_start();
$FollowedID = $_SESSION["SearchedUserID"];
$FollowerID = $_SESSION["UserID"];

require_once __DIR__ . '/dbConfig.php';
// Create connection
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$Select = "SELECT * FROM Followings WHERE FollowerID='$FollowerID' AND FollowedID='$FollowedID'";
$result = mysqli_query($conn, $Select) or die(mysqli_error($conn));
$count = mysqli_num_rows($result);

if ($count != 0){
  $followButton = "Unfollow";
}
else{
  $followButton = "Follow";
}
 ?>
