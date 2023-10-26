<!-- presents the user with the comments related to their chosen clock. -->
<?php
session_start();
if (isset($_SESSION["Error"]) && strlen($_SESSION["Error"]) > 0) {
  echo "<script>alert('".$_SESSION["Error"]."');</script>";
  $_SESSION["Error"] = "";
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
    <script>
      var clockID = window.location.search.substring(1);
      var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              var myRecords = JSON.parse(this.responseText);
              if(myRecords.success == 1) {
                var rows = "";
                for (i=0;i<myRecords.Comments.length;i++) {
                    var myRecord = myRecords.Comments[i];
                    var newRow = "<tr class='table-row'><td><table><tr><td>"+myRecord.Comment+"</td></tr><tr><td style='height:100px'></td></tr><tr><td><i style='font-size:15px;'>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='likeButton' onclick=like("+myRecord.CommentID+") style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton' onclick=dislike("+myRecord.CommentID+") style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td></tr><tr><td>"+myRecord.NumOfLikes+"</td><td>"+myRecord.NumOfDislikes+"</td></tr></table></td><td><form action='addReply.php' method='post'><table><tr><td><textarea style='height:100px;width:400px;font-size:30px;' name='reply' placeholder='Reply'></textarea><input type='hidden' name='CommentID' value="+myRecord.CommentID+"><input type='hidden' name='ClockID' value="+myRecord.ClockID+"></td></tr><tr><td><input type='button' style='width:200px;height:45px;' value='View All' onclick=getReplies("+myRecord.CommentID+")><input type='submit' style='width:200px;height:45px;' value='Enter'></form></td></tr></table></td></tr>";
                    rows = rows+newRow
                }
                document.getElementById("resultRows").innerHTML = rows;
              }
          }
      };

      xmlhttp.open("GET", "getComments.php?clockID="+clockID, true);
      xmlhttp.send();


    </script>
    <script>
      function like(commentID) {
        window.open('addVote.php?commentID='+commentID+'&location='+window.location.href+'&dislike=0','_self');
      }

      function dislike(commentID) {
        window.open('addVote.php?commentID='+commentID+'&location='+window.location.href+'&dislike=1','_self');
      }

      function getReplies(commentID) {
        window.open('replies.html?'+commentID,'_self');
      }

      function checkBack() {
        if (document.referrer.substring(0,28) == "http://localhost:8080/Clock/") {
          history.back();
        }
      }
    </script>
  </head>
  <body>
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
