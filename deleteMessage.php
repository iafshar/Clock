<?php
session_start();
require_once __DIR__ . '/dbConnect.php';

$db = new DB_CONNECT();

if (isset($_POST["messageID"]) && isset($_POST["rowID"])) {
    $messageID = $_POST["messageID"];
    $deleteMessage = "DELETE FROM Messages WHERE MessageID='$messageID'";

    $db->get_con()->query($deleteMessage);
    echo json_encode($_SESSION['responseMessages']);
}


?>