<?php
// Checks that the credentials that the user entered on the login page are valid
session_start();
require_once __DIR__ . '/dbConfig.php';

// Connect to the DB
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
// Check connection 
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//If the form is submitted
if (isset($_POST['Username']) && isset($_POST['Password']) && !isset($_GET['checkbox'])){
//Assigning posted values to variables.
  $Username = $_POST['Username'];
  $Password = $_POST['Password'];
  //Checking whether the values exist in the database or not
  $query = "SELECT * FROM `Users` WHERE Username='$Username' and Password='$Password'";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  $count = mysqli_num_rows($result);
  $_SESSION["Username"] = $Username;
  $_SESSION["Password"] = $Password;
  if ($count == 1) {
    while ($row = $result->fetch_assoc()) {
        $_SESSION['UserID'] = $row["UserID"];
        
    }
    header("Location:http://localhost:8080/Clock/myClocks.php");
   } else {
       $_SESSION["Error"] = "Invalid credentials";
       header("Location:http://localhost:8080/Clock/login.php");
   }
}
else if (isset($_GET['checkbox']) && $_GET['checkbox'] == 1) {
    if(isset($_GET['username'])) {
        $response = array();
        $Username = $_GET['username'];
        $ExistingUser = "SELECT * FROM `Users` WHERE Username='$Username'";
        $resultUser = mysqli_query($conn, $ExistingUser) or die(mysqli_error($conn));
        $countUser = mysqli_num_rows($resultUser);
        $response['numUsers'] = $countUser;

        if ($countUser != 0){
            $Suggest = "SELECT * FROM `Users` WHERE Username LIKE '%$Username%'";
            $resultSuggest = mysqli_query($conn, $Suggest) or die(mysqli_error($conn));
            $countSuggest = mysqli_num_rows($resultSuggest);
            for ($i = 0;$i < $countSuggest;$i ++){
            $Suggestion = $Username . "$i";
            $ExistingSuggestion = "SELECT * FROM `Users` WHERE Username='$Suggestion'";
            $resultSuggestion = mysqli_query($conn, $ExistingSuggestion) or die(mysqli_error($conn));
            $countSuggestion = mysqli_num_rows($resultSuggestion);
            if($countSuggestion == 0){
                break;
            }
            }
        
            $response['suggestion'] = $Suggestion;
        }
    }
    else if (isset($_GET['email'])) {
        $response = array();
        $Email = $_GET['email'];
        $ExistingEmail = "SELECT * FROM `Users` WHERE Email='$Email'";
        $resultEmail = mysqli_query($conn, $ExistingEmail) or die(mysqli_error($conn));
        $countEmail = mysqli_num_rows($resultEmail);

        if ($countEmail != 0) {
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
            $_SESSION['Username'] = $row["Username"];
            $Password = $row["Password"];
                
        }

        $response = array();
        
        if ($Password == $Password1) {
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
mysqli_close($conn);
?>
