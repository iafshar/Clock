
<?php
// <!-- edits the database so that the user is either following or unfollowing another user -->
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

$Delete = "DELETE FROM Followings Where FollowerID='$FollowerID' AND FollowedID='$FollowedID'";
$Insert = "INSERT INTO Followings (FollowerID,FollowedID)
  VALUES ('$FollowerID','$FollowedID')";

if ($count != 0){
  mysqli_query($conn, $Delete);
  header("Location:http://localhost:8080/Clock/otherProfile.php");
}

else if (mysqli_query($conn, $Insert)) {
       header("Location:http://localhost:8080/Clock/otherProfile.php");
   } else {
       echo "Error: " . $Insert . "<br>" . mysqli_error($conn);
   }
 ?>
