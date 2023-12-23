<?php
// deletes all items of a user's search history
session_start();

require_once __DIR__ . '/dbConnect.php';

$db = new DB_CONNECT();

$UserID = $_SESSION["UserID"];

$clearHistory = "DELETE FROM Searches WHERE UserID='$UserID'";

$db->get_con()->query($clearHistory);


?>