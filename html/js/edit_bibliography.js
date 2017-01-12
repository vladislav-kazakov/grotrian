$(document).ready(function() {	
	var p="";
	/* Initialise datatables */
	//Выбираем словарь в зависимости от локали				
	if(locale=="en") dataTableslib={
		"sLengthMenu": "Show _MENU_ records per page",
		"sZeroRecords": "No entries",
		"sInfo": "Entries from _START_ to _END_ of _TOTAL_",
		"sInfoEmtpy": "Entries from 0 to 0 of 0",
		"sInfoFiltered": "(Filtred from _MAX_ entries)",
		"oPaginate": {
			"sFirst": "&lt;&lt;",
			"sPrevious": "&lt;",
			"sNext": "&gt;",
			"sLast": "&gt;&gt;"
		}
	};
	
	if(locale=="ru") dataTableslib={
		"sLengthMenu": "Показать _MENU_ записей на странице",
		"sZeroRecords": "Записи отсутствуют",
		"sInfo": "Записи с _START_ до _END_ из _TOTAL_ записей",
		"sInfoEmtpy": "Записи с 0 до 0 из 0 записей",
		"sInfoFiltered": "(Отфильтровано из _MAX_ записей)",
		"oPaginate": {
			"sFirst": "&lt;&lt;",
			"sPrevious": "&lt;",
			"sNext": "&gt;",
			"sLast": "&gt;&gt;"
		}
	};
				
	var oTable = $('#bibliography_table').dataTable({	
	"sDom": 'l<"toolbar">rtip',	
	"oLanguage": dataTableslib,
	"aoColumns":[
	            { "sType": "html" },									
				{ "sType": "html" }
				], 
				"iDisplayLength": 25,
				"bLengthChange": true,
				"bFilter": true,
				"bProcessing": true,
				"sPaginationType": "full_numbers",
				
				"fnInitComplete": function() {
					// Make custom toolbar
					 $("div.toolbar").html(Search+': <input size="35" type="text" id="biblioSearchField"><input class="button white" id="createSource" value="'+CreateLevel+'" type="button"><input class="button white" id="deleteSources" value="'+DeleteLevels+'" type="button">');
				}
				
	});
	
		$("#biblioSearchField").keyup( function () {											
					oTable.fnFilter( this.value, 0);					
				} );

	
	$(document).on("click", ".bibliolink", function(){
		var level=$(this).parent();
		
    	if (level.hasClass('row_selected') ){
    		level.find('.source').html(level.data("source"));
    		level.removeClass('row_selected');
    	}
		else{
			level.data("source", level.find('.source').html());
			level.find('.source').html('<a href="#" class="button white" id="edit_source">E</a>');
			level.addClass('row_selected');
		}
    });
	
	$("#createSource").click(function(){	
		if (confirm('Создать новый источник?')) {						 
			$.post("/source_admin.php",  {action: "createSource"},function(data) {				
				if (p=="") p="even"; else if ($('tr:first').hasClass("odd")) p="even"; else p="odd";	
				var str ='<tr class="'+p+' row_selected"><input type="hidden" class="source_id" name="source_id" value="'+data+'" /><td class="bibliolink"></td><td id="source"><a href="#" class="button white" id="edit_source">E</a></td></tr>';
				$('table').prepend(str);
				//window.location.href = "/admin/ru/bibliography/";
				//alert(data);
			});
		}
	});
	
	$("#deleteSources").click(function(){
		var str = $(".row_selected .source_id").serialize()+"&action=deleteSources";		
		if (confirm('Удалить выбранные источники?')) {					
			$.post("/source_admin.php", str, function(data){
				$(".row_selected").remove();
			});							
		}
	});
	
	$(document).on("click", "#edit_source", function(event){
		event.preventDefault();
		var source = $(this).parent().parent();
		var str = 'source_id='+source.find('.source_id').val();
		
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