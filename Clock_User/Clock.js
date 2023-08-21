// code for the clock page, draw, setup and preload
function preload(){ //This function runs before the program is fully loaded.
  CYMBAL_SOUND = loadSound("../Sounds/cymbal.mp3");  //It makes sense to load the sounds here so that there are no time delays
  KICK_SOUND = loadSound("../Sounds/kick.mp3");
  HIHAT_SOUND = loadSound("../Sounds/hiHat.mp3");
  SNARE_SOUND = loadSound("../Sounds/snare.mp3");
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
  KEYPAD_IMAGE = loadImage('keypad.png');
  
}

function setup() {
  createCanvas(windowWidth,windowHeight); //Sets the height and width of the sketch to those of the browser's window
  enter = 0;
  screen = 0;
  BUTTON_Y = 20;
  BUTTON_HEIGHT = 50;
  BUTTON_WIDTH = 110;

  SOUND_BUTTON_WIDTH = 200;
  SOUND_BUTTON_X = 1150;

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

  checkMouseClicked = null;
  hs1 = new HScrollbar(0, height-30, width, 30,2,starting);

    snare = new Circle(SNARE_SOUND, CIRCLE_DIAMETER, 20, 140, RED);
    snare2 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,50,140, RED);
    snare3 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,80,140, RED);
    snare4 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,110,140, RED);
    snare5 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,140,140, RED);
    snare6 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,20,100, RED);
    snare7 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,50,100, RED);
    snare8 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,80,100, RED);
    snare9 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,110,100, RED);
    snare10 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,140,100, RED);
    snare11 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER, 170, 140, RED);
    snare12 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,200,140, RED);
    snare13 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,230,140, RED);
    snare14 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,260,140, RED);
    snare15 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,290,140, RED);
    snare16 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,170,100, RED);
    snare17 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,200,100, RED);
    snare18 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,230,100, RED);
    snare19 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,260,100, RED);
    snare20 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,290,100, RED);
    snare21 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER, 320, 140, RED);
    snare22 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,350,140, RED);
    snare23 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,380,140, RED);
    snare24 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,320,100, RED);
    snare25 = new Circle(SNARE_SOUND, CIRCLE_DIAMETER,350,100, RED);

    cymbal = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,410,20, GREEN);
    cymbal2 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,440,20, GREEN);
    cymbal3 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,80,20, GREEN);
    cymbal4 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,110,20, GREEN);
    cymbal5 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,140,20, GREEN);
    cymbal6 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,410,60, GREEN);
    cymbal7 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,440,60, GREEN);
    cymbal8 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,80,60, GREEN);
    cymbal9 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,110,60, GREEN);
    cymbal10 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,140,60, GREEN);
    cymbal11 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,170,20, GREEN);
    cymbal12 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,200,20, GREEN);
    cymbal13 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,230,20, GREEN);
    cymbal14 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,260,20, GREEN);
    cymbal15 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,290,20, GREEN);
    cymbal16 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,170,60, GREEN);
    cymbal17 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,200,60, GREEN);
    cymbal18 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,230,60, GREEN);
    cymbal19 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,260,60, GREEN);
    cymbal20 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,290,60, GREEN);
    cymbal21 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,320,20, GREEN);
    cymbal22 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,350,20, GREEN);
    cymbal23 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,380,20, GREEN);
    cymbal24 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,320,60, GREEN);
    cymbal25 = new Circle(CYMBAL_SOUND, CIRCLE_DIAMETER,350,60, GREEN);

    kick = new Circle(KICK_SOUND, CIRCLE_DIAMETER,170,300, PINK);
    kick2 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,200,300, PINK);
    kick3 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,230,300, PINK);
    kick4 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,260,300, PINK);
    kick5 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,290,300, PINK);
    kick6 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,170,260, PINK);
    kick7 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,200,260, PINK);
    kick8 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,230,260, PINK);
    kick9 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,260,260, PINK);
    kick10 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,290,260, PINK);
    kick11 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,20,300, PINK);
    kick12 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,50,300, PINK);
    kick13 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,80,300, PINK);
    kick14 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,110,300, PINK);
    kick15 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,140,300, PINK);
    kick16 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,20,260, PINK);
    kick17 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,50,260, PINK);
    kick18 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,80,260, PINK);
    kick19 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,110,260, PINK);
    kick20 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,140,260, PINK);
    kick21 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,320,300, PINK);
    kick22 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,350,300, PINK);
    kick23 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,380,300, PINK);
    kick24 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,320,260, PINK);
    kick25 = new Circle(KICK_SOUND, CIRCLE_DIAMETER,350,260, PINK);

    hiHat = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,20,180, ECLIPSE);
    hiHat2 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,50,180, ECLIPSE);
    hiHat3 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,80,180, ECLIPSE);
    hiHat4 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,110,180, ECLIPSE);
    hiHat5 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,140,180, ECLIPSE);
    hiHat6 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,170,180, ECLIPSE);
    hiHat7 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,200,180, ECLIPSE);
    hiHat8 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,230,180, ECLIPSE);
    hiHat9 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,260,180, ECLIPSE);
    hiHat10 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,290,180, ECLIPSE);
    hiHat11 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,20,220, ECLIPSE);
    hiHat12 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,50,220, ECLIPSE);
    hiHat13 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,80,220, ECLIPSE);
    hiHat14 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,110,220, ECLIPSE);
    hiHat15 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,140,220, ECLIPSE);
    hiHat16 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,170,220, ECLIPSE);
    hiHat17 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,200,220, ECLIPSE);
    hiHat18 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,230,220, ECLIPSE);
    hiHat19 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,260,220, ECLIPSE);
    hiHat20 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,290,220, ECLIPSE);
    hiHat21 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,320,220, ECLIPSE);
    hiHat22 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,350,220, ECLIPSE);
    hiHat23 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,320,180, ECLIPSE);
    hiHat24 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,350,180, ECLIPSE);
    hiHat25 = new Circle(HIHAT_SOUND, CIRCLE_DIAMETER,380,180, ECLIPSE);

  circles = [];

  snares = [snare,snare2,snare3,snare4,snare5,snare6,snare7,snare8,snare9,snare10,snare11,snare12,snare13,snare14,snare15,snare16,snare17,snare18,snare19,snare20,snare21,snare22,snare23,snare24,snare25,];
  snareCount = 0;

  cymbals = [cymbal,cymbal2,cymbal3,cymbal4,cymbal5,cymbal6,cymbal7,cymbal8,cymbal9,cymbal10,cymbal11,cymbal12,cymbal13,cymbal14,cymbal15,cymbal16,cymbal17,cymbal18,cymbal19,cymbal20,cymbal21,cymbal22,cymbal23,cymbal24,cymbal25,];
  cymbalCount = 0;

  Kicks = [kick,kick2,kick3,kick4,kick5,kick6,kick7,kick8,kick9,kick10,kick11,kick12,kick13,kick14,kick15,kick16,kick17,kick18,kick19,kick20,kick21,kick22,kick23,kick24,kick25,];
  kickCount = 0;

  hiHats = [hiHat,hiHat2,hiHat3,hiHat4,hiHat5,hiHat6,hiHat7,hiHat8,hiHat9,hiHat10,hiHat11,hiHat12,hiHat13,hiHat14,hiHat15,hiHat16,hiHat17,hiHat18,hiHat19,hiHat20,hiHat21,hiHat22,hiHat23,hiHat24,hiHat25,];
  hiHatCount = 0;

  saveBtn = new Button(1020,BUTTON_Y,BUTTON_WIDTH,BUTTON_HEIGHT,"SAVE",YELLOW,LIGHT_YELLOW);
  share = new Button(890,BUTTON_Y,BUTTON_WIDTH,BUTTON_HEIGHT,"SHARE",YELLOW,LIGHT_YELLOW);

  snareOp = new Option(SOUND_BUTTON_X,BUTTON_Y,SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"SNARE",snares,snareCount,RED,LIGHT_RED);
  kickOp = new Option(SOUND_BUTTON_X,BUTTON_Y+70,SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"KICK",Kicks,kickCount,PINK,LIGHT_PINK);
  cymbalOp = new Option(SOUND_BUTTON_X,BUTTON_Y+140,SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"CYMBAL",cymbals,cymbalCount,GREEN,LIGHT_GREEN);
  hiHatOp = new Option(SOUND_BUTTON_X,BUTTON_Y+210,SOUND_BUTTON_WIDTH,BUTTON_HEIGHT,"HI-HAT",hiHats,hiHatCount,ECLIPSE,LIGHT_ECLIPSE);

  options = [snareOp, kickOp, cymbalOp, hiHatOp];

  CLOCK_X = width/2;
  CLOCK_Y = height/2-20;
  RADIUS = 250;
  angle = 270;

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
  enterBtn = new Button(width/2-BUTTON_WIDTH-10,height/2+150,BUTTON_WIDTH,BUTTON_HEIGHT,"ENTER",LIGHT_ECLIPSE,LIGHT_ECLIPSE);
  clearBtn = new Button(width/2+10,height/2+150,BUTTON_WIDTH,BUTTON_HEIGHT,"CLEAR",LIGHT_ECLIPSE,LIGHT_ECLIPSE);
  
  deleteNameDelay = 100; // used to delay deleting characters from clock name so that clicking backspace once doesnt remove a bunch of chars


  if(edited && typeof savedCircles !== 'undefined'){
    for(i=0;i<savedCircles.length;i++){
      savedCircle = savedCircles[i];
      if(savedCircle.SoundID == 1){
        currentCircle = snareOp.sounds[snareOp.counter];
        currentCircle.ox = savedCircle.X;
        currentCircle.oy = savedCircle.Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        snareOp.counter ++;
      }
      else if(savedCircle.SoundID == 2){
        currentCircle = kickOp.sounds[kickOp.counter];
        currentCircle.ox = savedCircle.X;
        currentCircle.oy = savedCircle.Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        kickOp.counter ++;
      }
      else if(savedCircle.SoundID == 3){
        currentCircle = cymbalOp.sounds[cymbalOp.counter];
        currentCircle.ox = savedCircle.X;
        currentCircle.oy = savedCircle.Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        cymbalOp.counter ++;
      }
      else{
        currentCircle = hiHatOp.sounds[hiHatOp.counter];
        currentCircle.ox = savedCircle.X;
        currentCircle.oy = savedCircle.Y;
        currentCircle.drawCircle();
        circles.push(currentCircle);
        hiHatOp.counter ++;
      }
    }
  }
}

function clock() {
  background(bgColor);
  strokeWeight(1);
  fill(clockColor); //colours the ellipse yellow
  ellipse(CLOCK_X, CLOCK_Y, RADIUS*2, RADIUS*2);

  image(KEYPAD_IMAGE,10,10,50,50);

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
