<!-- presents the user with the results of their searches -->
<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="css/postLanding.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="functions.js"></script>
    <script>
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myRecords = JSON.parse(this.responseText);
            if(myRecords.success == 1) {
              var rows = "";
              for (i=0;i<myRecords.Users.length;i++) {
                  var myRecord = myRecords.Users[i];
                  var newRow = "<tr class='table-row-clickable'><td>"+myRecord.Username+"</td></tr>";
                  rows = rows+newRow
              }
              document.getElementById("resultRows").innerHTML = rows;
            }
        }
    };

    xmlhttp.open("GET", "intermediateSearch.php", true);
    xmlhttp.send();


    </script>
    <script>


    $(document).ready(function(){

  // code to read selected table row cell data (values).
      $("#clockTable").on('click','.table-row-clickable',function(){
       // get the current row
        var currentRow=$(this).closest("tr");

        var Username=currentRow.find("td:eq(0)").text(); // get current row 2nd TD
        console.log(Username);
       
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "getOtherUserClocks.php?Username=" + Username, true);
        xmlhttp.send();
        window.open("otherProfile.php","_self");
  
        
      });
    });

    
    </script>
  </head>
  <body>
    <div class="topnav">
      <a href="#" id="backBtn" onclick=checkBack()><img border="0" src="Icons/back.png" width="30" height="30"></a>
      <a href="feed.php"><img border="0" src="Icons/house.png" width="30" height="30"></a>
      <a href="discover.php"><img border="0" src="Icons/compass.png" width="30" height="30"></a>
      <a href="checkClockLimit.php"><img border="0" src="Icons/music.png" width="30" height="30"></a>
      <a href="myClocks.php"><img border="0" src="Icons/user.png" width="30" height="30"></a>
      <a href="inbox.php" id='chats' style='color:black'><img border="0" src="Icons/inbox.png" width="30" height="30"></a>
      <a href="search.php"><img border="0" src="Icons/magnifying-glass.png" width="30" height="30"></a>
      <div class="dropdown">
        <a>Account</a>
        <div class="dropdown-content">
            <a href="updateAccount.php">
              <?php // Checks if the user is a basic user and if they are, they will be presented with a button on the menu bar asking them if they want to upgrade to premium
              if($_SESSION["Premium"] == 0){
                echo "Upgrade To Premium";
              } 
              else {
                echo "Downgrade To Basic";
              }?>
            </a>
            <a onclick=deleteAccount()>Deactivate Account</a>
            <a href="start.php">Logout</a>
        </div>
      </div>
  </div>
  </body>
  <script>
    setUnreadCount();

  </script>
<table class="table" id="clockTable">
    <thead class="thead-light">
      <tr>
        <th>Username</th>
      </tr>
    </thead>
    <tbody id="resultRows">
    </tbody>
  </table>
</html>
