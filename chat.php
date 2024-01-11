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
      
      function displayChat() {
        var toUsername = "";
        if(window.location.href.indexOf("?") > -1) {
          toUsername = window.location.search.substring(1); // the username of the user that the current user is chatting with
        }

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  var myRecords = JSON.parse(this.responseText);
                  
                  var premium = (myRecords.Premium == 1);
                  document.getElementById("messageHeading").innerHTML = "<a href='otherProfile.php?clickedUserID="+myRecords.otherUserID+"' style='color:black'>"+myRecords.otherUsername+"</a>";
                  console.log(myRecords);
                  
                  // message box
                  document.getElementById("messageBody").innerHTML = "<td><table><tr><textarea id='messageText' style='height:100px;font-size:30px;' name='message' placeholder='Message'></textarea></tr><tr><button type='submit' style='width:100%;height:45px;' onclick=sendMessage('"+myRecords.otherUsername+"')>Enter</button></tr></table></td>";
                  var rows = "";
                  if (myRecords) {
                    if (myRecords.Messages) {
                        myUserID = myRecords.myUserID;
                        var countClocks = 0; // since you can send the same clock over and over again, this is to keep track of which one to mute/unmute
                        for (i=0;i<myRecords.Messages.length;i++) {
                            var myRecord = myRecords.Messages[i];
                            var newRow = "";
                            myRecord.Date = new Date(myRecord.Date);
                            myRecord.Date = myRecord.Date.toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric", hour:"numeric", minute:"numeric", second:"numeric"});
                            myRecord.DateSent = new Date(myRecord.DateSent);
                            myRecord.DateSent = myRecord.DateSent.toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric", hour:"numeric", minute:"numeric", second:"numeric"});
                            if (myRecord.sentByMe == 0) {
                              if (myRecord.Type == 1) { // if the message is a clock
                                if (myUserID != myRecord.UserID) { // prevents user from being linked to their own profile page but from another perspective
                                  if (myRecord.Shared == 1) {
                                    if (premium) {
                                      newRow = "<tr class='table-row-to-me'><td><table><tr><td><b><a href='otherProfile.php?clickedUserID="+myRecord.UserID+"' style='color:black'>"+myRecord.Username+"</a></b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick(this)></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton-"+myRecord.Content[0]+"' onclick=likeChat("+myRecord.Content[0]+") style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton-"+myRecord.Content[0]+"' onclick=dislikeChat("+myRecord.Content[0]+") style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td class=numLikes-"+myRecord.Content[0]+">"+myRecord.NumOfLikes+"</td><td class=numDislikes-"+myRecord.Content[0]+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><textarea id=commentBox-"+i+" style='height:195px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><button type='button' class='viewComments' style='width:50%;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View All</button><button type='submit' style='width:50%;height:45px;' onclick=addComment('"+myRecord.Content[0]+"','"+i+"')>Enter</button></td></tr></table></td></tr>";
                                    }
                                    else {
                                      newRow = "<tr class='table-row-to-me'><td><table><tr><td><b><a href='otherProfile.php?clickedUserID="+myRecord.UserID+"' style='color:black'>"+myRecord.Username+"</a></b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick(this)></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton-"+myRecord.Content[0]+"' onclick=likeChat("+myRecord.Content[0]+") style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton-"+myRecord.Content[0]+"' onclick=dislikeChat("+myRecord.Content[0]+") style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td class=numLikes-"+myRecord.Content[0]+">"+myRecord.NumOfLikes+"</td><td class=numDislikes-"+myRecord.Content[0]+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><button type='button' class='viewComments' style='width:100%;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View Comments</button></td></tr></table></td></tr>";
                                    }
                                  }
                                  else {
                                    if (premium) {
                                      newRow = "<tr class='table-row-to-me'><td><table><tr><td><b><a href='otherProfile.php?clickedUserID="+myRecord.UserID+"' style='color:black'>"+myRecord.Username+"</a></b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick(this)></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton-"+myRecord.Content[0]+"' onclick=likeChat("+myRecord.Content[0]+") style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton-"+myRecord.Content[0]+"' onclick=dislikeChat("+myRecord.Content[0]+") style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td class=numLikes-"+myRecord.Content[0]+">"+myRecord.NumOfLikes+"</td><td class=numDislikes-"+myRecord.Content[0]+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><textarea id=commentBox-"+i+" style='height:195px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><button type='button' class='viewComments' style='width:50%;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View All</button><button type='submit' style='width:50%;height:45px;' onclick=addComment('"+myRecord.Content[0]+"','"+i+"')>Enter</button></td></tr></table></td></tr>";
                                    }
                                    else {
                                      newRow = "<tr class='table-row-to-me'><td><table><tr><td><b><a href='otherProfile.php?clickedUserID="+myRecord.UserID+"' style='color:black'>"+myRecord.Username+"</a></b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick(this)></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton-"+myRecord.Content[0]+"' onclick=likeChat("+myRecord.Content[0]+") style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton-"+myRecord.Content[0]+"' onclick=dislikeChat("+myRecord.Content[0]+") style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td class=numLikes-"+myRecord.Content[0]+">"+myRecord.NumOfLikes+"</td><td class=numDislikes-"+myRecord.Content[0]+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><button type='button' class='viewComments' style='width:100%;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View Comments</button></td></tr></table></td></tr>";
                                    }
                                  }
                                }
                                else {
                                  if (premium) {
                                    newRow = "<tr class='table-row-to-me'><td><table><tr><td><b>"+myRecord.Username+"</b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick(this,true)></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"',true)><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td></td></tr><tr><td height=225></td></tr><tr><td><img border='0' src='Icons/like.png' width='40' height='40'></td><td><img border='0' src='Icons/dislike.png' width='40' height='40'></td><tr><td>"+myRecord.NumOfLikes+"</td><td>"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><textarea id=commentBox-"+i+" style='height:195px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><button type='button' class='viewComments' style='width:50%;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View All</button><button type='submit' style='width:50%;height:45px;' onclick=addComment('"+myRecord.Content[0]+"','"+i+"')>Enter</button></td></tr></table></td></tr>";
                                  } 
                                  else {
                                    newRow = "<tr class='table-row-to-me'><td><table><tr><td><b>"+myRecord.Username+"</b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick(this,true)></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"',true)><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td></td></tr><tr><td height=225></td></tr><tr><td><img border='0' src='Icons/like.png' width='40' height='40'></td><td><img border='0' src='Icons/dislike.png' width='40' height='40'></td><tr><td>"+myRecord.NumOfLikes+"</td><td>"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><button type='button' class='viewComments' style='width:100%;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View Comments</button></td></tr></table></td></tr>";
                                  }
                                }
                                countClocks += 1;
                              }
                              else {
                                newRow = "<tr class='table-row-to-me'><td><strong>Sent</strong><br>"+myRecord.DateSent+"</td><td></td><td>"+myRecord.Content+"</td></tr>";
                              }
                            }
                            else {
                              if (myRecord.Type == 1) { // if the message is a clock
                                
                                if (myUserID != myRecord.UserID) {
                                  if (premium) {
                                    newRow = "<tr class='table-row-from-me'><td><table><tr><td><b><a href='otherProfile.php?clickedUserID="+myRecord.UserID+"' style='color:black'>"+myRecord.Username+"</a></b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick(this)></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton-"+myRecord.Content[0]+"' onclick=likeChat("+myRecord.Content[0]+") style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton-"+myRecord.Content[0]+"' onclick=dislikeChat("+myRecord.Content[0]+") style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td class=numLikes-"+myRecord.Content[0]+">"+myRecord.NumOfLikes+"</td><td class=numDislikes-"+myRecord.Content[0]+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70><button type='button' class='deleteMessage' onclick=deleteMessage('"+myRecord.MessageID+"',this)><img border='0' src='Icons/trash.png' width='20' height='20'></button></td></tr><tr><td><textarea id=commentBox-"+i+" style='height:195px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><button type='button' class='viewComments' style='width:50%;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View All</button><button type='submit' style='width:50%;height:45px;' onclick=addComment('"+myRecord.Content[0]+"','"+i+"')>Enter</button></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td></tr>";
                                  } 
                                  else {
                                    newRow = "<tr class='table-row-from-me'><td><table><tr><td><b><a href='otherProfile.php?clickedUserID="+myRecord.UserID+"' style='color:black'>"+myRecord.Username+"</a></b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick(this)></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton-"+myRecord.Content[0]+"' onclick=likeChat("+myRecord.Content[0]+") style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton-"+myRecord.Content[0]+"' onclick=dislikeChat("+myRecord.Content[0]+") style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td class=numLikes-"+myRecord.Content[0]+">"+myRecord.NumOfLikes+"</td><td class=numDislikes-"+myRecord.Content[0]+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70><button type='button' class='deleteMessage' onclick=deleteMessage('"+myRecord.MessageID+"',this)><img border='0' src='Icons/trash.png' width='20' height='20'></button></td></tr><tr><td><button type='button' class='viewComments' style='width:100%;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View Comments</button></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td></tr>";
                                  }
                                }
                                else {
                                  if (premium) {
                                    newRow = "<tr class='table-row-from-me'><td><table><tr><td><b>"+myRecord.Username+"</b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick(this,true)></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"',true)><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td></td></tr><tr><td height=225></td></tr><tr><td><img border='0' src='Icons/like.png' width='40' height='40'></td><td><img border='0' src='Icons/dislike.png' width='40' height='40'></td><tr><td class=numLikes-"+myRecord.Content[0]+">"+myRecord.NumOfLikes+"</td><td class=numDislikes-"+myRecord.Content[0]+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70><button type='button' class='deleteMessage' onclick=deleteMessage('"+myRecord.MessageID+"',this)><img border='0' src='Icons/trash.png' width='20' height='20'></button></td></tr><tr><td><textarea id=commentBox-"+i+" style='height:195px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><button type='button' class='viewComments' style='width:50%;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View All</button><button type='submit' style='width:50%;height:45px;' onclick=addComment('"+myRecord.Content[0]+"','"+i+"')>Enter</button></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td></tr>";
                                  } 
                                  else {
                                    newRow = "<tr class='table-row-from-me'><td><table><tr><td><b>"+myRecord.Username+"</b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?rowID="+i+"clockID="+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick(this,true)></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"',true)><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"',"+i+")><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td></td></tr><tr><td height=225></td></tr><tr><td><img border='0' src='Icons/like.png' width='40' height='40'></td><td><img border='0' src='Icons/dislike.png' width='40' height='40'></td><tr><td class=numLikes-"+myRecord.Content[0]+">"+myRecord.NumOfLikes+"</td><td class=numDislikes-"+myRecord.Content[0]+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70><button type='button' class='deleteMessage' onclick=deleteMessage('"+myRecord.MessageID+"',this)><img border='0' src='Icons/trash.png' width='20' height='20'></button></td></tr><tr><td><button type='button' class='viewComments' style='width:100%;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View Comments</button></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td></tr>";
                                  }
                                }
                                countClocks += 1;
                              }
                              else {
                                newRow = "<tr class='table-row-from-me'><td>"+myRecord.Content+"</td><td></td><td><table><tr><td><strong>Sent</strong><br>"+myRecord.DateSent+"<button type='button' class='deleteMessage' onclick=deleteMessage('"+myRecord.MessageID+"',this)><img border='0' src='Icons/trash.png' width='20' height='20'></button></td></tr></table></td></tr>";
                              } 
                                          
                            }            
                            rows = rows+newRow;
                            localStorage.removeItem("muteRow"+i); // if there are any previous muteRows with the current is, remove them to prevent them from affecting the sound values of the current iframes
                        }
                    }
                  }
                  document.getElementById("resultRows").innerHTML = rows;
              }
          };
        xmlhttp.open("GET", "getMessages.php?otherUsername="+toUsername, true);
        xmlhttp.send();
      }

      displayChat();

    </script>
    <script>
      function likeChat(clockID) { 
        $.ajax({
          type: 'post',
          url: 'addVote.php',
          data: {
            clockID:clockID,
            dislike:0
          },
          success: function (response) {
            buttons = document.getElementsByClassName("likeButton-"+clockID); // all the like buttons that are for the current clock
            nums = document.getElementsByClassName("numLikes-"+clockID); // all the numLikes of the current clock
            for (let i = 0; i < buttons.length; i++) { // changes the color of the like buttons and the values of the numLikes
              var button = buttons[i];
              var numLikes = nums[i];
              if (response == 0) {
                numLikes.innerHTML = parseInt(numLikes.innerHTML) - 1;
                button.style.backgroundColor = "#efefef";
              }
              else {
                numLikes.innerHTML = parseInt(numLikes.innerHTML) + 1;
                button.style.backgroundColor = "#f39faa";
              }
            }
          }
        });
      }

      function dislikeChat(clockID) {
        $.ajax({
          type: 'post',
          url: 'addVote.php',
          data: {
            clockID:clockID,
            dislike:1
          },
          success: function (response) {
            buttons = document.getElementsByClassName("dislikeButton-"+clockID); // all the dislike buttons that are for the current clock
            nums = document.getElementsByClassName("numDislikes-"+clockID);// all the numDislikes of the current clock
            for (let i = 0; i < buttons.length; i++) { // changes the color of the dislike buttons and the values of the numDislikes
              var button = buttons[i];
              var numDislikes = nums[i];
              if (response == 0) {
                numDislikes.innerHTML = parseInt(numDislikes.innerHTML) - 1;
                button.style.backgroundColor = "#efefef";
              }
              else {
                numDislikes.innerHTML = parseInt(numDislikes.innerHTML) + 1;
                button.style.backgroundColor = "#f39faa";
              }
            }
          }
        });
      }

      function sendMessage(sender) {
        message = document.getElementById("messageText"); // the message being sent
        $.ajax({
          type: 'post',
          url: 'sendMessageInbox.php',
          data: {
            toUsername:sender,
            message:message.value
          },
          success: function (response) {
            var myRecords = JSON.parse(response);
            myRecord = myRecords.Messages[0];
            myRecord.DateSent = new Date(myRecord.DateSent);
            myRecord.DateSent = myRecord.DateSent.toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric", hour:"numeric", minute:"numeric", second:"numeric"});
            newRow = "<tr class='table-row-from-me'><td>"+myRecord.Content+"</td><td></td><td><table><tr><td><strong>Sent</strong><br>"+myRecord.DateSent+"<button type='button' class='deleteMessage' onclick=deleteMessage('"+myRecord.MessageID+"',this)><img border='0' src='Icons/trash.png' width='20' height='20'></button></td></tr></table></td></tr>";
            rows = newRow + document.getElementById("resultRows").innerHTML; // adds a new row with the new message to the top of the chat
            document.getElementById("resultRows").innerHTML = rows;
            message.value = ""; // clears the message box
          }
        });
      }

      function deleteMessage(messageID,elem) {
        while (!elem.classList.contains('table-row-from-me')) { // sets elem to the row of the message
          // have to do it in a while loop because there are different levels for clock messages and normal ones
          elem = elem.parentNode;
        }
        i = elem.rowIndex; // which row the row of the message is in
        $.ajax({
          type: 'post',
          url: 'deleteMessage.php',
          data: {
            messageID:messageID,
            rowID:i-1 // minus one because the message box at the top takes up one row
          },
          success: function (response) { // deletes the row from the display
            document.getElementById("messageTable").deleteRow(i);
            console.log(JSON.parse(response));
          }
        });
      }
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
      <a class="active" href="inbox.php" id='chats' style='color:black'><img border="0" src="Icons/inbox.png" width="30" height="30"></a>
      <a href="search.php"><img border="0" src="Icons/magnifying-glass.png" width="30" height="30"></a>
      <div class="dropdown">
      <a><?php
            echo $_SESSION["Username"];
        ?></a>
      <div class="dropdown-content">
          <a onclick=updateAccount(this,displayChat)>
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

    setUnreadCount()

  </script>
  <div class="messageTable">
    <table class="table" id="messageBox">
    <thead class="thead-light">
      <tr>
      <th id="messageHeading">Username</th>
      </tr>
      
    </thead>
    <tbody id="messageBody">
      </tbody>
    </table>
    <table class="table" id="messageTable">
      <thead>
        <tr>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody id="resultRows">
        
      </tbody>
    </table>
    </div>
  </body>
</html>