
<?php
// <!-- intermediate code that prints out the response array in "search_all_users" so that it can be accessed in "searchResults.html" -->
session_start();

echo json_encode($_SESSION['response']);

 ?>
