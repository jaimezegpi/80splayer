<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script type="text/javascript" src="copperlichtdata/copperlicht.js"></script>
	<style type="text/css">
		/* Descargado desde https://www.codeseek.co/ */
    html,
    #hud {
    position: fixed;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    width: 100vw;
    top: 0;
    }

    #xxx{
      margin: 0 auto;
    }
    </style>
</head>
<body>
	<div align="center">
		<canvas id="3darea" width="640" height="480" style="background-color:#000000">
		</canvas>
	</div>
	<script type="text/javascript">
	<!--
			startCopperLichtFromFile('3darea', 'copperlichtdata/80_radio.ccbz', 'Loading $PROGRESS$...', 'Error: This browser does not support WebGL (or it is disabled).<br/>See <a href=\"http://www.ambiera.com/copperlicht/browsersupport.html\">here</a> for details.', true);
	-->
	</script>
	<br/>
	<div align="center">
		<small>Created using <a href="http://www.ambiera.com/coppercube/index.html">CopperCube</a></small>	</div>

<div id="hud">
  	<img id="xxx" src="onda.png">
</div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js'></script>
	<script type="text/javascript">
/* Descargado desde https://www.codeseek.co/ */
(function() {

  var playBtn = document.getElementById('xxx');
  var audioBuffer, analyzer, frequency, soundsrc,
    isPlaying = false;

  function init() {
    playBtn.style.display = 'none';
    var context = getAudioContext();
    if (context) {
      loadSound(context, 'music.mp3');
      d3.select('body')
        .append('svg')
        .attr('width', '100%')
        .attr('height', '100%')
        .append('defs');
    } else {
      alert('Audio API not supported in current browser.');
    }
  }

  function getAudioContext() {
    window.AudioContext = window.AudioContext || window.webkitAudioContext;
    if (window.AudioContext) {
      return new AudioContext();
    }
    return null;
  }

  function loadSound(context, url) {
    var request = new XMLHttpRequest();
    request.open('GET', url, true);
    request.responseType = 'arraybuffer';
    request.onload = function() {
      context.decodeAudioData(request.response, function(buffer) {
        playBtn.style.display = 'block';
        playBtn.onclick = function(e) {
          if(!isPlaying){
            playSound(context, buffer);
          } else {
            stopSound();
          }
          
        }
      }, onLoadSoundError);
    }
    request.send();
  }

  function onLoadSoundError(e) {
    alert('Sound file could not be loaded.');
  }

  function playSound(context, buffer) {
    if (!isPlaying) {
      playBtn.className = 'stop';
      isPlaying = true;
      //playBtn.style.display = 'none';
      soundsrc = context.createBufferSource();
      analyzer = context.createAnalyser();
      frequency = new Uint8Array(analyzer.frequencyBinCount);

      soundsrc.buffer = buffer;
      soundsrc.connect(context.destination);
      soundsrc.connect(analyzer);
      soundsrc.addEventListener('ended', function(){
        stopSound();
      });
      soundsrc.start(0);
      render();
    }
  }
  
  function stopSound(){
    soundsrc.stop();
    isPlaying = false;
    playBtn.className = '';
  }

  function render() {
    requestAnimationFrame(render);
    var xxx = analyzer.getByteFrequencyData(frequency);
    console.log(frequency.slice(0, 10)[0]);
    if (frequency.slice(0, 10)[0]>50){
    	var ancho = frequency.slice(0, 10)[0]*2;
		document.getElementById('xxx').style.width=ancho+"px";
		document.getElementById('xxx').style.transform="rotate(" + frequency.slice(0, 10)[0] + "deg)";

    }
    
  }

  init();
})();
	</script>
</body>
</html>