
<?php
// <!-- gets the data required for the user to view a mini clock -->
session_start();

$response = array();


require_once '../dbConnect.php';

// connecting to db
$db = new DB_CONNECT();

$ClockID = $_GET["ClockID"];

$GetClock = "SELECT * FROM Clocks WHERE ClockID='$ClockID'";
$result = $db->get_con()->query($GetClock);
while ($row = $result->fetch_assoc()){ // gets the clock
  $response["name"] = $row["Name"];
  $response["tempo"] = $row["Tempo"];
}

$GetCircles = "SELECT * FROM Circles WHERE ClockID='$ClockID'";
$result = $db->get_con()->query($GetCircles); // gets the circles attached to the clock

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
 ?>
