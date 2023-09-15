
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
                  shared = "Unshare";
                }
                else {
                  shared = "Share";
                }
                
                var newRow = "<tr class='table-row'><td><table><tr><td><input type='text' name='clockName' value="+myRecord.Name+" id='clock-name' onblur=changeName(this,'"+myRecord.Name+"')></td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?1"+myRecord.ClockID+"' id='miniClock' width=410 height=205></iframe></td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr><tr><td><button class='share' onclick=changeShared('"+myRecord.ClockID+"')>"+shared+"</button></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.ClockID+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.ClockID+"')><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.ClockID+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='deletedata' onClick=deleteClock('"+myRecord.ClockID+"','"+myRecord.Name+"')>🗑️</button></td></tr><tr><td height=225></td></tr><tr><td><img border='0' src='Icons/like.png' width='40' height='40'></td><td><img border='0' src='Icons/dislike.png' width='40' height='40'></td><td><button type='button' class='viewComments' style='width:140px;height:45px;' onclick=openComments('"+myRecord.ClockID+"')>View Comments</button></td><tr><td>"+myRecord.NumOfLikes+"</td><td>"+myRecord.NumOfDislikes+"</td></tr></table></td></tr>";
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
            document.getElementsByClassName("sound-icon")[i].src = "Icons/volume.png";
          }
          else if (document.getElementsByTagName("iframe")[i].src == "http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?0"+clockID) {
            document.getElementsByTagName("iframe")[i].src = "http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?1"+clockID;
            document.getElementsByClassName("sound-icon")[i].src = "Icons/mute.png";
            break;
          }
          else {
            var source = document.getElementsByTagName("iframe")[i].src
            var index = source.indexOf("?") + 1;
            document.getElementsByTagName("iframe")[i].src = source.substring(0,index) + "1" + source.substring(index + 1);
            document.getElementsByClassName("sound-icon")[i].src = "Icons/mute.png";
          }
        }
      }

      function openComments(clockID) {
        window.open('comments.html?'+clockID,'_self');
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

      function changeShared(clockID) { // maybe it wont update so might have to pass in elem and change inner html
        window.open('changeShared.php?ClockID='+clockID,'_self');
      }


      function changeName(elem,ogName) {
        if (elem.value != ogName) {
          console.log("changed");
        }
        else {
          console.log("same");
        }
      }

    </script>
    <script>
      function checkBack() {
        if (document.referrer.substring(0,28) == "http://localhost:8080/Clock/") {
          history.back();
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
      <a href="#" id="backBtn" onclick=checkBack()><img border="0" src="Icons/back.png" width="30" height="30"></a>
      <a href="feed.html"><img border="0" src="Icons/house.png" width="30" height="30"></a>
      <a href="discover.html"><img border="0" src="Icons/compass.png" width="30" height="30"></a>
      <a href="checkClockLimit.php"><img border="0" src="Icons/music.png" width="30" height="30"></a>
      <a class="active" href="myClocks.php" ><img border="0" src="Icons/user.png" width="30" height="30"></a>
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
          <a href='#' onclick=deleteAccount()>Deactivate Account</a>
          <a href="start.php">Logout</a>
      </div>
    </div>
  </div>
  </body>
  <script>
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("chats").innerHTML += JSON.parse(this.responseText);
      }
      
    };

    
    xmlhttp.open("GET", "countUnreadMessages.php", true);
    xmlhttp.send();

  </script>

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
