
<?php
// <!-- Gets the UserID of the user that has been searched for so it can be used to access their clocks -->
session_start();
// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

$SearchedUser = $_GET['Username'];
$IDSearch = "SELECT * FROM `Users` WHERE Username='$SearchedUser'";
$result1 = $db->get_con()->query($IDSearch);

    // looping through all results

while ($row = $result1->fetch_assoc()) {

    $SearchedUserID = $row["UserID"];

}

$_SESSION["SearchedUserID"] = $SearchedUserID;
header("Location:otherProfile.html");


 ?>
