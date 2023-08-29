function preload(){
  CYMBAL_SOUND = loadSound("../Sounds/cymbal.mp3");
  KICK_SOUND = loadSound("../Sounds/kick.mp3");
  HIHAT_SOUND = loadSound("../Sounds/hiHat.mp3");
  SNARE_SOUND = loadSound("../Sounds/snare.mp3");
  var xmlhttp = new XMLHttpRequest();
  starting = 120;
  xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        data = JSON.parse(this.responseText);
        savedCircles = data.Circles;
        if(data.tempo != 0){
          starting = data.tempo;
        }
      }
  };

  xmlhttp.open("GET", "get.php", true);
  xmlhttp.send();
}

function setup() {
  
  clockScreen = true;

  clickedOnCircle = null;
  circleOnScreen = false;

  createCanvas(windowWidth,windowHeight);

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

  bgColor = WHITE;
  clockColor = YELLOW;

  CIRCLE_DIAMETER = 20;
  circleOnScreen = false;
  CircleOutline = 0;
  MAX_CIRCLES = 24;

  checkMouseClicked = null;


  Width = width;
  Height = height;

  hs1 = new HScrollbar(0, height-30, width, 30,2,starting);

    snares = [];
  Kicks = [];
  cymbals = [];
  hiHats = [];

  STARTING_CIRCLE_X = 20;
  circleX = STARTING_CIRCLE_X;

  snareY = 100;
  kickY = 180;
  cymbalY = 260;
  hiHatY = 340;

  for (let i = 0; i < MAX_CIRCLES; i++) {
    if (i == MAX_CIRCLES/2) {
      snareY += 40
      kickY += 40
      cymbalY += 40
      hiHatY += 40

      circleX = STARTING_CIRCLE_X;
    }
    snare = new Circle(SNARE_SOUND, CIRCLE_DIAMETER, circleX, snareY, RED);
    kick = new Circle(KICK_SOUND, CIRCLE_DIAMETER, circleX, kickY, PINK);
    cymbal = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER, circleX, cymbalY, GREEN);
    hiHat = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER, circleX, hiHatY, ECLIPSE);

    circleX += 30;

    snares.push(snare);
    Kicks.push(kick);
    cymbals.push(cymbal);
    hiHats.push(hiHat);
  }

  circles = [];
 
  snareCount = 0;
  cymbalCount = 0;
  kickCount = 0;
  hiHatCount = 0;

  CLOCK_X = width/2;
  CLOCK_Y = height/2-20;
  RADIUS = 250;
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
      else{
        currentCircle = hiHats[hiHatCount];
        currentCircle.ox = savedCircle.X;
        currentCircle.oy = savedCircle.Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        hiHatCount ++;
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
