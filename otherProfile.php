<!-- displays the profile page containing all the clocks of the user that has been searched for -->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="css/postLanding.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
      function like(clockID,elem) {
        numLikes = document.getElementById("numLikes-"+clockID);
        $.ajax({
          type: 'post',
          url: 'addVote.php',
          data: {
            location:'otherProfile.php',
            clockID:clockID,
            dislike:0
          },
          success: function (response) {
            if (response == 0) {
              numLikes.innerHTML = parseInt(numLikes.innerHTML) - 1;
              elem.style.backgroundColor = "#efefef";
            }
            else {
              numLikes.innerHTML = parseInt(numLikes.innerHTML) + 1;
              elem.style.backgroundColor = "#f39faa";
            }
            
          }
        });
      }

      function dislike(clockID,elem) {
        numDislikes = document.getElementById("numDislikes-"+clockID);
        $.ajax({
          type: 'post',
          url: 'addVote.php',
          data: {
            location:'otherProfile.php',
            clockID:clockID,
            dislike:1
          },
          success: function (response) {
            if (response == 0) {
              numDislikes.innerHTML = parseInt(numDislikes.innerHTML) - 1;
              elem.style.backgroundColor = "#efefef";
            }
            else {
              numDislikes.innerHTML = parseInt(numDislikes.innerHTML) + 1;
              elem.style.backgroundColor = "#f39faa";
            }
            
          }
        });
      }
      
      function openClock(clockID) {
        window.open('Clock_ReadOnly/index.html?'+clockID,'_self');
      }


      function changeSound(clockID,rowID) {
        for (let i = 0; i < document.getElementsByTagName("iframe").length; i++) {
          if (document.getElementsByTagName("iframe")[i].src == "http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?rowID="+rowID+"clockID="+clockID) {
            if (localStorage.getItem("muteRow"+rowID)) {
              localStorage.removeItem("muteRow"+rowID);
              document.getElementsByClassName("sound-icon")[i].src = "Icons/mute.png";
              break;
            }
            else {
              localStorage.setItem("muteRow"+rowID,0);
              document.getElementsByClassName("sound-icon")[i].src = "Icons/volume.png";
            }
          }
          else {
            var source = document.getElementsByTagName("iframe")[i].src
            var rowIDIndex = source.indexOf("rowID=");
            rowIDIndex += 6;
            var clockIDIndex = source.indexOf("clockID="); 
            var newRowID = source.substring(rowIDIndex,clockIDIndex);
            localStorage.removeItem("muteRow"+newRowID);
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

      function remixClock(clockID) {
        window.open('checkClockLimit.php?clockID='+clockID,'_self');
      }

      function addComment(clockID) {
        comment = document.getElementById("commentBox-"+clockID);
        $.ajax({
          type: 'post',
          url: 'addComment.php',
          data: {
            clockID:clockID,
            comment:comment.value
          },
          success: function () {
            comment.value = "";
          }
        });
      }

      function changeFollow(elem) {
        $.ajax({
          type: 'post',
          url: 'follow.php',
          success: function (response) {
            document.getElementById("followBtn").innerHTML = JSON.parse(response);
          }
        });
      }
    </script>

  </head>
  <body>
    <div class="otherProfile-buttons">
      
      
    </div>
    
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
              document.getElementById("followBtn").innerHTML = myRecords.Following;
              if(myRecords.success == 1) {
                var rows = "";
                for (i=0;i<myRecords.Clocks.length;i++) {
                    var myRecord = myRecords.Clocks[i];
                    myRecord.Date = new Date(myRecord.Date);
                    myRecord.Date = myRecord.Date.toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric", hour:"numeric", minute:"numeric", second:"numeric"});
                    if (premium) {
                      var newRow = "<tr class='table-row'><td><table><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.ClockID+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick()></iframe></td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.ClockID+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.ClockID+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.ClockID+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.ClockID+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton' onclick=like("+myRecord.ClockID+",this) style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton' onclick=dislike("+myRecord.ClockID+",this) style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td id=numLikes-"+myRecord.ClockID+">"+myRecord.NumOfLikes+"</td><td id=numDislikes-"+myRecord.ClockID+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><textarea id=commentBox-"+myRecord.ClockID+" style='height:195px;width:400px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.ClockID+"')>View All</button><input type='submit' style='width:200px;height:45px;' value='Enter' onclick=addComment('"+myRecord.ClockID+"')></td></tr></table></td></tr>";
                    } 
                    else {
                      var newRow = "<tr class='table-row'><td><table><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.ClockID+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick()></iframe></td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.ClockID+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.ClockID+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.ClockID+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.ClockID+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton' onclick=like("+myRecord.ClockID+",this) style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton' onclick=dislike("+myRecord.ClockID+",this) style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td id=numLikes-"+myRecord.ClockID+">"+myRecord.NumOfLikes+"</td><td id=numDislikes-"+myRecord.ClockID+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.ClockID+"')>View Comments</button></td></tr></table></td></tr>";
                    }
                    rows = rows+newRow;
                    localStorage.removeItem("muteRow"+i);
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
    <script>
      function iframeclick() {
        iframes = document.getElementsByTagName("iframe");
        for (let i = 0; i < iframes.length; i++) {
          iframes[i].contentWindow.document.body.onclick = function() {
            var source = iframes[i].src;
            var index = source.indexOf("clockID=") + 8;
            openClock(source.substring(index));
          }
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
          <th><table><td id='profileHeader'></td><td><input id='clockSearch' type='text' name='search' placeholder='Search' autocomplete='off' required style='margin-left: 20px;'><img src='Icons/magnifying-glass.png' width='30' height='30'></td></table></th>
          <th>
            <div class="follow">
              <button type="submit" class="followBtn" id="followBtn" onclick=changeFollow(this)>Follow</button>
            </div>
          </th>
          <th>
            <div class="message">
              <form action="sendMessageInbox.php" method="post">
                <button type="submit" class="messageBtn" onclick="getMessages()">Message</button>
                <input type='hidden' id="sender" name='Sender' value="">
              </form>
            </div>
          </th>
        </tr>
      </thead>
      <tbody id="resultRows">
      </tbody>
  </table>
  <script>
    inp = document.getElementById("clockSearch");
    if (inp) {
      inp.addEventListener("input", function(e) {
        var val = this.value;
        autocomplete(val);
      });
    }

    function autocomplete(val) {
      illegalChars = ['§','±','`','~',',','<','=','+','[',']','{','}',':',';','|','\\',"'","\"",'/','?'];
      for (let i = 0; i < illegalChars.length; i++) {
        val = val.replaceAll(illegalChars[i],"");
      }
      val = val.replaceAll(" ","_");
      var xmlhttp = new XMLHttpRequest();

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
                        var newRow = "<tr class='table-row'><td><table><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.ClockID+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick()></iframe></td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.ClockID+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.ClockID+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.ClockID+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.ClockID+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton' onclick=like("+myRecord.ClockID+",this) style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton' onclick=dislike("+myRecord.ClockID+",this) style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td id=numLikes-"+myRecord.ClockID+">"+myRecord.NumOfLikes+"</td><td id=numDislikes-"+myRecord.ClockID+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><textarea id=commentBox-"+myRecord.ClockID+" style='height:195px;width:400px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.ClockID+"')>View All</button><input type='submit' style='width:200px;height:45px;' value='Enter' onclick=addComment('"+myRecord.ClockID+"')></td></tr></table></td></tr>";
                      } 
                      else {
                        var newRow = "<tr class='table-row'><td><table><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.ClockID+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick()></iframe></td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.ClockID+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.ClockID+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.ClockID+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.ClockID+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton' onclick=like("+myRecord.ClockID+",this) style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton' onclick=dislike("+myRecord.ClockID+",this) style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td id=numLikes-"+myRecord.ClockID+">"+myRecord.NumOfLikes+"</td><td id=numDislikes-"+myRecord.ClockID+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.ClockID+"')>View Comments</button></td></tr></table></td></tr>";
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