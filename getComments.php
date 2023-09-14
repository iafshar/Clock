
<?php
// <!-- gets all the comments related to the desired clock  -->
session_start();

require_once __DIR__ . '/dbConnect.php';

// connecting to db
$db = new DB_CONNECT();

if (isset($_GET["clockID"])) {
  $_SESSION["ClockID"] = $_GET["clockID"];
}

$ClockID = $_SESSION["ClockID"];
$MyUserID = $_SESSION["UserID"];

$GetComments = "SELECT * FROM Comments WHERE ClockID='$ClockID'";

$result = $db->get_con()->query($GetComments);

// check for empty result
if ($result->num_rows > 0) {

  $response["Comments"] = array();

  while ($row = $result->fetch_assoc()) {
    $record = array();
    
    $record["CommentID"] = $row["CommentID"];
    $commentID = $row["CommentID"];

    $getLikes = "SELECT * FROM `Votes` WHERE ItemID='$commentID' AND Item=1 AND Dislike=0";
    $result2 = $db->get_con()->query($getLikes);
    $record["NumOfLikes"] = $result2->num_rows;

    $getDislikes = "SELECT * FROM `Votes` WHERE ItemID='$commentID' AND Item=1 AND Dislike=1";
    $result2 = $db->get_con()->query($getDislikes);
    $record["NumOfDislikes"] = $result2->num_rows;

    $checkLiked = "SELECT * FROM Votes WHERE UserID='$MyUserID' AND ItemID='$commentID' AND Item=1 AND Dislike=0";
    if ($db->get_con()->query($checkLiked)->num_rows > 0) {
      $record["LikeColor"] = "#f39faa";
    }
    else {
      $record["LikeColor"] = "#efefef";
    }
    $checkDisliked = "SELECT * FROM Votes WHERE UserID='$MyUserID' AND ItemID='$commentID' AND Item=1 AND Dislike=1";
    if ($db->get_con()->query($checkDisliked)->num_rows > 0) {
      $record["DislikeColor"] = "#f39faa";
    }
    else {
      $record["DislikeColor"] = "#efefef";
    }

    $record["ClockID"] = $row["ClockID"];
    $record["Comment"] = $row["Comment"];
    $record["Date"] = $row["Date"];

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
