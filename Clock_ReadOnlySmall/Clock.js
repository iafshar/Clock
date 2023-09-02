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
  starting = 120;
  
  xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        data = JSON.parse(this.responseText);
        savedCircles = data.Circles;
        starting = data.tempo;
      }
  };

  xmlhttp.open("GET", "get.php?ClockID="+clockID, true);
  xmlhttp.send();


}

function setup() {
  
  clockScreen = true;

  clickedOnCircle = null;
  circleOnScreen = false;

  RADIUS = 250;

  createCanvas(RADIUS*2,RADIUS*2);

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

  CIRCLE_DIAMETER = 20;
  circleOnScreen = false;
  CircleOutline = 0;
  MAX_CIRCLES = 24;

  checkMouseClicked = null;


  Width = width;
  Height = height;


  snares = [];
  Kicks = [];
  cymbals = [];
  hiHats = [];
  openHiHats = [];
  hiToms = [];
  midToms = [];
  crashes = [];

  STARTING_CIRCLE_X = 20;
  circleX = STARTING_CIRCLE_X;

  snareY = 20;
  kickY = 100;
  cymbalY = 180;
  hiHatY = 260;
  openHiHatY = 340;
  hiTomY = 420;
  midTomY = 500;
  crashY = 580;

  for (let i = 0; i < MAX_CIRCLES; i++) {
    if (i == MAX_CIRCLES/2) {
      snareY += 40;
      kickY += 40;
      cymbalY += 40;
      hiHatY += 40;
      openHiHatY += 40;
      hiTomY += 40;
      midTomY += 40;
      crashY += 40;

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

    circleX += 30;
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

  CLOCK_X = width/2;
  CLOCK_Y = height/2;
  angle = 270;

  if(typeof savedCircles !== 'undefined'){
    for(i=0;i<savedCircles.length;i++){
      savedCircle = savedCircles[i];
      if(savedCircle.SoundID == 1){
        currentCircle = snares[snareCount];
        currentCircle.ox = savedCircle.X;
        currentCircle.oy = savedCircle.Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        snareCount ++;
      }
      else if(savedCircle.SoundID == 2){
        currentCircle = Kicks[kickCount];
        currentCircle.ox = savedCircle.X;
        currentCircle.oy = savedCircle.Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        kickCount ++;
      }
      else if(savedCircle.SoundID == 3){
        currentCircle = cymbals[cymbalCount];
        currentCircle.ox = savedCircle.X;
        currentCircle.oy = savedCircle.Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        cymbalCount ++;
      }
      else if(savedCircle.SoundID == 4){
        currentCircle = hiHats[hiHatCount];
        currentCircle.ox = savedCircle.X;
        currentCircle.oy = savedCircle.Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        hiHatCount ++;
      }
      else if(savedCircle.SoundID == 5){
        currentCircle = openHiHats[openHiHatCount];
        currentCircle.ox = savedCircle.X;
        currentCircle.oy = savedCircle.Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        openHiHatCount ++;
      }
      else if(savedCircle.SoundID == 6){
        currentCircle = hiToms[hiTomCount];
        currentCircle.ox = savedCircle.X;
        currentCircle.oy = savedCircle.Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        hiTomCount ++;
      }
      else if(savedCircle.SoundID == 7){
        currentCircle = midToms[midTomCount];
        currentCircle.ox = savedCircle.X;
        currentCircle.oy = savedCircle.Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        midTomCount ++;
      }
      else{
        currentCircle = crashes[crashCount];
        currentCircle.ox = savedCircle.X;
        currentCircle.oy = savedCircle.Y;
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

  tempo = starting/40;

  lx = CLOCK_X + cos(radians(angle))*(RADIUS);
  ly = CLOCK_Y + sin(radians(angle))*(RADIUS);
  strokeWeight(1);
  fill(clockColor);


  for(i = 50;i < 251;i += 50){
    ellipse(CLOCK_X, CLOCK_Y, RADIUS*2-i, RADIUS*2-i);
  }

  side = (sqrt(2)/2)*RADIUS;

  fill(bgColor);
  stroke(bgColor);

  ellipse(CLOCK_X-70,CLOCK_Y+60,50,40);
  ellipse(CLOCK_X+60,CLOCK_Y+30,50,40);

  strokeWeight(5);
  line(CLOCK_X-48,CLOCK_Y+60,CLOCK_X-80,CLOCK_Y-80);
  line(CLOCK_X+82,CLOCK_Y+28,CLOCK_X+50,CLOCK_Y-90);
  line(CLOCK_X-80,CLOCK_Y-80,CLOCK_X+50,CLOCK_Y-90);

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
