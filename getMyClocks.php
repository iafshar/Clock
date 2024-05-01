<?php
//  gets the clocks of the user logged in to display on the profile page
/*
 * Following code will list all the records on the table
 */
if (session_status()!=1) {
    session_start();
}

include __DIR__ . '/getUserID.php';

$_SESSION["tempo"] = 0;
$_SESSION["Error"] = "";
// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/dbConnect.php';

// connecting to db
$db = new DB_CONNECT();
$UserID = $_SESSION["UserID"];
// get all clocks from clocks table
$sql = ("SELECT * FROM Clocks WHERE UserID='$UserID'
         ORDER BY Date DESC");
$result = $db->get_con()->query($sql);

// check for empty result
if ($result->num_rows > 0) {
    // looping through all results
    $response["Clocks"] = array();

    while ($row = $result->fetch_assoc()) {
        // temp user array
        $record = array();
        $ClockID = $row["ClockID"];
        $record["ClockID"] = $row["ClockID"];
        $record["Name"] = $row["Name"];
        $record["Tempo"] = $row["Tempo"];
        $record["Shared"] = $row["Shared"];
        $record["Date"] = $row["Date"];
        $GetNumOfLikes = "SELECT * FROM Votes WHERE ItemID='$ClockID' AND Item=0 AND Dislike=0";
        $result2 = $db->get_con()->query($GetNumOfLikes);
        $record["NumOfLikes"] = $result2->num_rows;
        $GetNumOfDislikes = "SELECT * FROM Votes WHERE ItemID='$ClockID' AND Item=0 AND Dislike=1";
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

    // echo no users JSON
    echo json_encode($response);
}
?>
