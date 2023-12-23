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
    for ($i=0; $i < count($illegalChars); $i++) { // removes all illegal chars from the new clock name
        $newName = str_replace($illegalChars[$i],"",$newName);
    }

    $checkUnique = "SELECT * FROM Clocks WHERE UserID='$UserID' AND Name='$newName'";
    $resultUnique = mysqli_query($conn, $checkUnique); // checks that this user doesnt have another clock with the same name

    $getCurrentName = "SELECT Name FROM Clocks WHERE ClockID='$clockID'";
    $resultCurrName = mysqli_query($conn, $getCurrentName); // gets the current name of the clock
    $currentName = "";
    while ($row = $resultCurrName->fetch_assoc()) {
        $currentName = $row["Name"];
    }

    if (strlen($newName) > 40) { // if the new name is longer than 40 chars, only take the first 40 
        $newName = substr($newName,0,40);
    }

    if (strlen($newName) == 0 || $resultUnique->num_rows > 0) { // if the new name is 0 chars or the clock name is not unique for the user
        echo $currentName; // dont change the name
    }
    else {
        $updateName = "UPDATE Clocks
            SET Name = '$newName'
            WHERE ClockID = '$clockID'";

        mysqli_query($conn, $updateName);

        echo $newName; // change the name to the new name  
    }
    
}

?>