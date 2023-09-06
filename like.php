
<?php
// <!-- adds a vote that is a like to the database -->
session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();


if (isset($_GET["clockID"]) && isset($_GET["Name"]) && isset($_GET["location"])) {
    $_SESSION["ClockID"] = $_GET["clockID"];
    $_SESSION["clockName"] = $_GET["Name"];
    $_SESSION["Location"] = $_GET["location"];
}

$ClockID = $_SESSION["ClockID"];
$Name = $_SESSION["clockName"];
$UserID = $_SESSION["UserID"];

$Check = "SELECT * FROM Votes WHERE UserID='$UserID' AND ClockID='$ClockID' AND Dislike=0";
$CheckResult = mysqli_query($conn, $Check) or die(mysqli_error($conn));
$CheckCount = mysqli_num_rows($CheckResult);

$Unlike = "DELETE FROM Votes WHERE UserID='$UserID' AND ClockID='$ClockID' AND Dislike=0";
$VoteInsert = "INSERT INTO Votes (UserID, ClockID, Dislike)
  VALUES ('$UserID','$ClockID',0)";

if ($CheckCount != 0){
    mysqli_query($conn, $Unlike);
    header("Location:".$_SESSION["Location"]);
}
else if (mysqli_query($conn, $VoteInsert)) {
    header("Location:".$_SESSION["Location"]);
}
else {
    echo "Error: " . $VoteInsert . "<br>" . mysqli_error($conn);
}

 ?>
