
<?php
// <!-- intermediate code to echo the list of recent searches so that they can be displayed in "search.php" -->
session_start();

$UserID = $_SESSION["UserID"];

require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();

$findSearches = "SELECT * FROM `Searches` WHERE UserID='$UserID'";
$result = $db->get_con()->query($findSearches);

$Searches = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $search = $row["Search"];

        array_unshift($Searches,$search);
    }


}

$uniqueSearches = array_values(array_unique($Searches));

echo json_encode($uniqueSearches);

?>
