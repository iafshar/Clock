<?php

// sends an email with a verification link to a user

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// include db connect class
require_once __DIR__ . '/dbConfig.php';
// Create connection
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['EmailForgot'])) {
    $Email = $_POST['EmailForgot'];

    $CheckEmail = "SELECT * FROM `Users` WHERE Email='$Email'";
    $result = mysqli_query($conn, $CheckEmail);

    if ($result->num_rows == 0) {
        $_SESSION["Error"] = "This email is not associated with an account";
        header("Location:http://localhost:8080/Clock/forgotPassword.html");
    } 
    else {
        $expirationFormat = mktime(
            date("H")+3, date("i"), date("s"), date("m") ,date("d"), date("Y")
            );
        $expirationDate = date("Y-m-d H:i:s",$expirationFormat);
        $pt1 = md5(2418*2 . $Email);
        $pt2 = substr(md5(uniqid(rand(),1)),3,10);
        $hash = $pt1 . $pt2;

        while ($row = $result->fetch_assoc()) {
            $Username = $row["Username"];
            
        }

        // $InsertHash = "INSERT INTO Hashes (Email,Username,Hash,ExpirationDate,Reset)
        // VALUES ('$Email', '$Username','$hash', '$expirationDate', 1)";

        // mysqli_query($conn, $InsertHash);

        

        $message = '<p>Dear '.$Username.',</p>';
        $message .= '<p>Please click on the following link to reset your password.</p>';
        $message .='<p><a href="http://localhost:8080/Clock/resetPassword.php?key='.$hash.'&email='.$Email.'&action=reset" target="_blank">
        http://localhost:8080/Clock/resetPassword.php?key='.$hash.'&email='.$Email.'&action=reset</a></p>';

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


?>