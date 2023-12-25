<?php
// Checks that the credentials that the user entered on the login page are valid
session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();

//If the form is submitted
if (isset($_POST['Username']) && isset($_POST['Password']) && !isset($_GET['checkbox'])){ // if it comes from login
//Assigning posted values to variables.
  $Username = mysqli_real_escape_string($conn, $_POST['Username']);
  $Password = mysqli_real_escape_string($conn, $_POST['Password']);
  //Checking whether the values exist in the database or not
  $query = "SELECT * FROM `Users` WHERE Username='$Username' and Password='$Password'";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  $count = mysqli_num_rows($result);
  $_SESSION["Username"] = $Username;
  $_SESSION["Password"] = $Password;
  if ($count == 1) { // if the credentials exist
    while ($row = $result->fetch_assoc()) {
        $_SESSION['UserID'] = $row["UserID"];
        
    }
    header("Location:http://localhost:8080/Clock/myClocks.php");
   } else {
    header("Location:http://localhost:8080/Clock/login.php");
   }
}
else if (isset($_GET['checkbox']) && $_GET['checkbox'] == 1) { // if it comes from signup
    if(isset($_GET['username'])) {
        $response = array();
        $Username = $_GET['username'];
        $ExistingUser = "SELECT * FROM `Users` WHERE Username='$Username'"; // check if there is a user with the username
        $resultUser = mysqli_query($conn, $ExistingUser) or die(mysqli_error($conn));
        $countUser = mysqli_num_rows($resultUser); // number of users with the username (can be 0)
        $response['numUsers'] = $countUser;
        if ($countUser != 0){
            $Suggest = "SELECT * FROM `Users` WHERE Username LIKE '%$Username%'";
            $resultSuggest = mysqli_query($conn, $Suggest) or die(mysqli_error($conn));
            $countSuggest = mysqli_num_rows($resultSuggest);
            for ($i = 0;$i < $countSuggest;$i ++){
                $Suggestion = $Username . "$i";
                $ExistingSuggestion = "SELECT * FROM `Users` WHERE Username='$Suggestion'"; // checks if the suggestion is in the database
                $resultSuggestion = mysqli_query($conn, $ExistingSuggestion) or die(mysqli_error($conn));
                $countSuggestion = mysqli_num_rows($resultSuggestion);
                if($countSuggestion == 0){ // if the suggestion is not in the database, use that as the suggested username
                    break;
                }
            }
        
            $response['suggestion'] = $Suggestion;
        }
    }
    else if (isset($_GET['email'])) {
        $response = array();
        $Email = $_GET['email'];
        $ExistingEmail = "SELECT * FROM `Users` WHERE Email='$Email'"; // check if the email is in the database
        $resultEmail = mysqli_query($conn, $ExistingEmail) or die(mysqli_error($conn));
        $countEmail = mysqli_num_rows($resultEmail); //number of times the email appears in the database

        if ($countEmail != 0) { // if the email exists in the database
            $response['addEmailClass'] = "invalid";
            $response['removeEmailClass'] = "valid";
        }
        else {
            $response['addEmailClass'] = "valid";
            $response['removeEmailClass'] = "invalid";
        }
    }
    else if (isset($_GET['password'])) { // reset password
        $Email = $_SESSION["Email"];
        $Password1 = $_GET['password'];

        $findUser = "SELECT * FROM `Users` WHERE Email='$Email'";

        $result = mysqli_query($conn, $findUser);

        while ($row = $result->fetch_assoc()) {
            $_SESSION['UserID'] = $row["UserID"];
            $UserID = $_SESSION['UserID'];
            $_SESSION['Username'] = $row["Username"];
            $Password = $row["Password"];
                
        }

        $checkPwds = "SELECT * FROM `Passwords` WHERE UserID='$UserID' AND Password='$Password1'"; // checks all the passwords used by the user before
        $result = mysqli_query($conn, $checkPwds);
        $response = array();
        
        if ($result->num_rows > 0) { // if the password has been used by this user before
            $response["removeDifferentClass"] = "valid";
            $response["addDifferentClass"] = "invalid";
        }
        else {
            $response["removeDifferentClass"] = "invalid";
            $response["addDifferentClass"] = "valid";
        }
    }

    echo json_encode($response);
}

?>
