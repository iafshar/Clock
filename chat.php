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
                var premium = (myRecords.Premium == 1);
                document.getElementById("messageHeading").innerHTML = myRecords.otherUsername;
                document.getElementById("messageBody").innerHTML = "<td><table><tr><textarea id='messageText' style='height:100px;width:1400px;font-size:30px;' name='message' placeholder='Message'></textarea></tr><tr><input type='submit' style='width:1400px;height:45px;' value='Enter' onclick=sendMessage('"+myRecords.otherUsername+"')></tr></table></td>";
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
                            if (myRecord.Type == 1) { 
                              if (myUserID != myRecord.UserID) { // prevents user from being linked to their own profile page but from another perspective
                                if (myRecord.Shared == 1) {
                                  if (premium) {
                                    newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td><table><tr><td><b><a href='otherProfile.php?clickedUserID="+myRecord.UserID+"' style='color:black'>"+myRecord.Username+"</a></b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?1"+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick()></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"','"+countClocks+"')><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton-"+myRecord.Content[0]+"' onclick=like("+myRecord.Content[0]+") style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton-"+myRecord.Content[0]+"' onclick=dislike("+myRecord.Content[0]+") style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td class=numLikes-"+myRecord.Content[0]+">"+myRecord.NumOfLikes+"</td><td class=numDislikes-"+myRecord.Content[0]+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><textarea id=commentBox-"+i+" style='height:195px;width:400px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View All</button><input type='submit' style='width:200px;height:45px;' value='Enter' onclick=addComment('"+myRecord.Content[0]+"','"+i+"')></td></tr></table></td></tr>";
                                  }
                                  else {
                                    newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td><table><tr><td><b><a href='otherProfile.php?clickedUserID="+myRecord.UserID+"' style='color:black'>"+myRecord.Username+"</a></b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?1"+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick()></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"','"+countClocks+"')><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton-"+myRecord.Content[0]+"' onclick=like("+myRecord.Content[0]+") style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton-"+myRecord.Content[0]+"' onclick=dislike("+myRecord.Content[0]+") style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td class=numLikes-"+myRecord.Content[0]+">"+myRecord.NumOfLikes+"</td><td class=numDislikes-"+myRecord.Content[0]+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View Comments</button></td></tr></table></td></tr>";
                                  }
                                }
                                else {
                                  if (premium) {
                                    newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td><table><tr><td><b><a href='otherProfile.php?clickedUserID="+myRecord.UserID+"' style='color:black'>"+myRecord.Username+"</a></b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?1"+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick()></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"','"+countClocks+"')><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton-"+myRecord.Content[0]+"' onclick=like("+myRecord.Content[0]+") style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton-"+myRecord.Content[0]+"' onclick=dislike("+myRecord.Content[0]+") style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td class=numLikes-"+myRecord.Content[0]+">"+myRecord.NumOfLikes+"</td><td class=numDislikes-"+myRecord.Content[0]+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><textarea id=commentBox-"+i+" style='height:195px;width:400px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View All</button><input type='submit' style='width:200px;height:45px;' value='Enter' onclick=addComment('"+myRecord.Content[0]+"','"+i+"')></td></tr></table></td></tr>";
                                  }
                                  else {
                                    newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td><table><tr><td><b><a href='otherProfile.php?clickedUserID="+myRecord.UserID+"' style='color:black'>"+myRecord.Username+"</a></b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?1"+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick()></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"','"+countClocks+"')><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton-"+myRecord.Content[0]+"' onclick=like("+myRecord.Content[0]+") style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton-"+myRecord.Content[0]+"' onclick=dislike("+myRecord.Content[0]+") style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td class=numLikes-"+myRecord.Content[0]+">"+myRecord.NumOfLikes+"</td><td class=numDislikes-"+myRecord.Content[0]+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View Comments</button></td></tr></table></td></tr>";
                                  }
                                }
                              }
                              else {
                                if (premium) {
                                  newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td><table><tr><td><b>"+myRecord.Username+"</b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?1"+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick()></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"','"+countClocks+"')><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td></td></tr><tr><td height=225></td></tr><tr><td><img border='0' src='Icons/like.png' width='40' height='40'></td><td><img border='0' src='Icons/dislike.png' width='40' height='40'></td><tr><td>"+myRecord.NumOfLikes+"</td><td>"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><textarea id=commentBox-"+i+" style='height:195px;width:400px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View All</button><input type='submit' style='width:200px;height:45px;' value='Enter' onclick=addComment('"+myRecord.Content[0]+"','"+i+"')></td></tr></table></td></tr>";
                                } 
                                else {
                                  newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td><table><tr><td><b>"+myRecord.Username+"</b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?1"+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick()></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"','"+countClocks+"')><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td></td></tr><tr><td height=225></td></tr><tr><td><img border='0' src='Icons/like.png' width='40' height='40'></td><td><img border='0' src='Icons/dislike.png' width='40' height='40'></td><tr><td>"+myRecord.NumOfLikes+"</td><td>"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View Comments</button></td></tr></table></td></tr>";
                                }
                              }
                              countClocks += 1;
                            }
                            else {
                              newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td><strong>Sent</strong><br>"+myRecord.DateSent+"</td><td></td><td>"+myRecord.Content+"</td></tr>";
                            }
                          }
                          else {
                            if (myRecord.Type == 1) {
                              
                              if (myUserID != myRecord.UserID) {
                                if (premium) {
                                  newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td><table><tr><td><b><a href='otherProfile.php?clickedUserID="+myRecord.UserID+"' style='color:black'>"+myRecord.Username+"</a></b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?1"+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick()></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"','"+countClocks+"')><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton-"+myRecord.Content[0]+"' onclick=like("+myRecord.Content[0]+") style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton-"+myRecord.Content[0]+"' onclick=dislike("+myRecord.Content[0]+") style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td class=numLikes-"+myRecord.Content[0]+">"+myRecord.NumOfLikes+"</td><td class=numDislikes-"+myRecord.Content[0]+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><textarea id=commentBox-"+i+" style='height:195px;width:400px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View All</button><input type='submit' style='width:200px;height:45px;' value='Enter' onclick=addComment('"+myRecord.Content[0]+"','"+i+"')></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td></tr>";
                                } 
                                else {
                                  newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td><table><tr><td><b><a href='otherProfile.php?clickedUserID="+myRecord.UserID+"' style='color:black'>"+myRecord.Username+"</a></b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?1"+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick()></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"','"+countClocks+"')><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td><button class='remixClock' onclick=remixClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/music.png' width='40' height='40'></button></td></tr><tr><td height=225></td></tr><tr><td><button class='likeButton-"+myRecord.Content[0]+"' onclick=like("+myRecord.Content[0]+") style='background-color: "+myRecord.LikeColor+";'><img border='0' src='Icons/like.png' width='40' height='40'></button></td><td><button class='dislikeButton-"+myRecord.Content[0]+"' onclick=dislike("+myRecord.Content[0]+") style='background-color: "+myRecord.DislikeColor+";'><img border='0' src='Icons/dislike.png' width='40' height='40'></button></td><tr><td class=numLikes-"+myRecord.Content[0]+">"+myRecord.NumOfLikes+"</td><td class=numDislikes-"+myRecord.Content[0]+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View Comments</button></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td></tr>";
                                }
                              }
                              else {
                                if (premium) {
                                  newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td><table><tr><td><b>"+myRecord.Username+"</b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?1"+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick()></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"','"+countClocks+"')><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td></td></tr><tr><td height=225></td></tr><tr><td><img border='0' src='Icons/like.png' width='40' height='40'></td><td><img border='0' src='Icons/dislike.png' width='40' height='40'></td><tr><td class=numLikes-"+myRecord.Content[0]+">"+myRecord.NumOfLikes+"</td><td class=numDislikes-"+myRecord.Content[0]+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><textarea id=commentBox-"+i+" style='height:195px;width:400px;font-size:30px;' name='comment' placeholder='Comment'></textarea></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View All</button><input type='submit' style='width:200px;height:45px;' value='Enter' onclick=addComment('"+myRecord.Content[0]+"','"+i+"')></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td></tr>";
                                } 
                                else {
                                  newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td><table><tr><td><b>"+myRecord.Username+"</b></td></tr><tr><td>"+myRecord.Name+"</td></tr><tr><td><iframe src='Clock_ReadOnlySmall/index.html?1"+myRecord.Content[0]+"' loading='lazy' id='miniClock' width=410 height=205 onload=iframeclick()></iframe><br>"+myRecord.Content[1]+"</td></tr><tr><td><i>"+myRecord.Date+"</i></td></tr></table></td><td><table><tr><td><button class='viewClock' onclick=openClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/expand.png' width='40' height='40'></button></td><td><button class='changeSound' onclick=changeSound('"+myRecord.Content[0]+"','"+countClocks+"')><img border='0' src='Icons/mute.png' class='sound-icon' width='40' height='40'></button></td><td><button class='sendClock' onclick=sendClock('"+myRecord.Content[0]+"')><img border='0' src='Icons/inbox.png' width='40' height='40'></button></td><td></td></tr><tr><td height=225></td></tr><tr><td><img border='0' src='Icons/like.png' width='40' height='40'></td><td><img border='0' src='Icons/dislike.png' width='40' height='40'></td><tr><td class=numLikes-"+myRecord.Content[0]+">"+myRecord.NumOfLikes+"</td><td class=numDislikes-"+myRecord.Content[0]+">"+myRecord.NumOfDislikes+"</td></tr></table></td><td><table><tr><td height=70></td></tr><tr><td><button type='button' class='viewComments' style='width:200px;height:45px;' onclick=openComments('"+myRecord.Content[0]+"')>View Comments</button></td></tr><tr><td><strong>Sent</strong><br><i>"+myRecord.DateSent+"</i></td></tr></table></td></tr>";
                                }
                              }
                              countClocks += 1;
                            }
                            else {
                              newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td>"+myRecord.Content+"</td><td></td><td><strong>Sent</strong><br>"+myRecord.DateSent+"</td></tr>";
                            }              
                          }
                                             
                          rows = rows+newRow;
                      }
                  }
                }
                document.getElementById("resultRows").innerHTML = rows;
            }
        };
      xmlhttp.open("GET", "intermediateMessages.php", true);
      xmlhttp.send();



    </script>
    <script>
      function like(clockID) {
        $.ajax({
          type: 'post',
          url: 'addVote.php',
          data: {
            location:'chat.php',
            clockID:clockID,
            dislike:0
          },
          success: function (response) {
            buttons = document.getElementsByClassName("likeButton-"+clockID);
            nums = document.getElementsByClassName("numLikes-"+clockID);
            for (let i = 0; i < buttons.length; i++) {
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

      function dislike(clockID) {
        $.ajax({
          type: 'post',
          url: 'addVote.php',
          data: {
            location:'chat.php',
            clockID:clockID,
            dislike:1
          },
          success: function (response) {
            buttons = document.getElementsByClassName("dislikeButton-"+clockID);
            nums = document.getElementsByClassName("numDislikes-"+clockID);
            for (let i = 0; i < buttons.length; i++) {
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

      function openClock(clockID) {
        window.open('Clock_ReadOnly/index.html?'+clockID,'_self');
      }

      function changeSound(clockID,countClocks) {
        for (let i = 0; i < document.getElementsByTagName("iframe").length; i++) {
          if (document.getElementsByTagName("iframe")[i].src == "http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?1"+clockID && i == countClocks) {
            document.getElementsByTagName("iframe")[i].src = "http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?0"+clockID;
            document.getElementsByClassName("sound-icon")[i].src = "Icons/volume.png";
          }
          else if (document.getElementsByTagName("iframe")[i].src == "http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?0"+clockID && i == countClocks) {
            document.getElementsByTagName("iframe")[i].src = "http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?1"+clockID;
            document.getElementsByClassName("sound-icon")[i].src = "Icons/mute.png";
            break;
          }
          else {
            var source = document.getElementsByTagName("iframe")[i].src
            var index = source.indexOf("?") + 1;
            if (source.charAt(index) == "0") {
              document.getElementsByTagName("iframe")[i].src = source.substring(0,index) + "1" + source.substring(index + 1);
              document.getElementsByClassName("sound-icon")[i].src = "Icons/mute.png";
            }
          }
        }
      }

      function openComments(clockID) {
        window.open('comments.html?'+clockID,'_self');
      }

      function sendClock(clockID) {
        window.open('chooseReceiver.php?'+clockID,'_self');
      }

      function remixClock(clockID) {
        window.open('checkClockLimit.php?clockID='+clockID,'_self');
      }

      function checkBack() {
        if (document.referrer.substring(0,28) == "http://localhost:8080/Clock/") {
          history.back();
        }
      }

      function addComment(clockID,rowID) {
        comment = document.getElementById("commentBox-"+rowID);
        $.ajax({
          type: 'post',
          url: 'addComment.php',
          data: {
            clockID:clockID,
            comment:comment.value
          },
          success: function () {
            comment.value = "";
          }
        });
      }

      function sendMessage(sender) {
        message = document.getElementById("messageText");
        $.ajax({
          type: 'post',
          url: 'sendMessageInbox.php',
          data: {
            Sender:sender,
            message:message.value
          },
          success: function (response) {
            var myRecords = JSON.parse(response);
            myRecord = myRecords.Messages[0];
            newRow = "<tr class='table-row' style='background-color:"+myRecord.Color+"'><td>"+myRecord.Content+"</td><td></td><td><strong>Sent</strong><br>"+myRecord.DateSent+"</td></tr>";
            rows = newRow + document.getElementById("resultRows").innerHTML;
            document.getElementById("resultRows").innerHTML = rows;
            message.value = "";
          }
        });
      }
    </script>
    <script>
      function iframeclick() {
        iframes = document.getElementsByTagName("iframe");
        for (let i = 0; i < iframes.length; i++) {
          iframes[i].contentWindow.document.body.onclick = function() {
            var source = iframes[i].src;
            var index = source.indexOf("?") + 2;
            openClock(source.substring(index));
          }
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