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

  RADIUS = 250/4;

  createCanvas(400,200);

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

  CIRCLE_DIAMETER = 20/4;
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

  STARTING_CIRCLE_X = 20/4;
  circleX = STARTING_CIRCLE_X;

  snareY = 20/4;
  kickY = 100/4;
  cymbalY = 180/4;
  hiHatY = 260/4;
  openHiHatY = 340/4;
  hiTomY = 420/4;
  midTomY = 500/4;
  crashY = 580/4;

  for (let i = 0; i < MAX_CIRCLES; i++) {
    if (i == MAX_CIRCLES/2) {
      snareY += 40/4;
      kickY += 40/4;
      cymbalY += 40/4;
      hiHatY += 40/4;
      openHiHatY += 40/4;
      hiTomY += 40/4;
      midTomY += 40/4;
      crashY += 40/4;

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

    circleX += 30/4;
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

  CLOCK_X = 1440/8;
  CLOCK_Y = (734/2-20)/4;
  angle = 270;

  if(typeof savedCircles !== 'undefined'){
    for(i=0;i<savedCircles.length;i++){
      savedCircle = savedCircles[i];
      if(savedCircle.SoundID == 1){
        currentCircle = snares[snareCount];
        currentCircle.ox = savedCircle.X/4;
        currentCircle.oy = savedCircle.Y/4;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        snareCount ++;
      }
      else if(savedCircle.SoundID == 2){
        currentCircle = Kicks[kickCount];
        currentCircle.ox = savedCircle.X/4;
        currentCircle.oy = savedCircle.Y/4;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        kickCount ++;
      }
      else if(savedCircle.SoundID == 3){
        currentCircle = cymbals[cymbalCount];
        currentCircle.ox = savedCircle.X/4;
        currentCircle.oy = savedCircle.Y/4;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        cymbalCount ++;
      }
      else if(savedCircle.SoundID == 4){
        currentCircle = hiHats[hiHatCount];
        currentCircle.ox = savedCircle.X/4;
        currentCircle.oy = savedCircle.Y/4;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        hiHatCount ++;
      }
      else if(savedCircle.SoundID == 5){
        currentCircle = openHiHats[openHiHatCount];
        currentCircle.ox = savedCircle.X/4;
        currentCircle.oy = savedCircle.Y/4;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        openHiHatCount ++;
      }
      else if(savedCircle.SoundID == 6){
        currentCircle = hiToms[hiTomCount];
        currentCircle.ox = savedCircle.X/4;
        currentCircle.oy = savedCircle.Y/4;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        hiTomCount ++;
      }
      else if(savedCircle.SoundID == 7){
        currentCircle = midToms[midTomCount];
        currentCircle.ox = savedCircle.X/4;
        currentCircle.oy = savedCircle.Y/4;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        midTomCount ++;
      }
      else{
        currentCircle = crashes[crashCount];
        currentCircle.ox = savedCircle.X/4;
        currentCircle.oy = savedCircle.Y/4;
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

  strokeWeight(0);
  fill(0);
  
  text(starting,370,185);

  lx = CLOCK_X + cos(radians(angle))*(RADIUS);
  ly = CLOCK_Y + sin(radians(angle))*(RADIUS);
  strokeWeight(1);
  fill(clockColor);


  for(i = 50/4;i < 251/4;i += 50/4){
    ellipse(CLOCK_X, CLOCK_Y, RADIUS*2-i, RADIUS*2-i);
  }

  side = (sqrt(2)/2)*RADIUS;


  stroke(BLACK);


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
