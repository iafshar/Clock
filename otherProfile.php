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
        window.open('addVote.php?clockID='+clockID+'&location=otherProfile.php&dislike=0','_self');
      }

      function dislike(clockID,name) {
        window.open('addVote.php?clockID='+clockID+'&location=otherProfile.php&dislike=1','_self');
      }
      
      function openClock(clockID) {
        window.open('Clock_ReadOnly/index.html?'+clockID,'_self');
      }


      function changeSound(clockID,elem) {
        for (let i = 0; i < document.getElementsByTagName("iframe").length; i++) {
          if (document.getElementsByTagName("iframe")[i].src == "http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?1"+clockID) {
            document.getElementsByTagName("iframe")[i].src = "http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?0"+clockID;
            elem.getElementsByTagName("img")[0].src = "Icons/volume.png";
            break;
          }
          else if (document.getElementsByTagName("iframe")[i].src == "http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?0"+clockID) {
            document.getElementsByTagName("iframe")[i].src = "http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?1"+clockID;
            elem.getElementsByTagName("img")[0].src = "Icons/mute.png";
            break;
          }
        }
      }

      function openComments(clockID) {
        window.open('comments.html?'+clockID,'_self');
      }

      function sendClock(clockID) {
        window.open('chooseReceiver.php?'+clockID,'_self');
      }
    </script>

  </head>
  <body>
    <div class="otherProfile-buttons">
      <div class="follow">
        <form action="follow.php" method="post">
          <button type="submit" class="followBtn" id="followBtn">Follow</button>
        </form>
      </div>
      <div class="message">
        <form action="sendMessageInbox.php" method="post">
          <button type="submit" class="messageBtn" onclick="getMessages()">Message</button>
          <input type='hidden' id="sender" name='Sender' value="">
        </form>
      </div>
      
    </div>
    
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
                    var newRow = "<tr class='table-row'><td><table><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?1"+myRecord.ClockID+"' id='miniClock' width=410 height=205 ></iframe></td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.ClockID+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.ClockID+"',this)><img border='0' src='Icons/mute.png' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.ClockID+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton' onclick=like("+myRecord.ClockID+",'"+myRecord.Name+"')><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton' onclick=dislike("+myRecord.ClockID+",'"+myRecord.Name+"')><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td>"+myRecord.NumOfLikes+"</td><td>"+myRecord.NumOfDislikes+"</td></tr></table></td><td><form action='addComment.php' method='post'><table><tr><td height=70></td></tr><tr><td><textarea style='height:195px;width:400px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><input type='hidden' name='MakerID' value="+myRecord.UserID+"><input type='hidden' name='clockName' value="+myRecord.Name+"><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.ClockID+"')>View All</button><input type='hidden' name='location' value=otherProfile.php><input type='submit' style='width:200px;height:45px;' value='Enter'></td></tr></table></form></td></tr>";
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

      function checkBack() {
        if (document.referrer.substring(0,28) == "http://localhost:8080/Clock/") {
          history.back();
        }
      }
    </script>
    <div class="topnav">
      <a href="#" id="backBtn" onclick=checkBack()><img border="0" src="Icons/back.png" width="30" height="30"></a>
      <a href="feed.html"><img border="0" src="Icons/house.png" width="30" height="30"></a>
      <a href="discover.html"><img border="0" src="Icons/compass.png" width="30" height="30"></a>
      <a href="checkClockLimit.php"><img border="0" src="Icons/music.png" width="30" height="30"></a>
      <a href="myClocks.php"><img border="0" src="Icons/user.png" width="30" height="30"></a>
      <a href="inbox.php" id='chats' style='color:black'><img border="0" src="Icons/inbox.png" width="30" height="30"></a>
      <a href="search.php"><img border="0" src="Icons/magnifying-glass.png" width="30" height="30"></a>
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