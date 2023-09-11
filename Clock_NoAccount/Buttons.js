// Creates the classes for all the types of buttons
class Button{
  constructor(x,y,Width,Height,text,buttonColor,hoverColor) {
    this.x = x;
    this.y = y;
    this.Width = Width;
    this.Height = Height;
    this.text = text;
    this.buttonColor = buttonColor;
    this.hoverColor = hoverColor;
  }
  overButton() {
   if (mouseX > this.x && mouseX < this.x+this.Width &&
      mouseY > this.y && mouseY < this.y+this.Height) {
     return true;
   }
   else {
     return false;

   }
 }
 drawButton() {
   if (this.overButton() && clickedOnCircle == null){
     var realColor = this.hoverColor;
   }
   else{
     var realColor = this.buttonColor;
   }
   stroke(realColor);
   strokeWeight(2.8);
   fill(bgColor);
   rect(this.x, this.y, this.Width, this.Height);

   textSize(30);
   strokeWeight(1);
   fill(realColor);
   textAlign(CENTER);
   text(this.text, this.x + (this.Width/2), this.y + 40);
 }

}

class Option extends Button{
 constructor(x,y,Width,Height,text,sounds,counter,buttonColor,hoverColor) {
   super(x,y,Width,Height,text,buttonColor,hoverColor);
   this.sounds = sounds;
   this.counter = counter;
 }
}

class PauseButton extends Button{
 constructor(x,y,Width,Height,buttonColor,hoverColor,paused) {
   super(x,y,Width,Height,"",buttonColor,hoverColor);
   this.paused = paused;
 }

 drawButton() {
   if (this.overButton() && clickedOnCircle == null){
     var realColor = this.hoverColor;
   }
   else{
     var realColor = this.buttonColor;
   }
   if (!this.paused) {
     stroke(realColor);
     
     line(this.x,this.y,this.x,this.y+this.Height);
     line(this.x+this.Width,this.y,this.x+this.Width,this.y+this.Height);
   }
   else {
     strokeWeight(0);
     fill(realColor);
     triangle(this.x,this.y,this.x,this.y+this.Height,this.x+this.Width,this.y+(this.Height/2));
   }

 }
}

class SeekButton extends Button{
 constructor(x,y,Width,Height,buttonColor,hoverColor,rewind,pressed) {
   super(x,y,Width,Height,"",buttonColor,hoverColor);
   this.rewind = rewind;
   this.pressed = pressed;
 }

 drawButton() {
   if ((this.overButton() && clickedOnCircle == null) || this.pressed){
     var realColor = this.hoverColor;
   }
   else{
     var realColor = this.buttonColor;
   }
   strokeWeight(0);
   fill(realColor);
   if (!this.rewind) {
     triangle(this.x,this.y,this.x,this.y+this.Height,this.x+(this.Width/2),this.y+(this.Height/2));
     triangle(this.x+(this.Width/2),this.y,this.x+(this.Width/2),this.y+this.Height,this.x+this.Width,this.y+(this.Height/2));
   }
   else {
     triangle(this.x,this.y+(this.Height/2),this.x+(this.Width/2),this.y,this.x+(this.Width/2),this.y+this.Height);
     triangle(this.x+(this.Width/2),this.y+(this.Height/2),this.x+this.Width,this.y,this.x+this.Width,this.y+this.Height);
   }
 }
}

class ImageButton extends Button{
 constructor(x,y,Width,Height,image) {
   super(x,y,Width,Height);
   this.image = image;
 }

 drawButton() {
   if (this.overButton() && clickedOnCircle == null){
     tint(0,0,0,100);
   }
   else {
     tint(0,0,0,255);
   }
   image(KEYPAD_IMAGE,this.x,this.y,this.Width,this.Height);

 }
}


class NumButton extends Button{
 constructor(x,y,text,diameter){
   super(x,y,width,height,text);
   this.diameter = diameter;
   this.numColor = WHITE;
 }
 overButton(){
   if (dist(mouseX,mouseY,this.x,this.y)<this.diameter/2){
     return true;
   }
   else{
     return false;
   } 
 }
 drawButton(){
   if (this.overButton()){
     this.numColor = SILVER;
   }
   else{
     this.numColor = WHITE;
   }
   fill(this.numColor);
   ellipse(this.x,this.y,this.diameter,this.diameter);
   fill(BLACK);
   textAlign(CENTER);
   text(this.text, this.x, this.y+5);
 }
}
