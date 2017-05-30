					
			$.fn.dataTableExt.afnFiltering.push(
				function( oSettings, aData, iDataIndex ) {		
				
					var iMin = document.getElementById('min_2').value * 1;
					var iMax = document.getElementById('max_2').value * 1;
					
					var iVersion = aData[7] == "-" ? 0 : aData[7]*1;
					
					var serie = $("select#serieSelect").val();
					var lowerlevel = $("select#lowerLevelSelect").val();
					var upperlevel = $("select#upperLevelSelect").val();
		
					if (aData[0]!=serie && serie!=''){
						return false;
					} else
					if (aData[1]!=lowerlevel && lowerlevel!=''){
						return false;
					} else
					if (aData[4]!=upperlevel && upperlevel!=''){
						return false;
					} else
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
					
					var iVersion = aData[8] == "-" ? 0 : aData[8]*1;
		
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
					
					var iVersion = aData[9] == "-" ? 0 : aData[9]*1;
		
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
					
					var iVersion = aData[10] == "-" ? 0 : aData[10]*1;
		
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
					
					var iVersion = aData[11] == "-" ? 0 : aData[11]*1;
		
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
				//Заполняем поля для фильтрации пустыми значениями
				$("#serieSelect").empty();
				$("#serieSelect").append( $('<option value="">Any</option>'));
				$("#serieSelect :last").attr("selected", "selected");
				$("#lowerLevelSelect").empty();
				$("#lowerLevelSelect").append( $('<option value="">Any</option>'));
				$("#lowerLevelSelect :last").attr("selected", "selected");
				$("#upperLevelSelect").empty();
				$("#upperLevelSelect").append( $('<option value="">Any</option>'));
				$("#upperLevelSelect :last").attr("selected", "selected");
					
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

				/* Initialise datatables */

				var oTable = $('#transitions_table').dataTable({
				"aaSorting": [[ 7, "asc" ]],
//				"bProcessing": true,
//				"bServerSide": true,
//				"sAjaxSource": 'a_qlines.php',

				"fnDrawCallback": function() {					
//		            alert( 'DataTables has redrawn the table' );
//					replaceTable();					
       			},    			

					"sDom": 'l<"toolbar">rtip',	
					"oLanguage": dataTableslib,			
					"aoColumns": [
									{ "fnRender": function ( oObj ) {
										return oObj.aData[0].replace(/(\([^\)]*\))/gi,"").replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");
									} },
									{ "fnRender": function ( oObj ) {
										return oObj.aData[1].replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");
									} },
						{ "sType": "numeric" },
						{ "sType": "numeric" },
									{ "fnRender": function ( oObj ) {
										return oObj.aData[4].replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");
									} },
						{ "sType": "numeric" },
						{ "sType": "numeric" },
									{ "fnRender": function ( oObj ) {
										return oObj.aData[7].replace(",",".");
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
//					"bStateSave": true,
					//"bJQueryUI": true,
					"sPaginationType": "full_numbers",
					
					"fnInitComplete": function() {
						 // Make custom toolbar
						$("div.toolbar").html('<input class="button white" id="btn_search" value="'+Tablelookup+'" type="button"> <input class="button white" id="btn_export" value="'+ExporttoExcel+'" type="button"> ');
							
						// Make Table Export
					
						$("#btn_export").click( function() { 
							$('#transitions_table').table2CSV();
							}); 
					}
				});	

				function fillSelectFields(){										
					//Запоминаем текущие параметры фильтра
					var serie = $("select#serieSelect").val();
					var lowerlevel = $("select#lowerLevelSelect").val();
					var upperlevel = $("select#upperLevelSelect").val();				
					
					//Заполняем поля для фильтрации пустыми значениями
					$("#serieSelect").empty();
					$("#serieSelect").append( $('<option value="">Any</option>'));
					$("#lowerLevelSelect").empty();
					$("#lowerLevelSelect").append( $('<option value="">Any</option>'));
					$("#upperLevelSelect").empty();
					$("#upperLevelSelect").append( $('<option value="">Any</option>'));					
				
					// Составляем массивы с данными, находящимися в таблице в данный момент. Автоматически вырезаются повторы - к сожалению, получаются массивы разной длины
					var seriesList = oTable.fnGetColumnData(0,true,true,true);
					var lowerLeveslList = oTable.fnGetColumnData(1,true,true,true);
					var upperLevelsList = oTable.fnGetColumnData(2,true,true,true);					
					
					// Заполняем select-поля инфой из массивов
					for (var i=0; i<seriesList.length;i++){
						$("#serieSelect").append( $('<option value="'+seriesList[i]+'">'+seriesList[i].replace(/<[^\/>]*>/gi,"[").replace(/<\/[^>]*>/gi,"]")+'</option>'));
						if (seriesList[i] == serie){
							$("#serieSelect :last").attr("selected", "selected");
						}
					}
					for (var i=0; i<lowerLeveslList.length;i++){
						$("#lowerLevelSelect").append( $('<option value="'+lowerLeveslList[i]+'">'+lowerLeveslList[i].replace(/<[^\/>]*>/gi,"[").replace(/<\/[^>]*>/gi,"]")+'</option>'));
						if (lowerLeveslList[i] == lowerlevel){
							$("#lowerLevelSelect :last").attr("selected", "selected");
						}
					}
					for (var i=0; i<upperLevelsList.length;i++){
						$("#upperLevelSelect").append( $('<option value="'+upperLevelsList[i]+'">'+upperLevelsList[i].replace(/<[\/]*[^\/>]*span>/gi,"").replace(/<[^\/>]*>/gi,"[").replace(/<\/[^>]*>/gi,"]")+'</option>'));
						if (upperLevelsList[i] == upperlevel){
							$("#upperLevelSelect :last").attr("selected", "selected");
						}
					}							
				}

				/* Add event listeners to the two range filtering inputs */
	
				$("#serieSelect").change( function () {					
					oTable.fnDraw();
					fillSelectFields();					
				} );
				
				$("#lowerLevelSelect").change( function () {					
					oTable.fnDraw();
					fillSelectFields();
				} );
				
				$("#upperLevelSelect").change( function () {					
					oTable.fnDraw();
					fillSelectFields();
				} );
	
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
				

				fillSelectFields();
			});	
