// code for the clock page, draw, setup and preload
function preload(){ //This function runs before the program is fully loaded.
  CYMBAL_SOUND = loadSound("../Sounds/cymbal.mp3");  //It makes sense to load the sounds here so that there are no time delays
  KICK_SOUND = loadSound("../Sounds/kick.mp3");
  HIHAT_SOUND = loadSound("../Sounds/hiHat.mp3");
  SNARE_SOUND = loadSound("../Sounds/snare.mp3");
  HITOM_SOUND = loadSound("../Sounds/hiTom.mp3");
  MIDTOM_SOUND = loadSound("../Sounds/midTom.mp3");
  OPENHIHAT_SOUND = loadSound("../Sounds/openHiHat.mp3");
  CRASH_SOUND = loadSound("../Sounds/crash.mp3");
  var xmlhttp = new XMLHttpRequest();
  starting = 120; // default tempo
  edited = false; // whether a clock is being editted or it is new
  remixed = false; // whether a clock is a remix or not
  names = []; // will contain names of all clocks of the user to check when naming
  xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        data = JSON.parse(this.responseText);
        
        if (data.new == 0) {
          savedCircles = data.Circles;
          if (data.tempo != null && data.tempo != 0) {
            starting = data.tempo;
          }
          if (data.remix == 1) {
            edited = false;
            remixed = true;
          }
          else {
            edited = true;
            remixed = false;
          }
        }
        else {
          names = data.Names;
          savedCircles = [];
        }
      }
  };
  xmlhttp.open("GET", "get.php?ClockID="+clockID, true);
  xmlhttp.send();
  TRASH_IMAGE = loadImage('../Icons/trash.png');
  KEYPAD_IMAGE = loadImage('keypad.png');
  
  
}

