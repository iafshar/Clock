// functions related to user interactions
function mouseReleased() {
  fastForwardBtn.timePressed = -1;
  rewindBtn.timePressed = -1;
  mouseButton = 0;
  if(clickedOnCircle != null){ 
    clickedOnCircle.outline = 0; // removes the outline of the circle that was clicked on
    if (trashBtn.overButton()) { // deletes the circle if it is dragged and dropped onto the trash
      for(Op = 0;Op < options.length;Op ++){
        if (options[Op].sounds.includes(clickedOnCircle)) {
          circlesIndex = circles.indexOf(clickedOnCircle);
          circles.splice(circlesIndex, 1);
          soundIndex = options[Op].sounds.indexOf(clickedOnCircle);
          options[Op].sounds.splice(soundIndex, 1);
          options[Op].sounds.push(clickedOnCircle);
          options[Op].counter --;
          clickedOnCircle.ox = clickedOnCircle.startingX;
          clickedOnCircle.oy = clickedOnCircle.startingY;
          break;
        }
      }
    }
    clickedOnCircle = null;

  }
}

function cancel() { //Function called when Cancel button is pressed
  close(); // for some reason just calling close doesnt work
  return;
}

function close(){ // closes the dialog box
  $( "#dialog" ).dialog( 'close' );
}

function ok() {       //function called when ok button is pressed
  clockName = $("input[name='name']").val(); 

  if (clockName.length > 40) { // should never happen because the maxlength of the field is 40 but just in case
    alert('Please enter a name that is shorter than 40 characters.');
    return;
  }
  else if (names.includes(clockName.toLowerCase())) {
    alertStr = "You have already used that name. Please choose another one."
    alert(alertStr);
    return;
  }
  else if (clockName.length > 0) { // the name is a unique name that is less than 40 chars and more than 0
    saving();
  }

}

function clockNamePaste(e) { // called when user pastes to the clockname field
  var key = e.clipboardData.getData('text') // what is copied to the clipboard
  for (let i = 0; i < illegals.length; i++) {
    if (key.includes(illegals[i])) { // if there is at least one illegal character in the string being pasted, dont paste anything
      e.preventDefault();
      return;
    }
  }
  if (key.includes(' ')) { // replace spaces in the string being pasted with underscores
   e.preventDefault();
  }
}

function nameClock() {
  var clockNameField = document.getElementById('clock-name');
  clockNameField.value = ""; // clears the value of the text field in case the user entered something before and pressed cancel
  $("#dialog").dialog( "open" );
  var dialogElem = document.getElementsByClassName("ui-dialog ui-widget ui-widget-content ui-corner-all ui-front")[0]; // class of the jquery dialog box
  //styling the dialog box to be at the top and be a certain height and width
  dialogElem.style.height = "24%";
  dialogElem.style.width = "16%";
  dialogElem.style.top = "60px";

  clockNameField.addEventListener('keydown', function(event) {
    if (illegals.includes(event.key)) { // if the current typed character is an illegal one
      event.preventDefault(); // dont add the character to the box

    }
    if (event.key == ' ') { // if the current typed character is a space
      event.preventDefault();
      var cursor = this.selectionStart; // position of the cursor
      clockNameField.value = clockNameField.value.substring(0,cursor) + '_' + clockNameField.value.substring(this.selectionEnd);
      this.setSelectionRange(cursor+1,cursor+1);
    }
    if (event.key == 'Enter') { // allows user to click enter to submit the name
      ok();
    }
  }, false);
}

