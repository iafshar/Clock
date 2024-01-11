<?php

require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();

session_start();
$myUsername = $_SESSION['Username'];
$response = array();

$MyUserID = $_SESSION['UserID'];
$response["myUserID"] = $MyUserID;

$otherUsername = $_GET["otherUsername"];

$viewMessages = "UPDATE Messages SET Viewed=1 WHERE ToUsername='$myUsername' AND FromUsername='$otherUsername'";
$db->get_con()->query($viewMessages); // views all the messages in the chat with this user

$getMessages = "SELECT * FROM `Messages`
 WHERE ToUsername IN ('$myUsername','$otherUsername') AND FromUsername IN ('$otherUsername','$myUsername')
    ORDER BY DateSent DESC";

$getOtherUserID = "SELECT * FROM `Users` WHERE Username='$otherUsername'";

$resultUserID = $db->get_con()->query($getOtherUserID);

if ($resultUserID->num_rows > 0) {
    while ($row = $resultUserID->fetch_assoc()) {
        $response["otherUserID"] = $row["UserID"];
    }
}

$result = $db->get_con()->query($getMessages);



if ($result->num_rows > 0) {
    $response["Messages"] = array();
    while ($row = $result->fetch_assoc()) {
        // temp user array
        $record = array();
        $record["MessageID"] = $row["MessageID"];

        if ($row["ToUsername"] == $myUsername) {
            $record["Color"] = "#ffffff";
            $record["sentByMe"] = 0; 
        }
        else {
            $record["Color"] = "#03c6fc";
            $record["sentByMe"] = 1;
        }

        $record["DateSent"] = $row["DateSent"];
        $record["Type"] = $row["Type"];

        if ($record["Type"] == 1) { // if it is a clock message
            $contents = explode(",",$row["Content"],2);
            array_push($contents,""); // prevents needing to check for length of array in javascript,
        //                             // if the length is now 2, it will add an empty string before the iframe which wont make a difference.
        //                             // if the length is now 3, the third element will never be used so it doesn't matter
            $record["Content"] = $contents;
            $clockID = $contents[0];
            $getClock = "SELECT * FROM `Clocks` WHERE ClockID='$clockID'";

            $result2 = $db->get_con()->query($getClock);
            if ($result2->num_rows > 0) {

                while ($row2 = $result2->fetch_assoc()) {
                    $UserID = $row2["UserID"];

                    $getUsername = "SELECT * FROM `Users` WHERE UserID='$UserID'";
                    $result3 = $db->get_con()->query($getUsername);

                    if ($result3->num_rows > 0) {
                        while ($row3 = $result3->fetch_assoc()) {
                            $record["Username"] = $row3["Username"];
                        }
                    }
                    $record["UserID"] = $UserID;
                    $record["Name"] = $row2["Name"];
                    $record["Tempo"] = $row2["Tempo"];
                    $record["Shared"] = $row2["Shared"];
                    $record["Date"] = $row2["Date"];
                    $GetNumOfLikes = "SELECT * FROM Votes WHERE ItemID='$clockID' AND Item=0 AND Dislike=0";
                    $result4 = $db->get_con()->query($GetNumOfLikes);
                    $record["NumOfLikes"] = $result3->num_rows;
                    $GetNumOfDislikes = "SELECT * FROM Votes WHERE ItemID='$clockID' AND Item=0 AND Dislike=1";
                    $result5 = $db->get_con()->query($GetNumOfDislikes);
                    $record["NumOfDislikes"] = $result5->num_rows;
                    $checkLiked = "SELECT * FROM Votes WHERE UserID='$MyUserID' AND ItemID='$clockID' AND Item=0 AND Dislike=0";
                    if ($db->get_con()->query($checkLiked)->num_rows > 0) {
                        $record["LikeColor"] = "#f39faa";
                    }
                    else {
                        $record["LikeColor"] = "#efefef";
                    }
                    $checkDisliked = "SELECT * FROM Votes WHERE UserID='$MyUserID' AND ItemID='$clockID' AND Item=0 AND Dislike=1";
                    if ($db->get_con()->query($checkDisliked)->num_rows > 0) {
                        $record["DislikeColor"] = "#f39faa";
                    }
                    else {
                        $record["DislikeColor"] = "#efefef";
                    }
                }
            }
        }

        else {
            $record["Content"] = $row["Content"];
        }

        array_push($response["Messages"], $record);

    }

    $response["success"] = 1;

}
else {
    $response["success"] = 0;
}


$response["otherUsername"] = $otherUsername;
$response["Premium"] = $_SESSION["Premium"];
$response["numMessages"] = $result->num_rows;
echo json_encode($response);

?>