function setup() {
  // 720 was the original CLOCK_X (width/2)
  // 347 was the original CLOCK_Y
  // 250 was the original RADIUS
  // (OGX-720)/250 = x
  // (250*x) + 720
  // (OGY-348.8910081743869)/250 = y
  // (250*OGY) + 348.8910081743869
  // console.log((70-348.8910081743869)/250);
  // createCanvas(1440,734); //For chrome
  // Try below - maybe for things like radius or squares do whichever is smaller for the sizes
  // NewPosition.x = (NewScreenWidth/OldScreenWidth) * CurrentPosition.x;
  // NewPosition.y = (NewScreenYHeight/OldScreenHeight) * CurrentPosition.y;
  // NewSize.x = (NewScreenWidth/OldScreenWidth) * OldSize.x;
  // NewSize.y = (NewScreenHeight/OldScreenHeight) * OldSize.y;
  createCanvas(windowWidth,windowHeight); //Sets the height and width of the sketch to those of the chrome browser's window
  
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

  CLOCK_X = wRatio * 720;
  CLOCK_Y = hRatio * 347

  RADIUS = Math.min((wRatio*250),(hRatio*250)); // since the radius should be the same in both height and width the lowest one will be taken

  angle = 270;
  enter = 0;
  screen = 0;

  BUTTON_Y = hRatio * 20;
  BUTTON_HEIGHT = hRatio * 50; //50
  BUTTON_WIDTH = wRatio * 110;
  MAX_CIRCLES = 24;

  SOUND_BUTTON_WIDTH = wRatio * 240;
  SOUND_BUTTON_X = wRatio * 1150;

  clickedOnCircle = null;
  circleOnScreen = false;

  RED = color('#d94d4c');
  GREEN = color('#87aa66');
  BLACK = color('#000000');
  WHITE = color('#ffffff');
  ECLIPSE = color('#3e3e3e');
  YELLOW = color('#eca539');
  GREY = color(102,102,102);
  LIGHT_YELLOW = color('#ffc75b');
  VERY_LIGHT_YELLOW = color('#faf39f');
  PINK = color('#d24cb3');
  SILVER = 200;
  LIGHT_PINK = color('#f57fe6');
  LIGHT_RED = color('#fb7f7f');
  LIGHT_GREEN = color('#a9cc88');
  LIGHT_ECLIPSE = color('#999999');
  BLUE = color('#6495ED');
  LIGHT_BLUE = color('#87CEEB');
  BROWN = color('#7b3f00');
  LIGHT_BROWN = color('#d2b48c');
  PURPLE = color('#8A2BE2');
  LIGHT_PURPLE = color('#E0B0FF');
  TEAL = color('#008B8B');
  LIGHT_TEAL = color('#20B2AA');

  bgColor = WHITE;
  clockColor = YELLOW;

  TEXT_SIZE = Math.min((wRatio*30),(hRatio*30));

  CIRCLE_DIAMETER = Math.min((wRatio*20),(hRatio*20))
  circleOnScreen = false;
  CircleOutline = 0;

  checkMouseClicked = null;
  SCROLLBAR_HEIGHT = hRatio*30;
  hs1 = new HScrollbar(0, height-SCROLLBAR_HEIGHT, width, SCROLLBAR_HEIGHT,2,starting);

  snares = [];
  Kicks = [];
  cymbals = [];
  hiHats = [];
  openHiHats = [];
  hiToms = [];
  midToms = [];
  crashes = [];

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

    snares.push(snare);
    Kicks.push(kick);
    cymbals.push(cymbal);
    hiHats.push(hiHat);
    openHiHats.push(openHiHat);
    hiToms.push(hiTom);
    midToms.push(midTom);
    crashes.push(crash);

    circleX += (1.5 * CIRCLE_DIAMETER);
  }

  circles = [];
 
  snareCount = 0;
  cymbalCount = 0;
  kickCount = 0;
  hiHatCount = 0;
  openHiHatCount = 0;
  hiTomCount = 0;
  midTomCount = 0;
  crashCount = 0;
  // 1020
  // 890
  saveBtn = new Button(wRatio*1020,BUTTON_Y,BUTTON_WIDTH,BUTTON_HEIGHT,"SAVE",YELLOW,LIGHT_YELLOW);
  share = new Button(wRatio*890,BUTTON_Y,BUTTON_WIDTH,BUTTON_HEIGHT,"SHARE",YELLOW,LIGHT_YELLOW);

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

  first = 0;
  secnd = 0;
  clickCount = 0;
  stop1 = false;
  stop2 = false;

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

  illegals = ['§','±','`','~',',','<','=','+','[',']','{','}',':',';','|','\\',"'","\"",'/','?']; // characters that are not allowed to be in a clockName
  clockName = "";
    
  if(( edited || remixed ) && typeof savedCircles !== 'undefined'){
    for(i=0;i<savedCircles.length;i++){
      
      savedCircle = savedCircles[i];
    
      if(savedCircle.SoundID == 1){
        currentCircle = snareOp.sounds[snareOp.counter];
        currentCircle.ox = (savedCircle.X * RADIUS) + CLOCK_X;
        currentCircle.oy = (savedCircle.Y * RADIUS) + CLOCK_Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        snareOp.counter ++;
      }
      else if(savedCircle.SoundID == 2){
        currentCircle = kickOp.sounds[kickOp.counter];
        currentCircle.ox = (savedCircle.X * RADIUS) + CLOCK_X;
        currentCircle.oy = (savedCircle.Y * RADIUS) + CLOCK_Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        kickOp.counter ++;
      }
      else if(savedCircle.SoundID == 3){
        currentCircle = cymbalOp.sounds[cymbalOp.counter];
        currentCircle.ox = (savedCircle.X * RADIUS) + CLOCK_X;
        currentCircle.oy = (savedCircle.Y * RADIUS) + CLOCK_Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        cymbalOp.counter ++;
      }
      else if(savedCircle.SoundID == 4){
        currentCircle = hiHatOp.sounds[hiHatOp.counter];
        currentCircle.ox = (savedCircle.X * RADIUS) + CLOCK_X;
        currentCircle.oy = (savedCircle.Y * RADIUS) + CLOCK_Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        hiHatOp.counter ++;
      }
      else if(savedCircle.SoundID == 5){
        currentCircle = openHiHatOp.sounds[openHiHatOp.counter];
        currentCircle.ox = (savedCircle.X * RADIUS) + CLOCK_X;
        currentCircle.oy = (savedCircle.Y * RADIUS) + CLOCK_Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        openHiHatOp.counter ++;
      }
      else if(savedCircle.SoundID == 6){
        currentCircle = hiTomOp.sounds[hiTomOp.counter];
        currentCircle.ox = (savedCircle.X * RADIUS) + CLOCK_X;
        currentCircle.oy = (savedCircle.Y * RADIUS) + CLOCK_Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        hiTomOp.counter ++;
      }
      else if(savedCircle.SoundID == 7){
        currentCircle = midTomOp.sounds[midTomOp.counter];
        currentCircle.ox = (savedCircle.X * RADIUS) + CLOCK_X;
        currentCircle.oy = (savedCircle.Y * RADIUS) + CLOCK_Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        midTomOp.counter ++;
      }
      else{
        currentCircle = crashOp.sounds[crashOp.counter];
        currentCircle.ox = (savedCircle.X * RADIUS) + CLOCK_X;
        currentCircle.oy = (savedCircle.Y * RADIUS) + CLOCK_Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        crashOp.counter ++;
      }
    }
  }
}

