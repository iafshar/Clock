
<?php
// <!-- gets the UserID of the user that is logged in -->
session_start();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

$Username = $_SESSION["Username"];
$Password = $_SESSION["Password"];

// get all products from products table
$query = "SELECT * FROM `Users` WHERE Username='$Username' and Password='$Password'";
$result = $db->get_con()->query($query);

$UserID = NULL;
if ($result->num_rows != NULL && $result->num_rows > 0) {
    // looping through all results

    while ($row = $result->fetch_assoc()) {
        // temp user array
        //$record = array();
        $UserID = $row["UserID"];
        $Email = $row["Email"];
        $Premium = $row["Premium"];


        // push single record into final response array
    }
    // success

    // echoing JSON response(prints it)
    $_SESSION["UserID"] = $UserID;
    $_SESSION["Email"] = $Email;
    $_SESSION["Premium"] = $Premium;
}

 ?>
