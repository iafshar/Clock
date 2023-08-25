<?php

session_start();

$UserID = $_SESSION["UserID"];

require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();

$getUsers = "SELECT * FROM `Users` WHERE UserID!='$UserID'";

$result = $db->get_con()->query($getUsers);

$Users = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $Username = $row["Username"];
        array_push($Users,$Username);
    }
}

echo json_encode($Users);

?>