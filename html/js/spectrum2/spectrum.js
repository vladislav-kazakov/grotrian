function  spectrum(spectr){
	
	var maxAvalibleLength=MaxLengthFrom(spectr,0);
	var MinLength=0;
	var MaxLength=30000;
	var ScaleValue=1;	
	var Center=4800;
	var initialCenter = Center;	
	var maxX;
	var leftLim;
	var rightLim;
	var mainslider;	
	

	
	$('#spectrum_holder').svg({onLoad: drawInitial});	//рисуем спектр в первоначальном положении
				
	$("#Btn").click(function(){
		// Получаем значения формы
		ScaleValue = $("#scaleValue").val();
		MinLength = $("#minLength").val();		
		MaxLength = Number($("#maxLength").val());
		Center = $("#centerValue").val();

		drawspectralines(spectr,MinLength,MaxLength,Center,ScaleValue);// рисуем линии	
	});

		//функция увеличения с колёсиком
	$("#spectrum_holder").mousewheel(function(objEvent, delta){

		ScaleValue=Number(ScaleValue)+Number(delta);							//прибавляем к значению увеличения, значение прокрутки колёсика 
		
		if (ScaleValue>=1) {
			$("#scaleSlider").slider({value:ScaleValue});							// перемещаем слайдер увеличения

			drawspectralines(spectr,MinLength,MaxLength,Center,ScaleValue);			// рисуем увеличенный спектр
			UpdateFormValues();														// обновляем данные формы
		} else ScaleValue=1;
				
	},true); 

	// подключаем функцию перетаскивания мышью
	$("#spectrum_holder").drag();
	
	// функция при перетаскивании мышью
	$("#spectrum_holder").ondrag(function(e, element){ 
		$("#spectrum_holder").css("cursor", "move");					// курсор вида move

		var delta = $.updatePosition(e);					// получаем значения смещения координаты курсора мыши относительно последней координаты полоски
	    Center = initialCenter - delta.x*10/ScaleValue;   	// вычисляем центр учитывая центр начала движения
	    UpdateFormValues();									// обновляем данные формы
	});

	$("#spectrum_holder").ondrop(function(e, element){
		$("#spectrum_holder").css("cursor", "default");		// курсор обычного вида
		initialCenter = Center;								// начальный центр устанавливается в значение смещенного центра 


		drawspectralines(spectr,MinLength,MaxLength,Center,ScaleValue);		// рисуем линии	
		UpdateFormValues();													// обновляем данные формы

    });

	
	var initialDelta=0;
	var initialSecondaryDelta=0;
	var deltax=0;
	var initialPosition=-480;//$('#spectrum_holder').position().left;
	
	//{#*Функция работы со слайдером основной перемотки*#}

	$("#positionSlider").slider({ 
		step: 1,				//{#*Шаг слайдера*#}	
			
		slide: function( event, ui ) {
		
			deltax = initialDelta-ui.value;								// расчитываем значение смещения
			Center =initialCenter-deltax*10/ScaleValue;					//	расчитываем смещение центра	
			$("#spectrum_holder").css("left", initialPosition+deltax);	// смещаем div
			UpdateFormValues();											// обновляем данные формы	
		},

		stop: function(event, ui) {
			initialCenter = Center;											// устанавливаем начальный центр	
			drawspectralines(spectr,MinLength,MaxLength,Center,ScaleValue);	// рисуем линии			
			UpdateFormValues();												// обновляем данные формы
		}
			
	}); 

	//{#*Функция работы со слайдером дополнительной перемотки*#}
	$("#secondaryPositionSlider").slider({ 
		step: 1,												//{#*Шаг слайдера*#}	
	
		slide: function( event, ui ) {

			deltax = initialSecondaryDelta-ui.value;				//расчёт изменения значения слайдера

			var move = initialPosition+deltax;						// расчитываем значение смещения
		
			if (move<leftLim && move>-rightLim){					//если значения смещения правее минимальной границы и левее максимальной 
				Center =initialCenter-deltax*10/ScaleValue;			//расчитываем центр 
				$("#spectrum_holder").css("left", move);						// производим смещение
				mainslider = initialDelta+ui.value;					// расчитываем смещение основного слайдера
				$("#positionSlider").slider({value:mainslider});	// перемещаем основной слайдер
				UpdateFormValues();									// обновляем форму
			}			
		},

		stop: function(event, ui) {
			initialCenter=Center;										// устанавливаем начальный центр
			initialPosition =$('#spectrum_holder').position().left;		// устанавливаем начальную позицию
			initialSecondaryDelta=ui.value;								// устанавливаем начальное смещение слайдера
			initialDelta = mainslider;									// устанавливаем начальное смещение основного слайдера
		}
			
	}); 

	// слайдер увеличения масштаба
	$("#scaleSlider").slider({
		//orientation: "vertical",
		value: 1, 
		min: 1,															//{#*Минимально значение слайдера *#}
		max: 500,														//{#*Максимально значение слайдера *#}
		step: 1,														//{#*Шаг слайдера*#}	
	
		slide: function( event, ui ) {
			$("#scaleValue").val(ui.value);								// показываем изменения масштаба	
			//$("#ScaleValue").val(ui.value);
		},
		
		stop:function( event, ui ) {
			ScaleValue=ui.value;												// устанавливаем значение масштаба
			initialCenter = Center;												// устанавливаем начальный центр
			drawspectralines(spectr,MinLength,MaxLength,Center,ScaleValue);		// рисуем линии	
			UpdateFormValues();													// обновляем форму
		}
	
	});

	// функция обновления формы
	function UpdateFormValues(){

	var	Max= (Center + 4800/ScaleValue).toFixed();
	var	Min= (Center - 4800/ScaleValue).toFixed();
	var fixedCenter = Center.toFixed();
	
		$("#centerValue").val(fixedCenter);
		$("#centerRulerValue").text(fixedCenter);
		$("#positionMinValue").text(Min);
		$("#positionMaxValue").text(Max);
		$("#scaleValue").val(ScaleValue);
	}


	// функция отрисовки линий

	function drawspectralines(spectr,MinLength,MaxLength,Center,ScaleValue){
		
		if (MaxLength<maxAvalibleLength) maxAvalibleLength = MaxLength;
		
		maxX=(maxAvalibleLength/10*ScaleValue).toFixed();								// вычисляем координату максимальной длины волны

		WidthX=Number(maxX)+960;														// вычисляем ширину div и svg

		leftLim =(Number(initialCenter))/10*ScaleValue-480;								//вычисляем левую границу
		rightLim=(Number(maxAvalibleLength)-Number(initialCenter))/10*ScaleValue+480;	//вычисляем правую границу
		
		$("#spectrum_holder").dragLimits(leftLim,rightLim);								// устанавливаем границы перемотки		
			
		var Xcenter=480+(Center/10)*ScaleValue;											// координата центра svg
			
		
		var svg = $('#spectrum_holder').svg('get');										//получаем svg обьект
		//svg.style('#test { fill: blue }');
				
		svg.configure({width:WidthX,height:100}, true);									// устанавливаем ширину svg
		
		if (g = svg.getElementById("lines_group")) svg.remove(g);						//удаляем группу всех линий если она существует

		var g = svg.group(null,"lines_group",{'stroke-width': 1, 'shape-rendering':"optimizeSpeed" });		// создаём группу линий

		svg.rect(g,0, 0, (WidthX), 100,{fill: '#000'});														// рисуем подложку для линий

		for (var key in  spectr){
			if (key>MinLength && key<MaxLength){			// если длина волны находится в диапазоне то вычисляем её координату svg и рисуем			

				if (key<Center) x= Xcenter - ((Center - key)/10*ScaleValue);	// расчитываем координаты относительно центра svg
				if (key>Center) x= Xcenter + ((key - Center)/10*ScaleValue);
				svg.line(g, x, 0, x, 100,{stroke: ""+spectr[key]+"",class_: 'spectrline',length:key});	//рисуем линию
			}
		}	

		$('.spectrline', svg.root).bind('mouseover', lineOver).bind('mouseout', lineOut);	//привязываем функции mouseover/mouseout к каждой линии				
					
		var sliderValue=Number(Center/10*ScaleValue)-480;									// вычисляем значение слайдера перемотки
		$("#positionSlider").slider({min:-480,max:Number(maxX-480),value:sliderValue});		// устанавливаем значения основного слайдера
		initialDelta=sliderValue;															// устанавливаем начальное смещение основного слайдера
		$("#secondaryPositionSlider").slider({min:-480,max:480,value:0});					// устанавливаем значения дополнительного слайдера 0
		initialSecondaryDelta=0;															// устанавливаем начальное смещение доп слайдера 0		
		
		$(g).attr({transform:"translate("+(480-(Number((Center/10)*ScaleValue)))+")"});		// смещаем группу линий
		$("#spectrum_holder").css("left", -480);											// возвращаем div на место
		initialPosition =-480;																// устанавливаем начальное смещение
	}

	// функция первой отрисовки
	function drawInitial(svg) {		
		drawspectralines(spectr,0,30000,4800,1);
		$("#positionMinValue").text(0);
		$("#positionMaxValue").text(9600);
		$("#centerRulerValue").text(4800);
	}			


	function MaxLengthFrom(ar,maxAvalibleLength) {
		for (var key in  ar) if (Number(key)>Number(maxAvalibleLength)) maxAvalibleLength = Number(key);		//узнаём самое большое значение длины волны
		return maxAvalibleLength;
		}
}

function lineOver() { 	
	    $(this).attr('stroke-width', '2'); 
	    $("#LengthValue").html($(this).attr('length'));
} 
	 
function lineOut() { 
	    $(this).attr('stroke-width', '1'); 
}