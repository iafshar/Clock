<?php
session_start();

require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();

$response = $_SESSION['responseMessages'];
$response["myUserID"] = $_SESSION['UserID'];

if (array_key_exists("Messages", $response)) {
    $messages = $response["Messages"];
    for ($i=0; $i < count($messages); $i++) { 
        if ($messages[$i]["Type"] == 1) {
            
            $record = array();

            
            $record["Color"] = $messages[$i]["Color"];
            $record["Content"] = $messages[$i]["Content"];
            $record["DateSent"] = $messages[$i]["DateSent"];
            $record["Type"] = $messages[$i]["Type"];
            $record["sentByMe"] = $messages[$i]["sentByMe"];

            $clockID = $messages[$i]["Content"];

            $getClock = "SELECT * FROM `Clocks` WHERE ClockID='$clockID'";

            $result = $db->get_con()->query($getClock);
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
                    $record["UserID"] = $UserID;
                    $record["Name"] = $row["Name"];
                    $record["Tempo"] = $row["Tempo"];
                    $record["Shared"] = $row["Shared"];
                    $record["DateShared"] = $row["DateShared"];
                    $GetNumOfLikes = "SELECT * FROM Votes WHERE ClockID='$clockID' AND Dislike=0";
                    $result2 = $db->get_con()->query($GetNumOfLikes);
                    $record["NumOfLikes"] = $result2->num_rows;
                    $GetNumOfDislikes = "SELECT * FROM Votes WHERE ClockID='$clockID' AND Dislike=1";
                    $result3 = $db->get_con()->query($GetNumOfDislikes);
                    $record["NumOfDislikes"] = $result3->num_rows;
                }
                $messages[$i] = $record;
            }
        }
    }

    $response["Messages"] = $messages;
    echo json_encode($response);
}
else {

    echo json_encode($response);
        

}

?>
