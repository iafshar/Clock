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
                   var Bold = myRecords.Bolds[i];
                   if (Bold == 0) {
                    var newRow = "<tr class='table-row'><td>"+Username+"</td><td>"+date+"</td></tr>";
                   }
                   else {
                    var newRow = "<tr class='table-row'><td><strong>"+Username+"</strong></td><td><strong>"+date+"</strong></td></tr>";
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
    $(document).ready(function(){

  // code to read selected table row cell data (values).
      $("#messageTable").on('click','.table-row',function(){
       // get the current row
       var currentRow=$(this).closest("tr");

       var Username=currentRow.find("td:eq(0)").text(); // get current row 2nd TD
    //    document.getElementById("searchHeading").innerHTML = Username;
    //    document.getElementById("dateHeading").innerHTML = "";
       var xmlhttp = new XMLHttpRequest();
       xmlhttp.open("GET", "getMessages.php?sender=" + Username, true);
       xmlhttp.send();
       window.open('chat.php','_self');
      });
    });

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
      <a class="active" href="inbox.php" id='chats' style='color:black'><img border="0" src="Icons/inbox.png" width="30" height="30"></a>
      <a href="search.php"><img border="0" src="Icons/magnifying-glass.png" width="30" height="30"></a>

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
  <div class="messageTable">
    <table class="table" id="messageTable">
      <thead class="thead-light">
        <tr>
          <th id="searchHeading">Usernames</th>
          <th id="dateHeading">Date Sent</th>
        </tr>
      </thead>
      <tbody id="resultRows">
      </tbody>
    </table>
    </div>
  </body>
</html>
