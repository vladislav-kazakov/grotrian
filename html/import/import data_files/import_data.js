console.log(levels_json);
$('.edit-level').click(function(){
	id = $(this).attr('id');
	re = /\s*-\s*/
	splitId = id.split(re);
	id1 = splitId[2];
	parametr = splitId[1]
	levels_json.forEach(function(item, i) {
		if(item['ID'] == id1){
			id2 = item['foundLevel'];
			replace = item[parametr]
			number = i;
		}
	});
	if(levels_json[number]['edit']){
		levels_json[number]['edit'] += ' ' + parametr;
	}else{
		levels_json[number]['edit'] = parametr;
	}
	$('tr#'+id2+' td.'+parametr).text(replace);
});

$('.buttonSave').click(function(){
	id = $(this).attr('id');
	re = /\s*-\s*/
	splitId = id.split(re);
	id1 = splitId[1];
	var levels = {};
	var datat = {};
	levels_json.forEach(function(item, i) {
		if(item['ID'] == id1){
			id2 = item['foundLevel'];
			statusLevel = item['status'];
			listEdit = item['edit'];
			if(id2 !== 'new'){
				levels[id1]  = id1 + '-' + id2;
				$('#'+id1 + '-' + id2).hide();
			}else{
				levels[id1]  = id1;
				$('#'+id1).hide();
			}
			delete levels_json[i];
		}
	});	
	checkedforall = $("#checkbox-"+id1).is(':checked');
	if(checkedforall){
		levels_json.forEach(function(item, i) {
			if(item['status'] === statusLevel){
				id1 = item['ID'];
				id2 = item['foundLevel'];
				if(id2 !== 'new'){
					levels[id1]  = id1 + '-' + id2;
					$('#'+id1 + '-' + id2).hide();
				}else{
					levels[id1] = id1;
					$('#'+id1).hide();
				}
				delete levels_json[i];
			}
		});	
	}
	console.log(datat);
	console.log(levels_json);

	datat['value'] = 'savelevel';
	datat['id_source'] = id_source;
	datat['edit'] = listEdit;
	datat['levels'] = levels;
	
	$.ajax({
		type: "POST",
		url: "ajax_import_data.php",
		data: datat,
		cache: false,                                 
		success: function(response){
			console.log(response);
		}
	});
	return false;
});

$('.buttonNotLinkSave').click(function(){
	id = $(this).attr('id');
	re = /\s*-\s*/
	splitId = id.split(re);
	id1 = splitId[1];
	var levels = {};
	var datat = {};
	levels_json.forEach(function(item, i) {
		if(item['ID'] == id1){
			id2 = item['foundLevel'];
			statusLevel = item['status'];
			levels[id1]  = id1;
			$('#'+id1 + '-' + id2).hide();
			delete levels_json[i];
		}
	});	
	checkedforall = $("#checkbox-"+id1).is(':checked');
	if(checkedforall){
		levels_json.forEach(function(item, i) {
			if(item['status'] === statusLevel){
				id1 = item['ID'];
				id2 = item['foundLevel'];
				levels[id1]  = id1;
				$('#'+id1 + '-' + id2).hide();
				delete levels_json[i];
			}
		});	
	}
	console.log(datat);
	console.log(levels_json);

	datat['value'] = 'savelevel';
	datat['id_source'] = id_source;
	datat['levels'] = levels;
	
	$.ajax({
		type: "POST",
		url: "ajax_import_data.php",
		data: datat,
		cache: false,                                 
		success: function(response){
			console.log(response);
		}
	});
	return false;
});