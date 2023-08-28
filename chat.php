
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
                document.getElementById("messageBody").innerHTML = "<td><form action='sendMessageInbox.php' method='post'><textarea rows='4' cols='120' name='message' placeholder='Message'></textarea><input type='hidden' name='Sender' value="+myRecords.otherUsername+"><input type='submit' value='Enter'></form></td>";
                var rows = "";
                if (myRecords) {
                  if (myRecords.Messages) {
                      for (i=0;i<myRecords.Messages.length;i++) {
                          var myRecord = myRecords.Messages[i];
                          console.log(myRecord);
                          var newRow = "";
                          if (myRecord.sentByMe == 0) {
                            if (myRecord.Type == 1) {
                              newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td>"+myRecord.DateSent+"<br><strong>Sent</strong></td><td><strong>Username</strong><br>"+myRecord.Username+"</td><td><strong>Name</strong><br>"+myRecord.Name+"</td><td name='tempo'><strong>Tempo</strong><br>"+myRecord.Tempo+"</td><td><strong>Date Shared</strong><br>"+myRecord.DateShared+"</td><td><strong>Likes</strong><br>"+myRecord.NumOfLikes+"</td><td><strong>Dislikes</strong><br>"+myRecord.NumOfDislikes+"</td><td><button class='likeButton'><img border='0' src='Icons/like.png' width='20' height='20'></button></td><td><button class='dislikeButton'><img border='0' src='Icons/dislike.png' width='20' height='20'></button></td><td><button class='viewComments'>View Comments</button></td><td><form action='addComment.php' method='post'><textarea rows='3' cols='20' name='comment' placeholder='Comment'></textarea><input type='hidden' name='Maker' value="+myRecord.Username+"><input type='hidden' name='clockID' value="+myRecord.Content+"><input type='hidden' name='clockName' value="+myRecord.Name+"><input type='hidden' name='location' value=chat.php><input type='submit' value='Enter'></form></td><td><button class='viewClock'>View Clock</button></td><td><button class='sendClock'>Send Clock</button></td></tr>";
                            }
                            else {
                              newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td>"+myRecord.DateSent+"<br><strong>Sent</strong></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>"+myRecord.Content+"</td></tr>";
                            }
                          }
                          else {
                            if (myRecord.Type == 1) {
                              newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td><strong>Username</strong><br>"+myRecord.Username+"</td><td><strong>Name</strong><br>"+myRecord.Name+"</td><td name='tempo'><strong>Tempo</strong><br>"+myRecord.Tempo+"</td><td><strong>Date Shared</strong><br>"+myRecord.DateShared+"</td><td><strong>Likes</strong><br>"+myRecord.NumOfLikes+"</td><td><strong>Dislikes</strong><br>"+myRecord.NumOfDislikes+"</td><td><button class='likeButton'><img border='0' src='Icons/like.png' width='20' height='20'></button></td><td><button class='dislikeButton'><img border='0' src='Icons/dislike.png' width='20' height='20'></button></td><td><button class='viewComments'>View Comments</button></td><td><form action='addComment.php' method='post'><textarea rows='3' cols='20' name='comment' placeholder='Comment'></textarea><input type='hidden' name='Maker' value="+myRecord.Username+"><input type='hidden' name='clockID' value="+myRecord.Content+"><input type='hidden' name='clockName' value="+myRecord.Name+"><input type='hidden' name='location' value=chat.php><input type='submit' value='Enter'></form></td><td><button class='viewClock'>View Clock</button></td><td><button class='sendClock'>Send Clock</button></td><td>"+myRecord.DateSent+"<br><strong>Sent</strong></td></tr>";
                            }
                            else {
                              newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td>"+myRecord.Content+"</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>"+myRecord.DateSent+"<br><strong>Sent</strong></td></tr>";
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
    $(document).ready(function(){

  // code to read selected table row cell data (values).
      $("#messageTable").on('click','.likeButton',function(){
       // get the current row
        var currentRow=$(this).closest("tr");

        var clockID = currentRow.find('input[name=clockID]').val();
        var Name = currentRow.find('input[name=clockName]').val();

        window.open('like.php?clockID='+clockID+'&Name='+Name+'&location=http://localhost:8080/Clock/chat.php','_self');
      });
    });
    </script>
    <script>
    $(document).ready(function(){

  // code to read selected table row cell data (values).
      $("#messageTable").on('click','.dislikeButton',function(){
       // get the current row
        var currentRow=$(this).closest("tr");

        var clockID = currentRow.find('input[name=clockID]').val();
        var Name = currentRow.find('input[name=clockName]').val();

        window.open('dislike.php?clockID='+clockID+'&Name='+Name+'&location=http://localhost:8080/Clock/chat.php','_self');
      });
    });
    </script>
    <script>
    $(document).ready(function(){

  // code to read selected table row cell data (values).
      $("#messageTable").on('click','.viewComments',function(){
       // get the current row
        var currentRow=$(this).closest("tr");

        var clockID = currentRow.find('input[name=clockID]').val();
        var Name = currentRow.find('input[name=clockName]').val();
        window.open('getComments.php?clockID='+clockID,'_self');
      });
    });
    </script>
    <script>
      $(document).ready(function(){

    // code to read selected table row cell data (values).
        $("#messageTable").on('click','.viewClock',function(){
        // get the current row
        var currentRow=$(this).closest("tr");

        var clockID = currentRow.find('input[name=clockID]').val();
        var Name = currentRow.find('input[name=clockName]').val();
        var tempo = currentRow.find('td[name=tempo]').text().substring(5);
        window.open('Clock_ReadOnly/get.php?clockID='+clockID+'&Name='+Name+'&tempo='+tempo,'_self');
        });
      });
    </script>
    <script>
      $(document).ready(function(){

// code to read selected table row cell data (values).
        $("#messageTable").on('click','.sendClock',function(){
        // get the current row
          var currentRow=$(this).closest("tr");

          var name = currentRow.find('input[name=clockName]').val();
          var tempo = currentRow.find('td[name=tempo]').text().substring(5);
          var username = currentRow.find('input[name=Maker]').val();

          var xmlhttp = new XMLHttpRequest();

          xmlhttp.open("GET", "getClockID.php?choose=6&clockName="+name+"&discoverUsername="+username+"&tempo="+tempo, true);
          xmlhttp.send();
          window.open('chooseReceiver.php','_self');

        });
      });
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
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
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