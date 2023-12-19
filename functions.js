function checkBack() {
    if (document.referrer.substring(0,28) == "http://localhost:8080/Clock/") {
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

function changeSound(clockID,rowID) {
    for (let i = 0; i < document.getElementsByTagName("iframe").length; i++) {
      if (document.getElementsByTagName("iframe")[i].src == "http://localhost:8080/Clock/Clock_ReadOnlySmall/index.html?rowID="+rowID+"clockID="+clockID) {
        if (localStorage.getItem("muteRow"+rowID)) {
          localStorage.removeItem("muteRow"+rowID);
          document.getElementsByClassName("sound-icon")[i].src = "Icons/mute.png";
          break;
        }
        else {
          localStorage.setItem("muteRow"+rowID,0);
          document.getElementsByClassName("sound-icon")[i].src = "Icons/volume.png";
        }
      }
      else {
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
      window.open('Clock_User/index.html?'+clockID,'_self');
    } else {
      window.open('Clock_ReadOnly/index.html?'+clockID,'_self');
    }
}

function iframeclick(elem,mine=false) {
    elem.contentWindow.document.body.onclick = function() {
      var source = elem.src;
      var index = source.indexOf("clockID=") + 8;
      openClock(source.substring(index),mine);
    }
}

function like(clockID,elem) {
    numLikes = document.getElementById("numLikes-"+clockID);
    $.ajax({
      type: 'post',
      url: 'addVote.php',
      data: {
        location:window.location.href,
        clockID:clockID,
        dislike:0
      },
      success: function (response) {
        if (response == 0) {
          numLikes.innerHTML = parseInt(numLikes.innerHTML) - 1;
          elem.style.backgroundColor = "#efefef";
        }
        else {
          numLikes.innerHTML = parseInt(numLikes.innerHTML) + 1;
          elem.style.backgroundColor = "#f39faa";
        }
        
      }
    });
}

function dislike(clockID,elem) {
    numDislikes = document.getElementById("numDislikes-"+clockID);
    $.ajax({
      type: 'post',
      url: 'addVote.php',
      data: {
        location:window.location.href,
        clockID:clockID,
        dislike:1
      },
      success: function (response) {
        if (response == 0) {
          numDislikes.innerHTML = parseInt(numDislikes.innerHTML) - 1;
          elem.style.backgroundColor = "#efefef";
        }
        else {
          numDislikes.innerHTML = parseInt(numDislikes.innerHTML) + 1;
          elem.style.backgroundColor = "#f39faa";
        }
        
      }
    });
}

function addComment(clockID,rowID=-1) {
    if (rowID < 0) {
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
        comment.value = "";
      }
    });
}

function deleteAccount() {
    var ensure = confirm("Are you sure you want to deactivate your account? Your clocks will be permanently deleted.");
    if (ensure) {
      window.open('deleteAccount.php','_self');
    }
}