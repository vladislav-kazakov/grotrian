			$.fn.dataTableExt.afnFiltering.push(
				function( oSettings, aData, iDataIndex ) {		
				
					var iMin = document.getElementById('min_3').value * 1;
					var iMax = document.getElementById('max_3').value * 1;
					
					var iVersion = aData[4] == "-" ? 0 : aData[4]*1;								
			
					var confType = $("select#configurationType").val();
					var config = $("select#configurationSelect").val();
					var term = $("select#termSelect").val();
					var jvalue = $("select#jvalueSelect").val();
					
					if (aData[0]!=confType && confType!=''){
						return false;
					} else
					if (aData[1]!=config && config!=''){
						return false;
					} else
					if (aData[2]!=term && term!=''){
						return false;
					} else
					if (aData[3]!=jvalue && jvalue!=''){
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
				$("#configurationType").empty();
				$("#configurationType").append( $('<option value="">Any</option>'));
				$("#configurationType :last").attr("selected", "selected");
				$("#configurationSelect").empty();
				$("#configurationSelect").append( $('<option value="">Any</option>'));
				$("#configurationSelect :last").attr("selected", "selected");
				$("#termSelect").empty();
				$("#termSelect").append( $('<option value="">Any</option>'));
				$("#termSelect :last").attr("selected", "selected");
				$("#jvalueSelect").empty();
				$("#jvalueSelect").append( $('<option value="">Any</option>'));		
				$("#jvalueSelect :last").attr("selected", "selected");				
			
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
				
				
				var oTableLevels = $('#levels_table').dataTable({	
//				"bProcessing": true,
//				"bServerSide": true,
//				"sAjaxSource": '/ind.php',

//				"fnDrawCallback": function() {					
//		            alert( 'DataTables has redrawn the table' );
//					replaceTable();					
//       			},
					"aaSorting": [[ 4, "asc" ]],
					"sDom": 'l<"toolbar">rtip',	
					"oLanguage": dataTableslib,
					"aoColumns": [
									{ "fnRender": function ( oObj ) {
										return oObj.aData[0].replace(/@\{0\}/gi,"&deg;").replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/#/gi,"&deg;");
									} , "sType": "html"},
								
									{ "fnRender": function ( oObj ) {
										return oObj.aData[1].replace(/@\{0\}/gi,"&deg;").replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/#/gi,"&deg;");
									} },
									
/*									{ "fnRender": function ( oObj ) {
										return oObj.aData[2].replace(/<sup>0<\/sup>/gi,"").replace(/<sup><suf>1<\/sup>/gi,"").replace(/[^0-9a-z<>,?\\\/\(\)\[\]]/gi,"");
									} },
*/
									{ "fnRender": function ( oObj ) {
										return oObj.aData[2].replace(/\s/gi,"");
									} },
									
									{ 
									},
									
									{ "fnRender": function ( oObj ) {
                                        return isNaN(parseFloat(oObj.aData[4]))?oObj.aData[4]:parseFloat(oObj.aData[4]);
                                    } },
									
									{ "sType": "numeric" },
									{ "sType": "numeric" }
								], 
					"iDisplayLength": 25,
					"bLengthChange": true,
					"bFilter": true,
					"bProcessing": true,
//					"bStateSave": true,
					//"bJQueryUI": true,
//					"sScrollY": 652,
//					"bPaginate": false,
					"sPaginationType": "full_numbers",
					"fnInitComplete": function() {
						 // Make custom toolbar
						$("div.toolbar").html('<input class="button white" id="btn_search" value="'+Tablelookup+'" type="button"> <input class="button white" id="btn_export" value="'+ExporttoExcel+'" type="button"> ');
							
						// Make Table Export
					
						$("#btn_export").click( function() { 
							$('#levels_table').table2CSV();
							}); 
					}
				
				});		

				function fillSelectFields(){										
					//Запоминаем текущие параметры фильтра
					var confType = $("select#configurationType").val();
					var config = $("select#configurationSelect").val();
					var term = $("select#termSelect").val();
					var jvalue = $("select#jvalueSelect").val();					
					
					//Заполняем поля для фильтрации пустыми значениями
					$("#configurationType").empty();
					$("#configurationType").append( $('<option value="">Any</option>'));
					//$("#configurationType :last").attr("selected", "selected");
					$("#configurationSelect").empty();
					$("#configurationSelect").append( $('<option value="">Any</option>'));
					//$("#configurationSelect :last").attr("selected", "selected");
					$("#termSelect").empty();
					$("#termSelect").append( $('<option value="">Any</option>'));
					//$("#termSelect :last").attr("selected", "selected");
					$("#jvalueSelect").empty();
					$("#jvalueSelect").append( $('<option value="">Any</option>'));		
					//$("#jvalueSelect :last").attr("selected", "selected");
				
					// Составляем массивы с данными, находящимися в таблице в данный момент. Автоматически вырезаются повторы - к сожалению, получаются массивы разной длины
					var configurationsTypesList = oTableLevels.fnGetColumnData(0,true,true,true);
					var configurationsList = oTableLevels.fnGetColumnData(1,true,true,true);
					var termsList = oTableLevels.fnGetColumnData(2,true,true,true);
					var jvalueList = oTableLevels.fnGetColumnData(3,true,true,true);
					
					// Заполняем select-поля инфой из массивов
					for (var i=0; i<configurationsTypesList.length;i++){
						$("#configurationType").append( $('<option value="'+configurationsTypesList[i]+'">'+configurationsTypesList[i].replace(/<[^\/>]*>/gi,"[").replace(/<\/[^>]*>/gi,"]")+'</option>'));
						if (configurationsTypesList[i] == confType){
							$("#configurationType :last").attr("selected", "selected");
						}
					}
					for (var i=0; i<configurationsList.length;i++){
						$("#configurationSelect").append( $('<option value="'+configurationsList[i]+'">'+configurationsList[i].replace(/<[^\/>]*>/gi,"[").replace(/<\/[^>]*>/gi,"]")+'</option>'));
						if (configurationsList[i] == config){
							$("#configurationSelect :last").attr("selected", "selected");
						}
					}
					for (var i=0; i<termsList.length;i++){
						$("#termSelect").append( $('<option value="'+termsList[i]+'">'+termsList[i].replace(/<[\/]*[^\/>]*span>/gi,"").replace(/<[^\/>]*>/gi,"[").replace(/<\/[^>]*>/gi,"]")+'</option>'));
						if (termsList[i] == term){
							$("#termSelect :last").attr("selected", "selected");
						}
					}
					for (var i=0; i<jvalueList.length;i++){
						$("#jvalueSelect").append( $('<option value="'+jvalueList[i]+'">'+jvalueList[i].replace(/<[^\/>]*>/gi,"[").replace(/<\/[^>]*>/gi,"]")+'</option>'));
						if (jvalueList[i] == jvalue){
							$("#jvalueSelect :last").attr("selected", "selected");
						}
					}					
				}

				/* Add event listeners to the two range filtering inputs */		

			
				$("#configurationType").change( function () {					
					oTableLevels.fnDraw();
					fillSelectFields();					
				} );
				
				$("#configurationSelect").change( function () {					
					oTableLevels.fnDraw();
					fillSelectFields();
				} );
				
				$("#termSelect").change( function () {					
					oTableLevels.fnDraw();
					fillSelectFields();
				} );
				
				$("#jvalueSelect").change( function () {					
					oTableLevels.fnDraw();
					fillSelectFields();
				} );
				
				
				$('#min_3').keyup( function() { oTableLevels.fnDraw(); fillSelectFields();} );
				$('#max_3').keyup( function() { oTableLevels.fnDraw(); fillSelectFields();} );				
				
				fillSelectFields();
			
			});	