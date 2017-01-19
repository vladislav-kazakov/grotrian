					
			$.fn.dataTableExt.afnFiltering.push(
				function( oSettings, aData, iDataIndex ) {		
				
					var iMin = document.getElementById('min_2').value * 1;
					var iMax = document.getElementById('max_2').value * 1;
					
					var iVersion = aData[3] == "-" ? 0 : aData[3]*1;			
		
					if ( iMin == "" && iMax == "" )
					{
						return true;
					}
					else if ( iMin== "" && iVersion < iMax )
					{
						return true;
					}
					else if ( iMin < iVersion && "" == iMax )
					{
						return true;
					}
					else if ( iMin < iVersion && iVersion < iMax )
					{
						return true;
					}
					
					else if ( iMin == iVersion && iVersion == iMax )
					{
						return true;
					}
					
					return false;
					
					}
			);
			
					
			$.fn.dataTableExt.afnFiltering.push(
				function( oSettings, aData, iDataIndex ) {		
				
					var iMin = document.getElementById('min_3').value * 1;
					var iMax = document.getElementById('max_3').value * 1;
					
					var iVersion = aData[4] == "-" ? 0 : aData[4]*1;			
		
					if ( iMin == "" && iMax == "" )
					{
						return true;
					}
					else if ( iMin== "" && iVersion < iMax )
					{
						return true;
					}
					else if ( iMin < iVersion && "" == iMax )
					{
						return true;
					}
					else if ( iMin < iVersion && iVersion < iMax )
					{
						return true;
					}
					
					else if ( iMin == iVersion && iVersion == iMax )
					{
						return true;
					}
					
					return false;
					
					}
			);
			
			
			$.fn.dataTableExt.afnFiltering.push(
				function( oSettings, aData, iDataIndex ) {		
				
					var iMin = document.getElementById('min_4').value * 1;
					var iMax = document.getElementById('max_4').value * 1;
					
					var iVersion = aData[5] == "-" ? 0 : aData[5]*1;			
		
					if ( iMin == "" && iMax == "" )
					{
						return true;
					}
					else if ( iMin== "" && iVersion < iMax )
					{
						return true;
					}
					else if ( iMin < iVersion && "" == iMax )
					{
						return true;
					}
					else if ( iMin < iVersion && iVersion < iMax )
					{
						return true;
					}
					
					else if ( iMin == iVersion && iVersion == iMax )
					{
						return true;
					}
					
					return false;
					
					}
			);
			
			
						$.fn.dataTableExt.afnFiltering.push(
				function( oSettings, aData, iDataIndex ) {		
				
					var iMin = document.getElementById('min_5').value * 1;
					var iMax = document.getElementById('max_5').value * 1;
					
					var iVersion = aData[6] == "-" ? 0 : aData[6]*1;			
		
					if ( iMin == "" && iMax == "" )
					{
						return true;
					}
					else if ( iMin== "" && iVersion < iMax )
					{
						return true;
					}
					else if ( iMin < iVersion && "" == iMax )
					{
						return true;
					}
					else if ( iMin < iVersion && iVersion < iMax )
					{
						return true;
					}
					
					else if ( iMin == iVersion && iVersion == iMax )
					{
						return true;
					}
					
					return false;
					
					}
			);
			
			
						$.fn.dataTableExt.afnFiltering.push(
				function( oSettings, aData, iDataIndex ) {		
				
					var iMin = document.getElementById('min_6').value * 1;
					var iMax = document.getElementById('max_6').value * 1;
					
					var iVersion = aData[7] == "-" ? 0 : aData[7]*1;			
		
					if ( iMin == "" && iMax == "" )
					{
						return true;
					}
					else if ( iMin== "" && iVersion < iMax )
					{
						return true;
					}
					else if ( iMin < iVersion && "" == iMax )
					{
						return true;
					}
					else if ( iMin < iVersion && iVersion < iMax )
					{
						return true;
					}
					
					else if ( iMin == iVersion && iVersion == iMax )
					{
						return true;
					}
					
					return false;
					
					}
			);	
			
			$.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
				// check that we have a column id
				if ( typeof iColumn == "undefined" ) return new Array();
	
				// by default we only wany unique data
				if ( typeof bUnique == "undefined" ) bUnique = true;
	
				// by default we do want to only look at filtered data
				if ( typeof bFiltered == "undefined" ) bFiltered = true;
	
				// by default we do not wany to include empty values
				if ( typeof bIgnoreEmpty == "undefined" ) bIgnoreEmpty = true;
	
				// list of rows which we're going to loop through
				var aiRows;
	
				// use only filtered rows
				if (bFiltered == true) aiRows = oSettings.aiDisplay; 
				// use all rows
				else aiRows = oSettings.aiDisplayMaster; // all row numbers

				// set up data array	
				var asResultData = new Array();
	
				for (var i=0,c=aiRows.length; i<c; i++) {
					iRow = aiRows[i];
					var aData = this.fnGetData(iRow);
					var sValue = aData[iColumn];
		
					// ignore empty values?
					if (bIgnoreEmpty == true && sValue.length == 0) continue;

					// ignore unique values?
					else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;
		
					// else push the value onto the result data array
					else asResultData.push(sValue);
				}			
				
				return asResultData.sort();
			};
			
			

			$(document).ready(function() {
			
				$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback ){
				    if ( typeof sNewSource != 'undefined' && sNewSource != null ){
				        oSettings.sAjaxSource = sNewSource;
					}
				
				    this.oApi._fnProcessingDisplay( oSettings, true );
				    var that = this;
     
					oSettings.fnServerData( oSettings.sAjaxSource, null, function(json) {
					/* Clear the old information from the table */
					that.oApi._fnClearTable( oSettings );        
			        /* Got the data - add it to the table */
			        for ( var i=0 ; i<json.aaData.length ; i++ ){
			            that.oApi._fnAddData( oSettings, json.aaData[i] );
			        }       
			
			        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
			        that.fnDraw( that );
			        that.oApi._fnProcessingDisplay( oSettings, false );
         
				    /* Callback user function - for event handlers etc */
			        if ( typeof fnCallback == 'function' ){
			            fnCallback( oSettings );
			        }
			    });
			}			

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
				
	var oTable = $('#table1').dataTable({
		"aaSorting": [[ 3, "asc" ]],
		"sDom": 'l<"toolbar">rtip',	
		"oLanguage": dataTableslib,
		"aoColumns": [
						/*{ "fnRender": function ( oObj ) {
							return oObj.aData[0].replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");
						} },*/
						{ },
						{ "fnRender": function ( oObj ) {
							return oObj.aData[1].replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");
						} },
						{ "fnRender": function ( oObj ) {
							return oObj.aData[2].replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/<sup><suf>1<\/sup>/gi,"").replace(/\s/gi,"");
						} },		
						{ "fnRender": function ( oObj ) {
							return oObj.aData[3].replace(",",".");
							},
						"sType": "numeric" 
						},
						{ "sType": "numeric" },
						{ "sType": "numeric" },
						{ 
					/*	"fnRender": function ( oObj ) {
							var str= oObj.aData[5];									
							str = str.replace(",", ".");
							str = parseFloat(str);					
							if (!isNaN(str)) str = str; else str="";
																	
							return str										
							},			*/						
						"sType": "numeric" },
						{ "sType": "numeric" },
						
						{ "sType": "html" }
					], 
		
		"iDisplayLength": 25,
		"bLengthChange": true,
		"bFilter": true,
		"bProcessing": true,
		"sPaginationType": "full_numbers",					
		"fnInitComplete": function() {
		 // Make custom toolbar
			$("div.toolbar").html('<input class="button white" id="saveTransitions" value="'+SaveLevels+'" type="button"><input class="button white" id="deleteTransitions" value="'+DeleteLevels+'" type="button"><input class="button white" id="createTransition" value="'+CreateLevel+'" type="button">');
		}			
	});		
	
	/* Add event listeners to the two range filtering inputs */
	
	$('#min_6').keyup( function() { oTable.fnDraw(); } );
	$('#max_6').keyup( function() { oTable.fnDraw(); } );
	$('#min_2').keyup( function() { oTable.fnDraw(); } );
	$('#max_2').keyup( function() { oTable.fnDraw(); } );
	$('#min_3').keyup( function() { oTable.fnDraw(); } );
	$('#max_3').keyup( function() { oTable.fnDraw(); } );
	$('#min_4').keyup( function() { oTable.fnDraw(); } );
	$('#max_4').keyup( function() { oTable.fnDraw(); } );
	$('#min_5').keyup( function() { oTable.fnDraw(); } );
	$('#max_5').keyup( function() { oTable.fnDraw(); } );
	
			function addSelection(transition){			
				var lower_level_config, upper_level_config, wavelength, intensity, f_ik, a_ki, absorption ,source; 						
				//alert("dfg");
		    	if (!transition.hasClass('row_selected') ){

		    		transition.removeClass('selectable').addClass('row_selected').find(':checkbox').attr('checked', 'checked');
		    		
		    		transition.children('.lower_level_config').data("cfg", transition.children('.lower_level_config').html());
		    		transition.children('.lower_level_config').html('<a href="#" class=" button white" id="select_lower_level">выбрать</a>');

		    		transition.children('.upper_level_config').data("cfg", transition.children('.upper_level_config').html());
		    		transition.children('.upper_level_config').html('<a href="#" class="button white" id="select_upper_level">выбрать</a>');

		    		wavelength = transition.children('.wavelength').text();
		    		transition.children('.wavelength').html('<input size="" type="text" name="wavelength[]" value="'+wavelength+'"/>');
		    		
		    		intensity = transition.children('.intensity').text();
		    		transition.children('.intensity').html('<input size="" type="text" name="intensity[]" value="'+intensity+'"/>');
		    		
		    		f_ik = transition.children('.f_ik').text();
		    		transition.children('.f_ik').html('<input size="" type="text" name="f_ik[]" value="'+f_ik+'"/>');

		    		a_ki = transition.children('.a_ki').text();
		    		transition.children('.a_ki').html('<input size="" type="text" name="a_ki[]" value="'+a_ki+'"/>');		    		
		    				    		 
		    		absorption = transition.children('.absorption').text();
		    		transition.children('.absorption').html('<input size="" type="text" name="absorption[]" value="'+absorption+'"/>');		    		

		    		    		
		    		if (transition.find('.links').children('a').html() !=null) {
		    			transition.children('.source').data("source", transition.find('.links').html());
		    			var buttons = '<span id="buttons"><a href="#" class="button white" id="add_source">+</a><a class="button white" id="remove_source">-</a></span>';		    			
		    		}	else var buttons = '<span id="buttons"><a href="#" class="button white" id="add_source">+</a></span>';
		    		
		    		transition.children('.source').append(buttons);
		    		//alert(level.children('.source').data("source"));

				}
			}
			

			function removeSelection(transition){
				var lower_level_config, upper_level_config, wavelength, intensity, f_ik, a_ki, absorption ,source; 						
						    	
				transition.removeClass('row_selected').addClass('selectable').find(':checkbox').removeAttr('checked');

	    		transition.children('.wavelength').html(transition.children('.wavelength').children().prop('value'));
	    		transition.children('.intensity').html(transition.children('.intensity').children().prop('value'));
	    		transition.children('.f_ik').html(transition.children('.f_ik').children().prop('value'));
	    		transition.children('.a_ki').html(transition.children('.a_ki').children().prop('value'));
	    		transition.children('.absorption').html(transition.children('.absorption').children().prop('value'));

	    		if (transition.children('.lower_level_config').data("cfg")){
	    			transition.children('.lower_level_config').html(transition.children('.lower_level_config').data("cfg"));
	    		}else transition.children('.lower_level_config').html('');
	    		
	    		if (transition.children('.upper_level_config').data("cfg")){
	    			transition.children('.upper_level_config').html(transition.children('.upper_level_config').data("cfg"));
	    		}else transition.children('.upper_level_config').html('');
	    		
	    		if (transition.children('.source').data("source")){
	    			transition.children('.source').html('<span class="links">'+transition.children('.source').data("source")+"</span>");
	    		}else transition.children('.source').html('<span class="links"></span>');
	    		
	    		
			}		

			function levelsTableSort(energyValue, lowerUpper, termMultiply){
				//alert(energyValue+"\n"+lowerUpper+"\n"+termMultiply);				
				//oTableLevels.fnFilter("109",4);
			}
			
			/* Add a click handler to the rows - this could be used as a callback */	
			
			$(document).on("click", "tr.selectable td:not(.source)", function(){
				addSelection($(this).parent());							    	
		    });			
			
			$(document).on("click", ".row_selected input:checkbox",function(){
				removeSelection($(this).parent().parent());
			});
			
			
				
			$("#saveTransitions").click(function(){					
				var str = $(".row_selected input").serialize();
				str+="&action=saveTransitions&count="+$(".row_selected .row_id").length;		
				//alert(str);
				$.post("/transitions_admin.php", str, function(data){													
					$('.row_selected').each(function() {
						//console.log(data);
						removeSelection($(this));
					});
				});

			});	
			
						
			$("#deleteTransitions").click(function(){
				var str = $(".row_selected .row_id").serialize()+"&action=deleteTransitions";
				
				if (confirm('Удалить выбранные переходы?')) {									
					$.post("/transitions_admin.php", str, function(data){
						$(".row_selected").remove();
						//alert(data);
					});							
				}
			});
			
			$("#createTransition").click(function(){	
				if (confirm('Создать новый переход?')) {
					var atom_id = $("#atom_id").val();
					//alert(atom_id);
					$.post("/transitions_admin.php",  { atom_id: atom_id , action: "createTransition" },function(data) {
						//alert(data);
						if ($('tr:first').hasClass("odd")) p="even"; else p="odd";  
						//var str ='<tr class="'+p+' row_selected"><input type="hidden" class="level_id" name="level_id[]" value="'+data+'"><td class=""><input type="checkbox" checked="checked"></td><!--  <td></td>--><td id="level_config" class=" sorting_1"><input size="" type="text" name="level_config[]" value=""></td><td id="term"><input size="1" type="text" id="termPrefix" name="termPrefix[]" value=""><input size="1" type="text" id="termFirstpart" name="termFirstpart[]" value=""><input size="1" type="text" id="termMultiply" name="termMultiply[]" value=""></td><td id="j"><input size="" type="text" name="j[]" value=""></td><td id="energy"><input size="" type="text" name="energy[]" value=""></td><td id="lifetime"><input size="" type="text" name="lifetime[]" value=""></td><td id="source"><a href="#" class="button white" id="add_source">+</a><a class="button white" id="remove_source">-</a></td></tr>';
						var str ='<tr class="'+p+' row_selected"><input type="hidden" class="row_id" name="row_id[]" value="'+data+'"><td class=""><input type="hidden" class="lower_level_id" value=""/><input type="hidden" class="upper_level_id" value="" /><input type="checkbox" checked="true"></td><td class="lower_level_config"><a href="#" class="button white" id="select_lower_level">выбрать</a></td><td class="upper_level_config"><a href="#" class="button white" id="select_upper_level">выбрать</a></td><td class="wavelength"><input size="" type="text" name="wavelength[]" value=""></td><td class="intensity"><input size="" type="text" name="intensity[]" value=""></td><td class="f_ik"><input size="" type="text" name="f_ik[]" value=""></td><td class="a_ki"><input size="" type="text" name="a_ki[]" value=""></td><td class="absorption"><input size="" type="text" name="absorption[]" value=""></td><td class="source"><span id="links"></span><span id="buttons"><a href="#" class="button white" id="add_source">+</a></span></td></tr>';
						//alert (str);
						$('#table1').prepend(str);						
						
						//window.location.href = "/admin/ru/element/"+data;
					});		
				}
			});		
			
			
			
			
