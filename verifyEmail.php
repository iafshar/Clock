<?php
session_start();

require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();


if (isset($_GET["hash"]) && isset($_GET["email"]) && isset($_GET["premium"]) && isset($_GET["action"]) && !isset($_POST["action"])) {
    // for verifying email 
    $hash = $_GET["hash"];
    $email = $_GET["email"];
    $premium = $_GET["premium"];
    $currentDate = date("Y-m-d H:i:s");

    if ($_GET["action"]=="verify") { // if verifying email on signup
        $reset = 0;
    }

    else if ($_GET["action"]=="verifyNew") { // if verifying new email when changing email
        $reset = 2;
    }
    
    $CheckHash = "SELECT * FROM `Hashes` WHERE Hash='$hash' AND Email='$email' AND Type='$reset'";

    $result = mysqli_query($conn, $CheckHash);

    if ($result->num_rows == 0) { // if the hash is not in the database
        header("Location:http://localhost:8080/Clock/invalidLink.html");
    }
    else {
        while ($row = $result->fetch_assoc()) {
            $Username = $row["Username"];
            // this will now be hashed password
            $Password = $row["Password"];
            $expirationDate = $row["ExpirationDate"];
        }
        $deleteHash = "DELETE FROM Hashes WHERE Hash='$hash' AND Email='$email' AND Type=$reset";
        

        if ($expirationDate <= $currentDate) { // if the hash has passed its expiration time
            mysqli_query($conn, $deleteHash);
            header("Location:http://localhost:8080/Clock/invalidLink.html");
        }
        else {
            $_SESSION["Email"] = $email;
            $_SESSION["Username"] = $Username;
            $_SESSION["Premium"] = $premium;
            if ($reset == 0) {
    
                mysqli_query($conn, $deleteHash); // the hash is deleted because it is not needed anymore
    
                $Insert = "INSERT INTO Users (Username,Password,Email,Premium)
                    VALUES ('$Username', '$Password', '$email', '$premium')";
                    // insert hashed pwd
                
                
                if (mysqli_query($conn, $Insert)) {
                    $getUserID = "SELECT UserID FROM Users WHERE Username='$Username' AND Email='$email'";
                    $result2 = mysqli_query($conn, $getUserID);
                    while ($row = $result2->fetch_assoc()) {
                        $UserID = $row["UserID"];
                        $_SESSION["UserID"] = $UserID;
                    }
                    $addPwd = "INSERT INTO Passwords (UserID,Password)
                            VALUES ('$UserID','$Password')";
                    // hashed pwd
    
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

            else if ($reset == 2) { // if verifying email on change email
                $updateEmail = "UPDATE Users
                SET Email = '$email'
                WHERE Username = '$Username' AND Password='$Password'";

                if (mysqli_query($conn, $updateEmail)) {
                    header("Location:http://localhost:8080/Clock/myClocks.php");
                }
                else {
                    echo "Error: " . $updateEmail . "<br>" . mysqli_error($conn);
                }
            }
            
        }
    }
}

?>