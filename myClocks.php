
<?php
// <!-- the profile page of the user -->
session_start();
require_once __DIR__ . '/getUserID.php';
if (isset($_SESSION["Error"]) && strlen($_SESSION["Error"]) > 0) { 
  echo "<script>alert('".$_SESSION["Error"]."');</script>";
}

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

      function deleteClock(clockID,name) {
        var ensure = confirm("Are you sure you want to delete "+name);
        if(ensure){
          window.open('delete.php?ClockID='+clockID,'_self');
        }
      }

      function changeShared(clockID,elem) { // changes the shared value of a clock
        $.ajax({
          type: 'post',
          url: 'changeShared.php',
          data: {
            ClockID:clockID,
          },
          success: function () {
            if (elem.innerHTML === "Share") { // changes what is displayed in the button that calls this function onclick
              elem.innerHTML = "Unshare";
            }
            else {
              elem.innerHTML = "Share"
            }
          }
        });
      }

      function checkEnter(elem) {
        // if the enter key is pressed while the element is in focus, take it out of focus
        $(elem).on('keyup', function (e) {
          if (e.key === 'Enter' || e.keyCode === 13) {
              $(elem).blur();
          }
        });
      }

      function changeName(elem,clockID) {
        // changes the name of a clock
        $.ajax({
          type: 'post',
          url: 'updateClockName.php',
          data: {
            newName:elem.value,
            clockID:clockID,
          },
          success: function (response) {
            // changes what is displayed for the name of the clock to the new name
            elem.value = response;
          }
        });
      }

    </script>
    
    <script>
      // removes all the items stored in localStorage from landing
      localStorage.removeItem("loginUsername");
      localStorage.removeItem("signUpUsername");
      localStorage.removeItem("signUpEmail");
      localStorage.removeItem("signUpPassword");
      localStorage.removeItem("signUpPassword2");
			localStorage.removeItem("resetPassword"); 
			localStorage.removeItem("resetPassword2"); 
      localStorage.removeItem("signUpPremium");
    </script>
  </head>
  <body>
    <div class="topnav">
      <a href="#" id="backBtn" onclick=checkBack()><img border="0" src="Icons/back.png" width="30" height="30"></a>
      <a href="feed.php"><img border="0" src="Icons/house.png" width="30" height="30"></a>
      <a href="discover.php"><img border="0" src="Icons/compass.png" width="30" height="30"></a>
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
          <!-- headings of the table -->
          <th><input id="clockSearch" type="text" name="search" placeholder="Search" autocomplete="off" required><img src="Icons/magnifying-glass.png" width="30" height="30"></th>
          <th></th>
        </tr>
      </thead>
      <tbody id="resultRows">
      </tbody>
    </table>

  <script>
    // if something is entered in the clock search box, call the autocomplete function on it
    inp = document.getElementById("clockSearch");
    if (inp) {
      inp.addEventListener("input", function(e) {
        var val = this.value;
        autocomplete(val);
      });
    }

    function autocomplete(val) {
      illegalChars = ['§','±','`','~',',','<','=','+','[',']','{','}',':',';','|','\\',"'","\"",'/','?'];
      for (let i = 0; i < illegalChars.length; i++) { // removes all illegal chars from the clock search
        val = val.replaceAll(illegalChars[i],"");
      }
      val = val.replaceAll(" ","_"); // replaces spaces with underscores
      var xmlhttp = new XMLHttpRequest();

      // gets all the clocks of the user but filters it to only show the ones that have names that start with what is currently in the search box
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var myRecords = JSON.parse(this.responseText);
          var rows = "";
          if (myRecords.success != 0){
            for (i=0;i<myRecords.Clocks.length;i++) {
              var myRecord = myRecords.Clocks[i];
              if (myRecord.Name.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                var shared = ""
                if (myRecord.Shared == 1) {
                  shared = "Unshare";
                }
                else {
                  shared = "Share";
                }
                myRecord.Date = new Date(myRecord.Date);
                myRecord.Date = myRecord.Date.toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric", hour:"numeric", minute:"numeric", second:"numeric"});
                var newRow = "<tr class='table-row'><td><table><tr><td><input type='text' name='clockName' value="+myRecord.Name+" id='clock-name' onfocus=checkEnter(this) onblur=changeName(this,'"+myRecord.ClockID+"') required></td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.ClockID+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick(this,true)></iframe></td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr><tr><td><button class='share' onclick=changeShared('"+myRecord.ClockID+"',this)>"+shared+"</button></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.ClockID+"',true)><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.ClockID+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.ClockID+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='deletedata' onClick=deleteClock('"+myRecord.ClockID+"','"+myRecord.Name+"')><img border='0' src='Icons/trash.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><img border='0' src='Icons/like.png' width='40' height='40'></td><td><img border='0' src='Icons/dislike.png' width='40' height='40'></td><td><button type='button' class='viewComments' style='width:140px;height:45px;' onclick=openComments('"+myRecord.ClockID+"')>View Comments</button></td><tr><td>"+myRecord.NumOfLikes+"</td><td>"+myRecord.NumOfDislikes+"</td></tr></table></td></tr>";
                rows = rows+newRow
              }
            }
            document.getElementById("resultRows").innerHTML = rows;
          }  
        }
      };

      xmlhttp.open("GET", "getMyClocks.php", true);
      xmlhttp.send();
    }
  
    // gets all the clocks of the user - displayed before searching
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myRecords = JSON.parse(this.responseText);
            var rows = "";
            if (myRecords.success != 0){
              for (i=0;i<myRecords.Clocks.length;i++) {
                var myRecord = myRecords.Clocks[i];
                var shared = ""
                if (myRecord.Shared == 1) {
                  shared = "Unshare";
                }
                else {
                  shared = "Share";
                }
                myRecord.Date = new Date(myRecord.Date);
                myRecord.Date = myRecord.Date.toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric", hour:"numeric", minute:"numeric", second:"numeric"});
                var newRow = "<tr class='table-row'><td><table><tr><td><input type='text' name='clockName' value="+myRecord.Name+" id='clock-name' onfocus=checkEnter(this) onblur=changeName(this,'"+myRecord.ClockID+"') required></td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.ClockID+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick(this,true)></iframe></td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr><tr><td><button class='share' onclick=changeShared('"+myRecord.ClockID+"',this)>"+shared+"</button></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.ClockID+"',true)><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.ClockID+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.ClockID+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='deletedata' onClick=deleteClock('"+myRecord.ClockID+"','"+myRecord.Name+"')><img border='0' src='Icons/trash.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><img border='0' src='Icons/like.png' width='40' height='40'></td><td><img border='0' src='Icons/dislike.png' width='40' height='40'></td><td><button type='button' class='viewComments' style='width:140px;height:45px;' onclick=openComments('"+myRecord.ClockID+"')>View Comments</button></td><tr><td>"+myRecord.NumOfLikes+"</td><td>"+myRecord.NumOfDislikes+"</td></tr></table></td></tr>";
                rows = rows+newRow;
                localStorage.removeItem("muteRow"+i);
              }
              document.getElementById("resultRows").innerHTML = rows;
            }
            
        }
    };

    xmlhttp.open("GET", "getMyClocks.php", true);
    xmlhttp.send();


  </script>
</html>
