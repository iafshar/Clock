first = 0;
secnd = 0;
ClickCount = 0;
stop1 = false;
stop2 = false;
NumButtonDiameter = 50;



one = new NumButton('1',200,200,NumButtonDiameter);
two = new NumButton('2',300,200,NumButtonDiameter);
three = new NumButton('3',400,200,NumButtonDiameter);
four = new NumButton('4',200,300,NumButtonDiameter);
five = new NumButton('5',300,300,NumButtonDiameter);
six = new NumButton('6',400,300,NumButtonDiameter);
seven = new NumButton('7',200,400,NumButtonDiameter);
eight = new NumButton('8',300,400,NumButtonDiameter);
nine = new NumButton('9',400,400,NumButtonDiameter);
zero = new NumButton('0',300,500,NumButtonDiameter);

Nums = [one,two,three,four,five,six,seven,eight,nine,zero,];

function click() {
  if (ClickCount == 1 && !stop1){
      first = millis(); //millis() is a function in processing that returns the number
      stop1 = true;     //of milliseconds that have passed since the start of the program.
  }
  else if (ClickCount == 2 && !stop2){
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
  strokeWeight(1);
  if(hs1.tempo>999999){
    hs1.tempo = 0;
  }
  text(hs1.tempo,300,100);
  if(mouseX >= 365 && mouseX <= 437 && mouseY >= 80 && mouseY <= 120){
    fill(255);
  }
  else{
    fill(0);
  }
  text("Clear",400,100);
  if(mouseX >= 170 && mouseX <= 233 && mouseY >= 480 && mouseY <= 520){
    fill(255);
  }
  else{
    fill(0);
  }
  text("Click", 200, 500);
  if(mouseX >= 360 && mouseX <= 435 && mouseY >= 480 && mouseY <= 520){
    fill(255);
  }
  else{
    fill(0);
  }
  text("Enter", 400, 500);
  
  one.drawCirc();
  one.drawNum();
  one.overNum();
  
  two.drawCirc();
  two.drawNum();
  two.overNum();
  
  three.drawCirc();
  three.drawNum();
  three.overNum();
  
  four.drawCirc();
  four.drawNum();
  four.overNum();
  
  five.drawCirc();
  five.drawNum();
  five.overNum();
  
  six.drawCirc();
  six.drawNum();
  six.overNum();
  
  seven.drawCirc();
  seven.drawNum();
  seven.overNum();
  
  eight.drawCirc();
  eight.drawNum();
  eight.overNum();
  
  nine.drawCirc();
  nine.drawNum();
  nine.overNum();
  
  zero.drawCirc();
  zero.drawNum();
  zero.overNum();
  
  click();
  return hs1.tempo;
}
