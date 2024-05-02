<!-- This is what happens after the user clicks on the search icon and is about to search. they are presented with their five most recent searches -->
<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Clock | Search</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="css/postLanding.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="functions.js"></script>
    <script>
      // displays the search history of the user
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              var myRecords = JSON.parse(this.responseText);
              var rows = "";
              for (i=0;i<myRecords.length;i++) {
                  var myRecord = myRecords[i];
                  myRecord = myRecord.replaceAll("'","&#39;");
                  myRecord = myRecord.replaceAll(">","&#62;");
                  myRecord = myRecord.replaceAll("\\","&#92;");
                  myRecord = myRecord.replaceAll("<","&#60;");

                  var type = myRecord.slice(-1);
                  var icon;
                  if (type == 0) {
                    icon = "Icons/magnifying-glass.png";
                  }
                  else {
                    icon = "Icons/user.png";
                  }
                  var newRow = "<tr class='table-row-clickable'><td class='search-username'><img class='search-type' src='"+icon+"' width='30' height='30' ></td><td class='search-username' id='recent"+i+"' >"+myRecord.slice(0,-1)+"</td><td><button item='"+myRecord+"' onclick=deleteHistoryItem(this)>X</button></td></tr>";
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
    // if the user clicks on one of the recent searches
        $("#clockTable").on('click','.search-username',function(){
        // get the current row
          var currentRow=$(this).closest("tr");

          var Username = currentRow.find("td:eq(1)").text(); // get current row 2nd TD
          var icon = currentRow.find(".search-type"); // get the src of the icon to determine what kind of search it is
          var src = $(icon).attr('src'); 
          
          if (src === "Icons/magnifying-glass.png") { // if it is not a username search
            var xmlhttp = new XMLHttpRequest();

            //adds the search to the database and stores the result of the search in a session variable
            xmlhttp.open("GET", "searchAllUsers.php?RecentUsername=" + Username, true);
            xmlhttp.send();
            window.open("searchResults.php","_self");
          }
          
          else {
            var xmlhttp = new XMLHttpRequest();
            // stores the userID and username of the clicked user in session and adds the search to the database
            xmlhttp.open("GET", "getOtherUserClocks.php?Username=" + Username, true);
            xmlhttp.send();
            window.open("otherProfile.php","_self");
          }

        });
      });
    
    </script>
    <script>
      // removes all the items stored in localStorage from landing
      deleteLocalStorageLanding();
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

      <form autocomplete="off" action="searchAllUsers.php" method="post">
        <input id="userSearch" type="text" name="search" placeholder="Search" required>
        <button type="submit">🔍</button>
      </form>

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
              <a href="updateEmail.php">Change Email</a>
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
          <th></th>
          <th id="searchHeading">Recents</th>
          <th id="clearButton">
            <button onclick="clearHistory()">Clear</button>
          </th>
        </tr>
      </thead>
      <tbody id="resultRows">
      </tbody>
    </table>
    </div>
  
  <script>

  inp = document.getElementById("userSearch");
  if (inp) { // if something is entered in the search bar
    inp.addEventListener("input", function(e) {
      var val = this.value;
      if (val.length > 0) {
        document.getElementById("searchHeading").innerHTML = "Username"; // change the heading from recents to Username
        document.getElementById("clearButton").innerHTML = ""; // change the other heading from the clear button to an empty string
        autocomplete(val); // call the autocomplete function
        $(document).ready(function(){

            
            // code to read selected table row cell data (values).
          $("#clockTable").on('click','.autocomplete-table-row',function(){
            // get the current row
            var currentRow=$(this).closest("tr");

            var Username=currentRow.find("td:eq(1)").text(); // get current row 2nd TD
            var xmlhttp = new XMLHttpRequest();
            // stores the userID and username of the clicked user in session and adds the search to the database
            xmlhttp.open("GET", "getOtherUserClocks.php?Username=" + Username, true);
            xmlhttp.send();
            window.open("otherProfile.php","_self");
          });
        });
      }
      else { // when the value of the search bar is empty
        document.getElementById("searchHeading").innerHTML = "Recents";
        document.getElementById("clearButton").innerHTML = "<button onclick='clearHistory()'>Clear</button>";
        var xmlhttp = new XMLHttpRequest();
        // display recent searches
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myRecords = JSON.parse(this.responseText);
                var rows = "";
                for (i=0;i<myRecords.length;i++) {
                    var myRecord = myRecords[i];
                    myRecord = myRecord.replaceAll("'","&#39;");
                    myRecord = myRecord.replaceAll(">","&#62;");
                    myRecord = myRecord.replaceAll("\\","&#92;");
                    myRecord = myRecord.replaceAll("<","&#60;");

                    var type = myRecord.slice(-1);
                    var icon;
                    if (type == 0) {
                      icon = "Icons/magnifying-glass.png";
                    }
                    else {
                      icon = "Icons/user.png";
                    }
        
                    var newRow = "<tr class='table-row-clickable'><td class='search-username'><img class='search-type' src='"+icon+"' width='30' height='30'></td><td class='search-username' id='recent"+i+"' >"+myRecord.slice(0,-1)+"</td><td><button item='"+myRecord+"' onclick=deleteHistoryItem(this)>X</button></td></tr>";
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
    // displays all the users that are not the current user that start with val
    var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var myRecords = JSON.parse(this.responseText);
          var rows = "";
          for (i=0;i<myRecords.length;i++) {
            if (myRecords[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
              var myRecord = myRecords[i];
              var newRow = "<tr class='autocomplete-table-row'><td><img class='search-type' src='Icons/user.png' width='30' height='30'></td><td>"+myRecord+"</td><td></td></tr>";
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
  function clearHistory() { // removes all the recent searches
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "clearHistory.php", true);
    xmlhttp.send();
    document.getElementById("resultRows").innerHTML = "";
  }
</script>
<script>
  function deleteHistoryItem(element) { // removes one search item
    item = element.getAttribute('item');
    row = element.parentNode.parentNode; // row that the button is on
    i = row.rowIndex; // index that the row is on in the table

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "deleteHistoryItem.php?item="+item, true);
    xmlhttp.send();
    document.getElementsByClassName('search-type')[i-1].style.display = 'none'; // sets the display of the search type image to none
    element.style.display = 'none'; // sets the display of the delete button to none
    row.className = "deleting"; // sets the row to its deleting class to make them disappear smoothly
    window.setTimeout(function() {
      // animation takes 400 ms so deletes the row after 800 ms to ensure animation is done
          row.parentNode.removeChild(row);
      }, 800);

  }
</script>
  </body>
</html>
