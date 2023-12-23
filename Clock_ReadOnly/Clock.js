function preload(){
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
  xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        data = JSON.parse(this.responseText);
        savedCircles = data.Circles;
        if(data.tempo != 0){
          starting = data.tempo;
        }
      }
  };

  xmlhttp.open("GET", "get.php?ClockID="+clockID, true);
  xmlhttp.send();
}

function setup() {
  
  clockScreen = true;

  clickedOnCircle = null;
  circleOnScreen = false;

  createCanvas(windowWidth,windowHeight);
  wRatio = width/1440;
  hRatio = height/734;

  RED = color('#d94d4c');
  GREEN = color('#87aa66');
  BLACK = color('#000000');
  WHITE = color('#ffffff');
  ECLIPSE = color('#3e3e3e');
  YELLOW = color('#eca539');
  GREY = color(102,102,102);
  LIGHT_YELLOW = color('#ffc75b');
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

  CIRCLE_DIAMETER = Math.min((wRatio*20),(hRatio*20)) // since the diameter should be the same in both height and width the lowest one will be taken

  circleOnScreen = false;
  CircleOutline = 0;
  MAX_CIRCLES = 24;

  checkMouseClicked = null;

  Width = width;
  Height = height;

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

  CLOCK_X = wRatio * 720;
  CLOCK_Y = hRatio * 347
  RADIUS = Math.min((wRatio*250),(hRatio*250)); // since the radius should be the same in both height and width the lowest one will be taken

  angle = 270;

  if(typeof savedCircles !== 'undefined'){ // if there are circles for this clock
    for(i=0;i<savedCircles.length;i++){
      savedCircle = savedCircles[i];
      if(savedCircle.SoundID == 1){
        currentCircle = snares[snareCount];
        currentCircle.ox = (savedCircle.X * RADIUS) + CLOCK_X;
        currentCircle.oy = (savedCircle.Y * RADIUS) + CLOCK_Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        snareCount ++;
      }
      else if(savedCircle.SoundID == 2){
        currentCircle = Kicks[kickCount];
        currentCircle.ox = (savedCircle.X * RADIUS) + CLOCK_X;
        currentCircle.oy = (savedCircle.Y * RADIUS) + CLOCK_Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        kickCount ++;
      }
      else if(savedCircle.SoundID == 3){
        currentCircle = cymbals[cymbalCount];
        currentCircle.ox = (savedCircle.X * RADIUS) + CLOCK_X;
        currentCircle.oy = (savedCircle.Y * RADIUS) + CLOCK_Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        cymbalCount ++;
      }
      else if(savedCircle.SoundID == 4){
        currentCircle = hiHats[hiHatCount];
        currentCircle.ox = (savedCircle.X * RADIUS) + CLOCK_X;
        currentCircle.oy = (savedCircle.Y * RADIUS) + CLOCK_Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        hiHatCount ++;
      }
      else if(savedCircle.SoundID == 5){
        currentCircle = openHiHats[openHiHatCount];
        currentCircle.ox = (savedCircle.X * RADIUS) + CLOCK_X;
        currentCircle.oy = (savedCircle.Y * RADIUS) + CLOCK_Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        openHiHatCount ++;
      }
      else if(savedCircle.SoundID == 6){
        currentCircle = hiToms[hiTomCount];
        currentCircle.ox = (savedCircle.X * RADIUS) + CLOCK_X;
        currentCircle.oy = (savedCircle.Y * RADIUS) + CLOCK_Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        hiTomCount ++;
      }
      else if(savedCircle.SoundID == 7){
        currentCircle = midToms[midTomCount];
        currentCircle.ox = (savedCircle.X * RADIUS) + CLOCK_X;
        currentCircle.oy = (savedCircle.Y * RADIUS) + CLOCK_Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        midTomCount ++;
      }
      else{
        currentCircle = crashes[crashCount];
        currentCircle.ox = (savedCircle.X * RADIUS) + CLOCK_X;
        currentCircle.oy = (savedCircle.Y * RADIUS) + CLOCK_Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        crashCount ++;
      }
    }
  }
}

function clock() {
  background(bgColor);
  strokeWeight(1);
  fill(clockColor); //colours the ellipse yellow
  ellipse(CLOCK_X, CLOCK_Y, RADIUS*2, RADIUS*2);

  drawSlider(hs1);
  tempo = hs1.tempo/40;

  lx = CLOCK_X + cos(radians(angle))*(RADIUS); // x and y positions of the end point of the metronome
  ly = CLOCK_Y + sin(radians(angle))*(RADIUS);
  strokeWeight(1);
  fill(clockColor);


  for(i = RADIUS/5;i < RADIUS+1;i += RADIUS/5){
    ellipse(CLOCK_X, CLOCK_Y, RADIUS*2-i, RADIUS*2-i); // draws the layers
  }

  side = (sqrt(2)/2)*RADIUS;

  fill(bgColor);
  stroke(bgColor);


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

  for (i = 0;i<circles.length;i++) {
    circles[i].drawCircle();
    circles[i].onScreen = true;
    circleOnScreen = true;

    hit = lineCircle(CLOCK_X, CLOCK_Y, lx, ly, circles[i].ox, circles[i].oy, CIRCLE_DIAMETER/2, circleOnScreen);

    if (hit){
        circles[i].playSound();
    }
  }

  angle += tempo;
}

function draw(){
  if(clockScreen){
    clock();
  }
}
