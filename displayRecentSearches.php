
<?php
// <!-- intermediate code to echo the list of recent searches so that they can be displayed in "Search.php" -->
session_start();


echo json_encode($_SESSION['Searches']);

?>
