
<?php
// <!-- adds a vote to the DB that is a dislike -->
session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();


if (isset($_POST["location"]) && isset($_POST["dislike"])) {
    if (isset($_POST["clockID"])) {
        $ItemID = $_POST["clockID"];
        $item = 0;
    }
    else if (isset($_POST["commentID"])) {
        $ItemID = $_POST["commentID"];
        $item = 1;
    }
    else if (isset($_POST["replyID"])) {
        $ItemID = $_POST["replyID"];
        $item = 2;
    }
    $location = $_POST["location"];
    $dislike = $_POST["dislike"];
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
    echo 0;
    // header("Location:".$location);
}
else if (mysqli_query($conn, $VoteInsert)) {
    echo 1;
    // header("Location:".$location);
}
else {
    echo "Error: " . $VoteInsert . "<br>" . mysqli_error($conn);
}

 ?>
