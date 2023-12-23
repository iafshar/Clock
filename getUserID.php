
<?php
// <!-- gets the UserID of the user that is logged in -->
session_start();

// include db connect class
require_once __DIR__ . '/dbConnect.php';

// connecting to db
$db = new DB_CONNECT();

$Username = $_SESSION["Username"];

// get all users from users table
$query = "SELECT * FROM `Users` WHERE Username='$Username'";
$result = $db->get_con()->query($query);

$UserID = NULL;
if ($result->num_rows != NULL && $result->num_rows > 0) {
    // looping through all results

    while ($row = $result->fetch_assoc()) {
        // temp user array
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
