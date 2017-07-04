$(document).ready(function() {	
	var p="";
	/* Initialise datatables */
	//Выбираем словарь в зависимости от локали				
	if(locale=="en") dataTableslib={
		"lengthMenu": "Show _MENU_ records per page",
		"zeroRecords": "No entries",
		"info": "Entries from _START_ to _END_ of _TOTAL_",
		"infoEmtpy": "Entries from 0 to 0 of 0",
		"infoFiltered": "(Filtred from _MAX_ entries)",
		"paginate": {
			"first": "&lt;&lt;",
			"previous": "&lt;",
			"next": "&gt;",
			"last": "&gt;&gt;"
		}
	};

	if(locale=="ru") dataTableslib={
		"lengthMenu": "Показать _MENU_ записей на странице",
		"zeroRecords": "Записи отсутствуют",
		"info": "Записи с _START_ до _END_ из _TOTAL_ записей",
		"infoEmtpy": "Записи с 0 до 0 из 0 записей",
		"infoFiltered": "(Отфильтровано из _MAX_ записей)",
		"paginate": {
			"first": "&lt;&lt;",
			"previous": "&lt;",
			"next": "&gt;",
			"last": "&gt;&gt;"
		}
	};
				
	var oTable = $('#bibliography_table').DataTable({
	serverSide: true,
	ajax: '/bibliolinks.php',
	"dom": 'l<"toolbar">rtip',
	"language": dataTableslib,
	"columns":[
				{ "className": "bibliolink",
					"render": function ( oObj ) { //return "1";
												return (new BibtexDisplay()).displayBibtex(String(oObj));
												//oObj.aData[2].replace(/\s/gi,"");
												},
				  "orderable": false},
	            { "className": "source_id",
					"type": "html" },
				],
	"order": [[1, 'asc']],
	"pageLength": 25,
	"lengthChange": true,
	"searching": true,
	"processing": true,
	"pagingType": "full_numbers",

	"initComplete": function() {
		// Make custom toolbar
		 $("div.toolbar").html(Search+': <input size="35" type="text" id="biblioSearchField"><input class="button white" id="createSource" value="'+CreateLevel+'" type="button"><input class="button white" id="deleteSources" value="'+DeleteLevels+'" type="button">');
	}
	});


	$(document).on("keyup","#biblioSearchField", function () {
		oTable.column(0).search(this.value).draw();
	});


	$(document).on("click", ".bibliolink", function(){
		var level=$(this).parent();

    	if (level.hasClass('row_selected') ){
    		level.find('.bibliolink').html(level.data("source"));
    		level.removeClass('row_selected');
    	}
		else{
			level.data("source", level.find('.bibliolink').html());
			level.find('.bibliolink').html(level.find('.bibliolink').html() + '<a href="#" class="button white" id="edit_source">E</a>');
			level.addClass('row_selected');
		}
    });

	$(document).on("click", "#createSource", function(){
		if (confirm('Создать новый источник?')) {
			$.post("/source_admin.php",  {action: "createSource"},function(data) {
				if (p=="") p="even"; else if ($('tr:first').hasClass("odd")) p="even"; else p="odd";
				var str ='<tr class="'+p+' row_selected"><td class="bibliolink"></td><td id="source_id"><a href="#" class="button white" id="edit_source">E</a></td></tr>';
				$('table').prepend(str);
				//window.location.href = "/admin/ru/bibliography/";
				//alert(data);
			});
		}
	});

	$(document).on("click", "#deleteSources", function(){
		//var str = $(".row_selected .source_id").serialize()+"&action=deleteSources";
		var str_sources_arr = [];
		$('.row_selected .source_id').each(function () {
			str_sources_arr.push("source_id[]=" + this.innerText);
		});
		var str = encodeURI(str_sources_arr.join("&")+"&action=deleteSources");
		if (confirm('Удалить выбранные источники?')) {
			$.post("/source_admin.php", str, function(data){
				$(".row_selected").remove();
			});
		}
	});

	$(document).on("click", "#edit_source", function(event){
		event.preventDefault();
		var source = $(this).parent().parent();
		var str = 'source_id='+source.find('.source_id')[0].innerText;

		str+="&action=editSource";
		//alert(str);
		$.fancybox.showLoading();

		$.post("/source_admin.php", str, function(data){
			$.fancybox(data);
			CheckType($('#source_type').val());
		});
	});

	$(document).on("click", "#save_source", function(event){
		event.preventDefault();
		var str = "source_id="+$(".current_source").val();
		str +="&"+$("#saveSourceForm").serialize();
		str +="&action=saveSource";

		//alert(str);


	var str_authors = $("#saveSourceAuthors").serialize();
		//alert(str_authors);
		//var str=str_levels+'&'+str_sources+'&type="L"&action=applySources';
			$.post("/source_admin.php", str,function(data) {
				window.location.href = "/admin/ru/bibliography/";
			});

				//window.location.href = "/admin/ru/levels/"+atom_id;
				//alert(data);
			//});
	});
});	