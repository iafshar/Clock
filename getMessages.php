<?php

require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();

session_start();
$myUsername = $_SESSION['Username'];
$response = array();

$otherUsername = $_GET["sender"];

$viewMessages = "UPDATE Messages SET Viewed=1 WHERE ToUsername='$myUsername' AND FromUsername='$otherUsername'";
$db->get_con()->query($viewMessages);

$getMessages = "SELECT * FROM `Messages`
 WHERE ToUsername IN ('$myUsername','$otherUsername') AND FromUsername IN ('$otherUsername','$myUsername')
    ORDER BY DateSent DESC";

$result = $db->get_con()->query($getMessages);

if ($result->num_rows > 0) {
    $response["Messages"] = array();
    while ($row = $result->fetch_assoc()) {
        // temp user array
        $record = array();
        $record["MessageID"] = $row["MessageID"];
        $record["Content"] = $row["Content"];
        $record["DateSent"] = $row["DateSent"];
        $record["Type"] = $row["Type"];
        if ($row["ToUsername"] == $myUsername) {
            $record["Color"] = "#ffffff";
            $record["sentByMe"] = 0; 
        }
        else {
            $record["Color"] = "#03c6fc";
            $record["sentByMe"] = 1;
        }
        

        array_push($response["Messages"], $record);

    }
    $response["success"] = 1;

}
else {
    $response["success"] = 0;
}


$response["otherUsername"] = $otherUsername;
$_SESSION['responseMessages'] = $response;


?>