<?php
// <!-- gets the data required for the user to edit a clock with -->
session_start();

$response = array();


require_once '../dbConnect.php';

// connecting to db
$db = new DB_CONNECT();

$ClockID = $_GET["ClockID"];
if ($ClockID >= 0) {
    $GetClock = "SELECT * FROM Clocks WHERE ClockID='$ClockID'";
    $result = $db->get_con()->query($GetClock);
    while ($row = $result->fetch_assoc()){
        $makerID = $row["UserID"];
        $response["name"] = $row["Name"];
        $response["tempo"] = $row["Tempo"];
    }
    if ($makerID != $_SESSION["UserID"]) {
        $response["remix"] = 1;
    }
    else {
        $response["remix"] = 0;
    }
    
    $response["new"] = 0;
    $GetCircles = "SELECT * FROM Circles WHERE ClockID='$ClockID'";
    $result = $db->get_con()->query($GetCircles);

    if ($result->num_rows > 0){
    $response["Circles"] = array();

    while ($row = $result->fetch_assoc()){
        $record = array();
        $record["SoundID"] = $row["SoundID"];
        $record["X"] = $row["X"];
        $record["Y"] = $row["Y"];

        array_push($response["Circles"], $record);
    }
    $response["success"] = 1;

    // echoing JSON response(prints it)
    echo json_encode($response);
    } else {
        // no products found
        $response["success"] = 0;
        $response["message"] = "No records found";

        // echo no users JSON
        echo json_encode($response);
    }
}
else {
    $response["new"] = 1;
    $response["success"] = 0;
    $response["message"] = "No records found";

    echo json_encode($response);
}

 ?>