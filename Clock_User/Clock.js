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
  starting = 120;
  edited = false;
  remixed = false;
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
  // 348.8910081743869 was the original CLOCK_Y
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
  
  CLOCK_X = width/2;
  CLOCK_Y = height/2-(windowHeight/36.7);
  RADIUS = windowWidth/5.76;
  angle = 270;
  enter = 0;
  screen = 0;

  BUTTON_Y = (-1.3155640326975477*RADIUS) + CLOCK_Y;
  BUTTON_END = (-1.1155640326975476*RADIUS) + CLOCK_Y;
  BUTTON_HEIGHT = BUTTON_END - BUTTON_Y; //50
  BUTTON_WIDTH = windowWidth/13.09;
  MAX_CIRCLES = 24;

  SOUND_BUTTON_WIDTH = windowWidth/6;
  SOUND_BUTTON_X = windowWidth/1.2522;

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

  CIRCLE_DIAMETER = windowWidth/72;
  circleOnScreen = false;
  CircleOutline = 0;

  checkMouseClicked = null;
  hs1 = new HScrollbar(0, height-30, width, windowHeight/24.4667,2,starting);

  snares = [];
  Kicks = [];
  cymbals = [];
  hiHats = [];
  openHiHats = [];
  hiToms = [];
  midToms = [];
  crashes = [];

  STARTING_CIRCLE_X = windowWidth/72;
  circleX = STARTING_CIRCLE_X;
  snareY = (-1.3155640326975477 * RADIUS) + CLOCK_Y;
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
  saveBtn = new Button(windowWidth/1.4118,BUTTON_Y,BUTTON_WIDTH,BUTTON_HEIGHT,"SAVE",YELLOW,LIGHT_YELLOW);
  share = new Button(windowWidth/1.61798,BUTTON_Y,BUTTON_WIDTH,BUTTON_HEIGHT,"SHARE",YELLOW,LIGHT_YELLOW);

  snareOp = new Option(SOUND_BUTTON_X,BUTTON_Y,SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"SNARE",snares,snareCount,RED,LIGHT_RED);
  kickOp = new Option(SOUND_BUTTON_X,BUTTON_Y+(BUTTON_HEIGHT+CIRCLE_DIAMETER),SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"KICK",Kicks,kickCount,PINK,LIGHT_PINK);
  cymbalOp = new Option(SOUND_BUTTON_X,BUTTON_Y+(2*(BUTTON_HEIGHT+CIRCLE_DIAMETER)),SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"RIDE",cymbals,cymbalCount,GREEN,LIGHT_GREEN);
  hiHatOp = new Option(SOUND_BUTTON_X,BUTTON_Y+(3*(BUTTON_HEIGHT+CIRCLE_DIAMETER)),SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"CLOSED HI-HAT",hiHats,hiHatCount,ECLIPSE,LIGHT_ECLIPSE);
  openHiHatOp = new Option(SOUND_BUTTON_X,BUTTON_Y+(4*(BUTTON_HEIGHT+CIRCLE_DIAMETER)),SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"OPEN HI-HAT",openHiHats,openHiHatCount,BLUE,LIGHT_BLUE);
  hiTomOp = new Option(SOUND_BUTTON_X,BUTTON_Y+(5*(BUTTON_HEIGHT+CIRCLE_DIAMETER)),SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"HI-TOM",hiToms,hiTomCount,BROWN,LIGHT_BROWN);
  midTomOp = new Option(SOUND_BUTTON_X,BUTTON_Y+(6*(BUTTON_HEIGHT+CIRCLE_DIAMETER)),SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"MID-TOM",midToms,midTomCount,PURPLE,LIGHT_PURPLE);
  crashOp = new Option(SOUND_BUTTON_X,BUTTON_Y+(7*(BUTTON_HEIGHT+CIRCLE_DIAMETER)),SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"CRASH",crashes,crashCount,TEAL,LIGHT_TEAL);

  options = [snareOp, kickOp, cymbalOp, hiHatOp, openHiHatOp, hiTomOp, midTomOp, crashOp];

  pauseBtn = new PauseButton(CLOCK_X-15,CLOCK_Y-25,30,50,WHITE,VERY_LIGHT_YELLOW,false);
  rewindBtn = new SeekButton(CLOCK_X-105,CLOCK_Y-25,60,50,WHITE,VERY_LIGHT_YELLOW,true);
  fastForwardBtn = new SeekButton(CLOCK_X+45,CLOCK_Y-25,60,50,WHITE,VERY_LIGHT_YELLOW,false);

  keypadBtn = new ImageButton(width-60,height-120,50,50,KEYPAD_IMAGE);
  trashBtn = new ImageButton(width-120,height-120,50,50,TRASH_IMAGE,true);

  first = 0;
  secnd = 0;
  clickCount = 0;
  stop1 = false;
  stop2 = false;
  NUM_BUTTON_DIAMETER = 50;
  one = new NumButton(200,200,'1',NUM_BUTTON_DIAMETER);
  two = new NumButton(300,200,'2',NUM_BUTTON_DIAMETER);
  three = new NumButton(400,200,'3',NUM_BUTTON_DIAMETER);
  four = new NumButton(200,300,'4',NUM_BUTTON_DIAMETER);
  five = new NumButton(300,300,'5',NUM_BUTTON_DIAMETER);
  six = new NumButton(400,300,'6',NUM_BUTTON_DIAMETER);
  seven = new NumButton(200,400,'7',NUM_BUTTON_DIAMETER);
  eight = new NumButton(300,400,'8',NUM_BUTTON_DIAMETER);
  nine = new NumButton(400,400,'9',NUM_BUTTON_DIAMETER);
  zero = new NumButton(300,500,'0',NUM_BUTTON_DIAMETER);

  nums = [one,two,three,four,five,six,seven,eight,nine,zero,];

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

  trashBtn.drawButton();
  keypadBtn.drawButton();

  for(i=0;i<options.length;i++){
    options[i].drawButton();
  }

  saveBtn.drawButton();
  share.drawButton();
  

  drawSlider(hs1);

  tempo = hs1.tempo/40;
  

  lx = CLOCK_X + cos(radians(angle))*(RADIUS);
  ly = CLOCK_Y + sin(radians(angle))*(RADIUS);
  strokeWeight(1);
  fill(clockColor);


  for(i = RADIUS/5;i < RADIUS+1;i += RADIUS/5){
    ellipse(CLOCK_X, CLOCK_Y, RADIUS*2-i, RADIUS*2-i);
  }

  side = (sqrt(2)/2)*RADIUS;

  strokeWeight(5);

  stroke(BLACK);

  line(CLOCK_X,CLOCK_Y-RADIUS,CLOCK_X,CLOCK_Y-RADIUS-10);
  line(CLOCK_X+RADIUS,CLOCK_Y,CLOCK_X+RADIUS+10,CLOCK_Y);
  line(CLOCK_X,CLOCK_Y+RADIUS,CLOCK_X,CLOCK_Y+RADIUS+10);
  line(CLOCK_X-RADIUS,CLOCK_Y,CLOCK_X-RADIUS-10,CLOCK_Y);
  line(CLOCK_X-side,CLOCK_Y-side,CLOCK_X-side-10,CLOCK_Y-side-10);
  line(CLOCK_X+side,CLOCK_Y-side,CLOCK_X+side+10,CLOCK_Y-side-10);
  line(CLOCK_X+side,CLOCK_Y+side,CLOCK_X+side+10,CLOCK_Y+side+10);
  line(CLOCK_X-side,CLOCK_Y+side,CLOCK_X-side-10,CLOCK_Y+side+10);

  line(CLOCK_X, CLOCK_Y, lx, ly);

  hit = false;

  pauseBtn.drawButton();
  rewindBtn.drawButton();
  fastForwardBtn.drawButton();

  for (i = 0;i<circles.length;i++) {
    circles[i].drawCircle();
    circles[i].onScreen = true;
    circleOnScreen = true;

    hit = lineCircle(CLOCK_X, CLOCK_Y, lx, ly, circles[i].ox, circles[i].oy, CIRCLE_DIAMETER/2, circleOnScreen);

    if (hit && !pauseBtn.paused){
      circles[i].playSound();
    }
  }

  if (rewindBtn.timePressed > 0) {
    if (millis() - rewindBtn.timePressed >= 500) {
      angle -= 250/40;
    }
  }
  else if (fastForwardBtn.timePressed > 0) {
    if (millis() - fastForwardBtn.timePressed >= 500) {
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
