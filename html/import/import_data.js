data_save = [];
data_json = [];

// Запрос на импорт данных
$('#import').click(function(){
	repost = true;
	element = $('#element').val();
	if(data_save.length > 0){
		if(confirm("Вы действительно хотите начать новый поиск, не сохраняя данный результат?")){
			repost = true;
		}else{
			repost = false;
		}
	}
	if(repost && element){
		method = $('input[name=selectmethod]:checked').val();
		ion = $('#ion').val();
		rangeenergy = $('#rangeenergy').val();
		$('#result').html('');
		$('#preloader').show();
		$('title').html('Подождите | Импорт данных');
		switch(method){
			case 'level':
			data_form = {'import': true, 'method': method, 'element': element, 'ion': ion, 'rangeenergy': rangeenergy};
			break;
			case 'line':
			data_form = {'import': true, 'method': method, 'element': element, 'ion': ion};
			break;
		}
		$.ajax({
			type: "POST",
			url: "ajax_import_data.php",
			data: data_form,
			cache: false,                             
			success: function(response){
				console.log(response);	
				data_json = [];
				data_save = [];
				$('#preloader').hide();
				$('title').html(element+' '+ion+' | Импорт данных');			
				// result = response;
				result = jQuery.parseJSON(response);
				data_json = result['data_json'];
				lengthabs = lengthmtl = lengthnew = 0;
				if(data_json){
					if(method == 'level'){
						lengthabs = result['lengthabs'];
						lengthmtl = result['lengthmtl'];
						lengthnew = result['lengthnew'];

					}else if(method == 'line'){
						lengthabs = result['lengthabs'];
						lengthnew = result['lengthnew'];

					}
				}
				id_source = result['id_source'];
				menu = "<li class='current' id='summary'><p>Сводка</p></li>";
				div = "<div class='block_view' id='summary'>"+result['summary']+"</div>";
				if(result['table']){
					for(i = 0; i < result['table'].length; i++){
						menu += "<li class='menu_li' id='table"+i+"'><p>"+result['table_menu'][i]+"</p></li>";
						title = "<h3>"+result['table_title'][i]+"</h3>";
						div += "<div class='block_view' id='table"+i+"'>"+title+result['table'][i]+"</div>";
					}
				}
				menu = "<ul class='menu'>"+menu+"</ul>";
				$('#result').html(menu+div);
				$('.block_view#summary').show();

			}
		});
	}
	return false;
});
// Клик по менюшки
$(document).on('click', '.menu_li', function(){
	new_id = this.id;
	old_id = $(".menu li.current").attr("id");
	$('.block_view#'+old_id).hide();
	$('#'+old_id).attr("class", "menu_li");
	$('#'+new_id).attr("class", "current");
	$('.block_view#'+new_id).show();
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
	// console.log(data_json[number]['edit']);
	// console.log(replace);
	replace.replace(/&nbsp;*/g,"");

	$('tr#total-'+id1+'-'+id2+' td.'+parametr).text(replace);
});

// Проверка и запуск скрипта по окончанию массива с уровнями
function finish(){
	if(0 == (lengthabs+lengthmtl+lengthnew)){		
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
		finishbutsave = "<input type='button' class='savebtn' id='finishSave' value='Сохранить все изменения'>";
		if(method == 'level'){			
			text = "Вы отметили все уровни <br>Уровни совпашие :"+lengthsave+"<br>Уровни новые :"+lengthsaveasnew+"<br>Уровни, которые пропустили: "+lengthskip;
		}else if(method == 'line'){
			text = "Вы отметили все переходы <br>Переходы отмечанные как совпашие :"+lengthsave+"<br>Переходы отмечанные как новые :"+lengthsaveasnew+"<br>Переходы, которые пропустили: "+lengthskip;
		}
		$('.block_view#summary').append('<div id="resultusersave"><hr>'+text+'<br>'+finishbutsave+'</div>');
		delete finishbutsave;
		
		new_id = 'summary';
		old_id = $(".menu li.current").attr("id");
		$('.block_view#'+old_id).hide();//animate({height: "hide"}, 1000);
		$('#'+old_id).attr("class", "menu_li");
		$('#'+new_id).attr("class", "current");
		$('.block_view#'+new_id).animate({height: "show"}, 1000);
	}else if($('div#resultusersave')){
		$('div#resultusersave').remove();
	}

	return false;
}

