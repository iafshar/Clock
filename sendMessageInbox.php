
<?php

session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();

$fromUsername = $_SESSION["Username"];

if(isset($_POST['message']) && strlen($_POST['message']) > 0 && isset($_POST['Sender'])){

    $toUsername = $_POST['Sender'];
    $content = $_POST['message'];

    $dateSent = date('Y-m-d H:i:s');



    $addMessage = "INSERT INTO Messages (FromUsername,ToUsername,Type,Content,DateSent)
        VALUES('$fromUsername','$toUsername',0,'$content','$dateSent')";


    $result = $db->get_con()->query($addMessage);


    $getMessages = "SELECT * FROM `Messages`
    WHERE ToUsername IN ('$fromUsername','$toUsername') AND FromUsername IN ('$toUsername','$fromUsername')
        ORDER BY DateSent DESC";

    $result = $db->get_con()->query($getMessages);

    if ($result->num_rows > 0) {
        $response["Messages"] = array();
        while ($row = $result->fetch_assoc()) {
            // temp user array
            $record = array();
            $record["Content"] = $row["Content"];
            $record["DateSent"] = $row["DateSent"];
            if ($row["ToUsername"] == $fromUsername) {
                $record["Color"] = "#ffffff";
                $record["sentByMe"] = 0; 
            }
            else {
                $record["Color"] = "#03c6fc";
                $record["sentByMe"] = 1;
            }
            

            array_push($response["Messages"], $record);

        }
        $response["success"] = 1;

    }
    else {
        $response["success"] = 0;
    }


    $response["otherUsername"] = $toUsername;
    $_SESSION['responseMessages'] = $response;
    
    
}
header("Location:http://localhost:8080/Clock/chat.php");

?>