<?php
// Checks that the credentials that the user entered on the login page are valid
session_start();
require_once __DIR__ . '/db_config.php';

// Connect to the DB
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
// Check connection 
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//If the form is submitted
if (isset($_POST['Username']) and isset($_POST['Password'])){
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
       header("Location:http://localhost:8080/Clock/MyClocks.php");
   } else {
       $_SESSION["Error"] = "Invalid credentials";
       header("Location:http://localhost:8080/Clock/login.php");
   }
}
mysqli_close($conn);
?>
