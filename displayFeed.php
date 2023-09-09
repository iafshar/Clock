<?php
// <!-- gets the clocks of all the other users that the user follows so that they can be accessed in "feed.html" -->
session_start();
$check = FALSE;
$MyUserID = $_SESSION["UserID"];

$response = array();

// include db connect class
require_once __DIR__ . '/dbConnect.php';
require_once __DIR__ . '/mergeSort.php';

// connecting to db
$db = new DB_CONNECT();

$Select = "SELECT * FROM Followings WHERE FollowerID='$MyUserID'";

$Followings = $db->get_con()->query($Select);

if ($Followings->num_rows > 0){
  $response["Followings"] = array();
  while ($row = $Followings->fetch_assoc()){
    $record = array();
    $record["FollowedID"] = $row["FollowedID"];

    array_push($response["Followings"], $record);
  }
  $response["ClocksUnsorted"] = array();
  for($i = 0;$i < sizeOf($response["Followings"]);$i ++){
    $FollowingID = $response["Followings"][$i];
    $First = $FollowingID["FollowedID"];
    $Display = "SELECT * FROM Clocks WHERE Shared=1 AND UserID='$First'";
    $result = $db->get_con()->query($Display);
    if ($result->num_rows > 0) {
      $check = TRUE;


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
        $record["DateShared"] = $row["DateShared"];
        $GetNumOfLikes = "SELECT * FROM Votes WHERE ItemID='$ClockID' AND Item=0 AND Dislike=0";
        $result2 = $db->get_con()->query($GetNumOfLikes);
        $record["NumOfLikes"] = $result2->num_rows;
        $GetNumOfDislikes = "SELECT * FROM Votes WHERE ItemID='$ClockID' AND Item=0 AND Dislike=1";
        $result3 = $db->get_con()->query($GetNumOfDislikes);
        $record["NumOfDislikes"] = $result3->num_rows;
        $record["Premium"] = $_SESSION["Premium"];
        //array_push($response["ClocksUnsorted"], $record);
        array_push($response["ClocksUnsorted"], $record);

        // push single record into final response array
      }
    }
  }
}
if ($check){
  $response["success"] = 1;

  // echoing JSON response(prints it)
  echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No records found";

    // echo no clocks JSON
    echo json_encode($response);
}
?>
