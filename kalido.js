var segments = 200,
  length = 10,
  width = 50,
  widthIncrement = 5,
  widthDuration = 10,
  colorIncrement = 8,
  colorDuration = 16,
  linesEnabled = "true",
  circlesEnabled = "true",
  rectanglesEnabled = "false";

var xCoords = [];
var yCoords = [];
var colors = [];
var rColors = [];
var gColors = [];
var bColors = [];
colors['r'] = rColors;
colors['g'] = gColors;
colors['b'] = bColors;
var widths = [];

var colorMax = 255;
var colorIncrementMax = colorIncrement;
var colorDurationMax = colorDuration;

var rColor = rand(0,colorMax);
var rColorDirection = rand(0,1);
var rColorIncrement = rand(1,colorIncrementMax);
var rColorDuration = rand(1,colorDurationMax);

var gColor = rand(0,colorMax);
var gColorDirection = rand(0,1);
var gColorIncrement = rand(0,colorIncrementMax);
var gColorDuration = rand(0,colorDurationMax);

var bColor = rand(0,colorMax);
var bColorDirection = rand(0,1);
var bColorIncrement = rand(0,colorIncrementMax);
var bColorDuration = rand(0,colorDurationMax);

var widthMax = width;
var lineWidth = rand(1,widthMax);
var widthDirection = rand(0,1);
var widthIncrementMax = widthIncrement;
var widthIncrement = rand(1,widthIncrementMax);
var widthDurationMax = widthDuration;
var widthDuration = rand(1,widthDurationMax);

var lineLength = length;
var xMax = 1700;
var yMax = 900;
var aspect = xMax/yMax;
var xDir = rand(0,1);
var yDir = rand(0,1);
var xDuration = rand(1,segments);
var yDuration = rand(1,segments);
var timeValue = 1;

function rand(randMin,randMax) {
  return Math.floor(Math.random() * (randMax - randMin + 1)) + randMin;
}

function d2h(d) {
  var hexString = d.toString(16);
  while (hexString.length < 6) {
    hexString = '0' + hexString;
  }
  return '#' + hexString;
}

function d2rgb(r,g,b){
  return 'rgb(' + r.toString() + ',' + g.toString() + ',' + b.toString() + ')';
}

function circle(x, y, radius, borderColor, borderWidth, fillColor){
  this.x = x;
  this.y = y;
  this.radius = radius;
  this.borderColor = borderColor;
  this.borderWidth = borderWidth;
  this.fillColor = fillColor;

  function draw(kalido) {
    kalido.beginPath();
    kalido.arc(this.x,this.y,this.radius,0,2*Math.PI);
    kalido.stroke
    kalido.fillStyle = fillColor;
    kalido.fill();
  }
}

function clear(kalido){
  //kalido.fillStyle = "black";
    kalido.clearRect(0,0,xMax,yMax);

}

function addLineCoord() {
  var newX;
  var newY;
  var oldX;
  var oldY;
  var rOldColor;
  var rNewColor;
  var gOldColor;
  var gNewColor;
  var bOldColor;
  var bNewColor;
  var oldWidth;
  var newWidth;

  coordIndex = xCoords.length - 1;
  // get last x and y
  oldX = xCoords[coordIndex];
  oldY = yCoords[coordIndex];
  if (xDir == 0) {
    newX = oldX - rand(1, lineLength);
    if (newX < 0 ) {
      newX = 1;
      xDir = 1;
    }
  } else {
    newX = oldX + rand(1, lineLength);
    if (newX > xMax) {
      newX = xMax;
      xDir = 0;
    }
  }
  if (yDir == 0) {
    newY = oldY - rand(1, lineLength);
    if (newY < 0 ) {
      newY = 1;
      yDir = 1;
    }
  } else {
    newY = oldY + rand(1, lineLength);
    if (newY > yMax) {
      newY = yMax;
      yDir = 0;
    }
  }
  xCoords.push(newX);
  yCoords.push(newY);

  xDuration--;
  if (xDuration == 0) {
    if (xDir == 0) {
      xDir = 1;
    } else {
      xDir = 0;
    }
    xDuration = rand(1, segments);
  }
  yDuration--;
  if (yDuration == 0) {
    if (yDir == 0) {
      yDir = 1;
    } else {
      yDir = 0;
    }
    yDuration = rand(1, segments);
  }

  rColorDuration--;
  if (rColorDuration < 0) {
    rOldColor = colors['r'][coordIndex];
    if (rColorDirection == 0) {
      rNewColor = rOldColor - rColorIncrement;
      if (rNewColor < 0 ) {
        rNewColor = rand(0,colorMax);
        rColorDirection = rand(0,1);
      }
    } else {
      rNewColor = rOldColor + rColorIncrement;
      if (rNewColor > colorMax) {
        rNewColor = rand(0,colorMax);
        rColorDirection = rand(0,1);
      }
    }
    rColorDuration = rand(1, colorDurationMax);
  } else {
    rNewColor = colors['r'][coordIndex];
  }
  colors['r'].push(rNewColor);

  gColorDuration--;
  if (gColorDuration < 0) {
    gOldColor = colors['g'][coordIndex];
    if (gColorDirection == 0) {
      gNewColor = gOldColor - gColorIncrement;
      if (gNewColor < 0 ) {
        gNewColor = rand(0,colorMax);
        gColorDirection = rand(0,1);
      }
    } else {
      gNewColor = gOldColor + gColorIncrement;
      if (gNewColor > colorMax) {
        gNewColor = rand(0,colorMax);
        gColorDirection = rand(0,1);
      }
    }
    gColorDuration = rand(1, colorDurationMax);
  } else {
    gNewColor = colors['g'][coordIndex];
  }
  colors['g'].push(gNewColor);

  bColorDuration--;
  if (bColorDuration < 0) {
    bOldColor = colors['b'][coordIndex];
    if (bColorDirection == 0) {
      bNewColor = bOldColor - bColorIncrement;
      if (bNewColor < 0 ) {
        bNewColor = rand(0, colorMax);
        bColorDirection = rand(0, 1);
      }
    } else {
      bNewColor = bOldColor + bColorIncrement;
      if (bNewColor > colorMax) {
        bNewColor = rand(0, colorMax);
        bColorDirection = rand(0, 1);
      }
    }
    bColorDuration = rand(1, colorDurationMax);
  } else {
    bNewColor = colors['b'][coordIndex];
  }
  colors['b'].push(bNewColor);

  widthDuration--;
  if (widthDuration < 0) {
    oldWidth = widths[coordIndex];
    if (widthDirection == 0) {
      newWidth = oldWidth - widthIncrement;
      if (newWidth <= 0 ) {
        newWidth = rand(1,widthMax);
        widthIncrement = rand(1,widthIncrementMax);
        widthDirection = rand(0,1);
      }
    } else {
      newWidth = oldWidth + widthIncrement;
      if (newWidth > widthMax) {
        newWidth = rand(1,widthMax);
        widthIncrement = rand(1,widthIncrementMax);
        widthDirection = rand(0,1);
      }
    }
  } else {
    newWidth = widths[coordIndex];
  }
  widths.push(newWidth);

  return 0;

}
function removeLineCoord(){
  xCoords.shift();
  yCoords.shift();
  colors['r'].shift();
  colors['g'].shift();
  colors['b'].shift();
  widths.shift();
}

