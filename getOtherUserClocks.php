
<?php
// <!-- Gets the UserID of the user that has been searched for so it can be used to access their clocks -->
session_start();
// include db connect class
require_once __DIR__ . '/dbConnect.php';

// connecting to db
$db = new DB_CONNECT();

$MyUserID = $_SESSION["UserID"];

$SearchedUser = $_GET['Username'];
$IDSearch = "SELECT * FROM `Users` WHERE Username='$SearchedUser'";
$result = $db->get_con()->query($IDSearch);

    // looping through all results

while ($row = $result->fetch_assoc()) {

    $SearchedUserID = $row["UserID"];

}

$addSearch = "INSERT INTO `Searches` (UserID, Search)
  VALUES ('$MyUserID','$SearchedUser')";
$db->get_con()->query($addSearch);

$_SESSION["SearchedUserID"] = $SearchedUserID;
$_SESSION["SearchedUsername"] = $SearchedUser;
header("Location:otherProfile.php");


 ?>
