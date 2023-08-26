<?php
// <!-- the profile page of the user -->
session_start();
$MyUsername = $_SESSION['Username'];


require_once __DIR__ . '/dbConnect.php';

$db = new DB_CONNECT();

$getMessages = "SELECT * FROM `Messages` WHERE ToUsername='$MyUsername' OR FromUsername='$MyUsername'
    ORDER BY DateSent DESC"; // maybe do order by date? but it should already be in order

$result = $db->get_con()->query($getMessages);

$response = array();
$Usernames = array();
$Dates = array();

if ($result->num_rows > 0) {
    // looping through all results
    while ($row = $result->fetch_assoc()) {
        if ($row["FromUsername"] != $MyUsername) {
            array_push($Usernames,$row["FromUsername"]);
        }

        else {
            array_push($Usernames,$row["ToUsername"]);
        }
        array_push($Dates,$row["DateSent"]);
        
    }
    $uniqueUsernames = array();
    $uniqueDates = array();
    for ($i=0; $i < count($Usernames); $i++) { 
        if (!in_array($Usernames[$i],$uniqueUsernames)) {
            array_push($uniqueUsernames,$Usernames[$i]);
            array_push($uniqueDates,$Dates[$i]);
        }
    }
    $Usernames = $uniqueUsernames;
    $Dates = $uniqueDates;
}

$response["Usernames"] = $Usernames;
$response["Dates"] = $Dates;
echo json_encode($response);

?>