function clock() {
  background(bgColor);
  strokeWeight(1);
  stroke(0);
  fill(clockColor); //colours the ellipse yellow
  ellipse(CLOCK_X, CLOCK_Y, RADIUS*2, RADIUS*2);

  overButton = 0; // will add 1 to this for each button that the mouse is hovering over and if it is greater than 0
  //                 the mouse will be a pointer

  trashBtn.drawButton();
  keypadBtn.drawButton();

  overButton += trashBtn.overButton();
  overButton += keypadBtn.overButton();

  for(i=0;i<options.length;i++){
    options[i].drawButton();
    overButton += options[i].overButton();
  }

  saveBtn.drawButton();
  share.drawButton();

  overButton += saveBtn.overButton();
  overButton += share.overButton();

  drawSlider(hs1);

  tempo = hs1.tempo/40;

  overButton += hs1.overEvent();
  

  lx = CLOCK_X + cos(radians(angle))*(RADIUS); // x and y positions of the end point of the metronome
  ly = CLOCK_Y + sin(radians(angle))*(RADIUS);
  strokeWeight(1);
  fill(clockColor);


  for(i = RADIUS/5;i < RADIUS+1;i += RADIUS/5){
    ellipse(CLOCK_X, CLOCK_Y, RADIUS*2-i, RADIUS*2-i); // draws the layers
  }

  side = (sqrt(2)/2)*RADIUS;

  strokeWeight(5);

  stroke(BLACK);

  line(CLOCK_X,CLOCK_Y-RADIUS,CLOCK_X,CLOCK_Y-RADIUS-10); // draws the markers at every 45 degrees
  line(CLOCK_X+RADIUS,CLOCK_Y,CLOCK_X+RADIUS+10,CLOCK_Y);
  line(CLOCK_X,CLOCK_Y+RADIUS,CLOCK_X,CLOCK_Y+RADIUS+10);
  line(CLOCK_X-RADIUS,CLOCK_Y,CLOCK_X-RADIUS-10,CLOCK_Y);
  line(CLOCK_X-side,CLOCK_Y-side,CLOCK_X-side-10,CLOCK_Y-side-10);
  line(CLOCK_X+side,CLOCK_Y-side,CLOCK_X+side+10,CLOCK_Y-side-10);
  line(CLOCK_X+side,CLOCK_Y+side,CLOCK_X+side+10,CLOCK_Y+side+10);
  line(CLOCK_X-side,CLOCK_Y+side,CLOCK_X-side-10,CLOCK_Y+side+10);

  line(CLOCK_X, CLOCK_Y, lx, ly);

  hit = false; // whether a circle has been hit or not

  pauseBtn.drawButton();
  rewindBtn.drawButton();
  fastForwardBtn.drawButton();

  overButton += pauseBtn.overButton()
  overButton += rewindBtn.overButton()
  overButton += fastForwardBtn.overButton() 

  for (i = 0;i<circles.length;i++) {
    circles[i].drawCircle();
    circles[i].onScreen = true;
    circleOnScreen = true;
    overButton += circles[i].overCircle();

    hit = lineCircle(CLOCK_X, CLOCK_Y, lx, ly, circles[i].ox, circles[i].oy, CIRCLE_DIAMETER/2, circleOnScreen);

    if (hit && !pauseBtn.paused){
      circles[i].playSound();
    }
  }

  if (overButton > 0) {
    cursor(HAND);
  }
  else {
    cursor(ARROW);
  }

  if (rewindBtn.timePressed > 0) {
    if (millis() - rewindBtn.timePressed >= 500) {
      // if the rewind button has been held for 500 or more milliseconds it will start moving the metronome backwards
      angle -= 250/40;
    }
  }
  else if (fastForwardBtn.timePressed > 0) {
    if (millis() - fastForwardBtn.timePressed >= 500) {
      // if the fast forward button has been held for 500 or more milliseconds it will start moving the metronome forwards
      angle += 250/40;
    }
  }
  else if (!pauseBtn.paused) {
    angle += tempo;
  }
}

function draw(){
  if(screen == 0){
    clock();
  }
  else if(screen == 1){
    hs1.tempo = keypad();
    enter = 0;
  }
}
