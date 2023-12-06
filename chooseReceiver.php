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
      function sendToUser(Username, clockID) {
        message = document.getElementById('addMessage').value;
        var xmlhttp = new XMLHttpRequest();

        if (message.length > 0) {
          xmlhttp.open("GET", "sendMessageInbox.php?sendingUsername="+Username+"&clockID="+clockID+"&addMessage="+encodeURIComponent(message), true);
        }
        else {
          xmlhttp.open("GET", "sendMessageInbox.php?sendingUsername="+Username+"&clockID="+clockID, true);
        }
        xmlhttp.send();
        window.open("chat.php","_self");
        

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
      <a class="active" href="search.php"><img border="0" src="Icons/magnifying-glass.png" width="30" height="30"></a>

    <input id="userSearch" type="text" name="search" placeholder="Search" autocomplete="off">
    <input type='hidden' name='message' value="1">
  </div>
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
  <div class="searchTable">
    <table class="table" id="clockTable">
      <thead class="thead-light">
        <tr>
          <th id="searchHeading">Chats</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="resultRows">
      </tbody>
    </table>
    <table>
      <tbody>
        <tr>
          <td>
            <iframe src='' id='miniClock' width=410 height=205 ></iframe>
          </td>
        </tr>
        <tr>
          <td>
            <input id="addMessage" type="text" name="message" placeholder="Add a message" value="">
          </td>
        </tr>
      </tbody>
    </table>
    </div>
    <script>
      var clockID = window.location.search.substring(1);
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              var myRecords = JSON.parse(this.responseText);
              var rows = "";
              for (i=0;i<myRecords.Usernames.length;i++) {
                   var Username = myRecords.Usernames[i];
                   var date = myRecords.Dates[i];
                   date = new Date(date);
                   date = date.toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric", hour:"numeric", minute:"numeric", second:"numeric"});
                   var newRow = "<tr class='table-row' onclick=sendToUser('"+Username+"','"+clockID+"')><td>"+Username+"</td><td>"+date+"</td></tr>";
                   rows = rows+newRow;
              }
              document.getElementById("resultRows").innerHTML = rows;
          }
      };
      xmlhttp.open("GET", "getMessageHeaders.php", true);
      xmlhttp.send();

    </script>
  <script>
    document.getElementById('miniClock').src = 'http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?1'+clockID;
  </script>
  <script>

  inp = document.getElementById("userSearch");
  var ogRows = document.getElementById("resultRows").innerHTML
  if (inp) {
    inp.addEventListener("input", function(e) {
      var val = this.value;
      if (val.length > 0) {
        document.getElementById("searchHeading").innerHTML = "Username";
        autocomplete(val);
      }
      else {
        document.getElementById("searchHeading").innerHTML = "Chats";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              var myRecords = JSON.parse(this.responseText);
              var rows = "";
              for (i=0;i<myRecords.Usernames.length;i++) {
                   var Username = myRecords.Usernames[i];
                   var date = myRecords.Dates[i];
                   date = new Date(date);
                   date = date.toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric", hour:"numeric", minute:"numeric", second:"numeric"});
                   var newRow = "<tr class='table-row' onclick=sendToUser('"+Username+"','"+clockID+"')><td>"+Username+"</td><td>"+date+"</td></tr>";
                   rows = rows+newRow;
              }
              document.getElementById("resultRows").innerHTML = rows;
          }
      };
      xmlhttp.open("GET", "getMessageHeaders.php", true);
      xmlhttp.send();
      }
    });
  }

  function autocomplete(val) {
    var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var myRecords = JSON.parse(this.responseText);
          var rows = "";
          for (i=0;i<myRecords.length;i++) {
            if (myRecords[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
              var myRecord = myRecords[i];
              var newRow = "<tr class='table-row' onclick=sendToUser('"+myRecord+"','"+clockID+"')><td>"+myRecord+"</td><td></td></tr>";
              rows = rows+newRow;
            }
          }
          document.getElementById("resultRows").innerHTML = rows;
        }
      };
      xmlhttp.open("GET", "getAllUsers.php", true);
      xmlhttp.send();
  }

</script>
  </body>
</html>
