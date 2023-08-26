
<?php
// <!-- the profile page of the user -->
session_start();
require_once __DIR__ . '/getUserID.php';
echo $_SESSION["Error"]; 
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="style2.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myRecords = JSON.parse(this.responseText);
            var rows = "";
            console.log(myRecords);
            if (myRecords.success != 0){
              for (i=0;i<myRecords.Clocks.length;i++) {
                var myRecord = myRecords.Clocks[i];
                var newRow = "<tr class='table-row'><td>"+myRecord.Name+"</td><td>"+myRecord.Tempo+"</td><td>"+myRecord.Shared+"</td><td>"+myRecord.DateShared+"</td><td>"+myRecord.NumOfLikes+"</td><td>"+myRecord.NumOfDislikes+"</td><td><button class='deletedata'>🗑️</button></td><td><button class='editdata'>Edit</button></td><td><button class='viewComments'>View Comments</button></td></tr>";
                rows = rows+newRow
              }
              document.getElementById("resultRows").innerHTML = rows;
            }
            
        }
    };

    xmlhttp.open("GET", "getMyClocks.php", true);
    xmlhttp.send();


    </script>
    <script>
    $(document).ready(function(){

    // code to read selected table row cell data (values).
      $("#clockTable").on('click','.deletedata',function(){

       // get the current row

       var currentRow=$(this).closest("tr");

       var name=currentRow.find("td:eq(0)").text();
       var tempo=currentRow.find("td:eq(1)").text(); // get current row 2nd TD
       var ensure = confirm("Are you sure you want to delete "+name);
       if(ensure){
         var xmlhttp = new XMLHttpRequest();
         xmlhttp.open("GET", "getClockID.php?choose=0&clockName="+name, true);
         xmlhttp.send();
         window.open('delete.php','_self');
       }
      });
    });
    </script>
    <script>
    $(document).ready(function(){

    // code to read selected table row cell data (values).
      $("#clockTable").on('click','.editdata',function(){
       // get the current row
       var currentRow=$(this).closest("tr");

       var name=currentRow.find("td:eq(0)").text();
       var tempo=currentRow.find("td:eq(1)").text(); // get current row 2nd TD
       var xmlhttp = new XMLHttpRequest();
       xmlhttp.open("GET", "getClockID.php?choose=4&clockName="+name+"&tempo="+tempo, true);
       xmlhttp.send();
       window.open('Clock_User/index.html','_self');
      });
    });
    </script>
    <script>
    $(document).ready(function(){

    // code to read selected table row cell data (values).
      $("#clockTable").on('click','.viewComments',function(){
       // get the current row
       var currentRow=$(this).closest("tr");

       var name=currentRow.find("td:eq(0)").text();

       var xmlhttp = new XMLHttpRequest();
       xmlhttp.open("GET", "getClockID.php?choose=5&clockName="+name, true);
       xmlhttp.send();
       window.open('stats.html','_self');
      });
    });
    </script>
  </head>
  <body>
    <div class="topnav">
      <a href="feed.html"><img border="0" src="Icons/house.png" width="30" height="30"></a>
      <a href="discover.html"><img border="0" src="Icons/compass.png" width="30" height="30"></a>
      <a href="checkClockLimit.php"><img border="0" src="Icons/music.png" width="30" height="30"></a>
      <a class="active" href="myClocks.php"><img border="0" src="Icons/user.png" width="30" height="30"></a>
      <a href="inbox.php"><img border="0" src="Icons/inbox.png" width="30" height="30"></a>
      <a href="search.php"><img border="0" src="Icons/magnifying-glass.png" width="30" height="30"></a>
      <a href="start.php" class="logoutBtn">Logout</a>
    <?php // Checks if the user is a basic user and if they are, they will be presented with a button on the menu bar asking them if they want to upgrade to premium
      if($_SESSION["Premium"] == 0){
        echo "<form action='updateAccount.php' method='post'><button type='submit'>Upgrade To Premium</button></form>";
      } ?>
  </div>
  </body>
  <table class="table" id="clockTable">
      <thead class="thead-light">
        <tr>
          <!-- headings of the table -->
          <th>Name</th>
          <th>Tempo</th>
          <th>Shared</th>
          <th>Date Shared</th>
          <th>Likes</th>
          <th>Dislikes</th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody id="resultRows">
      </tbody>
    </table>
</html>
