<!-- This is what happens after the user clicks on the search icon and is about to search. they are presented with their five most recent searches -->
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
              var rows = "";
              for (i=0;i<myRecords.length;i++) {
                   var myRecord = myRecords[i];
                   var newRow = "<tr class='table-row'><td>"+myRecord+"</td></tr>";
                   rows = rows+newRow;
              }
              document.getElementById("resultRows").innerHTML = rows;
          }
      };
      xmlhttp.open("GET", "displayRecentSearches.php", true);
      xmlhttp.send();



    </script>
    <script>
    $(document).ready(function(){

  // code to read selected table row cell data (values).
      $("#clockTable").on('click','.table-row',function(){
       // get the current row
       var currentRow=$(this).closest("tr");

       var Username=currentRow.find("td:eq(0)").text(); // get current row 2nd TD
       var xmlhttp = new XMLHttpRequest();

       xmlhttp.open("GET", "searchAllUsers.php?RecentUsername=" + Username, true);
       xmlhttp.send();
       window.open("searchResults.html","_self");
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
      <a href="inbox.php"><img border="0" src="Icons/inbox.png" width="30" height="30"></a>
      <a class="active" href="search.php"><img border="0" src="Icons/magnifying-glass.png" width="30" height="30"></a>

    <form autocomplete="off" action="searchAllUsers.php" method="post">
      <input id="userSearch" type="text" name="search" placeholder="Search" required>
      <input type="submit" value="🔍">
    </form>
    <a href="start.php" class="searchLogoutBtn">Logout</a>
  </div>
  <div class="searchTable">
    <table class="table" id="clockTable">
      <thead class="thead-light">
        <tr>
          <th id="searchHeading">Recents</th>
        </tr>
      </thead>
      <tbody id="resultRows">
      </tbody>
    </table>
    </div>
  
  <script>

  inp = document.getElementById("userSearch");
  var ogRows = document.getElementById("resultRows").innerHTML
  if (inp) {
    inp.addEventListener("input", function(e) {
      var val = this.value;
      if (val.length > 0) {
        document.getElementById("searchHeading").innerHTML = "Username";
        // document.querySelectorAll('th')[1].innerHTML = "Username";
        autocomplete(val);
        $(document).ready(function(){

          // code to read selected table row cell data (values).
          $("#clockTable").on('click','.table-row',function(){
          // get the current row
          var currentRow=$(this).closest("tr");

          var Username=currentRow.find("td:eq(0)").text(); // get current row 2nd TD
          var xmlhttp = new XMLHttpRequest();

          xmlhttp.open("GET", "getOtherUserClocks.php?Username=" + Username, true);
          xmlhttp.send();
          window.open("otherProfile.php","_self");
          });
        });
      }
      else {
        document.getElementById("searchHeading").innerHTML = "Recents";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myRecords = JSON.parse(this.responseText);
                var rows = "";
                for (i=0;i<myRecords.length;i++) {
                    var myRecord = myRecords[i];
                    var newRow = "<tr class='table-row'><td>"+myRecord+"</td></tr>";
                    rows = rows+newRow;
                }
                document.getElementById("resultRows").innerHTML = rows;
            }
        };
        xmlhttp.open("GET", "displayRecentSearches.php", true);
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
              var newRow = "<tr class='table-row'><td>"+myRecord+"</td></tr>";
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
