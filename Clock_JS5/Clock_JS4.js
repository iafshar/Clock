// code for the clock page, draw, setup and preload
function preload(){ //This function runs before the program is fully loaded.
  cymbalSound = loadSound("Sounds/cymbal.mp3");  //It makes sense to load the sounds here so that there are no time delays
  kickSound = loadSound("Sounds/kick.mp3");
  hiHatSound = loadSound("Sounds/hiHat.mp3");
  snareSound = loadSound("Sounds/snare.mp3");
  var xmlhttp = new XMLHttpRequest();
  starting = 120;
  edited = false;
  xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        data = JSON.parse(this.responseText);
        savedCircles = data.Circles;
        if(data.tempo != null && data.tempo != 0){
          edited = true;
          starting = data.tempo;
        }
      }
  };
  xmlhttp.open("GET", "get.php", true);
  xmlhttp.send();
  keypadImg = loadImage('keypad.png')
  
}

function setup() {
  createCanvas(windowWidth,windowHeight); //Sets the height and width of the sketch to those of the browser's window
  enter = 0;
  screen = 0;
  buttonY = 20;
  buttonHeight = 50;
  buttonWidth = 110;

  optionWidth = 200;
  optionX = 1150;

  ClickedOnCircle = null;
  CircleOnScreen = false;

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

  CircleDiameter = 20;
  CircleOnScreen = false;
  CircleOutline = 0;

  CheckMouseClicked = null;
  hs1 = new HScrollbar(0, height-30, width, 30,2,starting);

    snare = new Circle(snareSound, CircleDiameter, 20, 140, RED);
    snare2 = new Circle(snareSound, CircleDiameter,50,140, RED);
    snare3 = new Circle(snareSound, CircleDiameter,80,140, RED);
    snare4 = new Circle(snareSound, CircleDiameter,110,140, RED);
    snare5 = new Circle(snareSound, CircleDiameter,140,140, RED);
    snare6 = new Circle(snareSound, CircleDiameter,20,100, RED);
    snare7 = new Circle(snareSound, CircleDiameter,50,100, RED);
    snare8 = new Circle(snareSound, CircleDiameter,80,100, RED);
    snare9 = new Circle(snareSound, CircleDiameter,110,100, RED);
    snare10 = new Circle(snareSound, CircleDiameter,140,100, RED);
    snare11 = new Circle(snareSound, CircleDiameter, 170, 140, RED);
    snare12 = new Circle(snareSound, CircleDiameter,200,140, RED);
    snare13 = new Circle(snareSound, CircleDiameter,230,140, RED);
    snare14 = new Circle(snareSound, CircleDiameter,260,140, RED);
    snare15 = new Circle(snareSound, CircleDiameter,290,140, RED);
    snare16 = new Circle(snareSound, CircleDiameter,170,100, RED);
    snare17 = new Circle(snareSound, CircleDiameter,200,100, RED);
    snare18 = new Circle(snareSound, CircleDiameter,230,100, RED);
    snare19 = new Circle(snareSound, CircleDiameter,260,100, RED);
    snare20 = new Circle(snareSound, CircleDiameter,290,100, RED);
    snare21 = new Circle(snareSound, CircleDiameter, 320, 140, RED);
    snare22 = new Circle(snareSound, CircleDiameter,350,140, RED);
    snare23 = new Circle(snareSound, CircleDiameter,380,140, RED);
    snare24 = new Circle(snareSound, CircleDiameter,320,100, RED);
    snare25 = new Circle(snareSound, CircleDiameter,350,100, RED);

    cymbal = new Circle(cymbalSound, CircleDiameter,410,20, GREEN);
    cymbal2 = new Circle(cymbalSound, CircleDiameter,440,20, GREEN);
    cymbal3 = new Circle(cymbalSound, CircleDiameter,80,20, GREEN);
    cymbal4 = new Circle(cymbalSound, CircleDiameter,110,20, GREEN);
    cymbal5 = new Circle(cymbalSound, CircleDiameter,140,20, GREEN);
    cymbal6 = new Circle(cymbalSound, CircleDiameter,410,60, GREEN);
    cymbal7 = new Circle(cymbalSound, CircleDiameter,440,60, GREEN);
    cymbal8 = new Circle(cymbalSound, CircleDiameter,80,60, GREEN);
    cymbal9 = new Circle(cymbalSound, CircleDiameter,110,60, GREEN);
    cymbal10 = new Circle(cymbalSound, CircleDiameter,140,60, GREEN);
    cymbal11 = new Circle(cymbalSound, CircleDiameter,170,20, GREEN);
    cymbal12 = new Circle(cymbalSound, CircleDiameter,200,20, GREEN);
    cymbal13 = new Circle(cymbalSound, CircleDiameter,230,20, GREEN);
    cymbal14 = new Circle(cymbalSound, CircleDiameter,260,20, GREEN);
    cymbal15 = new Circle(cymbalSound, CircleDiameter,290,20, GREEN);
    cymbal16 = new Circle(cymbalSound, CircleDiameter,170,60, GREEN);
    cymbal17 = new Circle(cymbalSound, CircleDiameter,200,60, GREEN);
    cymbal18 = new Circle(cymbalSound, CircleDiameter,230,60, GREEN);
    cymbal19 = new Circle(cymbalSound, CircleDiameter,260,60, GREEN);
    cymbal20 = new Circle(cymbalSound, CircleDiameter,290,60, GREEN);
    cymbal21 = new Circle(cymbalSound, CircleDiameter,320,20, GREEN);
    cymbal22 = new Circle(cymbalSound, CircleDiameter,350,20, GREEN);
    cymbal23 = new Circle(cymbalSound, CircleDiameter,380,20, GREEN);
    cymbal24 = new Circle(cymbalSound, CircleDiameter,320,60, GREEN);
    cymbal25 = new Circle(cymbalSound, CircleDiameter,350,60, GREEN);

    kick = new Circle(kickSound, CircleDiameter,170,300, PINK);
    kick2 = new Circle(kickSound, CircleDiameter,200,300, PINK);
    kick3 = new Circle(kickSound, CircleDiameter,230,300, PINK);
    kick4 = new Circle(kickSound, CircleDiameter,260,300, PINK);
    kick5 = new Circle(kickSound, CircleDiameter,290,300, PINK);
    kick6 = new Circle(kickSound, CircleDiameter,170,260, PINK);
    kick7 = new Circle(kickSound, CircleDiameter,200,260, PINK);
    kick8 = new Circle(kickSound, CircleDiameter,230,260, PINK);
    kick9 = new Circle(kickSound, CircleDiameter,260,260, PINK);
    kick10 = new Circle(kickSound, CircleDiameter,290,260, PINK);
    kick11 = new Circle(kickSound, CircleDiameter,20,300, PINK);
    kick12 = new Circle(kickSound, CircleDiameter,50,300, PINK);
    kick13 = new Circle(kickSound, CircleDiameter,80,300, PINK);
    kick14 = new Circle(kickSound, CircleDiameter,110,300, PINK);
    kick15 = new Circle(kickSound, CircleDiameter,140,300, PINK);
    kick16 = new Circle(kickSound, CircleDiameter,20,260, PINK);
    kick17 = new Circle(kickSound, CircleDiameter,50,260, PINK);
    kick18 = new Circle(kickSound, CircleDiameter,80,260, PINK);
    kick19 = new Circle(kickSound, CircleDiameter,110,260, PINK);
    kick20 = new Circle(kickSound, CircleDiameter,140,260, PINK);
    kick21 = new Circle(kickSound, CircleDiameter,320,300, PINK);
    kick22 = new Circle(kickSound, CircleDiameter,350,300, PINK);
    kick23 = new Circle(kickSound, CircleDiameter,380,300, PINK);
    kick24 = new Circle(kickSound, CircleDiameter,320,260, PINK);
    kick25 = new Circle(kickSound, CircleDiameter,350,260, PINK);

    hiHat = new Circle(hiHatSound, CircleDiameter,20,180, ECLIPSE);
    hiHat2 = new Circle(hiHatSound, CircleDiameter,50,180, ECLIPSE);
    hiHat3 = new Circle(hiHatSound, CircleDiameter,80,180, ECLIPSE);
    hiHat4 = new Circle(hiHatSound, CircleDiameter,110,180, ECLIPSE);
    hiHat5 = new Circle(hiHatSound, CircleDiameter,140,180, ECLIPSE);
    hiHat6 = new Circle(hiHatSound, CircleDiameter,170,180, ECLIPSE);
    hiHat7 = new Circle(hiHatSound, CircleDiameter,200,180, ECLIPSE);
    hiHat8 = new Circle(hiHatSound, CircleDiameter,230,180, ECLIPSE);
    hiHat9 = new Circle(hiHatSound, CircleDiameter,260,180, ECLIPSE);
    hiHat10 = new Circle(hiHatSound, CircleDiameter,290,180, ECLIPSE);
    hiHat11 = new Circle(hiHatSound, CircleDiameter,20,220, ECLIPSE);
    hiHat12 = new Circle(hiHatSound, CircleDiameter,50,220, ECLIPSE);
    hiHat13 = new Circle(hiHatSound, CircleDiameter,80,220, ECLIPSE);
    hiHat14 = new Circle(hiHatSound, CircleDiameter,110,220, ECLIPSE);
    hiHat15 = new Circle(hiHatSound, CircleDiameter,140,220, ECLIPSE);
    hiHat16 = new Circle(hiHatSound, CircleDiameter,170,220, ECLIPSE);
    hiHat17 = new Circle(hiHatSound, CircleDiameter,200,220, ECLIPSE);
    hiHat18 = new Circle(hiHatSound, CircleDiameter,230,220, ECLIPSE);
    hiHat19 = new Circle(hiHatSound, CircleDiameter,260,220, ECLIPSE);
    hiHat20 = new Circle(hiHatSound, CircleDiameter,290,220, ECLIPSE);
    hiHat21 = new Circle(hiHatSound, CircleDiameter,320,220, ECLIPSE);
    hiHat22 = new Circle(hiHatSound, CircleDiameter,350,220, ECLIPSE);
    hiHat23 = new Circle(hiHatSound, CircleDiameter,320,180, ECLIPSE);
    hiHat24 = new Circle(hiHatSound, CircleDiameter,350,180, ECLIPSE);
    hiHat25 = new Circle(hiHatSound, CircleDiameter,380,180, ECLIPSE);

  Circles = [];

  Snares = [snare,snare2,snare3,snare4,snare5,snare6,snare7,snare8,snare9,snare10,snare11,snare12,snare13,snare14,snare15,snare16,snare17,snare18,snare19,snare20,snare21,snare22,snare23,snare24,snare25,];
  snareCount = 0;

  Cymbals = [cymbal,cymbal2,cymbal3,cymbal4,cymbal5,cymbal6,cymbal7,cymbal8,cymbal9,cymbal10,cymbal11,cymbal12,cymbal13,cymbal14,cymbal15,cymbal16,cymbal17,cymbal18,cymbal19,cymbal20,cymbal21,cymbal22,cymbal23,cymbal24,cymbal25,];
  cymbalCount = 0;

  Kicks = [kick,kick2,kick3,kick4,kick5,kick6,kick7,kick8,kick9,kick10,kick11,kick12,kick13,kick14,kick15,kick16,kick17,kick18,kick19,kick20,kick21,kick22,kick23,kick24,kick25,];
  kickCount = 0;

  hiHats = [hiHat,hiHat2,hiHat3,hiHat4,hiHat5,hiHat6,hiHat7,hiHat8,hiHat9,hiHat10,hiHat11,hiHat12,hiHat13,hiHat14,hiHat15,hiHat16,hiHat17,hiHat18,hiHat19,hiHat20,hiHat21,hiHat22,hiHat23,hiHat24,hiHat25,];
  hiHatCount = 0;

  saveBtn = new Button(1020,buttonY,buttonWidth,buttonHeight,"SAVE",YELLOW,LIGHT_YELLOW);
  share = new Button(890,buttonY,buttonWidth,buttonHeight,"SHARE",YELLOW,LIGHT_YELLOW);

  snareOp = new Option(optionX,buttonY,optionWidth,buttonHeight,"SNARE",Snares,snareCount,RED,LIGHT_RED);
  kickOp = new Option(optionX,buttonY+70,optionWidth,buttonHeight,"KICK",Kicks,kickCount,PINK,LIGHT_PINK);
  cymbalOp = new Option(optionX,buttonY+140,optionWidth,buttonHeight,"CYMBAL",Cymbals,cymbalCount,GREEN,LIGHT_GREEN);
  hiHatOp = new Option(optionX,buttonY+210,optionWidth,buttonHeight,"HI-HAT",hiHats,hiHatCount,ECLIPSE,LIGHT_ECLIPSE);

  Options = [snareOp, kickOp, cymbalOp, hiHatOp];

  clockX = width/2;
  clockY = height/2-20;
  radius = 250;
  angle = 270;

  first = 0;
  secnd = 0;
  ClickCount = 0;
  stop1 = false;
  stop2 = false;
  NumButtonDiameter = 50;
  one = new NumButton(200,200,'1',NumButtonDiameter);
  two = new NumButton(300,200,'2',NumButtonDiameter);
  three = new NumButton(400,200,'3',NumButtonDiameter);
  four = new NumButton(200,300,'4',NumButtonDiameter);
  five = new NumButton(300,300,'5',NumButtonDiameter);
  six = new NumButton(400,300,'6',NumButtonDiameter);
  seven = new NumButton(200,400,'7',NumButtonDiameter);
  eight = new NumButton(300,400,'8',NumButtonDiameter);
  nine = new NumButton(400,400,'9',NumButtonDiameter);
  zero = new NumButton(300,500,'0',NumButtonDiameter);

  Nums = [one,two,three,four,five,six,seven,eight,nine,zero,];

  clockName = "";
  if(edited && typeof savedCircles !== 'undefined'){
    for(i=0;i<savedCircles.length;i++){
      savedCircle = savedCircles[i];
      if(savedCircle.SoundID == 1){
        currentCircle = snareOp.sounds[snareOp.counter];
        currentCircle.ox = savedCircle.X;
        currentCircle.oy = savedCircle.Y;
        currentCircle.drawCircle();
        Circles.push(currentCircle);
        snareOp.counter ++;
      }
      else if(savedCircle.SoundID == 2){
        currentCircle = kickOp.sounds[kickOp.counter];
        currentCircle.ox = savedCircle.X;
        currentCircle.oy = savedCircle.Y;
        currentCircle.drawCircle();
        Circles.push(currentCircle);
        kickOp.counter ++;
      }
      else if(savedCircle.SoundID == 3){
        currentCircle = cymbalOp.sounds[cymbalOp.counter];
        currentCircle.ox = savedCircle.X;
        currentCircle.oy = savedCircle.Y;
        currentCircle.drawCircle();
        Circles.push(currentCircle);
        cymbalOp.counter ++;
      }
      else{
        currentCircle = hiHatOp.sounds[hiHatOp.counter];
        currentCircle.ox = savedCircle.X;
        currentCircle.oy = savedCircle.Y;
        currentCircle.drawCircle();
        Circles.push(currentCircle);
        hiHatOp.counter ++;
      }
    }
  }
}

