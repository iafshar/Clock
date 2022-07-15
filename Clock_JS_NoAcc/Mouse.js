
function mouseReleased() {
  mouseButton = 0;
  ClickedOnCircle = null;
}

function mousePressed() {
  if (mouseX>hs1.numX && mouseX<hs1.numX+50 && mouseY>hs1.numY-20 && mouseY<hs1.numY+3){
    clockScreen = false;
  }
  if (clockScreen){
  if (mouseY < hs1.ypos) {
    if (snareOp.overButton()){
      if(snareCount < Snares.length && !Circles.includes(Snares[snareCount])){
        Circles.push(Snares[snareCount]);
        snareCount ++;
      }
      CheckMouseClicked = snare;
    }
    else if (kickOp.overButton()){
      if(kickCount < Kicks.length && !Circles.includes(Kicks[kickCount])){
        Circles.push(Kicks[kickCount]);
        kickCount ++;
      }
      CheckMouseClicked = kick;
    }
    else if (cymbalOp.overButton()){
      if(cymbalCount < Cymbals.length && !Circles.includes(Cymbals[cymbalCount])){
        Circles.push(Cymbals[cymbalCount]);
        cymbalCount ++;
      }
      CheckMouseClicked = cymbal;
    }
    else if (hiHatOp.overButton()){
      if(hiHatCount < hiHats.length && !Circles.includes(hiHats[hiHatCount])){
        Circles.push(hiHats[hiHatCount]);
        hiHatCount ++;
      }
      CheckMouseClicked = hiHat;
    }
    else if (signUp.overButton()){
      window.open("http://localhost:8080/NEA5/choose.html", "_self")
    }
    for (i = 0;i<Circles.length;i++){
      if (CircleOnScreen && pointCircle(Circles[i].ox, Circles[i].oy, mouseX, mouseY, CircleDiameter/2)){
        ClickedOnCircle = Circles[i];
        Circles[i].outline = 2;
      }
      else{
        Circles[i].outline = 0;
      }
    }
  }
  else{
    enter = 0;
  }
  }
  else{
      if (mouseX >= 170 && mouseX <= 233 && mouseY >= 480 && mouseY <= 520){
      if (ClickCount==2||ClickCount==0){ //clicked as a condition
        ClickCount = 1;
        stop1 = false;
      }
      else{
        ClickCount++;
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
      second = 0;
    }
    else {
      for (i=0;i<Nums.length;i++){
        if (dist(mouseX,mouseY,Nums[i].x,Nums[i].y)<Nums[i].diameter/2){
           hs1.tempo += Nums[i].num;
           hs1.tempo = int(hs1.tempo);
        }
      }
    }
  }
}




function mouseDragged() { // Move Circle
    if (CircleOnScreen && ClickedOnCircle != null && mouseY < hs1.ypos - CircleDiameter/2 && mouseY > 0 && mouseX > 0 && mouseX < width && !pointCircle(mouseX, mouseY, clockX, clockY,radius*2-365) && !(mouseX>optionX-CircleDiameter/2 && mouseY<230+optionHeight+CircleDiameter/2)){ //if the mouse is over the slider and you have clicked on a Circle you can drag it
      check = 0;
      for(i = 50;i < 251;i += 50){
        if(!(layer(clockX,clockY,mouseX,mouseY,(radius*2-i)/2,10))){
          check++;
        }
      }
      if(check == 0){
        ClickedOnCircle.ox = mouseX;
        ClickedOnCircle.oy = mouseY;
      }
    }
    else if (mouseY > hs1.ypos - CircleDiameter){
      ClickedOnCircle = null;
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
