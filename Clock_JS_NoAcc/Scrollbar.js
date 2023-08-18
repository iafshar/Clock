class HScrollbar {
  constructor(xpos,ypos,swidth,sheight,loose){
    this.xpos = xpos;
    this.swidth = swidth;
    this.sheight = sheight;
    this.ypos = ypos-this.sheight/2;
    this.loose = loose;
    this.TempoRange = 205;
    this.Width = width;
    this.IncreaseTempo = this.Width/this.TempoRange;
    this.MinTempo = 25;
    this.MaxTempo = 225;
    this.tempo = this.MinTempo;
    this.over = false;
    this.locked = false; 
    this.spos = this.IncreaseTempo * (120-this.MinTempo);
    this.WidthToHeight = this.swidth - this.sheight;
    this.ratio = this.sw/this.WidthToHeight; 
    this.newspos = this.spos;
    this.sposMin = this.xpos;
    this.sposMax = this.xpos + this.swidth - this.sheight;
    this.numX = null;
    this.numY = null;
  }
  display() {
    noStroke();
    fill(204);
    rect(this.xpos, this.ypos, this.swidth, this.sheight);
    textAlign(LEFT);
    text("Tempo:", this.xpos, this.ypos - 40);
    if (this.over || this.locked) {
      fill(0, 0, 0);
    } else {
      fill(GREY);
    }
    rect(this.spos, this.ypos, this.sheight, this.sheight); // creates the slider
    
    this.tempo = round(this.spos/this.IncreaseTempo) + this.MinTempo;  
    textSize(30); 
    if(mouseX >= this.numX && mouseX <= this.numX+50 && mouseY >= this.numY-20 && mouseY <= this.numY+3){
      fill(LIGHT_YELLOW);
    }
    else{
      fill(clockColor); // colour of the text
    }
    if (this.spos > this.Width-60){  // if the slider gets too close to the end of the screen it stops moving the text to avoid it going past the screen
      text(this.tempo, this.Width-60, this.ypos-8);
      this.numX = this.Width-60;
      this.numY = this.ypos-8;
    }
    else{
      text(this.tempo, this.spos-3, this.ypos-8); // else it moves the text along with the slider
      this.numX = this.spos-3;
      this.numY = this.ypos-8;
    }
  }
  
  overEvent() {
    if (mouseX > this.xpos && mouseX < this.xpos+this.swidth &&
       mouseY > this.ypos && mouseY < this.ypos+this.sheight) {
      return true;
    } else {
      return false;
    }
  }
  
  update() {
    if (this.overEvent()) {
      this.over = true;
    } else {
      this.over = false;
    }
    if (mouseButton != 0 && this.over) {
      this.locked = true;
      
    }
    if (mouseButton == 0) {
      this.locked = false;
    }
    if(enter!=0){
      this.spos = this.IncreaseTempo * (enter-this.MinTempo);
    }
    else{
      if (this.locked) {
        this.newspos = constrain(mouseX-this.sheight/2, this.sposMin, this.sposMax);
      }
      if (abs(this.newspos - this.spos) > 1){
        this.spos += (this.newspos-this.spos)/this.loose;
      }
    }
  }
  
  constrain(val, minv, maxv) {
    return min(max(val, minv), maxv);
  }
  getPos() {
    // Convert spos to be values between
    // 0 and the total width of the scrollbar
    return this.spos * this.ratio;
  }
}

function drawSlider(hs1){

  hs1.update();
  hs1.display();
  stroke(0);
}
