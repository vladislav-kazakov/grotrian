<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
     "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<title>test</title>
<link rel="stylesheet" href="/css/spectrum2.css" type="text/css" media="screen">
<script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
				<script type="text/javascript" src="/js/spectrum2/jquery.svg.min.js"></script>
				<script type="text/javascript" src="/js/spectrum2/jquery.svgdom.min.js"></script>

				
	
				<script type="text/javascript">
				$(document).ready(function() {						
					//var spectr_list={#$spectrum_json#};	
					//spectrum(spectr_list);					

					$('#spectrum_holder').svg({onLoad: drawInitial});
					
					function drawInitial(svg) {
						
						//drawspectralines(spectr,0,30000,4800,1);
						svg.rect(0, 0, 1000, 100,{fill: '#3f3'});
					}	
				});		
				</script>
</head>
<body>
	<form action="" name="inputform">
    MinLength <input type="text" value="0" maxlength="8" size="8" id="MinLength" style="border:1; color:#f6931f; font-weight:bold;" />
    MaxLength <input type="text" value="30000" maxlength="8" size="8" id="MaxLength" style="border:1; color:#f6931f; font-weight:bold;" />
    Center <input type="text" value="4800" maxlength="8" size="8" id="Center" style="border:1; color:#f6931f; font-weight:bold;" />
    Scale <input type="text" value="1" maxlength="4" size="4" id="ScaleValue" style="border:1; color:#f6931f; font-weight:bold;" />

    <input type="button" value="Применить" id="Btn" class="button white">
        
    	</form>
    	<br>    	
        Length: <span id="LengthValue" style="color:#f6931f; font-weight:bold;" >0</span>
        <br> 
        DeltaX: <span id="DeltaXValue" style="color:#f6931f; font-weight:bold;" >0</span>
        Position: <span id="PositionValue" style="color:#f6931f; font-weight:bold;" >0</span>
        Center: <span id="CenterValue" style="color:#f6931f; font-weight:bold;" >0</span>
        Scale: <span id="scaleValue" style="color:#f6931f; font-weight:bold;" >0</span>
        <div id="spectrum_container">        	
        		<div id="spectrum_holder"></div>        	
        </div>
        <div id="centerPoint"></div>
        <!-- <div id="Scroll"></div> -->
        <div id="positionSlider"></div>
        <br/>
        <div id="secondaryPositionSlider"></div>
        <br/>
        <div id="scaleSlider"></div>
        <br/>
        Min:<span id="positionMinValue"></span>
        Max:<span id="positionMaxValue"></span><br/>
        MinValue:<span id="MinValue"></span>
        positionValue:<span id="positionValue"></span>
        maxAvalibleLength:<span id="maxAvalibleLength"></span>
        
</body>
</html>
