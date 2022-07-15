
<?php
// <!-- Checks that the user has not reached their clock limit -->
session_start();
require_once __DIR__ . '/db_config.php';


$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$UserID = $_SESSION['UserID'];
$Premium = $_SESSION['Premium'];

$ClockSearch = "SELECT * FROM `Clocks` WHERE UserID='$UserID'";
$result = mysqli_query($conn, $ClockSearch) or die(mysqli_error($conn));
$count = mysqli_num_rows($result);

if ($count == 5 && $Premium == 0 || $count == 20 && $Premium == 1){
    $_SESSION["Error"] = "You have reached your clock limit.";
    header("Location:http://localhost:8080/NEA5/MyClocks.php");
}
else {
    $_SESSION["Error"] = "";
    header("Location:http://localhost:8080/NEA5/Clock_JS5/index.html");
}

?>