function drawLine(kalido) {
  var lineColor;
    //ctx.save();
    kalido.lineCap = "round";
    kalido.lineJoin="round";

  for (var i = 1; i < xCoords.length ; i++) {
    xStart = xCoords[i-1];
    xEnd = xCoords[i];
    yStart = yCoords[i-1];
    yEnd = yCoords[i];

    kalido.beginPath();
      kalido.lineWidth = widths[i];
      lineColor = d2rgb(colors['r'][i],colors['g'][i],colors['b'][i]);
      kalido.strokeStyle = lineColor;

      //initial line
    kalido.moveTo(xStart,yStart);
      kalido.lineTo(xEnd,yEnd);

      // y mirror
      kalido.moveTo(xStart,yMax - yStart)
      kalido.lineTo(xEnd,yMax - yEnd);

      // x mirror
      kalido.moveTo(xMax - xStart,yStart)
      kalido.lineTo(xMax - xEnd,yEnd);

      // xy mirror
      kalido.moveTo(xMax - xStart,yMax - yStart)
      kalido.lineTo(xMax - xEnd,yMax - yEnd);

    xSwapStart = Math.round(yEnd * aspect);
    xSwapEnd = Math.round(yStart * aspect);
    ySwapStart = Math.round(xEnd / aspect);
    ySwapEnd = Math.round(xStart / aspect);

      //xy swap initial
      kalido.moveTo(xSwapStart,ySwapStart)
      kalido.lineTo(xSwapEnd,ySwapEnd);

    //swap y mirror
      kalido.moveTo(xSwapStart,yMax - ySwapStart)
      kalido.lineTo(xSwapEnd,yMax - ySwapEnd);

    //swap x mirror
      kalido.moveTo(xMax - xSwapStart,ySwapStart)
      kalido.lineTo(xMax - xSwapEnd,ySwapEnd);

      //swap xy mirror
      kalido.moveTo(xMax - xSwapStart,yMax - ySwapStart)
      kalido.lineTo(xMax - xSwapEnd,yMax - ySwapEnd);

      kalido.stroke();
  }
    //ctx.restore();
}

function randDraw(){
  var kalido = document.getElementById('canvas').getContext('2d');
  clear(kalido);
  if (linesEnabled) {
    addLineCoord();
    //if (xCoords.length == segments) {
    while ( xCoords.length > segments) {
      removeLineCoord();
    }
    drawLine(kalido);
  }
  if (circlesEnabled) {

  }
  if (rectanglesEnabled) {

  }
}

function resetSegments(newValue) {
  segments = newValue;
}

function resetLength(newValue) {
  lineLength = newValue;
}

function resetWidth(newValue) {
  widthMax = newValue;
}

function resetWidthIncrement(newValue) {
  widthIncrementMax = newValue;
}

function resetWidthDuration(newValue) {
   widthDurationMax = newValue;
}

function resetColorIncrement(newValue) {
  colorIncrementMax = newValue;
}

function resetColorDuration(newValue) {
  colorDurationMax = newValue;
}
function init(){
  // populate coordinate array
  xCoords[0] = Math.floor((Math.random()*xMax)+1);
  yCoords[0] = Math.floor((Math.random()*yMax)+1);
  colors['r'][0] = rColor;
  colors['g'][0] = gColor;
  colors['b'][0] = bColor;
  widths[0] = lineWidth;
  // set defaults in html control
  document.getElementById("segments").value = segments;
  document.getElementById("length").value = length;
  document.getElementById("width").value = widthMax;
  document.getElementById('widthIncrement').value = widthIncrementMax;
  document.getElementById('widthDuration').value = widthDurationMax;
  document.getElementById('colorDuration').value = colorDurationMax;
  document.getElementById('colorIncrement').value = colorIncrementMax;
  setInterval(randDraw,timeValue);
}
