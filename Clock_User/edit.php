
<?php
// <!-- updates the data of the clock in the database after the user has editted an existing clock -->
session_start();

require_once '../dbConnect.php';

$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();

$ClockID = $_GET["ClockID"];
$Circles = $_GET["Circles"];
$Tempo = $_GET["tempo"];
$Shared = $_GET["shared"];

$Date = date('Y-m-d H:i:s');


$Delete = "DELETE FROM Circles Where ClockID='$ClockID'"; // deletes the circles of the clock temporarily

$Edit = "UPDATE Clocks
  SET Tempo='$Tempo', Shared='$Shared', Date='$Date' 
  WHERE ClockID='$ClockID'";

if (mysqli_query($conn, $Delete) && mysqli_query($conn, $Edit)) {
  $head = 1;
  $tail = 0;
  $count = 0;
  $SoundIDs = array();
  $Xs = array();
  $Ys = array();
  // circles are in the form of soundID,x,y so this separates them into different arrays
  for($i=0;$i<strlen($Circles);$i++){
    if($head > $tail){
      if($count%3 == 0){
        array_push($SoundIDs, substr($Circles, $tail, $head-$tail));
      }
      else if($count%3 == 1){
        array_push($Xs, substr($Circles, $tail, $head-$tail));
      }
      else{
        array_push($Ys, substr($Circles, $tail, $head-$tail));
      }
      $tail = $head+1;
      $count++;
    }
    else if($Circles[$i] == ','){
      $head = $i;
    }
    else if ($i == strlen($Circles)-1){
      $head = $i+1;
      array_push($Ys, substr($Circles, $tail, $head-$tail));
    }
  }

  for($i = 0;$i < sizeof($SoundIDs);$i++){
    $SoundID = $SoundIDs[$i];
    $X = $Xs[$i];
    $Y = $Ys[$i];
    $CircInsert = "INSERT INTO Circles (ClockID,SoundID,X,Y)
     VALUES ('$ClockID','$SoundID','$X','$Y')";
    mysqli_query($conn, $CircInsert); // inserts the new circles into the db
  }
 header("Location:https://clockdrum.000webhostapp.com/myClocks.php");

 } else {
     echo "Error: " . $Delete . "<br>" . $Edit . "<br>" . mysqli_error($conn);
 }


 ?>
