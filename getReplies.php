<?php
session_start();
require_once __DIR__ . '/dbConnect.php';

// connecting to db
$db = new DB_CONNECT();

$CommentID = $_POST['CommentID'];
$GetReplies = "SELECT * FROM Replies WHERE CommentID='$CommentID'";
$result = $db->get_con()->query($GetReplies);

if ($result->num_rows > 0) {
    // looping through all results
    $response["Replies"] = array();

    while ($row = $result->fetch_assoc()) {
        // temp user array
        $record = array();

        $record["ReplyID"] = $row["ReplyID"];
        $record["Reply"] = $row["Reply"];

        // push single record into final response array
        array_push($response["Replies"], $record);
    }
    // success
    $response["success"] = 1;
    $_SESSION["Replies"] = $response;
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No records found";
    $_SESSION["Replies"] = $response;

}
header("Location:replies.html");
?>
