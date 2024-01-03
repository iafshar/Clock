function checkBack() { // for the back button
    if (document.referrer.substring(0,28) == "http://localhost:8080/Clock/") { // only takes you back to pages that are still part of the app
      history.back();
    }
}


function remixClock(clockID) {
    window.open('checkClockLimit.php?clockID='+clockID,'_self');
}

function sendClock(clockID) {
    window.open('chooseReceiver.php?'+clockID,'_self');
}

function openComments(clockID) {
    window.open('comments.php?'+clockID,'_self');
}

function changeSound(clockID,rowID) { // mutes/unmutes a clock
    for (let i = 0; i < document.getElementsByTagName("iframe").length; i++) {
      if (document.getElementsByTagName("iframe")[i].src == "http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?rowID="+rowID+"clockID="+clockID) { // finds the iframe to change the sound of
        if (localStorage.getItem("muteRow"+rowID)) { // if a key called muteRow followed by the rowID of the iframe is in localStorage
          localStorage.removeItem("muteRow"+rowID); // remove it from local storage
          document.getElementsByClassName("sound-icon")[i].src = "Icons/mute.png";
          break;
        }
        else {
          localStorage.setItem("muteRow"+rowID,0); // add it to local storage
          document.getElementsByClassName("sound-icon")[i].src = "Icons/volume.png";
        }
      }
      else { // mute all the other iframes
        var source = document.getElementsByTagName("iframe")[i].src
        var rowIDIndex = source.indexOf("rowID=");
        rowIDIndex += 6;
        var clockIDIndex = source.indexOf("clockID="); 
        var newRowID = source.substring(rowIDIndex,clockIDIndex);
        localStorage.removeItem("muteRow"+newRowID);
        document.getElementsByClassName("sound-icon")[i].src = "Icons/mute.png";
      }
    }
}

function setUnreadCount() {
  // add the number of unread chats to the inbox icon
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("chats").innerHTML += JSON.parse(this.responseText);
      }
      
    };

    
    xmlhttp.open("GET", "http://localhost:8080/Clock/countUnreadMessages.php", true);
    xmlhttp.send();
}

function openClock(clockID,mine=false) {
    if (mine) {
      window.open('Clock_User/index.php?'+clockID,'_self');
    } else {
      window.open('Clock_ReadOnly/index.php?'+clockID,'_self');
    }
}

function iframeclick(elem,mine=false) { // called on load of all of the iframes
    elem.contentWindow.document.body.onclick = function() {
      var source = elem.src;
      var index = source.indexOf("clockID=") + 8;
      openClock(source.substring(index),mine);
    }
}

function like(clockID,elem) {
    numLikes = document.getElementById("numLikes-"+clockID); // get the number of likes associated with this like button
    $.ajax({
      type: 'post',
      url: 'addVote.php',
      data: {
        clockID:clockID,
        dislike:0
      },
      success: function (response) {
        if (response == 0) { // if a like has been removed
          numLikes.innerHTML = parseInt(numLikes.innerHTML) - 1; 
          elem.style.backgroundColor = "#efefef";
        }
        else { // if a like has been added
          numLikes.innerHTML = parseInt(numLikes.innerHTML) + 1;
          elem.style.backgroundColor = "#f39faa";
        }
        
      }
    });
}

function dislike(clockID,elem) {
    numDislikes = document.getElementById("numDislikes-"+clockID); // get the number of dislikes associated with this dislike button
    $.ajax({
      type: 'post',
      url: 'addVote.php',
      data: {
        clockID:clockID,
        dislike:1
      },
      success: function (response) {
        if (response == 0) { // if a dislike has been removed
          numDislikes.innerHTML = parseInt(numDislikes.innerHTML) - 1;
          elem.style.backgroundColor = "#efefef";
        }
        else { // if a dislike has been added
          numDislikes.innerHTML = parseInt(numDislikes.innerHTML) + 1;
          elem.style.backgroundColor = "#f39faa";
        }
        
      }
    });
}

function addComment(clockID,rowID=-1) {
  // rowID will only be used for chat because there can be many rows of the same clock so that will be the only time it will be greater than or equal to 0

    if (rowID <= 0) { 
        comment = document.getElementById("commentBox-"+clockID);
    }
    else {
        comment = document.getElementById("commentBox-"+rowID);
    }
    $.ajax({
      type: 'post',
      url: 'addComment.php',
      data: {
        clockID:clockID,
        comment:comment.value
      },
      success: function () {
        comment.value = ""; // clear the comment box
      }
    });
}

function deleteAccount() {
    var ensure = confirm("Are you sure you want to deactivate your account? Your clocks will be permanently deleted.");
    if (ensure) {
      window.open('deleteAccount.php','_self');
    }
}

function updateAccount(elem,display=false) {
  $.ajax({
    type: 'post',
    url: 'updateAccount.php',
    success: function (response) {
      if (response == 1) {
        elem.innerHTML = "Downgrade To Basic";
      }
      else {
        elem.innerHTML = "Upgrade To Premium";
      }
      rows = display();
    }
  });
}