<?php 
session_start();?>

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
  </head>
  <body>
    <div class="topnav">
      <a href="feed.html"><img border="0" src="Icons/house.png" width="30" height="30"></a>
      <a href="discover.html"><img border="0" src="Icons/compass.png" width="30" height="30"></a>
      <a href="checkClockLimit.php"><img border="0" src="Icons/music.png" width="30" height="30"></a>
      <a href="myClocks.php"><img border="0" src="Icons/user.png" width="30" height="30"></a>
      <a href="inbox.php"><img border="0" src="Icons/inbox.png" width="30" height="30"></a>
      <a href="search.php"><img border="0" src="Icons/magnifying-glass.png" width="30" height="30"></a>
      <a href="start.php" class="logoutBtn">Logout</a>
  </div>
  </body>
  <table class="table" id="clockTable">
      <thead class="thead-light">
        <tr>
          <th><?php
            echo $_SESSION["SearchedUsername"]; ?></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody id="resultRows">
        <td>
            <form action="sendMessage.php" method='post'>
                <textarea rows='2' cols='100' name='message' placeholder='Message'></textarea>
                <input type='submit' value='Enter'>
            </form>
        </td>
        
      </tbody>
    </table>
</html>
