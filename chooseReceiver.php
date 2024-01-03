<!-- called when choosing a person to send a clock to -->
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
      function sendToUser(Username, clockID) {
        message = document.getElementById('addMessage').value; // value of the attached message of the clock - can be empty
        var xmlhttp = new XMLHttpRequest();

        if (message.length > 0) {
          // have to encode the message because it doesnt take anything after a hashtag otherwise
          xmlhttp.open("GET", "sendMessageInbox.php?sendingUsername="+Username+"&clockID="+clockID+"&addMessage="+encodeURIComponent(message), true);
        }
        else {
          xmlhttp.open("GET", "sendMessageInbox.php?sendingUsername="+Username+"&clockID="+clockID, true);
        }
        xmlhttp.send();
        window.open("chat.php?"+Username,"_self");
        
      }

      
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
      <a class="active" href="search.php"><img border="0" src="Icons/magnifying-glass.png" width="30" height="30"></a>

      <input id="userSearch" type="text" name="search" placeholder="Search" autocomplete="off">
      <input type='hidden' name='message' value="1">
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
                <a href="start.php">Logout</a>
            </div>
        </div>
    </div>
  <script>
    setUnreadCount();

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
            <iframe src='' id='miniClock' width=410 height=205 onload=iframeclick(this)></iframe>
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
      var boldUsers = []
      var clockID = window.location.search.substring(1);
      // display the usernames of the chats the user has with others
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
                  var Bold = myRecords.Bolds[i]; // decides whether username should be bold or not depending on whether the user has viewed their messages
                  if (Bold == 0) {
                    var newRow = "<tr class='table-row-clickable' onclick=sendToUser('"+Username+"','"+clockID+"')><td>"+Username+"</td><td>"+date+"</td></tr>";  
                  }
                  else {
                    boldUsers.push(Username);
                    var newRow = "<tr class='table-row-clickable' onclick=sendToUser('"+Username+"','"+clockID+"')><td><strong>"+Username+"</strong></td><td>"+date+"</td></tr>";  
                  }
                  
                  rows = rows+newRow;
              }
              document.getElementById("resultRows").innerHTML = rows;
          }
      };
      xmlhttp.open("GET", "getMessageHeaders.php", true);
      xmlhttp.send();
      
    </script>
  <script>
    document.getElementById('miniClock').src = 'http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?rowID=-1clockID='+clockID;
  </script>
  <script>

  inp = document.getElementById("userSearch"); // user can also search for people to sent it to
  if (inp) {
    inp.addEventListener("input", function(e) {
      var val = this.value;
      if (val.length > 0) { // if there is something entered in the search, change the heading from chats to username and call the autocomplete function
        document.getElementById("searchHeading").innerHTML = "Username";
        autocomplete(val);
      }
      else { // if nothing is entered in the search, display the chat headers normally
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
                  var Bold = myRecords.Bolds[i]; // decides whether username should be bold or not depending on whether the user has viewed their messages
                  if (Bold == 0) {
                    var newRow = "<tr class='table-row-clickable' onclick=sendToUser('"+Username+"','"+clockID+"')><td>"+Username+"</td><td>"+date+"</td></tr>";  
                  }
                  else {
                    var newRow = "<tr class='table-row-clickable' onclick=sendToUser('"+Username+"','"+clockID+"')><td><strong>"+Username+"</strong></td><td>"+date+"</td></tr>";  
                  }
                  
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

  function autocomplete(val) { // displays all the users in the database that have usernames that start with what is entered in the search bar
    var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var myRecords = JSON.parse(this.responseText);
          var rows = "";
          for (i=0;i<myRecords.length;i++) {
            if (myRecords[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
              var myRecord = myRecords[i];
              if (boldUsers.includes(myRecord)) {
                var newRow = "<tr class='table-row-clickable' onclick=sendToUser('"+myRecord+"','"+clockID+"')><td><strong>"+myRecord+"</strong></td><td></td></tr>";
              } else {
                var newRow = "<tr class='table-row-clickable' onclick=sendToUser('"+myRecord+"','"+clockID+"')><td>"+myRecord+"</td><td></td></tr>";
              }
              
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
