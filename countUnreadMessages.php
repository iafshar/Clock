<?php
session_start();

require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();

$myUsername = $_SESSION["Username"];

$getUnreadMessages = "SELECT * FROM `Messages` WHERE ToUsername='$myUsername' AND Viewed=0 GROUP BY FromUsername";

$result = $db->get_con()->query($getUnreadMessages);
echo json_encode($result->num_rows);

?>