function mousePressed() {
  if (keypadBtn.overButton()){ //keypad
    screen = 1;
  }
  if (screen == 0){ // clock screen
    if (mouseY < hs1.ypos) {
      for(Op = 0;Op < options.length;Op ++){
        if(options[Op].overButton()){ // finds the option that has been clicked on
          if(options[Op].counter < options[Op].sounds.length && !circles.includes(options[Op].sounds[options[Op].counter])){
            // if the circle does not already exist and it is under the limit for this circle
            circles.push(options[Op].sounds[options[Op].counter]); // adds the new circle to the circles array
            options[Op].counter ++; // adds one to the count of the circle that has been added
          }
        }
      }
      if (saveBtn.overButton()){
          shared = 0;
          if(edited){ // if it is not a new clock
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
              circs[i][1] = (circles[i].ox - CLOCK_X)/RADIUS; // positions saved like this to appear properly in all window sizes
              circs[i][2] = (circles[i].oy - CLOCK_Y)/RADIUS;
            }
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.open("GET", "edit.php?ClockID="+clockID+"&tempo=" + hs1.tempo + "&shared=" + shared + "&Circles=" + circs, true);
            xmlhttp.send();
            window.open("http://localhost:8080/Clock/myClocks.php", '_self');
          }
          else{ // if it is a new clock
            nameClock(); 
          }

      }
      else if (share.overButton()){
          shared = 1;
          if(edited){ // if it is not a new clock
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
                circs[i][1] = (circles[i].ox - CLOCK_X)/RADIUS;
                circs[i][2] = (circles[i].oy - CLOCK_Y)/RADIUS;
              }
              var xmlhttp = new XMLHttpRequest();

              xmlhttp.open("GET", "edit.php?ClockID="+clockID+"&tempo=" + hs1.tempo + "&shared=" + shared + "&Circles=" + circs, true);
              xmlhttp.send();
              window.open("http://localhost:8080/Clock/myClocks.php", '_self');
          }
          else{ // if it is a new clock
            nameClock();
          }
      }
      else if (pauseBtn.overButton()) {
        pauseBtn.paused = !pauseBtn.paused;
      }
      else if (rewindBtn.overButton()) {
        if (angle%45 == 0) {
          angle -= 45;
        }
        else { // if the angle is not a multiple of 45, take the line to the closest angle that is a multiple of 45 behind it
          angle = angle-(angle%45);
        }
        rewindBtn.timePressed = millis();
        pauseBtn.paused = true;
        
      }
      else if (fastForwardBtn.overButton()) {
        angle = angle-(angle%45)+45; // take the line to the closest angle that is a  multiple of 45 in front of it
        fastForwardBtn.timePressed = millis();
        pauseBtn.paused = true;
        
      }
      for (i = 0;i<circles.length;i++){
        if (circleOnScreen && pointCircle(circles[i].ox, circles[i].oy, mouseX, mouseY, CIRCLE_DIAMETER/2)){ // if the mouse has clicked on a circle
          clickedOnCircle = circles[i];
          circles[i].outline = 2;
        }
        else{
          circles[i].outline = 0;
        }
      }
    }
    else{
      enter = 0; // enter is the value of the tempo entered in the keypad so this makes sure it doesnt use it as the tempo
      // because if enter is 0, it doesnt set it to the tempo
    }
  }
  else if (screen == 1) { //kepad
    if (mouseX >= CLICK_X - (CLICK_WIDTH/2) && mouseX <= CLICK_X + (CLICK_WIDTH/2) && mouseY >= CLICK_Y-nhRatio*20 && mouseY <= CLICK_Y+nhRatio*20){
      if (clickCount==2||clickCount==0){ //clicked as a condition
        clickCount = 1; // clicked for the first time
        stop1 = false;
      }
      else{
        clickCount++; // clicked for the second time
        stop2 = false;
      }
    }
    else if (mouseX >= ENTER_X - (ENTER_WIDTH/2) && mouseX <= ENTER_X + (ENTER_WIDTH/2) && mouseY >= ENTER_Y-nhRatio*20 && mouseY <= ENTER_Y+nhRatio*20){
      if (hs1.tempo < 25){
        hs1.tempo = 25;
      }
      else if (hs1.tempo > 225){
        hs1.tempo = 225;
      }
      enter = hs1.tempo;
      screen = 0;
      // sets the following values to zero so it doesnt think you are in the middle of clicking if you decide to start clicking again
      first = 0;
      secnd = 0;
      clickCount = 0;
    }
    else if (mouseX >= CLEAR_X - (CLEAR_WIDTH/2) && mouseX <= CLEAR_X + (CLEAR_WIDTH/2) && mouseY >= CLEAR_Y-nhRatio*20 && mouseY <= CLEAR_Y+nhRatio*20){ //clear button
      hs1.tempo = 0;
      // sets the following values to zero so it doesnt think you are in the middle of clicking if you decide to start clicking again
      first = 0;
      secnd = 0;
      clickCount = 0;
    }
    else { // checks if the numButtons are being pressed
      for (i=0;i<nums.length;i++){
        if (dist(mouseX,mouseY,nums[i].x,nums[i].y)<nums[i].diameter/2){
          hs1.tempo += nums[i].text;
          hs1.tempo = int(hs1.tempo);
          // sets the following values to zero so it doesnt think you are in the middle of clicking if you decide to start clicking again
          first = 0;
          secnd = 0;
          clickCount = 0;
        }
      }
    }
  }
}




