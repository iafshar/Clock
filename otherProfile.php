<!-- displays the profile page containing all the clocks of the user that has been searched for -->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="style2.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myRecords = JSON.parse(this.responseText);
            var rows = "";
            for (i=0;i<myRecords.Clocks.length;i++) {
                var myRecord = myRecords.Clocks[i];
                var newRow = "<tr class='table-row'><td>"+myRecord.Name+"</td><td>"+myRecord.Tempo+"</td><td>"+myRecord.DateShared+"</td><td>"+myRecord.NumOfLikes+"</td><td>"+myRecord.NumOfDislikes+"</td><td><button class='likeButton'><img border='0' src='Icons/like.png' width='20' height='20'></button></td><td><button class='dislikeButton'><img border='0' src='Icons/dislike.png' width='20' height='20'></button></td><td><button class='viewComments'>View Comments</button></td><td><form action='addComment.php' method='post'><textarea rows='3' cols='40' name='comment' placeholder='Comment'></textarea><input type='hidden' name='clockName' value="+myRecord.Name+"><input type='hidden' name='location' value=otherProfile.php><input type='submit' value='Enter'></form></td><td><button class='viewClock'>View Clock</button></td></tr>";
                rows = rows+newRow
            }
            document.getElementById("resultRows").innerHTML = rows;
        }
    };

    xmlhttp.open("GET", "displaySearchedClocks.php", true);
    xmlhttp.send();


    </script>
    <script>
    $(document).ready(function(){

  // code to read selected table row cell data (values).
      $("#otherProfileTable").on('click','.likeButton',function(){
       // get the current row
       var currentRow=$(this).closest("tr");

       var name=currentRow.find("td:eq(0)").text();
       var xmlhttp = new XMLHttpRequest();
       xmlhttp.open("GET", "GetClockID.php?choose=1&clockName="+name, true);
       xmlhttp.send();
       window.open('like.php','_self');
      });

      $("#otherProfileTable").on('click','.dislikeButton',function(){
       // get the current row
       var currentRow=$(this).closest("tr");

       var name=currentRow.find("td:eq(0)").text();
       var xmlhttp = new XMLHttpRequest();
       xmlhttp.open("GET", "GetClockID.php?choose=1&clockName="+name, true);
       xmlhttp.send();
       window.open('dislike.php','_self');
      });

      $("#otherProfileTable").on('click','.viewComments',function(){
       // get the current row
       var currentRow=$(this).closest("tr");
       var name=currentRow.find("td:eq(0)").text();
       var xmlhttp = new XMLHttpRequest();
       xmlhttp.open("GET", "GetClockID.php?choose=1&clockName="+name, true);
       xmlhttp.send();
       window.open('stats.html','_self');
      });

      $("#otherProfileTable").on('click','.viewClock',function(){
       // get the current row
       var currentRow=$(this).closest("tr");

       var name=currentRow.find("td:eq(0)").text();
       var tempo=currentRow.find("td:eq(1)").text();
       var xmlhttp = new XMLHttpRequest();
       xmlhttp.open("GET", "GetClockID.php?choose=7&clockName="+name+"&tempo="+tempo, true);
       xmlhttp.send();
       window.open('Clock_JS_ReadOnly/index.html','_self');
      });
    });
    </script>

  </head>
  <body>
    <form action="follow.php" method="post">
      <button type="submit" class="followBtn"><?php
      require_once __DIR__ . '/followButton.php';
      echo $followButton; ?></button>
    </form>
    <div class="topnav">
      <a href="Feed.html"><img border="0" src="Icons/house.png" width="30" height="30"></a>
      <a href="Discover.html"><img border="0" src="Icons/compass.png" width="30" height="30"></a>
      <a href="checkClockLimit.php"><img border="0" src="Icons/music.png" width="30" height="30"></a>
      <a href="MyClocks.php"><img border="0" src="Icons/user.png" width="30" height="30"></a>
      <a href="Search.php"><img border="0" src="Icons/magnifying-glass.png" width="30" height="30"></a>
      <a href="start.php" class="logoutBtn">Logout</a>
    </div>
  </body>
  <table class="table" id="otherProfileTable">
      <thead class="thead-light">
        <tr>
          <th>Name</th>
          <th>Tempo</th>
          <th>Date Shared</th>
          <th>Likes</th>
          <th>Dislikes</th>
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
</html>
