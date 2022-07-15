<?php
// <!-- gets the clocks in the right order to display in "discover.html" -->

// include db connect class
require_once __DIR__ . '/db_connect.php';
require_once __DIR__ . '/mergeSort.php';

// connecting to db
$db = new DB_CONNECT();

$response = array(); // This is the array that will contain
										 // the details of the results from all queries
$sql = ("SELECT * FROM Clocks WHERE Shared = 1");
$result = $db->get_con()->query($sql); // Gets the result of the above query
// check for empty result
if ($result->num_rows > 0) {
    // looping through all results
    $response["ClocksUnsorted"] = array();
    while ($row = $result->fetch_assoc()) {
      $record = array();
      $ClockID = $row["ClockID"];
      $likes = 0;
      $dislikes = 0;
      $VoteCheck = "SELECT * FROM Votes WHERE ClockID='$ClockID'";
      $VoteResult = $db->get_con()->query($VoteCheck);
      while ($row2 = $VoteResult->fetch_assoc()){
        if($row2["Dislike"] == 1){
          $dislikes ++;
        }
        else{
          $likes ++;
        }
      }
      if($likes+$dislikes >= 5 && $likes > 0 && $dislikes > 0){
        $UserID = $row["UserID"];
        $FindUsername = "SELECT Username FROM Users Where UserID='$UserID'";
        $UsernameResult = $db->get_con()->query($FindUsername);
        $row3 = $UsernameResult->fetch_assoc();
        $record["Username"] = $row3["Username"];
        $record["Name"] = $row["Name"];
        $record["Tempo"] = $row["Tempo"];
        $record["Shared"] = $row["Shared"];
        $record["DateShared"] = $row["DateShared"];
        $record["NumOfLikes"] = $likes;
        $record["NumOfDislikes"] = $dislikes;
        $record["Ratio"] = $dislikes/$likes;
        array_push($response["ClocksUnsorted"], $record);
				// Puts each record in the array not sorted by their like:dislike ratio
      }
    }
    // success
    $response["success"] = 1;
    $response["ClocksSorted"] = array();
    array_push($response["ClocksSorted"], merge_sort($response["ClocksUnsorted"],"Ratio"));
		// Now a merge sort function which I have created has been applied to the unsorted clocks
		// and the array now has all the clocks sorted by their like:dislike ratio

    // echoing JSON response(prints it)
    echo json_encode($response);
} else {

    $response["success"] = 0;
    $response["message"] = "No records found";

    // echo empty array
    echo json_encode($response);
}
?>
