
<?php
// <!-- gets the clocks of the user that has been searched for to display in "otherProfile.php" -->

session_start();
$SearchedUserID = $_SESSION["SearchedUserID"];

$response = array();

// include db connect class
require_once __DIR__ . '/dbConnect.php';

// connecting to db
$db = new DB_CONNECT();

// get all products from products table
$sql = ("SELECT * FROM Clocks WHERE UserID='$SearchedUserID' AND Shared=1");
$result = $db->get_con()->query($sql);

// check for empty result
if ($result->num_rows > 0) {
    // looping through all results
    $response["Clocks"] = array();

    while ($row = $result->fetch_assoc()) {
        // temp user array
        $record = array();
        $ClockID = $row["ClockID"];
        $record["UserID"] = $row["UserID"];
        $record["Name"] = $row["Name"];
        $record["Tempo"] = $row["Tempo"];
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
    // no products found
    $response["success"] = 0;
    $response["message"] = "No records found";

    // echo no users JSON
    echo json_encode($response);
}

 ?>
