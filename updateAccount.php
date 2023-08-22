<?php
session_start();
require_once __DIR__ . '/dbConfig.php';

$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$UserID = $_SESSION["UserID"];

$Update = "UPDATE Users
    SET Premium = 1
    WHERE UserID = '$UserID'";

mysqli_query($conn, $Update);

$_SESSION["Premium"] = 1;
header("Location: myClocks.php");

?>
