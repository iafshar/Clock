// Creates the Circle class
class Circle {
  constructor(sound, diameter, ox, oy, colour) {
    this.sound = sound;
    this.diameter = diameter;
    this.ox = ox;
    this.oy = oy;
    this.colour = colour;
    this.outline = 0;
    this.onScreen = false;
    this.lastPlayed = 0;
    this.startingX = ox;
    this.startingY = oy;
  }
  drawCircle(){
    fill(this.colour);
    stroke(BLACK);
    strokeWeight(this.outline);
    ellipse(this.ox, this.oy, this.diameter, this.diameter);
  }
  
  overCircle(){
    if (dist(mouseX,mouseY,this.ox,this.oy)<this.diameter/2){
      return true;
    }
    else{
      return false;
    }
  }
  playSound(){
    if (millis()-this.lastPlayed > 100) { // if it has been long enough since the circle has played its sound last
      this.sound.play();
      this.lastPlayed = millis();
    }
  }
}
