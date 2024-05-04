<?php
// $hashedPassword = password_hash("maakiaankH!123", PASSWORD_DEFAULT);
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();

$getUsers = "SELECT * FROM Users";
$result = mysqli_query($conn, $getUsers);
while ($row = $result->fetch_assoc()) {
    $UserId = $row["UserID"];
    $Password = $row["Password"];
    $Username = $row["Username"];
    
    $hashedPassword = mysqli_real_escape_string($conn, password_hash($Password, PASSWORD_DEFAULT));
    $hashUsers = "UPDATE Users
        SET Password = '$hashedPassword'
        WHERE UserID = '$UserId'";
    mysqli_query($conn, $hashUsers);
}
echo "success";
?>