<?php
session_start();
// include db connect class
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();


if (isset($_GET["hash"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"]=="reset") && !isset($_POST["action"])){
    // if the link is correct
    $hash = $_GET["hash"];
    $email = $_GET["email"];
    $currentDate = date("Y-m-d H:i:s");

    $CheckHash = "SELECT * FROM `Hashes` WHERE Hash='$hash' AND Email='$email' AND Type=1";

    $result = mysqli_query($conn, $CheckHash);

    if ($result->num_rows == 0) { // if the hash does not exist
        header("Location:https://clockdrum.000webhostapp.com/invalidLink.html");
    }
    else {
        while ($row = $result->fetch_assoc()) {
            $expirationDate = $row["ExpirationDate"];
        }
        $_SESSION['deleteHash'] = "DELETE FROM Hashes WHERE Hash='$hash' AND Email='$email' AND Type=1";

        if ($expirationDate <= $currentDate) {
            header("Location:https://clockdrum.000webhostapp.com/invalidLink.html");
        }
        else { 
            $_SESSION["Email"] = $email;
            header("Location:https://clockdrum.000webhostapp.com/updatePassword.php");
        }
    }
}
else {
    header("Location:https://clockdrum.000webhostapp.com/invalidLink.html");
}

?>