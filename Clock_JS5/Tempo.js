// code for the tempo screen
function click() {
  if (ClickCount == 1 && !stop1){
      first = millis(); //millis() is a function in processing that returns the number
      stop1 = true;     //of milliseconds that have passed since the start of the program.
  }
  else if (ClickCount == 2 && !stop2){
     second = millis();
     stop2 = true;
  }
  ClickTempo = second-first; //The time difference in milliseconds between the first click and
  if(second>first){          //the second click is set to a variable called ClickTempo.
    hs1.tempo = int(60000/ClickTempo); //The actual tempo will be 60000/ClickTempo since there are 60000
    if (hs1.tempo > 225){        //milliseconds in a minute and tempo is measured in beats per minute.
      hs1.tempo = 225;
    }
    if (hs1.tempo < 25){
      hs1.tempo = 25;
    }
  }
}

function keypad(){
  background(200);
  strokeWeight(1);
  if(hs1.tempo>999){
    hs1.tempo = 0;
  }
  text(hs1.tempo,300,100);
  if(mouseX >= 365 && mouseX <= 437 && mouseY >= 80 && mouseY <= 120){
    fill(WHITE);
  }
  else{
    fill(BLACK);
  }
  text("Clear",400,100);
  if(mouseX >= 170 && mouseX <= 233 && mouseY >= 480 && mouseY <= 520){
    fill(WHITE);
  }
  else{
    fill(BLACK);
  }
  text("Click", 200, 500);
  if(mouseX >= 360 && mouseX <= 435 && mouseY >= 480 && mouseY <= 520){
    fill(WHITE);
  }
  else{
    fill(BLACK);
  }
  text("Enter", 400, 500);

  for(i=0;i<Nums.length;i++){
    Nums[i].drawButton();
  }

  click();
  return hs1.tempo;
}
