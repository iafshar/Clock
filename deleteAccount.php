<?php
// delete all things related to the user's account.
session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();

$UserID = $_SESSION["UserID"];
$Username = $_SESSION["Username"];

$deleteFollowings = "DELETE FROM Followings WHERE FollowerID='$UserID' OR FollowedID='$UserID'";

$db->get_con()->query($deleteFollowings);

$deleteMessages = "DELETE FROM Messages WHERE ToUsername='$Username' OR FromUsername='$Username'";

$db->get_con()->query($deleteMessages);

$deleteVotes = "DELETE FROM Votes WHERE UserID='$UserID'";

$db->get_con()->query($deleteVotes);

$deleteSearches = "DELETE FROM Searches WHERE UserID='$UserID'";
$db->get_con()->query($deleteSearches);

$deletePasswords = "DELETE FROM Passwords WHERE UserID='$UserID'";
$db->get_con()->query($deletePasswords);

$getClocks = "SELECT ClockID FROM Clocks WHERE UserID='$UserID'";

$result = $db->get_con()->query($getClocks);

while ($row = $result->fetch_assoc()) {
    $ClockID = $row["ClockID"];

    $deleteCircles = "DELETE FROM Circles WHERE ClockID='$ClockID'";
    $db->get_con()->query($deleteCircles);

    $getComments = "SELECT CommentID From Comments WHERE ClockID='$ClockID'";

    $result2 = $db->get_con()->query($getComments);

    while ($row2 = $result2->fetch_assoc()) {
        $CommentID = $row2["CommentID"];

        $deleteReplies = "DELETE FROM Replies WHERE CommentID='$CommentID'";
        $db->get_con()->query($deleteReplies);

    }

    $deleteComments = "DELETE FROM Comments WHERE ClockID='$ClockID'";
    $db->get_con()->query($deleteComments);

}

$deleteClocks = "DELETE FROM Clocks WHERE UserID='$UserID'";
$db->get_con()->query($deleteClocks);

$deleteUser = "DELETE FROM Users WHERE UserID='$UserID'";
$db->get_con()->query($deleteUser);

$_SESSION = array();

header("Location:http://localhost:8080/Clock/start.php");


?>