
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
    if (snareOp.overButton()){
      if(snareCount < snares.length && !circles.includes(snares[snareCount])){
        circles.push(snares[snareCount]);
        snareCount ++;
      }
      checkMouseClicked = snare;
    }
    else if (kickOp.overButton()){
      if(kickCount < Kicks.length && !circles.includes(Kicks[kickCount])){
        circles.push(Kicks[kickCount]);
        kickCount ++;
      }
      checkMouseClicked = kick;
    }
    else if (cymbalOp.overButton()){
      if(cymbalCount < cymbals.length && !circles.includes(cymbals[cymbalCount])){
        circles.push(cymbals[cymbalCount]);
        cymbalCount ++;
      }
      checkMouseClicked = cymbal;
    }
    else if (hiHatOp.overButton()){
      if(hiHatCount < hiHats.length && !circles.includes(hiHats[hiHatCount])){
        circles.push(hiHats[hiHatCount]);
        hiHatCount ++;
      }
      checkMouseClicked = hiHat;
    }
    else if (openHiHatOp.overButton()){
      if(openHiHatCount < openHiHats.length && !circles.includes(openHiHats[openHiHatCount])){
        circles.push(openHiHats[openHiHatCount]);
        openHiHatCount ++;
      }
      checkMouseClicked = hiHat;
    }
    else if (hiTomOp.overButton()){
      if(hiTomCount < hiToms.length && !circles.includes(hiToms[hiTomCount])){
        circles.push(hiToms[hiTomCount]);
        hiTomCount ++;
      }
      checkMouseClicked = hiHat;
    }
    else if (midTomOp.overButton()){
      if(midTomCount < midToms.length && !circles.includes(midToms[midTomCount])){
        circles.push(midToms[midTomCount]);
        midTomCount ++;
      }
      checkMouseClicked = hiHat;
    }
    else if (crashOp.overButton()){
      if(crashCount < crashes.length && !circles.includes(crashes[crashCount])){
        circles.push(crashes[crashCount]);
        crashCount ++;
      }
      checkMouseClicked = cymbal;
    }
    else if (signUp.overButton()){
      window.open("http://localhost:8080/Clock/choose.html", "_self")
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
    }
    else if (mouseX >= 365 && mouseX <= 437 && mouseY >= 80 && mouseY <= 120){
      hs1.tempo = 0;
      first = 0;
      secnd = 0;
    }
    else {
      for (i=0;i<nums.length;i++){
        if (dist(mouseX,mouseY,nums[i].x,nums[i].y)<nums[i].diameter/2){
           hs1.tempo += nums[i].num;
           hs1.tempo = int(hs1.tempo);
        }
      }
    }
  }
}




function mouseDragged() { // Move Circle
    if (circleOnScreen && clickedOnCircle != null && mouseY < hs1.ypos - CIRCLE_DIAMETER/2 && mouseY > 0 && mouseX > 0 && mouseX < width && !pointCircle(mouseX, mouseY, CLOCK_X, CLOCK_Y,RADIUS*2-365) && !(mouseX>SOUND_BUTTON_X-CIRCLE_DIAMETER/2 && mouseY<230+optionHeight+CIRCLE_DIAMETER/2)){ //if the mouse is over the slider and you have clicked on a Circle you can drag it
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
  if(!clockScreen && keyCode>=48 && keyCode<=57){
    hs1.tempo += str(keyCode-48);
    hs1.tempo = int(hs1.tempo);
  }
  if(keyCode == 13 && !clockScreen){
     if (hs1.tempo < 25){
        hs1.tempo = 25;
      }
      else if (hs1.tempo > 225){
        hs1.tempo = 225;
      }
      enter = hs1.tempo;
      clockScreen = true;
  }
}
