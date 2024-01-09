<?php
// <!-- gets the results of the user's search -->
session_start();
$MyUserID = $_SESSION['UserID'];
$response = array();
// include db connect class
require_once __DIR__ . '/dbConnect.php';

// connecting to db

$db = new DB_CONNECT();

$Username = NULL;

if (array_key_exists("RecentUsername" , $_GET )){
  $Username = mysqli_real_escape_string($db->get_con(),$_GET["RecentUsername"]);
}

else if (isset($_POST['search'])){
  $Username = mysqli_real_escape_string($db->get_con(),$_POST['search']);

}

if (isset($_POST['message'])) {
  $_SESSION["message"] = 1;
}
else {
  $_SESSION["message"] = 0;
}

$addSearch = "INSERT INTO `Searches` (UserID, Search, Type)
  VALUES ('$MyUserID','$Username',0)"; // adds the search to the database

if ($Username != NULL && strlen($Username) > 0){
  if ($_SESSION["message"] == 0) {
    $db->get_con()->query($addSearch);
  }
  $sql = ("SELECT * FROM `Users` WHERE UserID != '$MyUserID' AND Username LIKE '%$Username%' ORDER BY Username");
  $result = $db->get_con()->query($sql);
  if ($result->num_rows > 0) {
    $response["Users"] = array();
    while ($row = $result->fetch_assoc()) {
        // temp user array
        $record = array();
        $record["UserID"] = $row["UserID"];
        $record["Username"] = $row["Username"];

        array_push($response["Users"], $record);

    }
    $response["success"] = 1;
}
else {
    // no users found
    $response["success"] = 0;
    $response["message"] = "No records found";
    // // echo no users JSON
}
$_SESSION['response'] = $response;
header("Location:http://localhost:8080/Clock/searchResults.php");
}
else if (strlen($Username) == 0) {
  header("Location:http://localhost:8080/Clock/search.php");
}

?>
