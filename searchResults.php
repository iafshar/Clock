<!-- presents the user with the results of their searches -->
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
            if(myRecords.success == 1) {
              var rows = "";
              for (i=0;i<myRecords.Users.length;i++) {
                  var myRecord = myRecords.Users[i];
                  var newRow = "<tr class='table-row'><td>"+myRecord.Username+"</td></tr>";
                  rows = rows+newRow
              }
              document.getElementById("resultRows").innerHTML = rows;
            }
        }
    };

    xmlhttp.open("GET", "intermediateSearch.php", true);
    xmlhttp.send();


    </script>
    <script>


    $(document).ready(function(){

  // code to read selected table row cell data (values).
      $("#clockTable").on('click','.table-row',function(){
       // get the current row
       var currentRow=$(this).closest("tr");

       var Username=currentRow.find("td:eq(0)").text(); // get current row 2nd TD
       var message = (
        <?php
          session_start();
          echo json_encode($_SESSION["message"]);
        ?>
        );

        if (message == 0) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.open("GET", "getOtherUserClocks.php?Username=" + Username, true);
          xmlhttp.send();
          window.open("otherProfile.php","_self");
        }
        else {
          var xmlhttp = new XMLHttpRequest();

          xmlhttp.open("GET", "sendMessageInbox.php?sendingUsername="+Username, true);
          xmlhttp.send();
          window.open("chat.php","_self");
        }
        
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
      <a href="inbox.php" id='chats' style='color:black'><img border="0" src="Icons/inbox.png" width="30" height="30"></a>
      <a href="search.php"><img border="0" src="Icons/magnifying-glass.png" width="30" height="30"></a>
      <a href="start.php" class="logoutBtn">Logout</a>
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
        <th>Username</th>
      </tr>
    </thead>
    <tbody id="resultRows">
    </tbody>
  </table>
</html>
