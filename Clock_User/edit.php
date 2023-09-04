
<?php
// <!-- updates the data of the clock in the database after the user has editted an existing clock -->
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'ClockDB');
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$ClockID = $_GET["ClockID"];
$Circles = $_GET["Circles"];
$Tempo = $_GET["tempo"];
$Shared = $_GET["shared"];
if($Shared == 1){
  $DateShared = date('Y-m-d H:i:s');
}
else{
  $DateShared = date('0-0-0 0:0:0');
}

$Delete = "DELETE FROM Circles Where ClockID='$ClockID'";

$Edit = "UPDATE Clocks
  SET Tempo='$Tempo', Shared='$Shared', DateShared='$DateShared'
  WHERE ClockID='$ClockID'";

if (mysqli_query($conn, $Delete) && mysqli_query($conn, $Edit)) {
  $head = 1;
  $tail = 0;
  $count = 0;
  $SoundIDs = array();
  $Xs = array();
  $Ys = array();
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
    mysqli_query($conn, $CircInsert);
  }
 header("Location:http://localhost:8080/Clock/myClocks.php");

 } else {
     echo "Error: " . $Insert . "<br>" . mysqli_error($conn);
 }


 ?>