function hide_button(id1,status){
	$('tbody#'+id1).attr("bgcolor","#D8D8D8");
	$('#divbutton-'+id1).hide();
	buttoncancel = '<input type="button" class="cancelsave" id="cancelsave-'+id1+'" value="Исправить">';
	$('#text-'+id1).html('Выполнено '+buttoncancel);
	$('#editbutton-'+id1+' label').hide();
	// $('#tdbutton-'+id1+' input').attr("disabled", "true");
	if(status.substring(0,3) == 'abs'){
		lengthabs--;
		$('tbody#'+id1).appendTo('#table_abs');
	}else if(status.substring(0,3) == 'mtl'){
		lengthmtl--;
		$('tbody#'+id1).appendTo('#table_mtl');
	}else if(status.substring(0,3) == 'new'){
		lengthnew--;
		$('tbody#'+id1).appendTo('#table_mtl');
	}else{
		console.log('Что-то пошло не так');
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

			if(item['status'].substring(0,3) == 'abs'){
				lengthabs++;
			}else if(item['status'].substring(0,3) == 'mtl'){
				lengthmtl++;
			}else if(item['status'].substring(0,3) == 'new'){
				lengthnew++;
			}else{
				console.log('Что-то пошло не так');
			}
		}
	});
	$('tbody#'+id1).attr("bgcolor","");
	$('#editbutton-'+id1+' label').show();
	$('#divbutton-'+id1).show();
	$('#text-'+id1).html('В процессе переиспраления');
	finish();
});

// Запись массива на сохранения
$(document).on('click', '.buttonSave', function(){
	id = $(this).attr('id');
	re = /\s*-\s*/
	splitId = id.split(re);
	id1 = splitId[1];
	methodsave = $('input[name=methodsave-'+id1+']:checked').val();
	if(methodsave == null){
		return false;
	}
	$('#preloader').show();
	title = $('title').html();
	$('title').html('Подождите | Импорт данных');
	checkedforall = $("#checkbox-"+id1).is(':checked');
	var datat = {};
	
	methodsave = $('input[name=methodsave-'+id1+']:checked').val();
	console.log(methodsave);

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
			// data_save[id1] = datat;
			data_json[i]['out'] = 1;

			hide_button(id1, statusLevel);
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


$(document).on('click', '#finishSave', function(){
	$('#preloader').show();
	title = $('title').html();
	$('title').html('Подождите | Импорт данных');
	$.ajax({
		type: "POST",
		url: "ajax_import_data.php",
		data: { 'save': true, 'method': method, 'data_save': data_save},
		cache: false,                                 
		success: function(response){
			$('#preloader').hide();
			$('title').html(title);
			console.log(response);
			li = $('li.menu_li'); 
			for(i = 0; i < li.length; i++){
				$("div#"+li[i]['id']).remove();
			}
			li.remove();
			$('.savebtn').remove();
			data_save = [];
		}
	});
});




$(document).on('click', '#saveLimits', function(){
	limits = $('textarea#limits').val();
	$('#preloader').show();
	title = $('title').html();
	$('title').html('Подождите | Импорт данных');
	$.ajax({
		type: "POST",
		url: "ajax_import_data.php",
		data: { 'save': true, 'method': 'limits', 'limits': limits, "id_source": id_source},
		cache: false,                                 
		success: function(response){
			$('#preloader').hide();
			$('title').html(title);
			console.log(response);
		}
	});
});

$(document).on('mousemove', 'a.exstra', function(pos){  
	$("#textenergyexatra").show(); 
	$("#textenergyexatra").css('left',(pos.pageX+10)+'px').css('top',(pos.pageY+10)+'px'); 	
}).on('mouseleave', 'a.exstra', function(){
	$("#textenergyexatra").hide();  
}); 

$('input[name=selectmethod]').click(function(){
	method = $('input[name=selectmethod]:checked').val();
	if(method == 'line'){
		$('div#block_rangeenergy').hide();
	}else if(method == 'level'){
		$('div#block_rangeenergy').show();
	}
});