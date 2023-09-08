
<?php
// <!-- adds a vote to the DB that is a dislike -->
session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();


if (isset($_GET["clockID"]) && isset($_GET["location"]) && isset($_GET["dislike"])) {
    $ClockID = $_GET["clockID"];
    $location = $_GET["location"];
    $dislike = $_GET["dislike"];
}

$UserID = $_SESSION["UserID"];

$Check = "SELECT * FROM Votes WHERE UserID='$UserID' AND ClockID='$ClockID' AND Dislike='$dislike'";
$CheckResult = mysqli_query($conn, $Check) or die(mysqli_error($conn));
$CheckCount = mysqli_num_rows($CheckResult);

$Unlike = "DELETE FROM Votes WHERE UserID='$UserID' AND ClockID='$ClockID' AND Dislike='$dislike'";
$VoteInsert = "INSERT INTO Votes (UserID, ClockID, Dislike)
  VALUES ('$UserID','$ClockID','$dislike')";

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
