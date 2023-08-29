// functions related to user interactions
function mouseReleased() {
  mouseButton = 0;
  if(clickedOnCircle != null){
    clickedOnCircle.outline = 0;
    clickedOnCircle = null;
  }
}

function mousePressed() {
  if (mouseX>10 && mouseX<60 && mouseY>10 && mouseY<60){
    screen = 1;
  }
  if (screen == 0){
  if (mouseY < hs1.ypos) {
    for(Op = 0;Op < options.length;Op ++){
      if(options[Op].overButton()){
        if(options[Op].counter < options[Op].sounds.length && !circles.includes(options[Op].sounds[options[Op].counter])){
          circles.push(options[Op].sounds[options[Op].counter]);
          options[Op].counter ++;
        }
      }
    }
    if (saveBtn.overButton()){
        shared = 0;
        if(edited){
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
            else{
              circs[i][0] = 4;
            }
            circs[i][1] = circles[i].ox;
            circs[i][2] = circles[i].oy;
          }
          var xmlhttp = new XMLHttpRequest();

          xmlhttp.open("GET", "edit.php?tempo=" + hs1.tempo + "&shared=" + shared + "&Circles=" + circs, true);
          xmlhttp.send();
          window.open("http://localhost:8080/Clock/myClocks.php", '_self');
        }
        else{
          screen = 2;
        }

    }
    else if (share.overButton()){
        shared = 1;
        if(edited){
          if(edited){
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
              else{
                circs[i][0] = 4;
              }
              circs[i][1] = circles[i].ox;
              circs[i][2] = circles[i].oy;
            }
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.open("GET", "edit.php?tempo=" + hs1.tempo + "&shared=" + shared + "&Circles=" + circs, true);
            xmlhttp.send();
            window.open("http://localhost:8080/Clock/myClocks.php", '_self');
          }
        }
        else{
          screen = 2;
        }
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
  else if (screen == 1) {
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
      screen = 0;
    }
    else if (mouseX >= 365 && mouseX <= 437 && mouseY >= 80 && mouseY <= 120){
      hs1.tempo = 0;
      first = 0;
      secnd = 0;
    }
    else {
      for (i=0;i<nums.length;i++){
        if (dist(mouseX,mouseY,nums[i].x,nums[i].y)<nums[i].diameter/2){
           hs1.tempo += nums[i].text;
           hs1.tempo = int(hs1.tempo);
        }
      }
    }
  }
  else { //if screen == 2
    if (enterBtn.overButton() && clockName.length > 0) {
      saving();
    }
    else if (clearBtn.overButton()) {
      clockName = "";
    }
  }
}




function mouseDragged() { // Move Circle
    Buttons = [snareOp, kickOp, cymbalOp, hiHatOp, saveBtn, share];
    buttonCheck = false;
    for(var i = 0;i < Buttons.length;i++){
      if(Buttons[i].overButton()){
        buttonCheck = true;
      }
    }
    if (mouseX>10 && mouseX<60 && mouseY>10 && mouseY<60){
      buttonCheck = true;
    }
    if (circleOnScreen && clickedOnCircle != null && mouseY < hs1.ypos - CIRCLE_DIAMETER/2 && mouseY > 0 && mouseX > 0 && mouseX < width && !pointCircle(mouseX, mouseY, CLOCK_X, CLOCK_Y,RADIUS*2-365) && !buttonCheck){ //if the mouse is over the slider and you have clicked on a Circle you can drag it
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
  if(screen == 1){

    if(keyCode>=48 && keyCode<=57){

      hs1.tempo += str(keyCode-48);
      hs1.tempo = int(hs1.tempo);

    }
    else if (keyCode == 13){

       if (hs1.tempo < 25){
          hs1.tempo = 25;
        }
        else if (hs1.tempo > 225){
          hs1.tempo = 225;
        }
        enter = hs1.tempo;
        screen = 0;
    }
  }
  else if(screen == 2){
    // 65-90 are letters, 48-57 are numbers, 190 is period, 189 is dash
    if(((keyCode>=65 && keyCode<=90) || (keyCode>=48 && keyCode<=57) || (keyCode == 190 || keyCode == 189)) && clockName.length <= 40){
      clockName += key;
    }
    else if (keyCode == 32) {
      clockName += "_";
    }
    else if(keyCode == 13 && clockName.length > 0){ // enter
      saving();
    }
        
  }
}
