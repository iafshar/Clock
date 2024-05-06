<?php

session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();

$UserID = $_SESSION["UserID"];

if (isset($_POST['email1'])){ 
    $invalid = FALSE;

    $Email1 = mysqli_real_escape_string($conn, $_POST['email1']);
    $Email2 = mysqli_real_escape_string($conn, $_POST['email2']);

    $findUser = "SELECT * FROM `Users` WHERE UserID='$UserID' AND Email='$Email1'";

    $result = mysqli_query($conn, $findUser);

    if ($result->num_rows == 0) { // if the old email does not exist
        $invalid = TRUE;
        $_SESSION["wrongEmail"] = "invalid";
    }
    else {
        $_SESSION["wrongEmail"] = "valid";
    }

    $checkEmail = "SELECT * FROM `Users` WHERE Email='$Email2'";

    $result = mysqli_query($conn, $checkEmail);

    if ($result->num_rows > 0) { // if the new email already exists
        $invalid = TRUE;
        $_SESSION["existingEmail"] = "invalid";
    }
    else {
        $_SESSION["existingEmail"] = "valid";
    }

    if ($invalid) {
        $_SESSION["messageEmailDisplay"] = "block";
        header("Location:https://clockdrum.000webhostapp.com/updateEmail.php");
    }
    else {
        header("Location:https://clockdrum.000webhostapp.com/sendEmail.php?oldEmail=".$Email1."&newEmail=".$Email2);
    }

}


?>