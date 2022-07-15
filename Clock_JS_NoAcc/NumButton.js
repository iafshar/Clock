class NumButton{
  constructor(num,x,y,diameter){
    this.num = num;
    this.x = x;
    this.y = y;
    this.diameter = diameter;
    this.numColour = 255;
  }
  drawNum(){
    fill(0);
    textAlign(CENTER);
    text(this.num, this.x, this.y+5);
  }
  drawCirc(){
    fill(this.numColour);
    ellipse(this.x,this.y,this.diameter,this.diameter);
  }
  overNum(){
    if (dist(mouseX,mouseY,this.x,this.y)<this.diameter/2){
      this.numColour = 220;
    }
    else{
      this.numColour = 255;
    }
  }
}
