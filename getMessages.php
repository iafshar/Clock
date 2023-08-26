<?php

require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();

session_start();
$MyUsername = $_SESSION['Username'];
$response = array();

$otherUsername = $_GET["sender"];

$getMessages = "SELECT * FROM `Messages` WHERE (ToUsername='$MyUsername' AND FromUsername='$otherUsername') OR
    ToUsername='$otherUsername' AND FromUsername='$myUsername'
    ORDER BY DateSent DESC";

$result = $db->get_con()->query($getMessages);

if ($result->num_rows > 0) {
    $response["Messages"] = array();
    while ($row = $result->fetch_assoc()) {
        // temp user array
        $record = array();
        $record["Content"] = $row["Content"];
        $record["DateSent"] = $row["DateSent"];
        if ($row["ToUsername"] == $MyUsername) {
            $record["Color"] = "#ffffff";
        }
        else {
            $record["Color"] = "#0000ff";
        }
        

        array_push($response["Messages"], $record);

    }
    $response["success"] = 1;
}

$_SESSION['responseMessages'] = $response["Messages"];

header("Location:http://localhost:8080/Clock/chat.html");

?>