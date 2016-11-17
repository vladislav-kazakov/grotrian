$(document).ready(function() {		
				
	$(document).on("click", "#new_source", function(){
				
				if (confirm('Создать новый источник?')) {						 
					$.post("/source_admin.php",  {action: "createSource"},function(data) {				
						
						var str = 'source_id='+data;						
						str+="&action=editSource";	
						//alert(data);
						$.fancybox.showActivity();
						
						$.post("/source_admin.php", str, function(data){					
							$.fancybox(data);
							CheckType($('#source_type').val());
						});
					});
				}				
			});			
			
			$(document).on("click", "#add_source", function(event){
				event.preventDefault();
				var str="action=manageSources&count="+$(".row_selected .row_id").length;					
					
					$.fancybox.showActivity();
					
					$.post("/source_admin.php", str, function(data){					
						$.fancybox(data);					
					});					
				
			});

			
			$(document).on("click", "#remove_source", function(event){
				event.preventDefault();
				var str = $(".row_selected .row_id").serialize();
				str+="&action=removeSources&count="+$(".row_selected .row_id").length;					
				//alert(str);	
					$.fancybox.showActivity();
					
					$.post("/source_admin.php", str, function(data){						
						$.fancybox(data);						
					});					
				
			});
			
			$(document).on("click", "#bibliography_table tbody tr", function(){
				if ( $(this).hasClass('row_selected_source') )
					$(this).removeClass('row_selected_source');
                else
                    $(this).addClass('row_selected_source');
            });                
			
			
			$(document).on("click", "#apply_source", function(event){
				event.preventDefault();
				var type = $('#type').val();
				//alert(type);
				var str_rows = $(".row_selected .row_id").serialize();
				var str_sources = $(".row_selected_source .source_id").serialize();				
				var str=str_rows+'&'+str_sources+'&type="'+type+'"&action=applySources';	
				//alert(str);
				var rts;
				
					$.post("/source_admin.php", str,function(data) {
						
						$('.row_selected').each(function() {
							var row = $(this);				
							
							rts ="row_id="+row.find('.row_id').val();						
							rts+="&action=getSourceIDs&type="+type;
							
							$.post("/source_admin.php", rts,function(data) {
								//removeSelection(level);	
								//alert(data);
								row.find('.links').html(data);
								
								if (!row.children('.source').data("source")){
									row.find('#buttons').append('<a class="button white" id="remove_source">-</a>');									
					    		}
								
								row.find('.source').data("source", data);
							});
							parent.$.fancybox.close();
						  });

						//window.location.href = "/admin/ru/levels/"+atom_id;
						//alert(data);						
					});					
			});
			
			$(document).on("click", "#apply_removing", function(event){
				event.preventDefault();
				var type = $('#type').val();
				var str_rows = $(".row_selected .row_id").serialize();
				var str_sources = $(".row_selected_source .source_id").serialize();
				var str=str_rows+'&'+str_sources+'&type="'+type+'"&action=applyRemovingSources';	
				var rts="";
				
				$.post("/source_admin.php", str,function(data) {				
					$('.row_selected').each(function() {
						var row = $(this);
						rts ="row_id="+row.find('.row_id').val();						
						rts+="&action=getSourceIDs&type="+type;						
						$.post("/source_admin.php", rts,function(data) {
							//removeSelection(level);							
							if (!data){														
								row.find('#remove_source').remove();
								row.children('.source').removeData("source");
							}else {
								row.find('.source').data("source", data);								
							}							
							row.find('.links').html(data);
							
						});
					});											

					parent.$.fancybox.close();
				});					
			});
		
			/*	
			$("#new_source").live("click", function(){
				$.post("/source_admin.php",  {action: "createSource"},function(data) {
					
					//alert(data);
					//window.location.href = "/admin/ru/element/"+data;
				});		
			});
				*/

			$("a.source_link").fancybox({
				'hideOnContentClick': false,
				'overlayColor'		: '#000',
				'overlayOpacity'	: 0.8,
				'width'				: 600,
				'height'			: 200,
				'autoDimensions'	: false
			});


			$(document).on("click", "#save_source", function(event){
				event.preventDefault();
				var str=$("#saveSourceForm").serialize(); 				
				str += "&source_id="+$(".current_source").val();				
				str +="&action=saveSource";
				
				//alert(str);

				var str_authors = $("#saveSourceAuthors").serialize();
				//alert(str_authors);
				//var str=str_levels+'&'+str_sources+'&type="L"&action=applySources';	
					$.post("/source_admin.php", str,function(data) {
						var str = $(".row_selected .row_id").serialize();
						str+="&action=manageSources&count="+$(".row_selected .row_id").length;					
							
							$.fancybox.showActivity();
							
							$.post("/source_admin.php", str, function(data){					
								$.fancybox(data);					
							});						
					});

						//window.location.href = "/admin/ru/levels/"+atom_id;
						//alert(data);						
					//});					
			});
			
		var CheckType= function (source_type) {	
			
			switch (source_type) {
			
			case "j_article": 
				$('#article_name, #issue_name, #publisher, #year,  #publish_page, #link, #vol_num').show();
				$('#collection_type, #city, #publish_vol, #publish_tome,#page_num, #tome_num').hide();
		    break;
			case "c_article": 
				$('#article_name, #issue_name,#collection_type,#city, #publisher, #year, #publish_page, #link, #vol_num, #tome_num').show();
				$('#page_num, #publish_tome, #publish_vol').hide();
		    break;
			case "e_book":				
				$('#article_name,#link').show();
				$('#issue_name,#collection_type,#publish_tome, #city, #publisher, #year, #publish_vol, #publish_page,#page_num, #vol_num, #tome_num').hide();
		    break;
			case "book":				
				$('#issue_name, #city, #publisher, #year, #link, #page_num').show();
				$('#article_name,#collection_type,#publish_tome, #publish_vol, #publish_page, #vol_num, #tome_num').hide();
			break;
			case "journal":				
				$('#issue_name, #vol_num, #tome_num, #publisher, #year, #link, #page_num').show();
				$('#article_name, #city, #collection_type, #publisher, #publish_page,#publish_tome, #publish_vol').hide();
			break;
			case "collection":				
				$('#issue_name, #collection_type, #city, #publisher, #year, #link, #page_num,#tome_num,#vol_num').show();
				$('#article_name, #publish_page, #publish_tome, #publish_vol').hide();
			break;			
			}
		}	

			$(document).on('change', '#source_type', function(event) {
				event.preventDefault();
				var source_type = $(this).val();
				CheckType(source_type);
			});
			
			
			
			$(document).on("click", "#edit_author", function(event){
				event.preventDefault();
				var author=$(this).parent().parent().parent();		
				$(this).parent().html('<a class="button white" id="save_author">Сохранить</a>');
				author.find('.author_role').removeAttr("disabled");
				//<input type="text" name="author" class="article_author" value="{#$author.NAME#}" />
				var author_name=author.children('.author_name').text();		
				author.children('.author_name').html('<input type="text" name="author" class="article_author" value="'+author_name+'" />');
			
			});
			
			$(document).on("click", "#save_author",function(event){
				event.preventDefault();
				var author=$(this).parent().parent().parent();		
				var button = $(this).parent();		
				
				var author_name = author.find('.article_author').val();
				var author_role = author.find('.author_role').val();
				var source_id = $(".current_source").val()
				
				var str = 'author_id='+author.find('.author_id').val()+'&source_id='+source_id+'&author_name='+author_name+'&author_role='+author_role+'&action=save_author';		
				//alert(str);
				if (confirm('сохранить?')) {
					$.post("/source_admin.php", str,function(data) {
						//alert(data);
						author.children('.author_name').html(author_name);
						author.find('.author_id').val(data);
						author.find('.author_role').attr('disabled',"disabled");
						button.html('<a class="button white" id="edit_author">редактировать</a>');
						
					});
				}
				
			});
			
			
			$(document).on('click', "#add_author", function(event){
				event.preventDefault();
				$('#authors_edit_table').append('<tr><td class="author_name"><input type="text" name="author" class="article_author" value="" /></td><td class="author_controls"><select class="author_role" name="author_role"><option selected="selected" value="author">автор</option><option value="main_author">основной автор</option><option value="editor">редактор</option></select><input type="hidden" name="author_id" class="author_id" value="">	<span><a class="button white" id="save_author">сохранить</a></span>	<span><a class="button white" id="delete_author">Х</a></span></td></tr>');		
			});	
			
		/*	$(".article_author").live('keyup',function(){
				$(this).autocomplete("/source_admin.php");				
			});*/
			
			
			$(document).on('keyup', ".article_author", function(){
				$(this).autocomplete("/source_admin.php",{
					delay: 1			
					});	
			});
			
			$(this).result(function(event, data, formatted) {
				 //alert( !data ? "No match!" : "Selected: " + formatted);
			});
			
			
			$(document).on('click', "#delete_author", function(event){
				event.preventDefault();
				
				var str = "source_id="+$(".current_source").val();
				str +="&author_id="+$(this).parent().parent().children('.author_id').val()+"&action=deleteAuthor";
				//alert(str);
				if (confirm('Удалить автора?')) {	
					$(this).parent().parent().parent().fadeOut(200);
					$.post("/source_admin.php", str);							
				}
			});
			
/*				
				$("#add_source").fancybox({
					'hideOnContentClick': false,
					'overlayColor'		: '#000',
					'overlayOpacity'	: 0.8
					});
*/		
});