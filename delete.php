<?php
// <!-- deletes a clock from the DB -->
session_start();
require_once __DIR__ . '/dbConfig.php';
// Create connection
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

require_once __DIR__ . '/dbConnect.php';

// connecting to db
$db = new DB_CONNECT();

$ClockID = $_GET["ClockID"];

$DeleteCircles = "DELETE FROM Circles Where ClockID='$ClockID'";

mysqli_query($conn, $DeleteCircles);

$DeleteVotes = "DELETE FROM Votes WHERE ClockID='$ClockID'";

mysqli_query($conn, $DeleteVotes);

$SelectComments = "SELECT * FROM `Comments` WHERE ClockID='$ClockID'";
$result = $db->get_con()->query($SelectComments);


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

$DeleteClock = "DELETE FROM Clocks WHERE ClockID='$ClockID'";

mysqli_query($conn, $DeleteClock);

header("Location:http://localhost:8080/Clock/myClocks.php");
?>
