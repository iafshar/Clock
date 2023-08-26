<?php
session_start();
$_SESSION["ErrorEmail"] = "";
// include db connect class
require_once __DIR__ . '/dbConfig.php';
// Create connection
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET["hash"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"]=="reset") && !isset($_POST["action"])){
    $hash = $_GET["hash"];
    $email = $_GET["email"];
    $currentDate = date("Y-m-d H:i:s");

    $CheckHash = "SELECT * FROM `Hashes` WHERE Hash='$hash' AND Email='$email' AND Reset=1";

    $result = mysqli_query($conn, $CheckHash);

    if ($result->num_rows == 0) {
        header("Location:http://localhost:8080/Clock/invalidLink.html");
    }
    else {
        while ($row = $result->fetch_assoc()) {
            $expirationDate = $row["ExpirationDate"];
        }
        $_SESSION['deleteHash'] = "DELETE FROM Hashes WHERE Hash='$hash' AND Email='$email' AND Reset=1";

        if ($expirationDate <= $currentDate) {
            header("Location:http://localhost:8080/Clock/invalidLink.html");
        }
        else {
            $_SESSION["Email"] = $email;
            header("Location:http://localhost:8080/Clock/updatePassword.php");
        }
    }
}
else {
    header("Location:http://localhost:8080/Clock/invalidLink.html");
}

?>