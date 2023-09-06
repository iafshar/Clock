<?php
session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();


$UserID = $_SESSION["UserID"];

$Update = "UPDATE Users
    SET Premium = 1
    WHERE UserID = '$UserID'";

mysqli_query($conn, $Update);

$_SESSION["Premium"] = 1;
header("Location: myClocks.php");

?>
