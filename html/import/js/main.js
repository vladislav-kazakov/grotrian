element = method = null;
ion = 1;
data_save = [];
$(document).ready(function() {
	// Таблица периодическая
	$("html").click(function(){
		$(".element_picker").hide("fast");
	});					
	$("#chooseelement").click(function(){
		var link = $(':first-child', this).val();
		$(".plink").each(function() {
			$(this).attr('href', '/ru/'+link+'/'+$(':first-child', this).val());
		});					

		var position = $(this).offset();						
		$(".element_picker").css({'top': position.top, 'left': position.left});					
		$(".element_picker").show("fast");
		return false;
	});
	$(".newperiodic div").click(function(){
		number = $(this).children().get(1);
		number = $(number).text();
		element = $(this).children().get(2);
		element = $(element).text();
		if(element === '') return false;
		$("#infoelement h2").html(element);							
		$("#valion").attr("max",number);					
		$("#valion").val(1);
		ion = 1;					
		$("#infoelement").show("fast");						
		$("#choosetype").show("fast");
	});
	// Кнопка "Ион"
	$(document).on('click', '#valion', function(){	
		ion = $("#valion").val();
	});
	$(document).on('focusout', '#valion', function(){
		maxion = $("#valion").attr("max");
		ion = $("#valion").val();
		if(+ion > +maxion){
			ion = maxion;
			$("#valion").val(maxion);
		}
	});
	// Кнопка импорта уровней
	$("#btnlevel").click(function(){
		$('#preloader').show();
		method = 'level';
		rangeenergy = $("#rangeenergy").val();
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: {"import": true, "method": method, "element": element, "ion": ion, "rangeenergy": rangeenergy},
			cache: false,                             
			success: function(response){
				$("#preloader").hide();
				$("#result").html(response);
			}
		});
	});
	$(document).on('click', '.btnres', function(){
		id = $(this).attr("id");
		$(".res").hide();
		console.log(id);
		$(".res#"+id).show();
	});
	// Кнопка импорта переходов
	$("#btntransition").click(function(){
		$('#preloader').show();
		method = 'line';
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: {"import": true, "method": method, "element": element, "ion": ion},
			cache: false,                             
			success: function(response){
				$("#preloader").hide();
				$("#result").html(response);
			}
		});
	});
	$(document).on('click', '.btnres', function(){
		id = $(this).attr("id");
		$(".res").hide();
		console.log(id);
		$(".res#"+id).show();
	});
	// Изменение квантовых чисел
	$(document).on('click', '.edit', function(){
		id = $(this).attr('id');
		value = $(this).prop('checked');
		re = /\s*-\s*/
		splitId = id.split(re);
		parametr = splitId[1]
		id1 = splitId[2];
		id2 = splitId[3];
		data_json.forEach(function(item, i) {
			if(item['ID'] == id1){
				number = i;
			}
		});	
		if(value){
			replace = $("tr#"+id1+" td."+parametr).text();
			if(data_json[number]['edit']){
				data_json[number]['edit'] += ' ' + parametr;
			}else{
				data_json[number]['edit'] = parametr;
			}		
		}else{
			replace = $("tr#"+id2+" td."+parametr).text();
			re = /\s* \s*/
			splitEditLine = data_json[number]['edit'].split(re);
			delete data_json[number]['edit'];
			splitEditLine.forEach(function(item) {			
				if(item !== parametr){
					if(data_json[number]['edit']){
						data_json[number]['edit'] += ' ' + item;
					}else{
						data_json[number]['edit'] = item;
					}
				}
			});		
		}
		replace.replace(/&nbsp;*/g,"");

		$('tr#total-'+id1+'-'+id2+' td.'+parametr).text(replace);
	});
	//Запись массива на сохранения
	$(document).on('click', '.buttonSave', function(){
		id = $(this).attr('id');
		re = /\s*-\s*/
		splitId = id.split(re);
		id1 = splitId[1];
		methodsave = $('input[name=methodsave-'+id1+']:checked').val();
		if(methodsave == null){
			return false;
		}

		title = $('title').html();
		$('title').html('Подождите | Импорт данных');
		checkedforall = $("#checkbox-"+id1).is(':checked');
		var datat = {};

		data_json.forEach(function(item, i){
			if(item['ID'] == id1){
				id2 = item['data'];
				statusLevel = item['status'];
				listEdit = item['edit'];
				if(id2 == 'new' || methodsave !== 'save'){
					datat['data']  = id1;
				}else{
					datat['data']  = id1 + '-' + id2;
				}		

				datat['value'] = methodsave;
				datat['id'] = id1;
				datat['id_source'] = id_source;
				datat['edit'] = listEdit;
				data_save.push(datat);
				data_json[i]['out'] = 1;
				hide_button(id1,statusLevel)
			}
		});
		if(checkedforall){
			data_json.forEach(function(item, i) {
				if(item['status'] === statusLevel && item['out'] !== 1){
					datat = {};
					datat['id'] = item['ID'];
					hide_button(item['ID'],item['status']);
					$('input[name=methodsave-'+item['ID']+'],[value='+methodsave+']').attr("checked", "true");

					if(id2 == 'new' || methodsave == 'saveasnew'){
						datat['data']  = item['ID'];
					}else{
						datat['data']  = item['ID'] + '-' + item['data'];
					}

					datat['value'] = methodsave;
					datat['id_source'] = id_source;
					datat['edit'] = listEdit;
					data_save.push(datat);
					data_json[i]['out'] = 1;
				}
			});	
		}
		$('#preloader').hide();
		$('title').html(title);
		finish();
	});

	function hide_button(id1,status){
		$('tbody#'+id1).attr("bgcolor","#D8D8D8");
		$('#divbutton-'+id1).hide();
		buttoncancel = '<input type="button" class="cancelsave" id="cancelsave-'+id1+'" value="Исправить">';
		$('#text-'+id1).html('Выполнено '+buttoncancel);
		$('#editbutton-'+id1+' label').hide();
		parent = $('tbody#'+id1).closest("table");
		$('tbody#'+id1).appendTo(parent);
		lengthover--;
	}

	//Проверка и запуск скрипта по окончанию массива с уровнями
	function finish(){
		if(0 == lengthover){		
			lengthsave = lengthsaveasnew = lengthskip = 0;
			data_save.forEach(function(item){
				switch(item['value']) {
					case 'save':
					lengthsave++;
					break;
					case 'saveasnew':
					lengthsaveasnew++;
					break;
					case 'skip':
					lengthskip++;
				}
			});
			finishbutsave = "<input type='button' class='btn btn-large btn-success' id='finishSave' value='Сохранить все изменения'>";
			if(method == 'level'){			
				text = "Вы отметили все уровни <br>Уровни совпашие :"+lengthsave+"<br>Уровни новые :"+lengthsaveasnew+"<br>Уровни, которые пропустили: "+lengthskip;
			}else if(method == 'line'){
				text = "Вы отметили все переходы <br>Переходы отмечанные как совпашие :"+lengthsave+"<br>Переходы отмечанные как новые :"+lengthsaveasnew+"<br>Переходы, которые пропустили: "+lengthskip;
			}
			$('.res#resultsummary').append('<div id="resultusersave"><hr>'+text+'<br>'+finishbutsave+'</div>');
			delete finishbutsave;

			$('.res').hide();			
			$('.res#resultsummary').animate({height: "show"}, 1000);
		}else if($('div#resultusersave')){
			$('div#resultusersave').remove();
		}else{
			return false;
		}
	}	

	$(document).on('click', '.cancelsave', function(){
		id = $(this).attr('id');
		re = /\s*-\s*/
		splitId = id.split(re);
		id1 = splitId[1];
		data_save.forEach(function(item, i) {
			if(item['id'] === id1){			
				delete data_save[i];
			}
		});	
		data_json.forEach(function(item, i) {
			if(item['ID'] === id1){	
				data_json[i]['out'] = null;
				lengthover++;
			}
		});
		$('tbody#'+id1).attr("bgcolor","");
		$('#editbutton-'+id1+' label').show();
		$('#divbutton-'+id1).show();
		$('#text-'+id1).html('В процессе переиспраления');
		finish();
	});

	$(document).on('click', '#finishSave', function(){
		$('#preloader').show();
		title = $('title').html();
		$('title').html('Подождите | Импорт данных');
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: { 'save': true, 'method': method, 'data_save': data_save},
			cache: false,                                 
			success: function(response){
				$('#preloader').hide();
				$('title').html(title);
				console.log(response);
				$("#result").html('<h3>Готово!</h3>');
				data_save = [];
			}
		});
	});

});	