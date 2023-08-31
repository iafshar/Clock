// function for naming your clock after you choose to save or share it for the first time
function naming(){
  background(255);
  fill(0,0,0);
  strokeWeight(1);
  stroke(0);
  textAlign(LEFT);
  text("Type to name your clock",width/2-textWidth("Type to name your clock")/2, 200);
  text(clockName,width/2-textWidth(clockName)/2,height/2);
  strokeWeight(4);
  line(160,height/2+10,width-160,height/2+10);
  if (keyIsDown(8) && deleteNameDelay == 100) {
    clockName = clockName.substring(0, clockName.length - 1);
    deleteNameDelay = 0;
  }
  else if (deleteNameDelay < 100) {

    deleteNameDelay += 20;
  }
  if (clockName.length > 0) {
    enterBtn.buttonColor = BLACK;
    enterBtn.hoverColor = GREY;
    clearBtn.buttonColor = BLACK;
    clearBtn.hoverColor = GREY;
  }
  else {
    enterBtn.buttonColor = LIGHT_ECLIPSE;
    enterBtn.hoverColor = LIGHT_ECLIPSE;
    clearBtn.buttonColor = LIGHT_ECLIPSE;
    clearBtn.hoverColor = LIGHT_ECLIPSE;
  }
  enterBtn.drawButton();
  clearBtn.drawButton();
}
// HITOM_SOUND = loadSound("../Sounds/hiTom.mp3");
//   MIDTOM_SOUND = loadSound("../Sounds/midTom.mp3");
//   OPENHIHAT_SOUND = loadSound("../Sounds/openHiHat.mp3");
//   CRASH_SOUND
function saving(){
  var circs = [];
  for(i = 0;i < circles.length;i++){
    circs[i] = [];
    if (circles[i].sound == SNARE_SOUND){
      circs[i][0] = 1;
    }
    else if (circles[i].sound == KICK_SOUND){
      circs[i][0] = 2;
    }
    else if (circles[i].sound == CYMBAL_SOUND){
      circs[i][0] = 3;
    }
    else if (circles[i].sound == HIHAT_SOUND){
      circs[i][0] = 4;
    }
    else if (circles[i].sound == OPENHIHAT_SOUND) {
      circs[i][0] = 5;
    }
    else if (circles[i].sound == HITOM_SOUND) {
      circs[i][0] = 6;
    }
    else if (circles[i].sound == MIDTOM_SOUND) {
      circs[i][0] = 7;
    }
    else {
      circs[i][0] = 8;
    }

    circs[i][1] = circles[i].ox;
    circs[i][2] = circles[i].oy;
  }
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.open("GET", "send.php?clockName=" + clockName + "&tempo=" + hs1.tempo + "&shared=" + shared + "&Circles=" + circs, true);
  xmlhttp.send();
  window.open("http://localhost:8080/Clock/myClocks.php", '_self');
}
