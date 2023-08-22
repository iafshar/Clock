
<?php
// <!-- gets all the comments related to the desired clock  -->
session_start();

require_once __DIR__ . '/dbConnect.php';

// connecting to db
$db = new DB_CONNECT();

$ClockID = $_SESSION["ClockID"];

$GetComments = "SELECT * FROM Comments WHERE ClockID='$ClockID'";

$result = $db->get_con()->query($GetComments);

// check for empty result
if ($result->num_rows > 0) {

  $response["Comments"] = array();

  while ($row = $result->fetch_assoc()) {
    $record = array();
    $record["CommentID"] = $row["CommentID"];
    $record["Comment"] = $row["Comment"];

    array_push($response["Comments"], $record);
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
