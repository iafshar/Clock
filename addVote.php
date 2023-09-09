
<?php
// <!-- adds a vote to the DB that is a dislike -->
session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();


if (isset($_GET["location"]) && isset($_GET["dislike"])) {
    if (isset($_GET["clockID"])) {
        $ItemID = $_GET["clockID"];
        $item = 0;
    }
    else if (isset($_GET["commentID"])) {
        $ItemID = $_GET["commentID"];
        $item = 1;
    }
    else if (isset($_GET["replyID"])) {
        $ItemID = $_GET["replyID"];
        $item = 2;
    }
    $location = $_GET["location"];
    $dislike = $_GET["dislike"];
}

$UserID = $_SESSION["UserID"];

$Check = "SELECT * FROM Votes WHERE UserID='$UserID' AND ItemID='$ItemID' AND Item='$item' AND Dislike='$dislike'";
$CheckResult = mysqli_query($conn, $Check) or die(mysqli_error($conn));
$CheckCount = mysqli_num_rows($CheckResult);

$Unlike = "DELETE FROM Votes WHERE UserID='$UserID' AND ItemID='$ItemID' AND Item='$item' AND Dislike='$dislike'";
$VoteInsert = "INSERT INTO Votes (UserID, ItemID, Item, Dislike)
  VALUES ('$UserID','$ItemID','$item','$dislike')";

if ($CheckCount != 0){
    mysqli_query($conn, $Unlike);
    header("Location:".$location);
}
else if (mysqli_query($conn, $VoteInsert)) {
    header("Location:".$location);
}
else {
    echo "Error: " . $VoteInsert . "<br>" . mysqli_error($conn);
}

 ?>
