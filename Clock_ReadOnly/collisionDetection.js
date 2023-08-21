function pointCircle(lx, ly, ox, oy, RADIUS){
  distX = lx - ox;
  distY = ly - oy;
  distance = sqrt((distX*distX) + (distY*distY));

  // if the distance is less than the circle's
  // RADIUS the point is inside!
  if (distance <= RADIUS) {
    return true;
  }
  return false;
}

function lineCircle(x1,y1,x2,y2,cx,cy,r,circleOnScreen) {
  if(circleOnScreen){
    inside1 = pointCircle(x1,y1,cx,cy,r);
    inside2 = pointCircle(x2,y2, cx,cy,r);
    if (inside1 || inside2) {return true;}

    distX = x1 - x2;
    distY = y1 - y2;
    len = sqrt( (distX*distX) + (distY*distY) );

    dot = ( ((cx-x1)*(x2-x1)) + ((cy-y1)*(y2-y1)) ) / pow(len,2);

    closestX = x1 + (dot * (x2-x1));
    closestY = y1 + (dot * (y2-y1));

    onSegment = linePoint(x1,y1,x2,y2, closestX,closestY);
    if (!onSegment) {return false;}

    distX = closestX - cx;
    distY = closestY - cy;
    distance = sqrt( (distX*distX) + (distY*distY) );

    if (hs1.tempo > 105 && distance <= r+5) {
      return true;
    }
    else if (hs1.tempo > 65 && distance <= r/3) {
      return true;
    }
    else if (hs1.tempo > 0 && distance <= r/4) {
      return true;
    }
  }
  return false;
}

function linePoint(x1,y1,x2,y2,px,py){
  d1 = dist(px,py, x1,y1);
  d2 = dist(px,py, x2,y2);

  lineLen = dist(x1,y1, x2,y2);

  buffer = 0.1;

  if (d1+d2 >= lineLen-buffer && d1+d2 <= lineLen+buffer) {
    return true;
  }
  return false;
}

function layer(x1,y1,x2,y2,rad1,rad2){
  if(dist(x1,y1,x2,y2)>=rad1-rad2 && dist(x1,y1,x2,y2)<=rad1+rad2){
    return false;
  }
  return true;
}
