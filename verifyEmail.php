<?php
session_start();

require_once __DIR__ . '/dbConfig.php';
// Create connection
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET["hash"]) && isset($_GET["email"]) && isset($_GET["premium"]) && isset($_GET["action"]) && ($_GET["action"]=="verify") && !isset($_POST["action"])) {
    $hash = $_GET["hash"];
    $email = $_GET["email"];
    $premium = $_GET["premium"];
    $currentDate = date("Y-m-d H:i:s");

    $CheckHash = "SELECT * FROM `Hashes` WHERE Hash='$hash' AND Email='$email' AND Reset=0";

    $result = mysqli_query($conn, $CheckHash);

    if ($result->num_rows == 0) {
        header("Location:http://localhost:8080/Clock/invalidLink.html");
    }
    else {
        while ($row = $result->fetch_assoc()) {
            $Username = $row["Username"];
            $Password = $row["Password"];
            $expirationDate = $row["ExpirationDate"];
        }
        $deleteHash = "DELETE FROM Hashes WHERE Hash='$hash' AND Email='$email' AND Reset=0";
        

        if ($expirationDate <= $currentDate) {
            mysqli_query($conn, $deleteHash);
            header("Location:http://localhost:8080/Clock/invalidLink.html");
        }
        else {
            $_SESSION["Email"] = $email;
            $_SESSION["Username"] = $Username;
            $_SESSION["Password"] = $Password;
            $_SESSION["Premium"] = $premium;

            mysqli_query($conn, $deleteHash);

            $Insert = "INSERT INTO Users (Username,Password,Email,Premium)
                VALUES ('$Username', '$Password', '$email', '$premium')";
            if (mysqli_query($conn, $Insert)) {
                header("Location:http://localhost:8080/Clock/myClocks.php");
            } else {
                echo "Error: " . $Insert . "<br>" . mysqli_error($conn);
            }
        }
    }
}

?>