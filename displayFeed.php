<?php
// <!-- gets the clocks of all the other users that the user follows so that they can be accessed in "feed.html" -->
session_start();
$MyUserID = $_SESSION["UserID"];

$response = array();

// include db connect class
require_once __DIR__ . '/dbConnect.php';

// connecting to db
$db = new DB_CONNECT();

$getFeed = "SELECT * FROM Clocks WHERE Shared=1 AND UserID IN 
  (SELECT FollowedID FROM Followings WHERE FollowerID='$MyUserID')
  ORDER BY Date DESC";


$result = $db->get_con()->query($getFeed);

if ($result->num_rows > 0){
  $response["ClocksUnsorted"] = array();
  while ($row = $result->fetch_assoc()) {
    $record = array();
    $ClockID = $row["ClockID"];
    $UserID = $row["UserID"];
    $FindUsername = "SELECT * FROM Users Where UserID='$UserID'";
    $UsernameResult = $db->get_con()->query($FindUsername);
    while ($row2 = $UsernameResult->fetch_assoc()){
      $record["Username"] = $row2["Username"];
    }
    $record["UserID"] = $UserID;
    $record["ClockID"] = $ClockID;
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
    $record["Premium"] = $_SESSION["Premium"];
    array_push($response["ClocksUnsorted"], $record);

        // push single record into final response array
  }
  $response["success"] = 1;

  // echoing JSON response(prints it)
  echo json_encode($response);
}
  
else {
    // no products found
  $response["success"] = 0;
  $response["message"] = "No records found";

    // echo no clocks JSON
  echo json_encode($response);
}
?>
