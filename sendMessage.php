<?php

session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();

$toUsername = $_SESSION["SearchedUsername"];
$fromUsername = $_SESSION["Username"];

if(isset($_POST['message']) && strlen($_POST['message']) > 0){

    $content = $_POST['message'];

    $dateSent = date('Y-m-d H:i:s');



    $addMessage = "INSERT INTO Messages (FromUsername,ToUsername,Type,Content,DateSent)
        VALUES('$fromUsername','$toUsername',0,'$content','$dateSent')";


    $result = $db->get_con()->query($addMessage);
    
    
}
header("Location:http://localhost:8080/Clock/sendingMessage.php");

?>