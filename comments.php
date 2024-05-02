<!-- presents the user with the comments related to their chosen clock -->
<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clock | Comments</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="css/postLanding.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="functions.js"></script>
    <script>

      function displayComments() {
        var clockID = window.location.search.substring(1);
        var xmlhttp = new XMLHttpRequest();
        // displays all the comments of the current clock
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myRecords = JSON.parse(this.responseText);
                var premium = (myRecords.Premium == 1);
                if(myRecords.success == 1) {
                  var rows = "";
                  for (i=0;i<myRecords.Comments.length;i++) {
                      var myRecord = myRecords.Comments[i];
                      myRecord.Date = new Date(myRecord.Date);
                      myRecord.Date = myRecord.Date.toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric", hour:"numeric", minute:"numeric", second:"numeric"});
                      if (premium) { // if premium, the user can reply
                        var newRow = "<tr class='table-row'><td><table><tr><td>"+myRecord.Comment+"</td></tr><tr><td style='height:100px'></td></tr><tr><td><i style='font-size:15px;'>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='likeButton' onclick=likeComment("+myRecord.CommentID+",this) style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton' onclick=dislikeComment("+myRecord.CommentID+",this) style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td></tr><tr><td id=numLikes-"+myRecord.CommentID+">"+myRecord.NumOfLikes+"</td><td id=numDislikes-"+myRecord.CommentID+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td><textarea id=replyBox-"+myRecord.CommentID+" style='height:100px;width:100%;font-size:30px;' name='reply' placeholder='Reply'></textarea></td></tr><tr><td><button type='button' style='width:50%;height:45px;' onclick=getReplies("+myRecord.CommentID+")>View All</button><button type='submit' style='width:50%;height:45px;' onclick=addReply('"+myRecord.CommentID+"')>Enter</button></td></tr></table></td></tr>";
                      }
                      else {
                        var newRow = "<tr class='table-row'><td><table><tr><td>"+myRecord.Comment+"</td></tr><tr><td style='height:100px'></td></tr><tr><td><i style='font-size:15px;'>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='likeButton' onclick=likeComment("+myRecord.CommentID+",this) style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton' onclick=dislikeComment("+myRecord.CommentID+",this) style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td></tr><tr><td id=numLikes-"+myRecord.CommentID+">"+myRecord.NumOfLikes+"</td><td id=numDislikes-"+myRecord.CommentID+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td><button type='button' style='width:100%;height:45px;' onclick=getReplies("+myRecord.CommentID+")>View Replies</button></td></tr></table></td></tr>";
                      }
                      rows = rows+newRow
                  }
                  document.getElementById("resultRows").innerHTML = rows;
                }
            }
        };

        xmlhttp.open("GET", "getComments.php?clockID="+clockID, true);
        xmlhttp.send();
      }

      displayComments();


    </script>
    <script>
      function likeComment(commentID,elem) {
        numLikes = document.getElementById("numLikes-"+commentID); //numLikes associated with the like button and the comment
        $.ajax({
          type: 'post',
          url: 'addVote.php',
          data: {
            commentID:commentID,
            dislike:0
          },
          success: function (response) {
            if (response == 0) {
              numLikes.innerHTML = parseInt(numLikes.innerHTML) - 1; // reduces the number of likes by 1 if it was an unlike
              elem.style.backgroundColor = "#efefef"; // changes the color of the button
            }
            else {
              numLikes.innerHTML = parseInt(numLikes.innerHTML) + 1; // increases the number of likes by 1 if it added a like
              elem.style.backgroundColor = "#f39faa"; // changes the color of the button
            }
            
          }
        });
      }

      function dislikeComment(commentID,elem) {
        numDislikes = document.getElementById("numDislikes-"+commentID); //numDislikes associated with the like button and the comment
        $.ajax({
          type: 'post',
          url: 'addVote.php',
          data: {
            commentID:commentID,
            dislike:1
          },
          success: function (response) {
            if (response == 0) {
              numDislikes.innerHTML = parseInt(numDislikes.innerHTML) - 1; // reduces the number of dislikes by 1 if it was an unlike
              elem.style.backgroundColor = "#efefef"; // changes the color of the button
            }
            else {
              numDislikes.innerHTML = parseInt(numDislikes.innerHTML) + 1; // increases the number of likes by 1 if it added a dislike
              elem.style.backgroundColor = "#f39faa"; // changes the color of the button
            }
            
          }
        });
      }

      function getReplies(commentID) {
        window.open('replies.php?'+commentID,'_self');
      }

      

      function addReply(commentID) {
        reply = document.getElementById("replyBox-"+commentID); // the replyBox associated with the comment
        $.ajax({
          type: 'post',
          url: 'addReply.php',
          data: {
            CommentID:commentID,
            reply:reply.value
          },
          success: function () {
            reply.value = ""; // clears the reply box
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
            <a onclick=updateAccount(this,displayComments)>
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
          <th>Comment</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody id="resultRows">
      </tbody>
    </table>
</html>
