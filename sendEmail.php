<?php

// sends an email with a verification link to a user

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'libraries/PHPMailer/src/Exception.php';
require 'libraries/PHPMailer/src/PHPMailer.php';
require 'libraries/PHPMailer/src/SMTP.php';

// include db connect class
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();


if (isset($_POST['Forgot'])) { // if an email is being sent because a user has forgotten their password
    $Email = $_POST['Forgot']; // the user could have entered an email or a username
    $EscapedEmail =  mysqli_real_escape_string($conn, $Email);

    $CheckEmail = "SELECT * FROM `Users` WHERE Email='$EscapedEmail'";
    $result = mysqli_query($conn, $CheckEmail);

    if ($result->num_rows == 0) { // if no email exists that matches what the user entered
        $CheckUsername = "SELECT * FROM `Users` WHERE Username='$EscapedEmail'";
        $result = mysqli_query($conn, $CheckUsername);
        
        if ($result->num_rows == 0) { // if no username exists that matches what the user entered
            header("Location:http://localhost:8080/Clock/forgotPassword.php");
        }
    } 
    if ($result->num_rows > 0 ) { // if the user entered something that is an existing username or email in the database
        $expirationFormat = mktime(
            date("H")+3, date("i"), date("s"), date("m") ,date("d"), date("Y")
            );
        $expirationDate = date("Y-m-d H:i:s",$expirationFormat);
        
        while ($row = $result->fetch_assoc()) {
            $EscapedUsername =  mysqli_real_escape_string($conn, $row["Username"]);
            $Username = $row["Username"];
            $Password = $row["Password"];
            $Email = $row["Email"];  
        }

        
        $pt1 = md5(2418*2 . $Email); // first part of the hash that uses the user's email
        $pt2 = substr(md5(uniqid(rand(),1)),3,10); //second part of the hash that is random
        $hash = $pt1 . $pt2;

        $InsertHash = "INSERT INTO Hashes (Email,Username,Password,Hash,ExpirationDate,Reset)
        VALUES ('$Email', '$EscapedUsername','$Password','$hash', '$expirationDate', 1)";

        mysqli_query($conn, $InsertHash);

        

        $message = '<p>Dear '.$Username.',</p>';
        $message .= '<p>Please click on the following link to reset your password.</p>';
        $message .='<p><a href="http://localhost:8080/Clock/resetPassword.php?hash='.$hash.'&email='.$Email.'&action=reset" target="_blank">
        http://localhost:8080/Clock/resetPassword.php?hash='.$hash.'&email='.$Email.'&action=reset</a></p>';

        // this will probably have to change once this gets publicly hosted
        // had to set up a new email called iafsharclock@gmail.com the password for which is (Hint: usual mki)
        // then had to set up 2 factor authentication for that email.
        // then had to set up an app password for that email which is what is passed in to mail->password on line 69
        // just followed instructions that port is 465
        $subject = "Password Recovery";
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com'; // Enter your host here
        $mail->SMTPAuth = true;
        $mail->Username = "iafsharclock@gmail.com"; // Enter your email here
        $mail->Password = "qhduwaasquwrjcyh"; //Enter your password here
        $mail->Port = 465;                    //SMTP port
        $mail->SMTPSecure = "ssl";
        $mail->IsHTML(true);
        $mail->setFrom('iafsharclock@gmail.com', 'Clock Team');

        //receiver email address and name
        $mail->addAddress($Email, $Username); 

        $mail->Subject = $subject;
        $mail->Body = $message;


        if(!$mail->Send()){
            echo "Mailer Error: " . $mail->ErrorInfo;
        }else{
            echo "<div class='error'>
            <p>An email has been sent to you with instructions on how to reset your password.</p>
            </div><br /><br /><br />";

        }

    }

}

else { // if an email is being set because a user wants to sign up for an account
    $Email = $_SESSION["Email"];
    $Username = $_SESSION['Username'];
    $Password = $_SESSION["Password"];
    $Premium = $_SESSION["Premium"];

    $expirationFormat = mktime(
        date("H")+3, date("i"), date("s"), date("m") ,date("d"), date("Y")
        );
    $expirationDate = date("Y-m-d H:i:s",$expirationFormat);
    $pt1 = md5(2418*2 . $Email);
    $pt2 = substr(md5(uniqid(rand(),1)),3,10);
    $hash = $pt1 . $pt2;

    $InsertHash = "INSERT INTO Hashes (Email,Username,Password,Hash,ExpirationDate,Reset)
        VALUES ('$Email', '$Username','$Password','$hash', '$expirationDate', 0)";

    mysqli_query($conn, $InsertHash);

    $UnescapeUsername = "SELECT * FROM Hashes Where Username='$Username'";
    $UsernameResult = $db->get_con()->query($UnescapeUsername); // need to do this because the user would see a backslash infront of special characters in their username in the email
    while ($row = $UsernameResult->fetch_assoc()){
        $Username2 = $row["Username"];
    }

    $message = '<p>Dear '.$Username2.',</p>';
    $message .= '<p>Please click on the following link to verify your email.</p>';
    $message .='<p><a href="http://localhost:8080/Clock/verifyEmail.php?hash='.$hash.'&email='.$Email.'&premium='.$Premium.'&action=verify" target="_blank">
    http://localhost:8080/Clock/verifyEmail.php?hash='.$hash.'&email='.$Email.'&premium='.$Premium.'&action=verify</a></p>';

        // this will probably have to change once this gets publicly hosted
        // had to set up a new email called iafsharclock@gmail.com the password for which is (Hint: usual mki)
        // then had to set up 2 factor authentication for that email.
        // then had to set up an app password for that email which is what is passed in to mail->password below
        // just followed instructions that port is 465
    $subject = "Email Verification";
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com'; // Enter your host here
    $mail->SMTPAuth = true;
    $mail->Username = "iafsharclock@gmail.com"; // Enter your email here
    $mail->Password = "qhduwaasquwrjcyh"; //Enter your password here
    $mail->Port = 465;                    //SMTP port
    $mail->SMTPSecure = "ssl";
    $mail->IsHTML(true);
    $mail->setFrom('iafsharclock@gmail.com', 'Clock Team');

        //receiver email address and name
    $mail->addAddress($Email, $Username2); 

    $mail->Subject = $subject;
    $mail->Body = $message;
    if(!$mail->Send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
    }else{
        echo "<div class='error'>
        <p>An email has been sent to you with a verification link.</p>
        </div><br /><br /><br />";

    }

}


?>