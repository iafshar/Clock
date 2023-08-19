// functions related to user interactions
function mouseReleased() {
  mouseButton = 0;
  if(ClickedOnCircle != null){
    ClickedOnCircle.outline = 0;
    ClickedOnCircle = null;
  }
}

function mousePressed() {
  if (mouseX>10 && mouseX<60 && mouseY>10 && mouseY<60){
    screen = 1;
  }
  if (screen == 0){
  if (mouseY < hs1.ypos) {
    for(Op = 0;Op < Options.length;Op ++){
      if(Options[Op].overButton()){
        if(Options[Op].counter < Options[Op].sounds.length && !Circles.includes(Options[Op].sounds[Options[Op].counter])){
          Circles.push(Options[Op].sounds[Options[Op].counter]);
          Options[Op].counter ++;
        }
      }
    }
    if (saveBtn.overButton()){
        shared = 0;
        if(edited){
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

          xmlhttp.open("GET", "edit.php?tempo=" + hs1.tempo + "&shared=" + shared + "&Circles=" + circs, true);
          xmlhttp.send();
          window.open("http://localhost:8080/Clock/MyClocks.php", '_self');
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

            xmlhttp.open("GET", "edit.php?tempo=" + hs1.tempo + "&shared=" + shared + "&Circles=" + circs, true);
            xmlhttp.send();
            window.open("http://localhost:8080/Clock/MyClocks.php", '_self');
          }
        }
        else{
          screen = 2;
        }
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
      screen = 0;
    }
    else if (mouseX >= 365 && mouseX <= 437 && mouseY >= 80 && mouseY <= 120){
      hs1.tempo = 0;
      first = 0;
      secnd = 0;
    }
    else {
      for (i=0;i<Nums.length;i++){
        if (dist(mouseX,mouseY,Nums[i].x,Nums[i].y)<Nums[i].diameter/2){
           print(Nums[i].text);
           hs1.tempo += Nums[i].text;
           hs1.tempo = int(hs1.tempo);
        }
      }
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
    if (CircleOnScreen && ClickedOnCircle != null && mouseY < hs1.ypos - CircleDiameter/2 && mouseY > 0 && mouseX > 0 && mouseX < width && !pointCircle(mouseX, mouseY, clockX, clockY,radius*2-365) && !buttonCheck){ //if the mouse is over the slider and you have clicked on a Circle you can drag it
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
    else if(keyCode == 13 && clockName.length > 0){ // enter
      saving();
    }
        
  }
}
