<?php
#defaults
$segments = 200;
$length = 10;
$width = 50;
$widthIncrement = 5;
$widthDuration = 10;
$colorIncrement = 8;
$colorDuration = 16;
$linesEnabled = "true";
$circlesEnabled = "false";
$rectanglesEnabled = "false";

#if any POST values are passed in, then use them, else use defaults
if (count($_POST)){
	if (isset($_POST['segments'])) {
		$segments = $_POST['segments'];
	}
	if (isset($_POST['length'])) {
		$length = $_POST['length'];
	}
	if (isset($_POST['width'])) {
		$width = $_POST['width'];
	}
	if (isset($_POST['colorIncrement'])) {
		$colorIncrement = $_POST['colorIncrement'];
	}
	if (isset($_POST['colorDuration'])) {
		$colorDuration = $_POST['colorDuration'];
	}
	if (isset($_POST['widthIncrement'])) {
		$widthIncrement = $_POST['widthIncrement'];
	}
	if (isset($_POST['widthDuration'])) {
		$widthDuration = $_POST['widthDuration'];
	}
	if (isset($_POST['circlesEnabled'])){
		$circlesEnabled = $_POST['circlesEnabled'];
	}
	if (isset($_POST['linesEnabled'])) {
		$linesEnabled = $_POST['linesEnabled'];
	}
	if (isset($_POST['rectanglesEnabled'])){
		$rectanglesEnabled = $_POST['rectanglesEnabled'];
	}
	
}
?>
<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript">
			var xCoords = new Array();
			var yCoords = new Array();
			var colors = new Array();
			var rColors = new Array();
			var gColors = new Array();
			var bColors = new Array();
			colors['r'] = rColors;
			colors['g'] = gColors;
			colors['b'] = bColors;
			var widths = new Array();
			
			var circlesEnabled = true;
			var linesEnabled = true;
			var rectanglesEnabled = false;
			
			var colorMax = 255;
			var colorIncrementMax = <?php echo $colorIncrement; ?>;
			var colorDurationMax = <?php echo $colorDuration; ?>;
			
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
			
			var widthMax = <?php echo $width; ?>;
			var lineWidth = rand(1,widthMax);
			var widthDirection = rand(0,1);
			var widthIncrementMax = <?php echo $widthIncrement; ?>;
			var widthIncrement = rand(1,widthIncrementMax);
			var widthDurationMax = <?php echo $widthDuration; ?>;
			var widthDuration = rand(1,widthDurationMax);
			
			var segments = <?php echo $segments; ?>;
			var lineLength = <?php echo $length; ?>;
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
					if (xCoords.length == segments) {
						removeLineCoord();					
					}
					drawLine(kalido);
				}
				if (circlesEnabled) {
					
				}
				if (rectanglesEnabled) {
					
				}
			}
			
			function init(){
				// populate coordinate array
				xCoords[0] = Math.floor((Math.random()*xMax)+1);
				yCoords[0] = Math.floor((Math.random()*yMax)+1);
				colors['r'][0] = rColor;
				colors['g'][0] = gColor;
				colors['b'][0] = bColor;
				widths[0] = lineWidth;
				setInterval(randDraw,timeValue);
			}
			
		
		</script>	
	</head>
	<body onload="init()" style="background-color: black;">	
		<div style="z-index:4; position:absolute; top:0px; left:0px;">		
			<canvas id="canvas" width="1700" height="900" style="border:1px solid #000000;"></canvas>
		</div>
		<div id="console" style="position:absolute; top:0px; left:1700px; background-color: white;">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<fieldset>
					<legend>Line Segment Maximums</legend>
					Number: <input name="segments" type="text" size="3" value = <?php echo $segments; ?>><br>
					Length: <input name="length" type="text" size="4" value = <?php echo $length; ?>><br>
					Width: <input name="width" type="text" size="3" value = <?php echo $width; ?>><br>
					Width Increment: <input name="widthIncrement" type="text" size="3" value = <?php echo $widthIncrement; ?>><br>
					Width Duration: <input name="widthDuration" type="text" size="3" value = <?php echo $widthDuration; ?>><br>
				</fieldset>
				<fieldset>
					<legend>Color Maximums</legend>
					Increment: <input name="colorIncrement" type="text" size="3" value=<?php echo $colorIncrement; ?>><br>
					Duration: <input name="colorDuration" tupe="text" size="3" value=<?php echo $colorDuration; ?>><br>
				</fieldset>
				<input type="submit" value="Submit">
			</form>
		</div>
	</body>
</html>
