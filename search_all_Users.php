<?php
// <!-- gets the results of the user's search -->
session_start();
$MyUserID = $_SESSION['UserID'];
$response = array();
// include db connect class
require_once __DIR__ . '/db_connect.php';

$Username = NULL;

if (array_key_exists("RecentUsername" , $_GET )){
  $Username = $_GET["RecentUsername"];
}

else if (isset($_POST['search'])){
  $Username = $_POST['search'];
}
// connecting to db

$db = new DB_CONNECT();
if ($Username != NULL){
  array_unshift($_SESSION["Searches"],$Username);
  if(sizeof($_SESSION["Searches"]) > 5){
    array_pop($_SESSION["Searches"]);
  }
  $sql = ("SELECT * FROM `Users` WHERE UserID != '$MyUserID' AND Username LIKE '%$Username%'");
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
    // no products found
    $response["success"] = 0;
    $response["message"] = "No records found";
    //
    // // echo no users JSON
}
$_SESSION['response'] = $response;
header("Location:http://localhost:8080/Clock/searchResults.html");
}

?>
