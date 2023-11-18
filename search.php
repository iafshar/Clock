<!-- This is what happens after the user clicks on the search icon and is about to search. they are presented with their five most recent searches -->
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
              for (i=0;i<myRecords.length;i++) {
                   var myRecord = myRecords[i];
                   var newRow = "<tr class='table-row'><td class='search-username'>"+myRecord+"</td><td><input type='button' value='X' item="+myRecord+" onclick=deleteHistoryItem(this)></td></tr>";
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
      $("#clockTable").on('click','.search-username',function(){
       // get the current row
       var currentRow=$(this).closest("tr");

       var Username=currentRow.find("td:eq(0)").text(); // get current row 2nd TD
       var xmlhttp = new XMLHttpRequest();

       xmlhttp.open("GET", "searchAllUsers.php?RecentUsername=" + Username, true);
       xmlhttp.send();
       window.open("searchResults.php","_self");
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
      <a href="inbox.php" id='chats' style='color:black'><img border="0" src="Icons/inbox.png" width="30" height="30"></a>
      <a class="active" href="search.php"><img border="0" src="Icons/magnifying-glass.png" width="30" height="30"></a>

    <form autocomplete="off" action="searchAllUsers.php" method="post">
      <input id="userSearch" type="text" name="search" placeholder="Search" required>
      <input type="submit" value="🔍">
    </form>
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
          <th id="searchHeading">Recents</th>
          <th id="clearButton">
            <form action=""></form>
            <input type="button" value="Clear" onclick="clearHistory()">
          </th>
        </tr>
      </thead>
      <tbody id="resultRows">
      </tbody>
    </table>
    </div>
  
  <script>

  inp = document.getElementById("userSearch");
  var ogRows = document.getElementById("resultRows").innerHTML;
  if (inp) {
    inp.addEventListener("input", function(e) {
      var val = this.value;
      if (val.length > 0) {
        document.getElementById("searchHeading").innerHTML = "Username";
        document.getElementById("clearButton").innerHTML = "";
        // document.querySelectorAll('th')[1].innerHTML = "Username";
        autocomplete(val);
        $(document).ready(function(){

            
            // code to read selected table row cell data (values).
          $("#clockTable").on('click','.autocomplete-table-row',function(){
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
        document.getElementById("clearButton").innerHTML = "<input type='button' value='Clear' onclick='clearHistory()'>";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myRecords = JSON.parse(this.responseText);
                var rows = "";
                for (i=0;i<myRecords.length;i++) {
                    var myRecord = myRecords[i];
                    var newRow = "<tr class='table-row'><td class='search-username'>"+myRecord+"</td><td><input type='button' value='X' item="+myRecord+" onclick=deleteHistoryItem(this)></td></tr>";
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
    val = val.replaceAll("\"","");
    val = val.replaceAll("\'","");
    val = val.replaceAll("\\","");
    val = val.replaceAll(">","");
    val = val.replaceAll("<","");
    var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var myRecords = JSON.parse(this.responseText);
          var rows = "";
          for (i=0;i<myRecords.length;i++) {
            if (myRecords[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
              var myRecord = myRecords[i];
              var newRow = "<tr class='autocomplete-table-row'><td>"+myRecord+"</td><td></td></tr>";
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
<script>
  function clearHistory() {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "clearHistory.php", true);
    xmlhttp.send();
    location.reload();
  }
</script>
<script>
  function deleteHistoryItem(element) {
    
    item = element.getAttribute('item')

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "deleteHistoryItem.php?item="+item, true);
    xmlhttp.send();
    location.reload();

  }
</script>
  </body>
</html>