/*			$("#select_upper_level").live("click", function(){
				var n = 0;
				var transition = $(this).parent().parent();
				var atom_id = $("#atom_id").val();
				var transition_id=transition.find('.row_id').val();				
				energyValue=transition.find('.lower_level_energy').val();
				isUpperOrLower="is_upper";
				isOtherLevel = transition.find('.lower_level_config').data("cfg");
				termmultiplyValue=transition.find('.lower_level_termmultiply').val()+"a";
				
				$.fancybox.showLoading();
				
				$.post("/levels_admin.php",  {atom_id: atom_id , action: "manageLevel"}, function(data){
					$.fancybox(data,{
						'hideOnContentClick': false,
						'overlayColor'		: '#000',
						'overlayOpacity'	: 0.8
					});					
				});	
				
				
				$('#levels_table tbody tr').live("click", function(){	
					if (n == 0){
						n = 1;
						if (confirm('Поставить этот уровень?')) {
							var level_id = $(this).children('.row_id').val();
							//	alert("transition_id="+transition_id+"level_di="+level_id);						
							$.post("/transitions_admin.php",  { transition_id:transition_id,level_id:level_id , action: "setUpperLevel" },function(data) {							
								//	alert(transition.find('.upper_level_config').data("cfg"));
								data=data.replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");
								transition.find('.upper_level_config').data("cfg", data);
								parent.$.fancybox.close();							
							});	
							
						}
					}
				});				
			});	*/
			
			/*$("#select_lower_level").live("click", function(){	
				var n = 0;				
				var transition = $(this).parent().parent();
				var atom_id = $("#atom_id").val();				
				var transition_id=transition.find('.row_id').val();
				energyValue=transition.find('.upper_level_energy').val();
				isUpperOrLower = "is_lower";
				isOtherLevel = transition.find('.upper_level_config').data("cfg");
				//alert(isOtherLevel);
				//console.log(isOtherLevel);				
				termmultiplyValue=transition.find('.upper_level_termmultiply').val()+"a";				
				$.fancybox.showLoading();
				
				$.post("/levels_admin.php", {atom_id: atom_id , action: "manageLevel"}, function(data){
					alert(data);
					$.fancybox(data,{						
						'hideOnContentClick': false,
						'overlayColor'		: '#000',
						'overlayOpacity'	: 0.8						
					});						
				});				
				
				$('#levels_table tbody tr').live("click", function(){
					if (n == 0){
						n = 1;			

						if (confirm('Поставить этот уровень?')) {						
							var level_id = $(this).children('.row_id').val();
							//alert("transition_id="+row_id+"level_di="+level_id+"atom_id="+atom_id);
							//alert("transition_id:"+transition_id+"level_id:"+level_id+"action: setLowerLevel");
							$.post("/transitions_admin.php",  { transition_id:transition_id,level_id:level_id , action: "setLowerLevel"},function(data) {								
								data=data.replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");								
								transition.find('.lower_level_config').data("cfg", data);
								parent.$.fancybox.close();							
							});
						}
					}						
				});	
			});	*/
			
			$(document).on("click", "#select_lower_level", function(event){
				event.preventDefault(); 
				var position = "lower";				
				var transition = $(this).parent().parent();
				var atom_id = $("#atom_id").val();				
				var transition_id=transition.find('.row_id').val();
				var level_id;
				var str;
				$('.clicked').removeClass('clicked');
				transition.addClass("clicked");
		
				if (transition.find('.upper_level_config').data("cfg")){				
					level_id = transition.find('.upper_level_id').val();
					str = '../addlevels/'+atom_id+'/'+transition_id+'/'+position+'/'+level_id;
				}else str = '../addlevels/'+atom_id+'/'+transition_id+'/'+position;

				$.fancybox({
			    	'href'          : str,
			        'width'             : '75%',
			        'height'            : '75%',
			        'autoScale'         : false,
			        'type'              : 'iframe',
					'hideOnContentClick': false	
			    });					
			});
			
			$(document).on("click", "#select_upper_level", function(event){
				event.preventDefault();
				var position = "upper";				
				var transition = $(this).parent().parent();
				var atom_id = $("#atom_id").val();				
				var transition_id=transition.find('.row_id').val();
				var level_id;
				var str;
				$('.clicked').removeClass('clicked');
				transition.addClass("clicked");
		
				if (transition.find('.lower_level_config').data("cfg")){				
					level_id = transition.find('.lower_level_id').val();
					str = '../addlevels/'+atom_id+'/'+transition_id+'/'+position+'/'+level_id;
				}else str = '../addlevels/'+atom_id+'/'+transition_id+'/'+position;

				$.fancybox({
			    	'href'          : str,
			        'width'             : '75%',
			        'height'            : '75%',
			        'autoScale'         : false,
			        'type'              : 'iframe',
					'hideOnContentClick': false
			    });					
			});

		
});