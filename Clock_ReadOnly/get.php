
<?php
// <!-- gets the data required for the user to edit a clock with -->
session_start();

$response = array();

$response["tempo"] = $_SESSION["tempo"];

require_once '../db_connect.php';

// connecting to db
$db = new DB_CONNECT();

$ClockID = $_SESSION["ClockID"];
$Name = $_SESSION["clockName"];

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
 ?>
