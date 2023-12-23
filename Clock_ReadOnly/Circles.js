class Circle {
  constructor(sound, diameter, ox, oy, colour) {
    this.sound = sound;
    this.diameter = diameter;
    this.ox = ox;
    this.oy = oy;
    this.colour = colour;
    this.outline = 0;
    this.onScreen = false;
    this.lastPlayed = -401;
  }
  drawCircle(){
    fill(this.colour);
    stroke(BLACK);
    strokeWeight(this.outline);
    ellipse(this.ox, this.oy, this.diameter, this.diameter);
  }
  playSound(){
    if (millis()-this.lastPlayed > 400) { // if it has been long enough since the circle has played its sound last
      // it will definitely be more than 400 because the circles cant move
      this.sound.play();
      this.lastPlayed = millis();
    }
  }
}
