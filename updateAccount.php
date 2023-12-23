<?php
// Updates a user's account to make it premium if it was basic before, or basic if it was premium before
session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();


$UserID = $_SESSION["UserID"];
if ($_SESSION["Premium"] == 1) {
    $Premium = 0;
}
else {
    $Premium = 1;
}
$Update = "UPDATE Users
    SET Premium = '$Premium'
    WHERE UserID = '$UserID'";

mysqli_query($conn, $Update);

$_SESSION["Premium"] = $Premium;
header("Location: myClocks.php");

?>
