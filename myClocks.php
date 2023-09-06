
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
            if (myRecords.success != 0){
              for (i=0;i<myRecords.Clocks.length;i++) {
                var myRecord = myRecords.Clocks[i];
                var shared = ""
                if (myRecord.Shared == "Yes") {
                  shared = "Shared";
                }
                var newRow = "<tr class='table-row'><td><table><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?1"+myRecord.ClockID+"' id='miniClock' width=410 height=205 ></iframe></td></tr><tr><td><i>"+myRecord.DateShared+"</i></td></tr><tr><td><b>"+shared+"</b></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.ClockID+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.ClockID+"')><img border='0' src='Icons/volume.png' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.ClockID+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='deletedata' onClick=deleteClock('"+myRecord.ClockID+"','"+myRecord.Name+"')>🗑️</button></td></tr><tr><td height=225></td></tr><tr><td><img border='0' src='Icons/like.png' width='40' height='40'></td><td><img border='0' src='Icons/dislike.png' width='40' height='40'></td><td><button type='button' class='viewComments' style='width:140px;height:45px;' onclick=openComments('"+myRecord.ClockID+"')>View Comments</button></td><tr><td>"+myRecord.NumOfLikes+"</td><td>"+myRecord.NumOfDislikes+"</td></tr></table></td></tr>";
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
      function openClock(clockID) {
        window.open('Clock_User/index.html?'+clockID,'_self');
      }

      function changeSound(clockID) {
        for (let i = 0; i < document.getElementsByTagName("iframe").length; i++) {
          if (document.getElementsByTagName("iframe")[i].src == "http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?1"+clockID) {
            document.getElementsByTagName("iframe")[i].src = "http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?0"+clockID;
            break;
          }
          else if (document.getElementsByTagName("iframe")[i].src == "http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?0"+clockID) {
            document.getElementsByTagName("iframe")[i].src = "http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?1"+clockID;
            break;
          }
        }

      }

      function openComments(clockID) {
        window.open('stats.html?'+clockID,'_self');
      }

      function sendClock(clockID) {
        window.open('chooseReceiver.php?'+clockID,'_self');
      }

      function deleteClock(clockID,name) {
        var ensure = confirm("Are you sure you want to delete "+name);
        if(ensure){
          window.open('delete.php?ClockID='+clockID,'_self');
        }
      }

      function deleteAccount() {
        var ensure = confirm("Are you sure you want to deactivate your account? Your clocks will be permanently deleted.");
        if (ensure) {
          window.open('deleteAccount.php','_self');
        }
      }

    </script>
    <script>
      localStorage.removeItem("loginUsername");
      localStorage.removeItem("signUpUsername");
      localStorage.removeItem("signUpEmail");
      localStorage.removeItem("signUpPassword");
      localStorage.removeItem("signUpPassword2");
			localStorage.removeItem("resetPassword"); 
			localStorage.removeItem("resetPassword2"); 
    </script>
  </head>
  <body>
    <div class="topnav">
      <input type="button" value="Go back!" onclick="history.back()">
      <button type='submit' onclick=deleteAccount()>Deactivate Account</button>
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
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody id="resultRows">
      </tbody>
    </table>
    
</html>
