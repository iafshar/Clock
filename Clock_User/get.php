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
    $result = $db->get_con()->query($GetClock); // gets the clock
    while ($row = $result->fetch_assoc()){
        $makerID = $row["UserID"];
        $response["name"] = $row["Name"];
        $response["tempo"] = $row["Tempo"];
    }
    if ($makerID != $_SESSION["UserID"]) { // if the userID of the clock is not the same as the userID of the current user it is a remix
        $response["remix"] = 1;
    }
    else {
        $response["remix"] = 0;
    }
    
    $response["new"] = 0; // it is not a new clock
    $GetCircles = "SELECT * FROM Circles WHERE ClockID='$ClockID'";
    $result = $db->get_con()->query($GetCircles); // gets the cirles attached to the clock

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
        // no circles found
        $response["success"] = 0;
        $response["message"] = "No records found";

        // echo no circles JSON
        echo json_encode($response);
    }
}
else {
    $response["new"] = 1; // if the clockID has not been provided (i.e. it is less than 0) it is a new clock
    $UserID = $_SESSION["UserID"];

    $response["Names"] = array();
    $getNames = "SELECT Name FROM Clocks WHERE UserID='$UserID'";
    $result = $db->get_con()->query($getNames);

    while ($row = $result->fetch_assoc()){
        array_push($response["Names"],strtolower($row["Name"])); // list of all the names of the clocks of the user
    }


    $response["success"] = 0;
    $response["message"] = "No records found";

    echo json_encode($response);
}

 ?>