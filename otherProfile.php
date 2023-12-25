<?php
session_start();
?>
<!-- displays the profile page containing all the clocks of the user that has been searched for -->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="css/postLanding.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="functions.js"></script>
    <script>
      
      // follows the user if they were not following previously, and unfollows if they were following
      function changeFollow(elem) {
        $.ajax({
          type: 'post',
          url: 'follow.php',
          success: function (response) {
            // changes the text of the follow button
            document.getElementById("followBtn").innerHTML = JSON.parse(response);
          }
        });
      }
    </script>

  </head>
  <body>
    
    <script>
      const urlParams = new URLSearchParams(window.location.search);
      const clickedUserID = urlParams.get('clickedUserID');

      var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              var myRecords = JSON.parse(this.responseText);
              var premium = (myRecords.Premium == 1);
              document.getElementById("profileHeader").innerHTML = myRecords.Username;
              document.getElementById("sender").value = myRecords.Username;
              document.getElementById("followBtn").innerHTML = myRecords.Following; // whether the follow button should say follow or unfollow
              if(myRecords.success == 1) {
                var rows = "";
                for (i=0;i<myRecords.Clocks.length;i++) {
                    var myRecord = myRecords.Clocks[i];
                    myRecord.Date = new Date(myRecord.Date);
                    myRecord.Date = myRecord.Date.toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric", hour:"numeric", minute:"numeric", second:"numeric"});
                    if (premium) {
                      var newRow = "<tr class='table-row'><td><table><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.ClockID+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick(this)></iframe></td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.ClockID+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.ClockID+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.ClockID+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.ClockID+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton' onclick=like("+myRecord.ClockID+",this) style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton' onclick=dislike("+myRecord.ClockID+",this) style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td id=numLikes-"+myRecord.ClockID+">"+myRecord.NumOfLikes+"</td><td id=numDislikes-"+myRecord.ClockID+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><textarea id=commentBox-"+myRecord.ClockID+" style='height:195px;width:400px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.ClockID+"')>View All</button><button type='submit' style='width:200px;height:45px;' onclick=addComment('"+myRecord.ClockID+"')>Enter</button></td></tr></table></td></tr>";
                    } 
                    else {
                      var newRow = "<tr class='table-row'><td><table><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.ClockID+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick(this)></iframe></td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.ClockID+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.ClockID+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.ClockID+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.ClockID+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton' onclick=like("+myRecord.ClockID+",this) style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton' onclick=dislike("+myRecord.ClockID+",this) style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td id=numLikes-"+myRecord.ClockID+">"+myRecord.NumOfLikes+"</td><td id=numDislikes-"+myRecord.ClockID+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.ClockID+"')>View Comments</button></td></tr></table></td></tr>";
                    }
                    rows = rows+newRow;
                    localStorage.removeItem("muteRow"+i); // for the sound of the mini clocks
                }
                document.getElementById("resultRows").innerHTML = rows;
              }
          }
      };
      if (urlParams.size == 0) {
        xmlhttp.open("GET", "displaySearchedClocks.php", true); // if a user reaches profile by clicking insearch results
      }
      else if (clickedUserID != null) {
        xmlhttp.open("GET", "displaySearchedClocks.php?UserID="+clickedUserID, true); // if user reaches profile by clicking on their username in autocomplete search rather than searching
      }
      xmlhttp.send();


    </script>
    <script>
      function getMessages() {
        Username = document.getElementById("sender").value;
        window.open('chat.php?'+Username,'_self');
      }

      
    </script>
    
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
  <table class="table" id="otherProfileTable">
      <thead class="thead-light">
        <tr>
          <th><table><td id='profileHeader'></td><td><input id='clockSearch' type='text' name='search' placeholder='Search' autocomplete='off' required style='margin-left: 20px;'><img src='Icons/magnifying-glass.png' width='30' height='30'></td></table></th>
          <th>
            <div class="follow">
              <button type="submit" class="followBtn" id="followBtn" onclick=changeFollow(this)>Follow</button>
            </div>
          </th>
          <th>
            <div class="message">
              <button type="submit" class="messageBtn" onclick="getMessages()">Message</button>
              <input type='hidden' id="sender" name='Sender' value="">
            </div>
          </th>
        </tr>
      </thead>
      <tbody id="resultRows">
      </tbody>
  </table>
  <script>
    inp = document.getElementById("clockSearch");
    if (inp) { // if something is entered in the clock search
      inp.addEventListener("input", function(e) {
        var val = this.value;
        autocomplete(val); // call the autocmplete function
      });
    }

    function autocomplete(val) {
      var xmlhttp = new XMLHttpRequest();
      // display clocks that have names that start with what is entered
      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              var myRecords = JSON.parse(this.responseText);
              var premium = (myRecords.Premium == 1);
              document.getElementById("profileHeader").innerHTML = myRecords.Username;
              document.getElementById("sender").value = myRecords.Username;
              document.getElementById("followBtn").innerHTML = myRecords.Following;
              if(myRecords.success == 1) {
                var rows = "";
                for (i=0;i<myRecords.Clocks.length;i++) {
                    var myRecord = myRecords.Clocks[i];
                    if (myRecord.Name.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                      myRecord.Date = new Date(myRecord.Date);
                      myRecord.Date = myRecord.Date.toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric", hour:"numeric", minute:"numeric", second:"numeric"});
                      if (premium) {
                        var newRow = "<tr class='table-row'><td><table><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.ClockID+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick(this)></iframe></td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.ClockID+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.ClockID+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.ClockID+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.ClockID+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton' onclick=like("+myRecord.ClockID+",this) style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton' onclick=dislike("+myRecord.ClockID+",this) style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td id=numLikes-"+myRecord.ClockID+">"+myRecord.NumOfLikes+"</td><td id=numDislikes-"+myRecord.ClockID+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><textarea id=commentBox-"+myRecord.ClockID+" style='height:195px;width:400px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.ClockID+"')>View All</button><button type='submit' style='width:200px;height:45px;' onclick=addComment('"+myRecord.ClockID+"')>Enter</button></td></tr></table></td></tr>";
                      } 
                      else {
                        var newRow = "<tr class='table-row'><td><table><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.ClockID+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick(this)></iframe></td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.ClockID+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.ClockID+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.ClockID+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.ClockID+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton' onclick=like("+myRecord.ClockID+",this) style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton' onclick=dislike("+myRecord.ClockID+",this) style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td id=numLikes-"+myRecord.ClockID+">"+myRecord.NumOfLikes+"</td><td id=numDislikes-"+myRecord.ClockID+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.ClockID+"')>View Comments</button></td></tr></table></td></tr>";
                      }
                      rows = rows+newRow;
                    }
                }
                document.getElementById("resultRows").innerHTML = rows;
              }
          }
      };
      if (urlParams.size == 0) {
        xmlhttp.open("GET", "displaySearchedClocks.php", true);
      }
      else if (clickedUserID != null) {
        xmlhttp.open("GET", "displaySearchedClocks.php?UserID="+clickedUserID, true); // if user reaches profile by clicking on their username rather than searching
      }
      xmlhttp.send();
    }

  </script>
</html>