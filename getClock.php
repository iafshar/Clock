<?php

require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();

if(isset($_GET['clockID'])) {
    $clockID = $_GET['clockID'];
    $getClock = "SELECT * FROM `Clocks` WHERE ClockID='$clockID'";

    $result = $db->get_con()->query($getClock);
    $record = array();
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $UserID = $row["UserID"];

            $getUsername = "SELECT * FROM `Users` WHERE UserID='$UserID'";
            $result2 = $db->get_con()->query($getUsername);

            if ($result2->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()) {
                    $record["Username"] = $row2["Username"];
                }
            }

            $record["Name"] = $row["Name"];
            $record["Tempo"] = $row["Tempo"];
            $record["Shared"] = $row["Shared"];
            $record["DateShared"] = $row["DateShared"];
            $GetNumOfLikes = "SELECT * FROM Votes WHERE ClockID='$ClockID' AND Dislike=0";
            $result2 = $db->get_con()->query($GetNumOfLikes);
            $record["NumOfLikes"] = $result2->num_rows;
            $GetNumOfDislikes = "SELECT * FROM Votes WHERE ClockID='$ClockID' AND Dislike=1";
            $result3 = $db->get_con()->query($GetNumOfDislikes);
            $record["NumOfDislikes"] = $result3->num_rows;
        }
    }

    echo json_encode($record);
}


?>