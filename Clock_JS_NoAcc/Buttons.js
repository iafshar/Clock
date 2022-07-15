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
  constructor(x,y,Width,Height,text,sound,buttonColor,hoverColor) {
    super(x,y,Width,Height,text);
    this.sound = sound;
    this.buttonColor = buttonColor;
    this.hoverColor = hoverColor;
  }
}