function mouseDragged() { // Move Circle
    Buttons = [snareOp, kickOp, cymbalOp, hiHatOp, openHiHatOp, hiTomOp, midTomOp, crashOp, saveBtn, share, keypadBtn];
    buttonCheck = false;
    for(var i = 0;i < Buttons.length;i++){
      if(Buttons[i].overButton() && circleOnScreen && clickedOnCircle != null){
        // if you are dragging a circle and the mouse goes above a button, make the circle go to the nearest point on the edge of the button
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
    if (circleOnScreen && clickedOnCircle != null && mouseY < hs1.ypos - CIRCLE_DIAMETER/2 && mouseY > 0 && mouseX > 0 && mouseX < width && !pointCircle(mouseX, mouseY, CLOCK_X, CLOCK_Y,RADIUS*2-365) && !buttonCheck){ //if the mouse is over the slider and you have clicked on a Circle you can drag it
      check = 0;
      for(i = RADIUS/5;i < RADIUS+1;i += RADIUS/5){
        // constrain the circles to the layers of the circles
        if(!(layer(CLOCK_X,CLOCK_Y,mouseX,mouseY,(RADIUS*2-i)/2,CIRCLE_DIAMETER/2))){
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
      // if the mouse goes below the scrollbar
      clickedOnCircle = null;
      CircleOutline = 0;
    }
}

function keyPressed(){
  if(screen == 1){ // keypad screen 

    if(keyCode>=48 && keyCode<=57){ // numbers

      hs1.tempo += str(keyCode-48);
      hs1.tempo = int(hs1.tempo);
      // sets the following values to zero so it doesnt think you are in the middle of clicking if you decide to start clicking again
      first = 0;
      secnd = 0;
      clickCount = 0;

    }
    else if (keyCode == 13){ // enter button

       if (hs1.tempo < 25){
          hs1.tempo = 25;
        }
        else if (hs1.tempo > 225){
          hs1.tempo = 225;
        }
        enter = hs1.tempo;
        // sets the following values to zero so it doesnt think you are in the middle of clicking if you decide to start clicking again
        screen = 0;
        first = 0;
        secnd = 0;
        clickCount = 0;
    }
    else if (keyCode == 8) { // backspace
      if (hs1.tempo < 10) {
        hs1.tempo = 0;
      }
      else {
        hs1.tempo = int(str(hs1.tempo).slice(0, -1));
      }
      // sets the following values to zero so it doesnt think you are in the middle of clicking if you decide to start clicking again
      first = 0;
      secnd = 0;
      clickCount = 0;
    }
  }
}

function windowResized() { // following happens when the user changes the size of the window
  // resetting a bunch of important variables to work with the new window size
  resizeCanvas(windowWidth,windowHeight);
  wRatio = width/1440;
  hRatio = height/734;

  if (width >= 445 && height >= 533) // checks the dimensions are good enough for the keypad screen
  { // if they are big enough for the keypad screen, the aspect ratios will not be changed at all
    nwRatio = 1;
    nhRatio = 1;
  }
  else
  { // if at least one of the dimensions are too small for the keypad, the aspect ratios will be changed
    nwRatio = wRatio;
    nhRatio = hRatio;
  }

  oldCLOCK_X = CLOCK_X;
  oldCLOCK_Y = CLOCK_Y;
  oldRADIUS = RADIUS;

  CLOCK_X = wRatio * 720;
  CLOCK_Y = hRatio * 347

  RADIUS = Math.min((wRatio*250),(hRatio*250)); // since the radius should be the same in both height and width the lowest one will be taken

  BUTTON_Y = hRatio * 20;
  BUTTON_HEIGHT = hRatio * 50; //50
  BUTTON_WIDTH = wRatio * 110;

  SOUND_BUTTON_WIDTH = wRatio * 240;
  SOUND_BUTTON_X = wRatio * 1150;

  TEXT_SIZE = Math.min((wRatio*30),(hRatio*30));

  CIRCLE_DIAMETER = Math.min((wRatio*20),(hRatio*20))

  SCROLLBAR_HEIGHT = hRatio*30;
  starting = hs1.tempo;
  hs1 = new HScrollbar(0, height-SCROLLBAR_HEIGHT, width, SCROLLBAR_HEIGHT,2,starting);
  hs1.tempo = starting; // needed because by default the tempo is set to minTempo (25)

  STARTING_CIRCLE_X = wRatio*20;
  circleX = STARTING_CIRCLE_X;
  snareY = hRatio * 20;
  kickY = snareY + (4*CIRCLE_DIAMETER);
  cymbalY = kickY + (4*CIRCLE_DIAMETER);
  hiHatY = cymbalY + (4*CIRCLE_DIAMETER);
  openHiHatY = hiHatY + (4*CIRCLE_DIAMETER);
  hiTomY = openHiHatY + (4*CIRCLE_DIAMETER);
  midTomY = hiTomY + (4*CIRCLE_DIAMETER);
  crashY = midTomY + (4*CIRCLE_DIAMETER);

  for (let i = 0; i < MAX_CIRCLES; i++) {
    // sets the circles that aren't on screen yet to new circle objects with new positions and diameters
    if (i == MAX_CIRCLES/2) {
      snareY += (2*CIRCLE_DIAMETER);
      kickY += (2*CIRCLE_DIAMETER);
      cymbalY += (2*CIRCLE_DIAMETER);
      hiHatY += (2*CIRCLE_DIAMETER);
      openHiHatY += (2*CIRCLE_DIAMETER);
      hiTomY += (2*CIRCLE_DIAMETER);
      midTomY += (2*CIRCLE_DIAMETER);
      crashY += (2*CIRCLE_DIAMETER);

      circleX = STARTING_CIRCLE_X;
    }
    snare = new Circle(SNARE_SOUND, CIRCLE_DIAMETER, circleX, snareY, RED);
    kick = new Circle(KICK_SOUND, CIRCLE_DIAMETER, circleX, kickY, PINK);
    cymbal = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER, circleX, cymbalY, GREEN);
    hiHat = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER, circleX, hiHatY, ECLIPSE);
    openHiHat = new Circle(OPENHIHAT_SOUND, CIRCLE_DIAMETER, circleX, openHiHatY, BLUE);
    hiTom = new Circle(HITOM_SOUND, CIRCLE_DIAMETER, circleX, hiTomY, BROWN);
    midTom = new Circle(MIDTOM_SOUND, CIRCLE_DIAMETER, circleX, midTomY, PURPLE);
    crash = new Circle(CRASH_SOUND, CIRCLE_DIAMETER, circleX, crashY, TEAL);

    if (!circles.includes(snares[i])) {
      snares[i] = snare;
    }
    if (!circles.includes(Kicks[i])) {
      Kicks[i] = kick;
    }
    if (!circles.includes(cymbals[i])) {
      cymbals[i] = cymbal;
    }
    if (!circles.includes(hiHats[i])) {
      hiHats[i] = hiHat;
    }
    if (!circles.includes(openHiHats[i])) {
      openHiHats[i] = openHiHat;
    }
    if (!circles.includes(hiToms[i])) {
      hiToms[i] = hiTom;
    }
    if (!circles.includes(midToms[i])) {
      midToms[i] = midTom;
    }
    if (!circles.includes(crashes[i])) {
      crashes[i] = crash;
    }

    circleX += (1.5 * CIRCLE_DIAMETER);
  }

  for (let i = 0; i < circles.length; i++) {
    // changes the positions and diameters of the circles that are on screen
    currentCircle = circles[i];
    currentCircle.diameter = CIRCLE_DIAMETER;
    currentCircle.ox = (((currentCircle.ox - oldCLOCK_X) / oldRADIUS) * RADIUS) + CLOCK_X;
    currentCircle.oy = (((currentCircle.oy - oldCLOCK_Y) / oldRADIUS) * RADIUS) + CLOCK_Y;
  }
  // 1020
  // 890
  saveBtn = new Button(wRatio*1020,BUTTON_Y,BUTTON_WIDTH,BUTTON_HEIGHT,"SAVE",YELLOW,LIGHT_YELLOW);
  share = new Button(wRatio*890,BUTTON_Y,BUTTON_WIDTH,BUTTON_HEIGHT,"SHARE",YELLOW,LIGHT_YELLOW);

  snareCount = snareOp.counter;
  kickCount = kickOp.counter;
  cymbalCount = cymbalOp.counter;
  hiHatCount = hiHatOp.counter;
  openHiHatCount = openHiHatOp.counter;
  hiTomCount = hiTomOp.counter;
  midTomCount = midTomOp.counter;
  crashCount = crashOp.counter;

  snareOp = new Option(SOUND_BUTTON_X,BUTTON_Y,SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"SNARE",snares,snareCount,RED,LIGHT_RED);
  kickOp = new Option(SOUND_BUTTON_X,BUTTON_Y+(BUTTON_HEIGHT+CIRCLE_DIAMETER),SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"KICK",Kicks,kickCount,PINK,LIGHT_PINK);
  cymbalOp = new Option(SOUND_BUTTON_X,BUTTON_Y+(2*(BUTTON_HEIGHT+CIRCLE_DIAMETER)),SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"RIDE",cymbals,cymbalCount,GREEN,LIGHT_GREEN);
  hiHatOp = new Option(SOUND_BUTTON_X,BUTTON_Y+(3*(BUTTON_HEIGHT+CIRCLE_DIAMETER)),SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"CLOSED HI-HAT",hiHats,hiHatCount,ECLIPSE,LIGHT_ECLIPSE);
  openHiHatOp = new Option(SOUND_BUTTON_X,BUTTON_Y+(4*(BUTTON_HEIGHT+CIRCLE_DIAMETER)),SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"OPEN HI-HAT",openHiHats,openHiHatCount,BLUE,LIGHT_BLUE);
  hiTomOp = new Option(SOUND_BUTTON_X,BUTTON_Y+(5*(BUTTON_HEIGHT+CIRCLE_DIAMETER)),SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"HI-TOM",hiToms,hiTomCount,BROWN,LIGHT_BROWN);
  midTomOp = new Option(SOUND_BUTTON_X,BUTTON_Y+(6*(BUTTON_HEIGHT+CIRCLE_DIAMETER)),SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"MID-TOM",midToms,midTomCount,PURPLE,LIGHT_PURPLE);
  crashOp = new Option(SOUND_BUTTON_X,BUTTON_Y+(7*(BUTTON_HEIGHT+CIRCLE_DIAMETER)),SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"CRASH",crashes,crashCount,TEAL,LIGHT_TEAL);


  options = [snareOp, kickOp, cymbalOp, hiHatOp, openHiHatOp, hiTomOp, midTomOp, crashOp];

  PAUSE_WIDTH = Math.min((wRatio*30),(0.6*hRatio*50));
  PAUSE_HEIGHT = Math.min((5/3)*(wRatio*30),(hRatio*50));
  PAUSE_Y = CLOCK_Y-(PAUSE_HEIGHT/2);

  pauseBtn = new PauseButton(CLOCK_X-(PAUSE_WIDTH/2),PAUSE_Y,PAUSE_WIDTH,PAUSE_HEIGHT,WHITE,VERY_LIGHT_YELLOW,false);
  rewindBtn = new SeekButton(CLOCK_X-(3.5*PAUSE_WIDTH),PAUSE_Y,2*PAUSE_WIDTH,PAUSE_HEIGHT,WHITE,VERY_LIGHT_YELLOW,true);
  fastForwardBtn = new SeekButton(CLOCK_X+(1.5*PAUSE_WIDTH),PAUSE_Y,2*PAUSE_WIDTH,PAUSE_HEIGHT,WHITE,VERY_LIGHT_YELLOW,false);

  IMAGE_WIDTH = Math.min((wRatio*50),(hRatio*50));

  keypadBtn = new ImageButton(wRatio*1380,hRatio*614,IMAGE_WIDTH,IMAGE_WIDTH,KEYPAD_IMAGE);
  trashBtn = new ImageButton(wRatio*1380 - 1.2*(IMAGE_WIDTH),hRatio*614,IMAGE_WIDTH,IMAGE_WIDTH,TRASH_IMAGE,true);


  NUM_BUTTON_DIAMETER = Math.min((nwRatio*50),(nhRatio*50));
  NUM_BUTTON_X = nwRatio * 200;
  NUM_BUTTON_Y = nhRatio * 200;

  
  one = new NumButton(NUM_BUTTON_X,NUM_BUTTON_Y,'1',NUM_BUTTON_DIAMETER);
  two = new NumButton(NUM_BUTTON_X+(2*NUM_BUTTON_DIAMETER),NUM_BUTTON_Y,'2',NUM_BUTTON_DIAMETER);
  three = new NumButton(NUM_BUTTON_X+(4*NUM_BUTTON_DIAMETER),NUM_BUTTON_Y,'3',NUM_BUTTON_DIAMETER);
  four = new NumButton(NUM_BUTTON_X,NUM_BUTTON_Y+(2*NUM_BUTTON_DIAMETER),'4',NUM_BUTTON_DIAMETER);
  five = new NumButton(NUM_BUTTON_X+(2*NUM_BUTTON_DIAMETER),NUM_BUTTON_Y+(2*NUM_BUTTON_DIAMETER),'5',NUM_BUTTON_DIAMETER);
  six = new NumButton(NUM_BUTTON_X+(4*NUM_BUTTON_DIAMETER),NUM_BUTTON_Y+(2*NUM_BUTTON_DIAMETER),'6',NUM_BUTTON_DIAMETER);
  seven = new NumButton(NUM_BUTTON_X,NUM_BUTTON_Y+(4*NUM_BUTTON_DIAMETER),'7',NUM_BUTTON_DIAMETER);
  eight = new NumButton(NUM_BUTTON_X+(2*NUM_BUTTON_DIAMETER),NUM_BUTTON_Y+(4*NUM_BUTTON_DIAMETER),'8',NUM_BUTTON_DIAMETER);
  nine = new NumButton(NUM_BUTTON_X+(4*NUM_BUTTON_DIAMETER),NUM_BUTTON_Y+(4*NUM_BUTTON_DIAMETER),'9',NUM_BUTTON_DIAMETER);
  zero = new NumButton(NUM_BUTTON_X+(2*NUM_BUTTON_DIAMETER),NUM_BUTTON_Y+(6*NUM_BUTTON_DIAMETER),'0',NUM_BUTTON_DIAMETER);

  nums = [one,two,three,four,five,six,seven,eight,nine,zero,];

  CLEAR_X = NUM_BUTTON_X + (4*NUM_BUTTON_DIAMETER);
  CLEAR_WIDTH = textWidth("Clear") * (8/6);
  CLEAR_Y = nhRatio*100;


  CLICK_X = NUM_BUTTON_X;
  CLICK_WIDTH = textWidth("Click") * (8/6);
  CLICK_Y = nhRatio*500;

  ENTER_X = NUM_BUTTON_X + (4*NUM_BUTTON_DIAMETER);
  ENTER_WIDTH = textWidth("Enter") * (8/6);
  ENTER_Y = CLICK_Y;
}