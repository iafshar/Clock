
function mouseReleased() {
  mouseButton = 0;
  clickedOnCircle = null;
}

function mousePressed() {
  if (mouseX>hs1.numX && mouseX<hs1.numX+50 && mouseY>hs1.numY-20 && mouseY<hs1.numY+3){
    clockScreen = false;
  }
  if (clockScreen){
  if (mouseY < hs1.ypos) {
    for(Op = 0;Op < options.length;Op ++){
      if(options[Op].overButton()){
        if(options[Op].counter < options[Op].sounds.length && !circles.includes(options[Op].sounds[options[Op].counter])){
          circles.push(options[Op].sounds[options[Op].counter]);
          options[Op].counter ++;
        }
      }
    }
    if (signUp.overButton()){
      window.open("http://localhost:8080/Clock/choose.html", "_self")
    }
    else if (login.overButton()) {
      window.open("http://localhost:8080/Clock/login.php", "_self")
    }
    for (i = 0;i<circles.length;i++){
      if (circleOnScreen && pointCircle(circles[i].ox, circles[i].oy, mouseX, mouseY, CIRCLE_DIAMETER/2)){
        clickedOnCircle = circles[i];
        circles[i].outline = 2;
      }
      else{
        circles[i].outline = 0;
      }
    }
  }
  else{
    enter = 0;
  }
  }
  else{
    if (mouseX >= 170 && mouseX <= 233 && mouseY >= 480 && mouseY <= 520){
      if (clickCount==2||clickCount==0){ //clicked as a condition
        clickCount = 1;
        stop1 = false;
      }
      else{
        clickCount++;
        stop2 = false;
      }
    }
    else if (mouseX >= 360 && mouseX <= 435 && mouseY >= 480 && mouseY <= 520){
      if (hs1.tempo < 25){
        hs1.tempo = 25;
      }
      else if (hs1.tempo > 225){
        hs1.tempo = 225;
      }
      enter = hs1.tempo;
      clockScreen = true;
      first = 0;
      secnd = 0;
      clickCount = 0;
    }
    else if (mouseX >= 365 && mouseX <= 437 && mouseY >= 80 && mouseY <= 120){
      hs1.tempo = 0;
      first = 0;
      secnd = 0;
      clickCount = 0;
    }
    else {
      for (i=0;i<nums.length;i++){
        if (dist(mouseX,mouseY,nums[i].x,nums[i].y)<nums[i].diameter/2){
          hs1.tempo += nums[i].text;
          hs1.tempo = int(hs1.tempo);
          first = 0;
          secnd = 0;
          clickCount = 0;
        }
      }
    }
  }
}




function mouseDragged() { // Move Circle
    Buttons = [snareOp, kickOp, cymbalOp, hiHatOp, openHiHatOp, hiTomOp, midTomOp, crashOp, signUp, login];
    buttonCheck = false;
    for(var i = 0;i < Buttons.length;i++){
      if(Buttons[i].overButton() && circleOnScreen && clickedOnCircle != null){
        leftDist = mouseX - Buttons[i].x;
        rightDist = (Buttons[i].x+Buttons[i].Width) - mouseX;
        topDist = mouseY - Buttons[i].y;
        bottomDist = (Buttons[i].y+Buttons[i].Height) - mouseY;
        if (min(leftDist,rightDist,topDist,bottomDist) == leftDist) {
          clickedOnCircle.ox = Buttons[i].x;
          clickedOnCircle.oy = mouseY;
        }
        else if (min(leftDist,rightDist,topDist,bottomDist) == rightDist) {
          clickedOnCircle.ox = (Buttons[i].x+Buttons[i].Width);
          clickedOnCircle.oy = mouseY;
        }
        else if (min(leftDist,rightDist,topDist,bottomDist) == topDist) {
          clickedOnCircle.ox = mouseX;
          clickedOnCircle.oy = Buttons[i].y;
        }
        else {
          clickedOnCircle.ox = mouseX;
          clickedOnCircle.oy = (Buttons[i].y+Buttons[i].Height);
        }
        buttonCheck = true;
      }
    }
    if (circleOnScreen && clickedOnCircle != null && mouseY < hs1.ypos - CIRCLE_DIAMETER/2 && mouseY > 0 && mouseX > 0 && mouseX < width && !pointCircle(mouseX, mouseY, CLOCK_X, CLOCK_Y,RADIUS*2-365) && !(mouseX>SOUND_BUTTON_X-CIRCLE_DIAMETER/2 && mouseY<230+BUTTON_HEIGHT+CIRCLE_DIAMETER/2) && buttonCheck == false){ //if the mouse is over the slider and you have clicked on a Circle you can drag it
      check = 0;
      for(i = 50;i < 251;i += 50){
        if(!(layer(CLOCK_X,CLOCK_Y,mouseX,mouseY,(RADIUS*2-i)/2,10))){
          vX = mouseX - CLOCK_X;
          vY = mouseY - CLOCK_Y;
          magV = sqrt(vX*vX + vY*vY);
          aX = CLOCK_X + vX / magV * (((RADIUS*2-i)/2) + CIRCLE_DIAMETER/2);
          aY = CLOCK_Y + vY / magV * (((RADIUS*2-i)/2) + CIRCLE_DIAMETER/2);
          clickedOnCircle.ox = aX;
          clickedOnCircle.oy = aY;
          check++;
        }
      }
      if(check == 0){
        clickedOnCircle.ox = mouseX;
        clickedOnCircle.oy = mouseY;
      }
    }
    else if (mouseY > hs1.ypos - CIRCLE_DIAMETER){
      clickedOnCircle = null;
      CircleOutline = 0;
    }
}

function keyPressed(){
  if (!clockScreen) {
    if(keyCode>=48 && keyCode<=57){
      hs1.tempo += str(keyCode-48);
      hs1.tempo = int(hs1.tempo);
      first = 0;
      secnd = 0;
      clickCount = 0;
    }
    if(keyCode == 13){
       if (hs1.tempo < 25){
          hs1.tempo = 25;
        }
        else if (hs1.tempo > 225){
          hs1.tempo = 225;
        }
        enter = hs1.tempo;
        clockScreen = true;
        first = 0;
        secnd = 0;
        clickCount = 0;
    }
    else if (keyCode == 8) {
      if (hs1.tempo < 10) {
        hs1.tempo = 0;
      }
      else {
        hs1.tempo = int(str(hs1.tempo).slice(0, -1));
      }
      first = 0;
      secnd = 0;
      clickCount = 0;
    }
  }
}
