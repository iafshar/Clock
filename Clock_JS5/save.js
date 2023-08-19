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
  }
  else {
    enterBtn.buttonColor = LIGHT_ECLIPSE;
    enterBtn.hoverColor = LIGHT_ECLIPSE;
  }
  enterBtn.drawButton();
}

function saving(){
  var circs = [];
  for(i = 0;i < Circles.length;i++){
    circs[i] = [];
    if (Circles[i].sound == snareSound){
      circs[i][0] = 1;
    }
    else if (Circles[i].sound == kickSound){
      circs[i][0] = 2;
    }
    else if (Circles[i].sound == cymbalSound){
      circs[i][0] = 3;
    }
    else{
      circs[i][0] = 4;
    }
    circs[i][1] = Circles[i].ox;
    circs[i][2] = Circles[i].oy;
  }
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.open("GET", "send.php?clockName=" + clockName + "&tempo=" + hs1.tempo + "&shared=" + shared + "&Circles=" + circs, true);
  xmlhttp.send();
  window.open("http://localhost:8080/Clock/MyClocks.php", '_self');
}
