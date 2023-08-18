<?php
//  gets the clocks of the user logged in to display on the profile page
/*
 * Following code will list all the records on the table
 */
session_start();
include '/get_UserID.php';

$_SESSION["tempo"] = 0;
$_SESSION["Error"] = "";
// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();
$UserID = $_SESSION["UserID"];
//echo '<script>console.log("here")</script>';
// get all clocks from clocks table
$sql = ("SELECT * FROM Clocks WHERE UserID='$UserID'");
$result = $db->get_con()->query($sql);

// check for empty result
if ($result->num_rows > 0) {
    // looping through all results
    $response["Clocks"] = array();

    while ($row = $result->fetch_assoc()) {
        // temp user array
        $record = array();
        $ClockID = $row["ClockID"];
        $record["Name"] = $row["Name"];
        $record["Tempo"] = $row["Tempo"];
        if ($row["Shared"] == 1) {
          $record["Shared"] = "Yes";
        }
        else {
          $record["Shared"] = "No";
        }
        $record["DateShared"] = $row["DateShared"];
        $GetNumOfLikes = "SELECT * FROM Votes WHERE ClockID='$ClockID' AND Dislike=0";
        $result2 = $db->get_con()->query($GetNumOfLikes);
        $record["NumOfLikes"] = $result2->num_rows;
        $GetNumOfDislikes = "SELECT * FROM Votes WHERE ClockID='$ClockID' AND Dislike=1";
        $result3 = $db->get_con()->query($GetNumOfDislikes);
        $record["NumOfDislikes"] = $result3->num_rows;

        // push single record into final response array
        array_push($response["Clocks"], $record);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response(prints it)
    echo json_encode($response);
} else {
    // no clocks found
    $response["success"] = 0;
    $response["message"] = "No records found";
    $response["SesUID"] = $_SESSION["UserID"];
    $response["UID"] = $UserID;

    // echo no users JSON
    echo json_encode($response);
}
?>
