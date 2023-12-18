
<?php
// <!-- Checks that the user has not reached their clock limit -->
session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();

$UserID = $_SESSION['UserID'];
$Premium = $_SESSION["Premium"];

$ClockSearch = "SELECT * FROM `Clocks` WHERE UserID='$UserID'";
$result = mysqli_query($conn, $ClockSearch) or die(mysqli_error($conn));
$count = mysqli_num_rows($result);

if ($count == 5 && $Premium == 0 || $count == 20 && $Premium == 1){
    $_SESSION["Error"] = "You have reached your clock limit.";
    header("Location:http://localhost:8080/Clock/myClocks.php");
}
else {
    $_SESSION["Error"] = "";
    $clockID = "";
    if (isset($_GET["clockID"])) { // only true for remix
        $clockID .= "?".$_GET["clockID"];
    }
    header("Location:http://localhost:8080/Clock/Clock_User/index.html".$clockID);
}

?>
