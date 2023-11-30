<?php
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();

if (isset($_POST["ClockID"])) {
    $clockID = $_POST["ClockID"];

    $changeShared = "UPDATE Clocks
        SET Shared = NOT (SELECT Shared FROM Clocks WHERE ClockID='$clockID')
        WHERE ClockID = '$clockID'";

    mysqli_query($conn, $changeShared);
}
echo "yes";

?>