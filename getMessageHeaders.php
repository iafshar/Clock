<?php
// <!-- the profile page of the user -->
session_start();
$MyUsername = $_SESSION['Username'];


require_once __DIR__ . '/dbConnect.php';

$db = new DB_CONNECT();

$getMessages = "SELECT * FROM `Messages` WHERE ToUsername='$MyUsername'
    ORDER BY DateSent DESC"; // maybe do order by date? but it should already be in order

$result = $db->get_con()->query($getMessages);

$Usernames = array();

if ($result->num_rows > 0) {
    // looping through all results
    while ($row = $result->fetch_assoc()) {
        array_push($Usernames,$row["FromUsername"]);
    }

    $Usernames = array_values(array_unique($Usernames));
}

echo json_encode($Usernames);

?>