
<?php
// <!-- code adding a clock that has been saved for the first time to the DB -->
include '/opt/lampp/htdocs/NEA5/get_UserID.php';

$conn = mysqli_connect('localhost', 'root', '', 'NEA');
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$Circles = $_GET["Circles"];
$Tempo = $_GET["tempo"];
$Name = $_GET["name"];
$Shared = $_GET["shared"];

if($Shared == 0){
  $DateShared = NULL;
}
else{
  $DateShared = date('Y-m-d H:i:s');
}

$Insert = "INSERT INTO Clocks (UserID, Name,Tempo,Shared,DateShared,NumOfLikes,NumOfDislikes)
 VALUES ('$UserID','$Name', '$Tempo', '$Shared', '$DateShared', 0, 0)";

$Select = "SELECT * FROM `Clocks` WHERE UserID='$UserID' AND Name='$Name'";
$result = mysqli_query($conn, $Select) or die(mysqli_error($conn));
$count = mysqli_num_rows($result);

if ($count != 0){
  $Suggest = "SELECT * FROM `Clocks` WHERE UserID='$UserID' AND Name LIKE '%$Name%'";
  $resultSuggest = mysqli_query($conn, $Suggest) or die(mysqli_error($conn));
  $countSuggest = mysqli_num_rows($resultSuggest);
  for ($i = 0;$i < $countSuggest;$i ++){
    $Suggestion = $Name . "$i";
    $ExistingSuggestion = "SELECT * FROM `Clocks` WHERE UserID='$UserID' AND Name='$Suggestion'";
    $resultSuggestion = mysqli_query($conn, $ExistingSuggestion) or die(mysqli_error($conn));
    $countSuggestion = mysqli_num_rows($resultSuggestion);
    if($countSuggestion == 0){
      $Name = $Suggestion;
    }
  }
}

$Insert = "INSERT INTO Clocks (UserID, Name,Tempo,Shared,DateShared)
 VALUES ('$UserID','$Name', '$Tempo', '$Shared', '$DateShared')";

$Select = "SELECT * FROM `Clocks` WHERE UserID='$UserID' AND Name='$Name'";

 if (mysqli_query($conn, $Insert)) {
   $result = $db->get_con()->query($Select);
   while ($row = $result->fetch_assoc()) {
     $ClockID = $row["ClockID"];
   }
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
  //header("Location:http://localhost:8080/NEA5/MyClocks.php");

  } else {
      echo "Error: " . $Insert . "<br>" . mysqli_error($conn);
  }

?>
