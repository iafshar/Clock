
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
                document.getElementById("messageHeading").innerHTML = myRecords.otherUsername;
                document.getElementById("messageBody").innerHTML = "<td><form action='sendMessageInbox.php' method='post'><table><tr><textarea style='height:100px;width:1400px;font-size:30px;' name='message' placeholder='Message'></textarea></tr><tr><input type='hidden' name='Sender' value="+myRecords.otherUsername+"><input type='submit' style='width:1400px;height:45px;' value='Enter'></tr></table></form></td>";
                var rows = "";
                if (myRecords) {
                  if (myRecords.Messages) {
                      for (i=0;i<myRecords.Messages.length;i++) {
                          var myRecord = myRecords.Messages[i];
                          var newRow = "";
                          if (myRecord.sentByMe == 0) {
                            if (myRecord.Type == 1) {
                              newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td><table><tr><td><b><a href='otherProfile.php?clickedUserID="+myRecord.UserID+"' style='color:black'>"+myRecord.Username+"</a></b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?1"+myRecord.Content+"' id='miniClock' width=410 height=205 ></iframe></td></tr><tr><td><i>"+myRecord.DateShared+"</i></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content+"')><img border='0' src='Icons/volume.png' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton' onclick=like("+myRecord.Content+",'"+myRecord.Name+"')><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton' onclick=dislike("+myRecord.Content+",'"+myRecord.Name+"')><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td>"+myRecord.NumOfLikes+"</td><td>"+myRecord.NumOfDislikes+"</td></tr></table></td><td><form action='addComment.php' method='post'><table><tr><td height=70></td></tr><tr><td><textarea style='height:195px;width:400px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><input type='hidden' name='Maker' value="+myRecord.Username+"><input type='hidden' name='clockName' value="+myRecord.Name+"><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.Content+"')>View All</button><input type='hidden' name='location' value=chat.php><input type='submit' style='width:200px;height:45px;' value='Enter'></td></tr></table></form></td></tr>";
                            }
                            else {
                              newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td>"+myRecord.DateSent+"<br><strong>Sent</strong></td><td></td><td>"+myRecord.Content+"</td></tr>";
                            }
                          }
                          else {
                            if (myRecord.Type == 1) {
                              newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td><table><tr><td><b><a href='otherProfile.php?clickedUserID="+myRecord.UserID+"' style='color:black'>"+myRecord.Username+"</a></b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?1"+myRecord.Content+"' id='miniClock' width=410 height=205 ></iframe></td></tr><tr><td><i>"+myRecord.DateShared+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content+"')><img border='0' src='Icons/volume.png' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton' onclick=like("+myRecord.Content+",'"+myRecord.Name+"')><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton' onclick=dislike("+myRecord.Content+",'"+myRecord.Name+"')><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td>"+myRecord.NumOfLikes+"</td><td>"+myRecord.NumOfDislikes+"</td></tr></table></td><td><form action='addComment.php' method='post'><table><tr><td height=70></td></tr><tr><td><textarea style='height:195px;width:400px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><input type='hidden' name='Maker' value="+myRecord.Username+"><input type='hidden' name='clockName' value="+myRecord.Name+"><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.Content+"')>View All</button><input type='hidden' name='location' value=chat.php><input type='submit' style='width:200px;height:45px;' value='Enter'></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></form></td></tr>";
                            }
                            else {
                              newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td>"+myRecord.Content+"</td><td></td><td>"+myRecord.DateSent+"<br><strong>Sent</strong></td></tr>";
                            }              
                          }                    
                          rows = rows+newRow;
                      }
                  }
                }
                document.getElementById("resultRows").innerHTML = rows;
            }
        };
      xmlhttp.open("GET", "intermediateMessages.php", true);
      xmlhttp.send();



    </script>
    <script>
      function like(clockID,name) {
        window.open('like.php?clockID='+clockID+'&Name='+name+'&location=chat.php','_self');
      }

      function dislike(clockID,name) {
        window.open('dislike.php?clockID='+clockID+'&Name='+name+'&location=chat.php','_self');
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
    <div class="topnav">
      <input type="button" value="Go back!" onclick="history.back()">
      <a href="feed.html"><img border="0" src="Icons/house.png" width="30" height="30"></a>
      <a href="discover.html"><img border="0" src="Icons/compass.png" width="30" height="30"></a>
      <a href="checkClockLimit.php"><img border="0" src="Icons/music.png" width="30" height="30"></a>
      <a href="myClocks.php"><img border="0" src="Icons/user.png" width="30" height="30"></a>
      <a class="active" href="inbox.php"><img border="0" src="Icons/inbox.png" width="30" height="30"></a>
      <a href="search.php"><img border="0" src="Icons/magnifying-glass.png" width="30" height="30"></a>
    <a href="start.php" class="searchLogoutBtn">Logout</a>
  </div>
  <div class="messageTable">
    <table class="table" id="messageBox">
    <thead class="thead-light">
      <tr>
      <th id="messageHeading">Username</th>
      </tr>
      
    </thead>
    <tbody id="messageBody">
      </tbody>
    </table>
    <table class="table" id="messageTable">
      <thead>
        <tr>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody id="resultRows">
        
      </tbody>
    </table>
    </div>
  </body>
</html>