<?php
session_start();

require_once __DIR__ . '/dbConnect.php';

$db = new DB_CONNECT();

$UserID = $_SESSION["UserID"];

if (isset($_GET["item"])) {
    $search = $_GET["item"];
    $deleteHistoryItem = "DELETE FROM Searches WHERE UserID='$UserID' AND Search='$search'";

    $db->get_con()->query($deleteHistoryItem);
}



?>