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
    var commentID = window.location.search.substring(1);
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myRecords = JSON.parse(this.responseText);
            if(myRecords.success == 1) {
              var rows = "";
              for (i=0;i<myRecords.Replies.length;i++) {
                  var myRecord = myRecords.Replies[i];
                  myRecord.Date = new Date(myRecord.Date);
                  myRecord.Date = myRecord.Date.toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric", hour:"numeric", minute:"numeric", second:"numeric"});
                  var newRow = "<tr class='table-row'><td><table><tr><td>"+myRecord.Reply+"</td></tr><tr><td><i style='font-size:15px;'>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='likeButton' onclick=likeReply("+myRecord.ReplyID+",this) style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton' onclick=dislikeReply("+myRecord.ReplyID+",this) style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td></tr><tr><td id=numLikes-"+myRecord.ReplyID+">"+myRecord.NumOfLikes+"</td><td id=numDislikes-"+myRecord.ReplyID+">"+myRecord.NumOfDislikes+"</td></tr></table></td></tr>";
                  rows = rows+newRow
              }
              document.getElementById("resultRows").innerHTML = rows;
            }
        }
    };

    xmlhttp.open("GET", "getReplies.php?CommentID="+commentID, true);
    xmlhttp.send();

    
    </script>
    <script>
      function likeReply(replyID,elem) {
        numLikes = document.getElementById("numLikes-"+replyID);
        $.ajax({
          type: 'post',
          url: 'addVote.php',
          data: {
            replyID:replyID,
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

      function dislikeReply(replyID,elem) {
        numDislikes = document.getElementById("numDislikes-"+replyID);
        $.ajax({
          type: 'post',
          url: 'addVote.php',
          data: {
            replyID:replyID,
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
    </script>
    <script>
      // removes all the items stored in localStorage from landing
      deleteLocalStorageLanding();
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
        <a><?php
            echo $_SESSION["Username"];
        ?></a>
        <div class="dropdown-content">
            <a onclick=updateAccount(this)>
              <?php // Checks if the user is a basic user and if they are, they will be presented with a button on the menu bar asking them if they want to upgrade to premium
              if($_SESSION["Premium"] == 0){
                echo "Upgrade To Premium";
              } 
              else {
                echo "Downgrade To Basic";
              }?>
            </a>
            <a onclick=deleteAccount()>Deactivate Account</a>
            <a href="updateEmail.php">Change Email</a>
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
          <th>Reply</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="resultRows">
      </tbody>
    </table>
</html>
