class HScrollbar {
  constructor(xpos,ypos,swidth,sheight,loose,starting){
    this.xpos = xpos;
    this.swidth = swidth;
    this.sheight = sheight;
    this.ypos = ypos
    this.loose = loose;
    this.starting = starting;
    this.TempoRange = 205;
    this.Width = width;
    this.IncreaseTempo = this.Width/this.TempoRange;
    this.MinTempo = 25;
    this.MaxTempo = 225;
    this.tempo = this.MinTempo;
    this.over = false;
    this.locked = false;
    this.spos = this.IncreaseTempo * (this.starting-this.MinTempo);
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
    fill(clockColor); // colour of the text
    if (this.spos > this.Width-60){  // if the slider gets too close to the end of the screen it stops moving the text to avoid it going past the screen
      text(nf(this.tempo,3,0), this.Width-60, this.ypos-8);
      this.numX = this.Width-60;
      this.numY = this.ypos-8;
    }
    else{
      text(nf(this.tempo,3,0), this.spos-3, this.ypos-8); // else it moves the text along with the slider
      this.numX = this.spos-3;
      this.numY = this.ypos-8;
    }
  }

  getPos() {
    // Convert spos to be values between
    // 0 and the total width of the scrollbar
    return this.spos * this.ratio;
  }
}

function drawSlider(hs1){

  hs1.display();
  stroke(0);
}
