					$(document).ready(function() {  						
						sliderMax = 18750; //{#*Максимальное значение слайдера*#}
						sliderMin = 0;  //{#*Минимальное значение слайдера*#}		

							
					
						//{#*Функция работы со слайдерами перемотки*#}
						$("#positionSlider").slider({ 
							value:948.0,			//{#*Значение слайдера = значению смещения*#}
							min: sliderMin,			//{#*Минимально значение слайдера = мин значению диапазона спектра*#}
							max: sliderMax,			//{#*Максимально значение слайдера = (макс значению диапазона спектра/10)*2.5 (стандартное масштабирование) *#}	
							step: 0.1,				//{#*Шаг слайдера*#}	
						
							slide: function( event, ui ) {			
								var scale=$( "#scaleSlider" ).slider( "value" ); 	//{#*получение значения увеличения масштаба*#}	
								window.SVGcontentMove(ui.value);					//{#*Передаём в скрипт svg комманду смеситьтся на опр. кол-во пунктов*#}	
						
								$("#positionMinValue").text(Math.round((ui.value/2.5)*10)); 				//{#*устанавливаем значение мин*#}		
								$("#positionMaxValue").text(Math.round(((ui.value + 960/scale)/2.5)*10)); 	//{#*устанавливаем значение макс (960 - ширина видимой части схемы)*#}	
							}
						});
					
						//{#*Функция Drag перемотка*#}						
						$("#bgRect").mousedown(function(){
						      $(this).append('<span style="color:#00F;">Mouse down.</span>');
						    });	
						
						//{#*Функция работы со слайдерами масштабирования*#}
						
						$("#scaleSlider").slider({
							orientation: "vertical", 
							min: 1,					//{#*Минимально значение слайдера *#}
							max: 100,				//{#*Максимально значение слайдера *#}
							step: 1,				//{#*Шаг слайдера*#}	
						
							slide: function( event, ui ) {
								var position=$( "#positionSlider" ).slider( "value" );	//{#*получение значения смещения*#}	
								window.SVGdocumentScale(ui.value);						//{#*Передаём в скрипт svg комманду увеличить на опр. кол-во пунктов*#}	
								
								$("#scaleValue").text(ui.value);												//{#*устанавливаем значение масштабирования*#}	
								$("#positionMaxValue").text(Math.round(((position + 960/ui.value)/2.5)*10));	//{#*устанавливаем значение макс*#}
							}
						});
					
					
						//{#*Установка мин и макс по умолчанию*#}
						$("#positionMinValue").text(Math.round(($( "#positionSlider" ).slider( "value" )/2.5)*10) );
						$("#positionMaxValue").text(Math.round((($( "#positionSlider" ).slider( "value" ) + 960)/2.5)*10));
						
						waveMin=(sliderMin/2.5)*10;
						waveMax=(sliderMax/2.5)*10+(960/2.5)*10;
						
						$("#filterBtn").click(function(){
							var scale=$( "#scaleSlider" ).slider( "value" );//получение значения увеличения масштаба
							
							waveMinVal = document.inputform.waveMinVal.value;
							waveMaxVal = document.inputform.waveMaxVal.value;															
							
							if ((waveMinVal=="") || (waveMinVal<waveMin)) waveMinVal=waveMin;
							if ((waveMaxVal=="") || (waveMaxVal>waveMax)) waveMaxVal=waveMax;
							

							if ( ((waveMaxVal/10)*2.5)-((waveMinVal/10)*2.5) > 960/scale ){
								
							if(!isNaN(waveMaxVal)) {															
								var maxVal = (waveMaxVal/10)*2.5;												//Переводем из Ангстремов в координаты svg
								var sliderVal = $( "#positionSlider" ).slider( "value" );						//Берём переменную позиции слайдера = текущей позиции слайдера

								maxVal=maxVal-960/scale;														//Расчитываем координату смещения svg
	
								if (sliderVal > maxVal){														//Если слайдер стоит правее максимального значения									
									window.SVGcontentMove(maxVal,0);											//Передаём в скрипт svg комманду смеситьтся на опр. кол-во пунктов							
									$("#positionMinValue").text(Math.round((maxVal/2.5)*10)); 					//устанавливаем значение мин
									$("#positionMaxValue").text(Math.round(((maxVal + 960/scale)/2.5)*10)); 	//устанавливаем значение макс (960 - ширина видимой части схемы)	
									sliderVal=maxVal;															//переменной позиции слайдера присваеваем  максимальное значение из формы
								}
								$("#positionSlider").slider({max:maxVal,value:sliderVal});						//Устанавливаем позицию слайдера
								
							}
							else waveMaxVal="getMaxWave";
							
							
							if(!isNaN(waveMinVal)) {								 								
								var minVal = (waveMinVal/10)*2.5;												//Переводем из Ангстремов в координаты svg
								var sliderVal = $( "#positionSlider" ).slider( "value" );						//Берём переменную позиции слайдера = текущей позиции слайдера

								
	
								if (sliderVal < minVal){														//Если слайдер стоит левее минимального значения									
									window.SVGcontentMove(maxVal,0);											//Передаём в скрипт svg комманду смеситьтся на опр. кол-во пунктов							
									$("#positionMinValue").text(Math.round((minVal/2.5)*10)); 					//устанавливаем значение мин
									$("#positionMaxValue").text(Math.round(((minVal + 960/scale)/2.5)*10)); 	//устанавливаем значение макс (960 - ширина видимой части схемы)	
									sliderVal=minVal;															//переменной позиции слайдера присваеваем  максимальное значение из формы
								}
								$("#positionSlider").slider({min:minVal,value:sliderVal});						//Устанавливаем позицию слайдера
								
							}
							else waveMinVal="getMinWave";
							}
							
							
							/*
							$.post('a_spectr.php',{element_id:"2511", maxlength:waveMaxVal, minlength:waveMinVal }, function(data) {
								//$('#svg').html(data);
								$('#spectrum_container').html(data);
								//$('#spectrum').html(data);
							},"string");*/
						
						});

						$("#showAllBtn").click(function(){
							$("#positionSlider").slider({min:sliderMin,max:sliderMax});		
							$("#positionMinValue").text(sliderMin);
							$("#positionMaxValue").text(sliderMax);
						});					

						
					});