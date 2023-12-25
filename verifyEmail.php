<?php
session_start();

require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();


if (isset($_GET["hash"]) && isset($_GET["email"]) && isset($_GET["premium"]) && isset($_GET["action"]) && ($_GET["action"]=="verify") && !isset($_POST["action"])) {
    // for verifying email on signup
    $hash = $_GET["hash"];
    $email = $_GET["email"];
    $premium = $_GET["premium"];
    $currentDate = date("Y-m-d H:i:s");

    $CheckHash = "SELECT * FROM `Hashes` WHERE Hash='$hash' AND Email='$email' AND Reset=0";

    $result = mysqli_query($conn, $CheckHash);

    if ($result->num_rows == 0) { // if the hash is not in the database
        header("Location:http://localhost:8080/Clock/invalidLink.html");
    }
    else {
        while ($row = $result->fetch_assoc()) {
            $Username = mysqli_real_escape_string($conn, $row["Username"]);
            $Password = $row["Password"];
            $expirationDate = $row["ExpirationDate"];
        }
        $deleteHash = "DELETE FROM Hashes WHERE Hash='$hash' AND Email='$email' AND Reset=0";
        

        if ($expirationDate <= $currentDate) { // if the hash has passed its expiration time
            mysqli_query($conn, $deleteHash);
            header("Location:http://localhost:8080/Clock/invalidLink.html");
        }
        else {
            $_SESSION["Email"] = $email;
            $_SESSION["Username"] = $Username;
            $_SESSION["Password"] = $Password;
            $_SESSION["Premium"] = $premium;

            mysqli_query($conn, $deleteHash); // the hash is deleted because it is not needed anymore

            $Insert = "INSERT INTO Users (Username,Password,Email,Premium)
                VALUES ('$Username', '$Password', '$email', '$premium')";
            
            if (mysqli_query($conn, $Insert)) {
                
                $getUserID = "SELECT UserID FROM Users WHERE Username='$Username' AND Email='$email'";
                $result2 = mysqli_query($conn, $getUserID);
                while ($row = $result2->fetch_assoc()) {
                    $UserID = $row["UserID"];
                    $_SESSION["UserID"] = $UserID;
                }
                $addPwd = "INSERT INTO Passwords (UserID,Password)
                        VALUES ('$UserID','$Password')";

                if (mysqli_query($conn, $addPwd)) {
                    header("Location:http://localhost:8080/Clock/myClocks.php");
                }
                else {
                    echo "Error: " . $addPwd . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "Error: " . $Insert . "<br>" . mysqli_error($conn);
            }
        }
    }
}

?>