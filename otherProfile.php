<!-- displays the profile page containing all the clocks of the user that has been searched for -->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="style2.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
      function like(clockID,name) {
        window.open('like.php?clockID='+clockID+'&Name='+name+'&location=otherProfile.php','_self');
      }

      function dislike(clockID,name) {
        window.open('dislike.php?clockID='+clockID+'&Name='+name+'&location=otherProfile.php','_self');
      }
      
      function openClock(clockID) {
        window.open('Clock_ReadOnly/index.html?'+clockID,'_self');
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
    </script>

  </head>
  <body>
    <form action="follow.php" method="post">
      <button type="submit" class="followBtn" id="followBtn">Follow</button>
    </form>
    <form action="sendMessageInbox.php" method="post">
      <button type="submit" class="messageBtn" onclick="getMessages()">Message</button>
      <input type='hidden' id="sender" name='Sender' value="">
    </form>
    <script>
      const urlParams = new URLSearchParams(window.location.search);
      const clickedUserID = urlParams.get('clickedUserID');

      var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              var myRecords = JSON.parse(this.responseText);
              document.getElementById("profileHeader").innerHTML = myRecords.Username;
              document.getElementById("sender").value = myRecords.Username;
              document.getElementById("followBtn").innerHTML = myRecords.Following;
              if(myRecords.success == 1) {
                var rows = "";
                for (i=0;i<myRecords.Clocks.length;i++) {
                    var myRecord = myRecords.Clocks[i];
                    var newRow = "<tr class='table-row'><td><table><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?1"+myRecord.ClockID+"' id='miniClock' width=410 height=205 ></iframe></td></tr><tr><td><i>"+myRecord.DateShared+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.ClockID+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.ClockID+"')><img border='0' src='Icons/volume.png' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.ClockID+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton' onclick=like("+myRecord.ClockID+",'"+myRecord.Name+"')><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton' onclick=dislike("+myRecord.ClockID+",'"+myRecord.Name+"')><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td>"+myRecord.NumOfLikes+"</td><td>"+myRecord.NumOfDislikes+"</td></tr></table></td><td><form action='addComment.php' method='post'><table><tr><td height=70></td></tr><tr><td><textarea style='height:195px;width:400px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><input type='hidden' name='MakerID' value="+myRecord.UserID+"><input type='hidden' name='clockName' value="+myRecord.Name+"><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.ClockID+"')>View All</button><input type='hidden' name='location' value=otherProfile.php><input type='submit' style='width:200px;height:45px;' value='Enter'></td></tr></table></form></td></tr>";
                    rows = rows+newRow;
                }
                document.getElementById("resultRows").innerHTML = rows;
              }
          }
      };
      if (urlParams.size == 0) {
        xmlhttp.open("GET", "displaySearchedClocks.php", true);
      }
      else if (clickedUserID != null) {
        xmlhttp.open("GET", "displaySearchedClocks.php?UserID="+clickedUserID, true);
      }
      xmlhttp.send();


    </script>
    <script>
      function getMessages() {
        var Username = document.getElementById("sender").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "getMessages.php?sender=" + Username, true);
        xmlhttp.send();
        window.open('chat.php','_self');
      }
    </script>
    <div class="topnav">
      <input type="button" value="Go back!" onclick="history.back()">
      <a href="feed.html"><img border="0" src="Icons/house.png" width="30" height="30"></a>
      <a href="discover.html"><img border="0" src="Icons/compass.png" width="30" height="30"></a>
      <a href="checkClockLimit.php"><img border="0" src="Icons/music.png" width="30" height="30"></a>
      <a href="myClocks.php"><img border="0" src="Icons/user.png" width="30" height="30"></a>
      <a href="inbox.php"><img border="0" src="Icons/inbox.png" width="30" height="30"></a>
      <a href="search.php"><img border="0" src="Icons/magnifying-glass.png" width="30" height="30"></a>
      <a href="start.php" class="logoutBtn">Logout</a>
    </div>
  </body>
  <table class="table" id="otherProfileTable">
      <thead class="thead-light">
        <tr>
          <th id='profileHeader'></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody id="resultRows">
      </tbody>
    </table>
</html>