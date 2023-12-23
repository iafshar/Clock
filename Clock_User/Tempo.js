// code for the tempo screen
function click() {
  if (clickCount == 1 && !stop1){
      first = millis(); //millis() is a function in processing that returns the number
      stop1 = true;     //of milliseconds that have passed since the start of the program.
  }
  else if (clickCount == 2 && !stop2){
     secnd = millis();
     stop2 = true;
  }
  ClickTempo = secnd-first; //The time difference in milliseconds between the first click and
  if(secnd>first){          //the secnd click is set to a variable called ClickTempo.
    hs1.tempo = int(60000/ClickTempo); //The actual tempo will be 60000/ClickTempo since there are 60000
    if (hs1.tempo > 225){        //millisecnds in a minute and tempo is measured in beats per minute.
      hs1.tempo = 225;
    }
    if (hs1.tempo < 25){
      hs1.tempo = 25;
    }
  }
}

function keypad(){
  background(200);
  stroke(BLACK);
  strokeWeight(1);
  if(hs1.tempo>999){ // doesnt let a user enter more than 3 characters
    hs1.tempo = 0;
  }
  text(hs1.tempo,NUM_BUTTON_X + (2*NUM_BUTTON_DIAMETER),nhRatio*100);
  if(mouseX >= CLEAR_X - (CLEAR_WIDTH/2) && mouseX <= CLEAR_X + (CLEAR_WIDTH/2) && mouseY >= CLEAR_Y-nhRatio*20 && mouseY <= CLEAR_Y+nhRatio*20){
    fill(WHITE);
  }
  else{
    fill(BLACK);
  }
  text("Clear",CLEAR_X,CLEAR_Y);
  if(mouseX >= CLICK_X - (CLICK_WIDTH/2) && mouseX <= CLICK_X + (CLICK_WIDTH/2) && mouseY >= CLICK_Y-nhRatio*20 && mouseY <= CLICK_Y+nhRatio*20){
    fill(WHITE);
  }
  else{
    fill(BLACK);
  }
  text("Click", CLICK_X, CLICK_Y);
  if(mouseX >= ENTER_X - (ENTER_WIDTH/2) && mouseX <= ENTER_X + (ENTER_WIDTH/2) && mouseY >= ENTER_Y-nhRatio*20 && mouseY <= ENTER_Y+nhRatio*20){
    fill(WHITE);
  }
  else{
    fill(BLACK);
  }
  text("Enter", ENTER_X, ENTER_Y);

  for(i=0;i<nums.length;i++){
    nums[i].drawButton();
  }

  click();
  return hs1.tempo;
}