function clock() {
  background(bgColor);
  strokeWeight(1);
  fill(clockColor); //colours the ellipse yellow
  ellipse(clockX, clockY, radius*2, radius*2);

  image(keypadImg,10,10,50,50)

  for(i=0;i<Options.length;i++){
    Options[i].drawButton();
  }

  saveBtn.drawButton();
  share.drawButton();

  drawSlider(hs1);
  tempo = hs1.tempo/40;

  lx = clockX + cos(radians(angle))*(radius);
  ly = clockY + sin(radians(angle))*(radius);
  strokeWeight(1);
  fill(clockColor);


  for(i = 50;i < 251;i += 50){
    ellipse(clockX, clockY, radius*2-i, radius*2-i);
  }

  side = (sqrt(2)/2)*radius;

  fill(bgColor);
  stroke(bgColor);

  ellipse(clockX-70,clockY+60,50,40);
  ellipse(clockX+60,clockY+30,50,40);

  strokeWeight(5);
  line(clockX-48,clockY+60,clockX-80,clockY-80);
  line(clockX+82,clockY+28,clockX+50,clockY-90);
  line(clockX-80,clockY-80,clockX+50,clockY-90);

  stroke(BLACK);

  line(clockX,clockY-radius,clockX,clockY-radius-10);
  line(clockX+radius,clockY,clockX+radius+10,clockY);
  line(clockX,clockY+radius,clockX,clockY+radius+10);
  line(clockX-radius,clockY,clockX-radius-10,clockY);
  line(clockX-side,clockY-side,clockX-side-10,clockY-side-10);
  line(clockX+side,clockY-side,clockX+side+10,clockY-side-10);
  line(clockX+side,clockY+side,clockX+side+10,clockY+side+10);
  line(clockX-side,clockY+side,clockX-side-10,clockY+side+10);

  line(clockX, clockY, lx, ly);

  hit = false;

  for (i = 0;i<Circles.length;i++) {
    Circles[i].drawCircle();
    Circles[i].onScreen = true;
    CircleOnScreen = true;

    hit = lineCircle(clockX, clockY, lx, ly, Circles[i].ox, Circles[i].oy, CircleDiameter/2, CircleOnScreen);

    if (hit){
        Circles[i].playSound();
    }
  }

  angle += tempo;
}

function draw(){
  if(screen == 0){
    clock();
  }
  else if(screen == 1){
    hs1.tempo = keypad();
    enter = 0;
  }
  else{
    naming();
  }
}
