<?php
session_start();
require_once __DIR__ . '/dbConnect.php';

// connecting to db
$db = new DB_CONNECT();

$MyUserID = $_SESSION["UserID"];

$CommentID = $_GET['CommentID'];
$GetReplies = "SELECT * FROM Replies WHERE CommentID='$CommentID'";
$result = $db->get_con()->query($GetReplies);

if ($result->num_rows > 0) {
    // looping through all results
    $response["Replies"] = array();

    while ($row = $result->fetch_assoc()) {
        // temp user array
        $record = array();

        $record["ReplyID"] = $row["ReplyID"];
        $replyID = $row["ReplyID"];

        $getLikes = "SELECT * FROM `Votes` WHERE ItemID='$replyID' AND Item=2 AND Dislike=0";
        $result2 = $db->get_con()->query($getLikes);
        $record["NumOfLikes"] = $result2->num_rows;

        $getDislikes = "SELECT * FROM `Votes` WHERE ItemID='$replyID' AND Item=2 AND Dislike=1";
        $result2 = $db->get_con()->query($getDislikes);
        $record["NumOfDislikes"] = $result2->num_rows;

        $checkLiked = "SELECT * FROM Votes WHERE UserID='$MyUserID' AND ItemID='$replyID' AND Item=2 AND Dislike=0";
        if ($db->get_con()->query($checkLiked)->num_rows > 0) {
            $record["LikeColor"] = "#f39faa";
        }
        else {
            $record["LikeColor"] = "#efefef";
        }
        $checkDisliked = "SELECT * FROM Votes WHERE UserID='$MyUserID' AND ItemID='$replyID' AND Item=2 AND Dislike=1";
        if ($db->get_con()->query($checkDisliked)->num_rows > 0) {
            $record["DislikeColor"] = "#f39faa";
        }
        else {
            $record["DislikeColor"] = "#efefef";
        }

        $record["Reply"] = $row["Reply"];
        $record["Date"] = $row["Date"];

        // push single record into final response array
        array_push($response["Replies"], $record);
    }
    // success
    $response["success"] = 1;
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No records found";

}
echo json_encode($response);
?>
