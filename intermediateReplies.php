<?php
session_start();
$response = $_SESSION["Replies"];
echo json_encode($response);
 ?>
