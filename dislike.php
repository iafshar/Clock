
<?php
// <!-- adds a vote to the DB that is a dislike -->
session_start();
require_once __DIR__ . '/db_config.php';
// Create connection
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$ClockID = $_SESSION["ClockID"];
$Name = $_SESSION["clockName"];
$UserID = $_SESSION["UserID"];

$Check = "SELECT * FROM Votes WHERE UserID='$UserID' AND ClockID='$ClockID' AND Dislike=1";
$CheckResult = mysqli_query($conn, $Check) or die(mysqli_error($conn));
$CheckCount = mysqli_num_rows($CheckResult);

$Unlike = "DELETE FROM Votes WHERE UserID='$UserID' AND ClockID='$ClockID' AND Dislike=1";
$VoteInsert = "INSERT INTO Votes (UserID, ClockID, Dislike)
  VALUES ('$UserID','$ClockID',1)";


$Increase = "UPDATE Clocks
  SET NumOfDislikes = NumOfDislikes + 1
  WHERE ClockID='$ClockID'";

$Decrease = "UPDATE Clocks
  SET NumOfDislikes = NumOfDislikes - 1
  WHERE ClockID='$ClockID'";

if ($CheckCount != 0){
  mysqli_query($conn, $Unlike);
  mysqli_query($conn, $Decrease);
  header("Location:".$_SESSION["Location"]);
}
else if (mysqli_query($conn, $VoteInsert)) {
  mysqli_query($conn, $Increase);
  header("Location:".$_SESSION["Location"]);
}
else {
  echo "Error: " . $VoteInsert . "<br>" . mysqli_error($conn);
}


 ?>
