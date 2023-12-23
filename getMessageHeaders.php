<?php
// gets the usernames of people that the current user has chats with
session_start();
$MyUsername = $_SESSION['Username'];


require_once __DIR__ . '/dbConnect.php';

$db = new DB_CONNECT();

$getMessages = "SELECT * FROM `Messages` WHERE ToUsername='$MyUsername' OR FromUsername='$MyUsername'
    ORDER BY DateSent DESC"; 

$result = $db->get_con()->query($getMessages);

$response = array();
$Usernames = array();
$Dates = array();

if ($result->num_rows > 0) {
    // looping through all results
    while ($row = $result->fetch_assoc()) {
        if ($row["FromUsername"] != $MyUsername) { // add the from username if it is a message sent to me
            array_push($Usernames,$row["FromUsername"]);
        }

        else { // add the to username if i sent a message to them
            array_push($Usernames,$row["ToUsername"]);
        }
        array_push($Dates,$row["DateSent"]);
        
    }
    $uniqueUsernames = array();
    $uniqueDates = array();
    $bolds = array();
    for ($i=0; $i < count($Usernames); $i++) { 
        // previously we had arrays for all messages, now we only want one per username
        if (!in_array($Usernames[$i],$uniqueUsernames)) { // if the current username is not in the unique usernames array
            $curr = $Usernames[$i];
            $getUnreadMessages = "SELECT * FROM `Messages` WHERE ToUsername='$MyUsername' AND FromUsername='$curr' AND Viewed=0";
            $result2 = $db->get_con()->query($getUnreadMessages); // checks if there are any messages from that username that hasnt been viewed
            if ($result2->num_rows > 0) {
                array_push($bolds,1); // if there are, add 1 to bolds
            }
            else {
                array_push($bolds,0); // else add 0 to bolds.
            }
            array_push($uniqueUsernames,$Usernames[$i]);
            array_push($uniqueDates,$Dates[$i]);
        }
    }
    $Usernames = $uniqueUsernames;
    $Dates = $uniqueDates;
}

$response["Usernames"] = $Usernames;
$response["Dates"] = $Dates;
$response["Bolds"] = $bolds;
echo json_encode($response);

?>