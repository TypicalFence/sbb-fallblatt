
<?php

//$command_path = "/home/pi/fallblatt/python/show_text.py";
$command_path = "/home/roland/Documents/projects/sbb-fallblatt/python/show_text.py";

if(isset($_POST["text"])){
	$text = $_POST["text"];
	$text = escapeshellarg($text);
	exec("python3 $command_path --start=1 --end=30 --text=$text");
}


?>


<!DOCTYPE html>
<html>
	<head>
		<title>Fallblatt</title>
		<style>
			@font-face {
				font-family: "SBB";
				src: url("./font/SBBWeb-Condensed-Bold.woff") format("woff2"),
					url("./font/SBBWeb-Condensed-Bold.woff2") format("woff");
			}
			body{
				font-family: sans-serif;
			}
			#inputForm{
				margin: 20px;
				text-align: center;
			}
			.segment{
				background-color: #26356e;
				border: 1px #151e3d solid;
				color: #FFFFFF;
				height: calc(6.666vw * 1.2);
				font-size: calc(6.666vw * 1.0);
				text-align: center;
				overflow: hidden;
			}
			#preview{
				display: grid;
				grid-gap: 0.5vw;
				grid-template-columns: repeat(15, 1fr);
				font-family: SBB;
			}
			.segment.active{
				animation-name: cursor;
				animation-duration: 1s;
				animation-iteration-count: infinite;
				animation-timing-function: steps(2);
			}
			
			@keyframes cursor {
				from {
					filter: brightness(2);
				}

				to {
					filter: brightness(1);
				}
			}
		</style>
	</head>
	<body>
		<form id="inputForm" method="post" action="" autocomplete="off">
			<input autofocus type="text" id="input" name="text" size="30" maxlength="30">
			<input type="submit" value="Send">
		</form>
		<div id="preview"></div>
	</body>
	<script>
		const lineLength = 15;
		const lineCount = 2;
		const segmentCount = lineLength*lineCount;
		
		const input = document.getElementById("input");
		const preview = document.getElementById("preview");
		
		const segments = [];
		for(let segment = 0; segment < segmentCount; segment++){
			let segment = document.createElement("div");
			segment.className = "segment";
			segments.push(segment);
			preview.appendChild(segment);
		}
		
		segments[0].classList.add("active");
		let active = segments[0];
		
		
		input.addEventListener("input", updatePreview);
		document.addEventListener("selectionchange", updatePreview);
		
		function updatePreview(){
			if(active){
				active.classList.remove("active");
			}
			active = segments[input.selectionStart];
			if(input.selectionStart < segmentCount){
				active.classList.add("active");
			} else {
				active = null;
			}
			let text = input.value;
			text = text.replace(/[^a-zA-Z0-9\-\.\/ ]/g, " ");
			text = text.substring(0, lineLength*lineCount);
			text = text.toUpperCase();
			for(let i in segments){
				console.log(i);
				segments[i].innerHTML = text.substr(i, 1);
			}
		}
	</script>
</html>
