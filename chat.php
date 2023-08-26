
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
                console.log(myRecords);
                var rows = "<td><form action='sendMessageInbox.php' method='post'><textarea rows='2' cols='100' name='message' placeholder='Message'></textarea><input type='hidden' name='Sender' value="+myRecords.otherUsername+"><input type='submit' value='Enter'></form></td>";
                if (myRecords.Messages) {
                    for (i=0;i<myRecords.Messages.length;i++) {
                        var myRecord = myRecords.Messages[i];
                        if (myRecord.sentByMe == 0) {
                            var newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td>"+myRecord.DateSent+"</td><td>"+myRecord.Content+"</td></tr>";
                        }
                        else {
                            var newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td>"+myRecord.Content+"</td><td>"+myRecord.DateSent+"</td></tr>";
                        }
                        rows = rows+newRow;
                    }
                }
                document.getElementById("resultRows").innerHTML = rows;
            }
        };
      xmlhttp.open("GET", "intermediateMessages.php", true);
      xmlhttp.send();



    </script>
  </head>
  <body>
    <div class="topnav">
      <a href="feed.html"><img border="0" src="Icons/house.png" width="30" height="30"></a>
      <a href="discover.html"><img border="0" src="Icons/compass.png" width="30" height="30"></a>
      <a href="checkClockLimit.php"><img border="0" src="Icons/music.png" width="30" height="30"></a>
      <a href="myClocks.php"><img border="0" src="Icons/user.png" width="30" height="30"></a>
      <a class="active" href="inbox.php"><img border="0" src="Icons/inbox.png" width="30" height="30"></a>
      <a href="search.php"><img border="0" src="Icons/magnifying-glass.png" width="30" height="30"></a>
    <a href="start.php" class="searchLogoutBtn">Logout</a>
  </div>
  <div class="messageTable">
    <table class="table" id="messageTable">
      <thead class="thead-light">
        <tr>
          <th id="messageHeading">Username</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="resultRows">
      </tbody>
    </table>
    </div>
  </body>
</html>