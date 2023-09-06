<?php
// <!-- deletes a clock from the DB -->
session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();

$ClockID = $_GET["ClockID"];

$DeleteCircles = "DELETE FROM Circles Where ClockID='$ClockID'";

mysqli_query($conn, $DeleteCircles);

$DeleteVotes = "DELETE FROM Votes WHERE ClockID='$ClockID'";

mysqli_query($conn, $DeleteVotes);

$SelectComments = "SELECT * FROM `Comments` WHERE ClockID='$ClockID'";
$result = mysqli_query($conn, $SelectComments);


if ($result->num_rows > 0) {
    // looping through all results

    while ($row = $result->fetch_assoc()) {
        // temp user array
        //$record = array();
        $CommentID = $row["CommentID"];
        $DeleteReplies = "DELETE FROM Replies WHERE CommentID='$CommentID'";
        mysqli_query($conn, $DeleteReplies);
    }
}

$DeleteComments = "DELETE FROM Comments WHERE ClockID='$ClockID'";
mysqli_query($conn, $DeleteComments);

$DeleteMessages = "DELETE FROM Messages WHERE Type=1 AND Content='$ClockID'";

mysqli_query($conn, $DeleteMessages);

$DeleteClock = "DELETE FROM Clocks WHERE ClockID='$ClockID'";

mysqli_query($conn, $DeleteClock);

header("Location:http://localhost:8080/Clock/myClocks.php");
?>
