<?php
// <!-- deletes a clock from the DB -->
session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();

$ClockID = $_POST["ClockID"];

$DeleteCircles = "DELETE FROM Circles Where ClockID='$ClockID'";

mysqli_query($conn, $DeleteCircles); // delete circles attached to the clock being deleted

$DeleteVotes = "DELETE FROM Votes WHERE ItemID='$ClockID' AND Item=0";

mysqli_query($conn, $DeleteVotes); // delete votes attached to the clock being deleted

$SelectComments = "SELECT * FROM `Comments` WHERE ClockID='$ClockID'";
$result = mysqli_query($conn, $SelectComments); // get all comments attached to the clock being deleted


if ($result->num_rows > 0) {
    // looping through all results

    while ($row = $result->fetch_assoc()) { // for each comment, delete all replies attached to it
        $CommentID = $row["CommentID"];
        $DeleteReplies = "DELETE FROM Replies WHERE CommentID='$CommentID'";
        mysqli_query($conn, $DeleteReplies);
    }
}

$DeleteComments = "DELETE FROM Comments WHERE ClockID='$ClockID'";
mysqli_query($conn, $DeleteComments); // delete all comments

$DeleteMessages = "DELETE FROM Messages WHERE Type=1 AND Content=$ClockID"; 
// dont put clockID in quotes because it will only delete content that ONLY has clockID and not comma with message

mysqli_query($conn, $DeleteMessages);

$DeleteClock = "DELETE FROM Clocks WHERE ClockID='$ClockID'";

mysqli_query($conn, $DeleteClock);

header("Location:http://localhost:8080/Clock/myClocks.php");
?>
