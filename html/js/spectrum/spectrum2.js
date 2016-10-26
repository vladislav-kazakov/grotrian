//Инициализация переменных
var mapApp;
var waveText;
var SVGDoc;
var scaleValue=1;		// масштаб увеличения по-умолчанию	
var	positionMaxValue;	// шаг смещения по-умолчанию
var	positionMinValue;
var positionStep=500;			
			
function init(LoadEvent) {
	top.SVGcontentMove	= contentMove;
	top.SVGdocumentScale	= documentScale;				
	SVGDoc = LoadEvent.target.ownerDocument;			
	myMapApp = new mapApp(false,undefined);
	waveText = document.getElementById("waveText");	
	hideCoords();
}
		
//функция масштабирования линий			
function linesScale(id,scale){
	var lineElement = document.getElementById(""+id+"");
			
	var child = lineElement.firstChild;
	
	while (child != null) {
		if (child.nodeName == "path") {
			child.setAttribute("stroke-width", 0.4/scale);
		}
		child = child.nextSibling;
	} 			
}
		
//функция масштабирования линейки		
function rulerScale(scale){
	var rulerRect = document.getElementById("rulerRect");
	rulerRect.setAttribute("height", 11/scale);			
	var rulerLayer = document.getElementById("rulerLayer");
	var child = rulerLayer.firstChild;
	
	if (scale<3) positionStep=500;
	if (scale>=3 && scaleValue<7) positionStep=250;
	if (scaleValue>=5 && scaleValue<11) positionStep=100;
	if (scaleValue>=11 && scaleValue<25) positionStep=50;
	if (scaleValue>=25 && scaleValue<40) positionStep=25;
	if (scaleValue>=40 && scaleValue<50) positionStep=10;
	if (scaleValue>=60 && scaleValue<100) positionStep=5;

	// рассчитываем значение макс 
	positionX =	positionMinValue/4;
	positionMaxValue=((positionX+960/scaleValue)/2.5)*10;
	
	// перерисовываем текст линейки			
	drawRulerText(positionMinValue,positionMaxValue,positionStep);
}

//Функция рисования текста на линейке		
function drawRulerText(MinValue,MaxValue,step){
	var svgns = "http://www.w3.org/2000/svg";		
	var rulerText = document.getElementById("rulerText");			//выбираем текстовый слой
	var rulerLayer = document.getElementById("rulerLayer");			//выбираем слой линейки
	
	rulerText.parentNode.removeChild(rulerText);					//удаляем существующие надписи
	var newRulerText = SVGDoc.createElementNS(svgns, "g");			//создаём текстовой слой заново
	newRulerText.setAttributeNS(null, "id", "rulerText");			
	newRulerText.setAttributeNS(null, "font-size", 10/scaleValue);
	newRulerText.setAttributeNS(null, "font-family", "Arial");
		
	rulerLayer.appendChild(newRulerText);							// добавляем текстовый слой на слой линейки
	var textX =0;
	
	for (var i=MinValue;i<MaxValue;i+=step) {						//добавляем текстовые записи в цикле			
		var data = SVGDoc.createTextNode(i.toFixed());				//значение = значение цикла через установленый шаг
		var text = SVGDoc.createElementNS(svgns, "text");
			
		strLength=""+i.toFixed();
		//(wavelength.length*3))/scaleValue
		text.setAttributeNS(null, "x", (textX/4)-(strLength.length*3/scaleValue));		//расчитываем координату х текста 
		text.setAttributeNS(null, "y", 9/scaleValue);									//расчитываем координату у текста 
			
		text.appendChild(data);			
		document.getElementById("rulerText").appendChild(text);							// добавляем текстовый елемент
		textX+=step;
	}		
} 
	
// Функция масштабирования svg		
function documentScale(scale) {	
	var width=SVGDoc.documentElement.getAttribute("width")/scale;						//расчитываем значения масштаба
	var height=SVGDoc.documentElement.getAttribute("height")/scale;	
	scaleValue = scale;
			
	width=960/scale;	
	height=100/scale;	
	SVGDoc.documentElement.setAttribute("viewBox", "0 0 "+width+" "+height+"");			//устанавливаем значение viewbox

	linesScale("lines",scale);															//масштабируем линии
	rulerScale(scale);																	//масштабируем линейку	
}		
		
// Функция перемещения svg		
function contentMove(x) {
	var content = document.getElementById("content1");					
	positionMinValue=(x/2.5)*10;
	positionMaxValue=((x+960/scaleValue)/2.5)*10;						//расчитываем значения смещения
	x=-x;
	content.setAttributeNS(null,"transform","translate("+x+")");		// смещаем svg
	drawRulerText(positionMinValue,positionMaxValue,positionStep);		// перерисовываем текст линейки			
}
		
// Функция отображения координат		
function showCoords(evt) {					
	var coords = myMapApp.calcCoord(evt);
	//var wavelength = ""+coords.x.toFixed(1)*10;						
	//var wavelength = ""+((coords.x*10).toFixed());					//расчитываем значение координаты х на svg
	var wavelength = ""+((coords.x*10).toFixed(1));						//расчитываем значение координаты х на svg с одним знаком после запятой
	var waveTextRect = document.getElementById("waveTextRect");			//Выбираем подложку отображения координат
				
	waveTextRect.setAttributeNS(null, "style", "display: visible;");											//Делаем этот элемент видимым
	waveTextRect.setAttributeNS(null, "x", Math.round(evt.clientX-((wavelength.length-1)*3)-5)/scaleValue);		//Устанавливаем значение x подложки так, чтобы она была посередине над линией							
	waveTextRect.setAttributeNS(null, "width", (wavelength.length*6+5)/scaleValue);								//Устанавливаем ширину подложки в зависимости от количества цифр в числе и масштаба
	waveTextRect.setAttributeNS(null, "height", 11/scaleValue);													//Устанавливаем высоту в зависимости от масштаба
	
	waveText.setAttribute("font-size", 10/scaleValue);				//Устанавливаем размер шрифта в зависимости от масштаба
	waveText.setAttribute("y", 9/scaleValue);						//Устанавливаем высоту текста в зависимости от масштаба
	waveText.setAttributeNS(null,"x",Math.round(evt.clientX-(wavelength.length*3))/scaleValue);	//Устанавливаем ширину подложки в зависимости от количества цифр в числе и масштаба
	waveText.firstChild.nodeValue = wavelength;						//Пишем надпись
				
}

// Функция прячит координаты			
function hideCoords() {
	var waveTextRect = document.getElementById("waveTextRect");		//Выбираем подложку отображения координат
	waveTextRect.setAttributeNS(null, "style", "display: none;");   //Делаем этот элемент невидимым             
	waveText.firstChild.nodeValue = "";								//Стираем текст
	}