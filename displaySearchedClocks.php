
<?php
// <!-- gets the clocks of the user that has been searched for to display in "otherProfile.php" -->

session_start();

// include db connect class
require_once __DIR__ . '/dbConnect.php';

// connecting to db
$db = new DB_CONNECT();

$response = array();

if (isset($_GET["UserID"])) {
    $_SESSION["SearchedUserID"] = $_GET["UserID"];
}
$SearchedUserID = $_SESSION["SearchedUserID"];

$getUsername = "SELECT Username FROM Users WHERE UserID='$SearchedUserID'";
$result = $db->get_con()->query($getUsername);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $_SESSION["SearchedUsername"] = $row["Username"];
        $SearchedUsername = $row["Username"];
    }
}


$MyUserID = $_SESSION["UserID"];
$isFollowing = "SELECT * FROM Followings WHERE FollowerID='$MyUserID' AND FollowedID='$SearchedUserID'";
$result = $db->get_con()->query($isFollowing);



if ($result->num_rows == 0) {
    $response["Following"] = "Follow";
}
else {
    $response["Following"] = "Unfollow";
}



// get all clocks from clocks table
$sql = ("SELECT * FROM Clocks WHERE UserID='$SearchedUserID' AND Shared=1
        ORDER BY Date DESC");
$result = $db->get_con()->query($sql);
$response["Username"] = $SearchedUsername;
// check for empty result
if ($result->num_rows > 0) {
    // looping through all results
    $response["Clocks"] = array();


    while ($row = $result->fetch_assoc()) {
        // temp user array
        $record = array();
        $ClockID = $row["ClockID"];
        $record["UserID"] = $row["UserID"];
        $record["ClockID"] = $ClockID;
        $record["Name"] = $row["Name"];
        $record["Tempo"] = $row["Tempo"];
        $record["Date"] = $row["Date"];
        $GetNumOfLikes = "SELECT * FROM Votes WHERE ItemID='$ClockID' AND Item=0 AND Dislike=0";
        $result2 = $db->get_con()->query($GetNumOfLikes);
        $record["NumOfLikes"] = $result2->num_rows;
        $GetNumOfDislikes = "SELECT * FROM Votes WHERE ItemID='$ClockID' AND Item=0 AND Dislike=1";
        $result3 = $db->get_con()->query($GetNumOfDislikes);
        $record["NumOfDislikes"] = $result3->num_rows;
        $checkLiked = "SELECT * FROM Votes WHERE UserID='$MyUserID' AND ItemID='$ClockID' AND Item=0 AND Dislike=0";
        if ($db->get_con()->query($checkLiked)->num_rows > 0) {
          $record["LikeColor"] = "#f39faa";
        }
        else {
          $record["LikeColor"] = "#efefef";
        }
        $checkDisliked = "SELECT * FROM Votes WHERE UserID='$MyUserID' AND ItemID='$ClockID' AND Item=0 AND Dislike=1";
        if ($db->get_con()->query($checkDisliked)->num_rows > 0) {
          $record["DislikeColor"] = "#f39faa";
        }
        else {
          $record["DislikeColor"] = "#efefef";
        }

        // push single record into final response array
        array_push($response["Clocks"], $record);
    }
    $response["Premium"] = $_SESSION["Premium"];
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
