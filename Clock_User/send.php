<?php
session_start();
// <!-- code adding a clock that has been saved for the first time to the DB -->
include '../getUserID.php';
$response = array();

require_once '../dbConnect.php';

$db = new DB_CONNECT();
// Create connection
$conn = $db->get_con();

$Circles = $_GET["Circles"];
$Tempo = $_GET["tempo"];
$Name = $_GET["clockName"];
$Shared = $_GET["shared"];

$UserID = $_SESSION["UserID"];

$Date = date('Y-m-d H:i:s');

$Select = "SELECT * FROM `Clocks` WHERE UserID='$UserID' AND Name='$Name'";
$result = mysqli_query($conn, $Select) or die(mysqli_error($conn));
$count = mysqli_num_rows($result);

if ($count != 0 && $count != NULL){ // if there already exists a clock with this name that the user has made
  $Suggest = "SELECT * FROM `Clocks` WHERE UserID='$UserID' AND Name LIKE '%$Name%'";
  $resultSuggest = mysqli_query($conn, $Suggest) or die(mysqli_error($conn));
  $countSuggest = mysqli_num_rows($resultSuggest);
  for ($i = 0;$i < $countSuggest;$i ++){ 
    $Suggestion = $Name . "$i";
    $ExistingSuggestion = "SELECT * FROM `Clocks` WHERE UserID='$UserID' AND Name='$Suggestion'";
    $resultSuggestion = mysqli_query($conn, $ExistingSuggestion) or die(mysqli_error($conn));
    $countSuggestion = mysqli_num_rows($resultSuggestion);
    if($countSuggestion == 0){ // if the suggestion does not exist in the user's clocks, use it as the suggested name
      $Name = $Suggestion;
    }
  }
}

$Insert = "INSERT INTO Clocks (UserID, Name,Tempo,Shared,Date)
 VALUES ('$UserID','$Name', '$Tempo', '$Shared', '$Date')";

$Select = "SELECT * FROM `Clocks` WHERE UserID='$UserID' AND Name='$Name'";

if (mysqli_query($conn, $Insert)) { // add the clock to the db
  
  $result = $db->get_con()->query($Select);
  while ($row = $result->fetch_assoc()) { // gets the clockID of the new clock to add the circles to the db
    $ClockID = $row["ClockID"];
  }
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
    mysqli_query($conn, $CircInsert); // adds the circles into the db
  }
  $response["success"] = 1;
  
} else {
    $response["success"] = 0;
      
    echo "Error: " . $Insert . "<br>" . mysqli_error($conn);
}

?>
