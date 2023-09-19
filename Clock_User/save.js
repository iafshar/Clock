function saving(){
  var circs = [];
  for(i = 0;i < circles.length;i++){
    circs[i] = [];
    if (circles[i].sound == SNARE_SOUND){
      circs[i][0] = 1;
    }
    else if (circles[i].sound == KICK_SOUND){
      circs[i][0] = 2;
    }
    else if (circles[i].sound == CYMBAL_SOUND){
      circs[i][0] = 3;
    }
    else if (circles[i].sound == HIHAT_SOUND){
      circs[i][0] = 4;
    }
    else if (circles[i].sound == OPENHIHAT_SOUND) {
      circs[i][0] = 5;
    }
    else if (circles[i].sound == HITOM_SOUND) {
      circs[i][0] = 6;
    }
    else if (circles[i].sound == MIDTOM_SOUND) {
      circs[i][0] = 7;
    }
    else {
      circs[i][0] = 8;
    }

    circs[i][1] = circles[i].ox;
    circs[i][2] = circles[i].oy;
  }
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.open("GET", "send.php?clockName=" + clockName + "&tempo=" + hs1.tempo + "&shared=" + shared + "&Circles=" + circs, true);
  xmlhttp.send();
  window.open("http://localhost:8080/Clock/myClocks.php", '_self');
}
