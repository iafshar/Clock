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
    if (millis()-this.lastPlayed > 400) {
      this.sound.play();
      this.lastPlayed = millis();
    }
  }
}
