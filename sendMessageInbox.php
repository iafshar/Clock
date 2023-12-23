
<?php

session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();

$fromUsername = $_SESSION["Username"];

if(isset($_POST['message']) && strlen($_POST['message']) > 0 && isset($_POST['toUsername'])){ 
    // if a normal message has been sent through chat
    $toUsername = $_POST['toUsername'];
    $content = mysqli_real_escape_string($db->get_con(), $_POST['message']);

    $dateSent = date('Y-m-d H:i:s');
    
    

    $addMessage = "INSERT INTO Messages (FromUsername,ToUsername,Type,Content,DateSent,Viewed)
        VALUES('$fromUsername','$toUsername',0,'$content','$dateSent',0)";


    $result = $db->get_con()->query($addMessage); // adds the message to the db


    $getMessages = "SELECT * FROM `Messages`
    WHERE ToUsername IN ('$fromUsername','$toUsername') AND FromUsername IN ('$toUsername','$fromUsername')
        ORDER BY DateSent DESC";

    $result = $db->get_con()->query($getMessages); // gets all messages with the new message

    if ($result->num_rows > 0) {
        $response["Messages"] = array();
        while ($row = $result->fetch_assoc()) {
            // temp user array
            $record = array();
            $record["MessageID"] = $row["MessageID"];
            $record["Content"] = $row["Content"];
            $record["Type"] = $row["Type"];
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

    echo json_encode($response);
    
}
else if (isset($_GET['sendingUsername']) && isset($_GET['clockID'])) {
    // if a clock message is being sent
    $toUsername = $_GET['sendingUsername'];
    $clockID = $_GET['clockID'];


    $content = $clockID;

    if (isset($_GET['addMessage'])) { // if a message has been attached to the clock
        $content = $content . "," . $_GET['addMessage']; // the content will be the clockID followed by the message separated by a comma
    }
    
    $dateSent = date('Y-m-d H:i:s');

    $content = mysqli_real_escape_string($db->get_con(), $content);
    $addMessage = "INSERT INTO Messages (FromUsername,ToUsername,Type,Content,DateSent,Viewed)
        VALUES('$fromUsername','$toUsername',1,'$content','$dateSent',0)"; 


    $result = $db->get_con()->query($addMessage); // adds the message to the db

}

?>