// function for naming your clock after you choose to save or share it for the first time
function naming(){
  background(255);
  text("Name Your Clock",width/2-150, 200);
  text(clockName,width/2-150,height/2);
}

function saving(){
  var circs = [];
  for(i = 0;i < Circles.length;i++){
    circs[i] = [];
    if (Circles[i].sound == snareSound){
      circs[i][0] = 1;
    }
    else if (Circles[i].sound == kickSound){
      circs[i][0] = 2;
    }
    else if (Circles[i].sound == cymbalSound){
      circs[i][0] = 3;
    }
    else{
      circs[i][0] = 4;
    }
    circs[i][1] = Circles[i].ox;
    circs[i][2] = Circles[i].oy;
  }
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.open("GET", "send.php?clockName=" + clockName + "&tempo=" + hs1.tempo + "&shared=" + shared + "&Circles=" + circs, true);
  xmlhttp.send();
  window.open("http://localhost:8080/Clock/MyClocks.php", '_self');
}
