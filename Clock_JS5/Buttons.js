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
    if (this.overButton() && ClickedOnCircle == null){
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
