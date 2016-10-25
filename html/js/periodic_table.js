function hsl2rgb(h, s, l) {
	var m1, m2, hue;
	var r, g, b
	s /=100;
	l /= 100;
	if (s == 0)
		r = g = b = (l * 255);
	else {
		if (l <= 0.5)
			m2 = l * (s + 1);
		else
			m2 = l + s - l * s;
		m1 = l * 2 - m2;
		hue = h / 360;
		r = HueToRgb(m1, m2, hue + 1/3);
		g = HueToRgb(m1, m2, hue);
		b = HueToRgb(m1, m2, hue - 1/3);
	}
	return "rgb("+Math.round(r)+","+Math.round(g)+","+Math.round(b)+")";
}

function HueToRgb(m1, m2, hue) {
	var v;
	if (hue < 0)
		hue += 1;
	else if (hue > 1)
		hue -= 1;

	if (6 * hue < 1)
		v = m1 + (m2 - m1) * hue * 6;
	else if (2 * hue < 1)
		v = m2;
	else if (3 * hue < 2)
		v = m1 + (m2 - m1) * (2/3 - hue) * 6;
	else
		v = m1;

	return 255 * v;
}


$(document).ready(function() {
	
	$.fn.SetQuantityColor = function(maxValue,idValue,defaultH,defaultL){
		$(this).each(function() {			
			
			var colorpercent = maxValue/100;
			var colorgrad = 180/maxValue;
			var sat=0;			
			var hue=0;
			
			var value = $(this).find('.'+idValue).val();
			
			//sat = value/colorpercent;
			//hue = value*colorgrad+180;			 
			
			hue = Math.pow(value, (Math.log(180)/Math.log(maxValue)))+180;
		
			if (value == 0) sat = 10; else sat = 100;
			
		    $(this).css("background-color",hsl2rgb(hue, sat, defaultL));				
			$(this).children('a').attr("title",value);
			
		});
	}

	
	$('#showLevelsFilling').click(function () {
		if ( $(this).hasClass('selected') )	{
			$(this).removeClass('selected');
			$('.periodic .pick').each(function() {
				var title= $(this).find('.ptitle').text();
				$(this).css("background-color","");
				$(this).children('a').attr("title",title);			
			});						
		}
		else 
		{			
			$('.periodic .pick').SetQuantityColor(1192,'levelsNum',280,80);
			$('.selected').removeClass('selected');
			$(this).addClass('selected');
		}
	});
	
	$('#showTransitionsFilling').click(function () {
		if ( $(this).hasClass('selected') )	{
			$(this).removeClass('selected');
			$('.periodic .pick').each(function() {
				var title= $(this).find('.ptitle').text();
				$(this).css("background-color","");
				$(this).children('a').attr("title",title);
			});						
		}
		else 
		{			
			$('.periodic .pick').SetQuantityColor(5852,'transitionsNum',256,80);
			$('.selected').removeClass('selected');
			$(this).addClass('selected');
		}
	});	
});	