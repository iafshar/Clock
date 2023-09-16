<?php
session_start();
require_once __DIR__ . '/dbConnect.php';
$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();

$UserID = $_SESSION["UserID"];

if (isset($_POST["newName"]) && isset($_POST["clockID"])) {
    
    $newName = $_POST["newName"];
    $clockID = $_POST["clockID"];
    $illegalChars = array('§','±','`','~',',','<','=','+','[',']','{','}',':',';','|','\\',"'","\"",'/','?');
    
    $newName = str_replace(' ','_',$newName);
    for ($i=0; $i < count($illegalChars); $i++) {
        $newName = str_replace($illegalChars[$i],"",$newName);
    }

    $checkUnique = "SELECT * FROM Clocks WHERE UserID='$UserID' AND Name='$newName'";
    $resultUnique = mysqli_query($conn, $checkUnique);

    $getCurrentName = "SELECT Name FROM Clocks WHERE ClockID='$clockID'";
    $resultCurrName = mysqli_query($conn, $getCurrentName);
    $currentName = "";
    while ($row = $resultCurrName->fetch_assoc()) {
        $currentName = $row["Name"];
    }

    if (strlen($newName) > 40) {
        $newName = substr($newName,0,40);
    }

    if (strlen($newName) == 0 || $resultUnique->num_rows > 0) {
        echo $currentName;
    }
    else {
        $updateName = "UPDATE Clocks
            SET Name = '$newName'
            WHERE ClockID = '$clockID'";

        mysqli_query($conn, $updateName);

        echo $newName;   
    }
    
}

?>