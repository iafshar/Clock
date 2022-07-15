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
  }
  drawCircle(){
    fill(this.colour);
    stroke(BLACK);
    strokeWeight(this.outline);
    ellipse(this.ox, this.oy, this.diameter, this.diameter);
  }
  playSound(){
    this.sound.play();
  }
}
