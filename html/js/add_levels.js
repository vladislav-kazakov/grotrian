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

								$(".btn-slide").click(function(){
									$("#panel").slideToggle("slow");
									$(this).toggleClass("active");
									$("#panel div").addClass('tpanel');
								});	
							
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
								
					var oTable_levels = $('#levels_table').dataTable({
						"aaSorting": [[ 5, "asc" ]],
						"sDom": 'l<"toolbar">rtip',	
						"oLanguage": dataTableslib,
						"aoColumns": 
						[	{ "fnRender": function ( oObj ) {
							return oObj.aData[0].replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>");
						} , "sType": "html"},
					
						{ "fnRender": function ( oObj ) {
							return oObj.aData[1].replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>");
						} },
						
						{ "fnRender": function ( oObj ) {
							return oObj.aData[2].replace(/<sup><pr>0<\/sup>/gi,"").replace(/<sup><suf>1<\/sup>/gi,"").replace(/[^0-9a-z<>?\\\/\(\)\[\]]/gi,"");
						} },
						
						{ "fnRender": function ( oObj ) {
							return oObj.aData[3].replace(",",".");
							}
						},
						
						{ "sType": "numeric" , "bVisible":false },	
						{ "sType": "numeric" },	
						
						{ "sType": "numeric" },
						{ "sType": "numeric" }
						], 
						
						"iDisplayLength": 25,
						"bLengthChange": true,
						"bFilter": true,
						"bProcessing": true,
						"sPaginationType": "full_numbers",					
						"fnInitComplete": function() {
							 // Make custom toolbar
								$("div.toolbar").html('<a href="/admin/ru/addlevels/'+atom_id+'/'+transition_id+'/'+position+'" class="button white" >Показать все уровни</a>');
							}					
								
					});		
					
	

					function fillSelectFields(fromFieldWeCome){										
						if (fromFieldWeCome != 'configurationType'){
							var selectConfigType = document.getElementById("configurationType");								
							var saveConfigType = selectConfigType.value
							selectConfigType.options.length = 1;										
							var configurationsTypesList = oTable_levels.fnGetColumnData(0,true,true);
							for (var i=0; i<configurationsTypesList.length;i++){
								selectConfigType.options[i+1] = new Option(configurationsTypesList[i].replace(/<[^\/>]*>/gi,"[").replace(/<\/[^>]*>/gi,"]"), configurationsTypesList[i].replace(/<[^>]*>/gi,""));							
								if (configurationsTypesList[i].replace(/<[^>]*>/gi,"") == saveConfigType){
									selectConfigType.options[i+1].selected = true;
								}
								else{
									selectConfigType.options[i+1].selected = false;
								}
							}						
							
							if (configurationsTypesList.length>1){
								selectConfigType.options[0].selected = true;
							}
							else{
								selectConfigType.options[1].selected = true;
							}
						}
							
						if (fromFieldWeCome != 'configurationSelect'){
										var selectConfig = document.getElementById("configurationSelect");								
										var saveConfig = selectConfig.value;
										selectConfig.options.length = 1;
										var configurationsList = oTable_levels.fnGetColumnData(1,true,true);
										selectConfig.options[0].selected=true;
										for (var i=0; i<configurationsList.length;i++){
											selectConfig.options[i+1] = new Option(configurationsList[i].replace(/<[^\/>]*>/gi,"[").replace(/<\/[^>]*>/gi,"]"), configurationsList[i]);
											if (configurationsList[i] == saveConfig){
												selectConfig.options[i+1].selected = true;
											} else {
												selectConfig.options[i+1].selected = false;
											}
										}
										if (configurationsList.length>1){
											selectConfig.options[0].selected = true;
										} else {
											selectConfig.options[1].selected = true;
										}
									}
							
									if (fromFieldWeCome != 'thermSelect'){
										var selectTherm = document.getElementById("thermSelect");			
										var saveTherm = selectTherm.value;
										selectTherm.options.length = 1;
										var thermsList = oTable_levels.fnGetColumnData(2,true,true);
										selectTherm.options[0].selected=true;
										for (var i=0; i<thermsList.length;i++){
											selectTherm.options[i+1] = new Option(thermsList[i].replace(/<[^\/>]*>/gi,"[").replace(/<\/[^>]*>/gi,"]"), thermsList[i].replace(/<[^>]*>/gi,""));
											if (thermsList[i].replace(/<[^>]*>/gi,"") == saveTherm){
												selectTherm.options[i+1].selected = true;
											} else {
												selectTherm.options[i+1].selected = false;
											}
										}
										if (thermsList.length>1){
											selectTherm.options[0].selected = true;
										} else {
											selectTherm.options[1].selected = true;
										}
									}
							
									if (fromFieldWeCome != 'jvalueSelect'){
										var selectJvalue = document.getElementById("jvalueSelect");			
										var saveJvalue = selectJvalue.value;
										selectJvalue.options.length = 1;
										var jvalueList = oTable_levels.fnGetColumnData(3,true,true);
										selectJvalue.options[0].selected = true;
										for (var i=0; i<jvalueList.length;i++){
											selectJvalue.options[i+1] = new Option(jvalueList[i].replace(/<[^\/>]*>/gi,"[").replace(/<\/[^>]*>/gi,"]"), jvalueList[i].replace(/<[^>]*>/gi,""));
											if (jvalueList[i].replace(/<[^>]*>/gi,"") == saveJvalue){
												selectJvalue.options[i+1].selected = true;
											} else {
												selectJvalue.options[i+1].selected = false;
											}
										}
										if (jvalueList.length>1){
											selectJvalue.options[0].selected = true;
										} else {
											selectJvalue.options[1].selected = true;
										}
									}
								}

								/* Add event listeners to the two range filtering inputs */		

								$("#parity").change( function () {
									oTable_levels.fnFilter( this.value, 3);
									} ); 
				
								$("#configurationType").change( function () {						
									oTable_levels.fnFilter( this.value, 0);					
									if (this.value != '') {
										fillSelectFields('configurationType');
									} else {
										fillSelectFields('Any text here');
									}
								} );
								
								
								$("#configurationSelect").change( function () {					
									oTable_levels.fnFilter(this.value,1);				
									if (this.value != '') {
										fillSelectFields('configurationSelect');
									} else {
										fillSelectFields('Any text here');
									}
								} );
												
								$("#thermSelect").change( function () {					
									oTable_levels.fnFilter(this.value,2);					
									if (this.value != '') {
										fillSelectFields('thermSelect');
									} else {
										fillSelectFields('Any text here');
									}
								} );
								
								$("#jvalueSelect").change( function () {					
									oTable_levels.fnFilter(this.value,3);										
									if (this.value != '') {
										fillSelectFields('jvalueSelect');
									} else {
										fillSelectFields('Any text here');
									}
								} );
								
							
								$('#min_3').keyup( function() { oTable_levels.fnDraw(); } );
								$('#max_3').keyup( function() { oTable_levels.fnDraw(); } );				
								
								fillSelectFields('Any text here');
							

							
							
							

							function checkConfigFunction(config, energy){
								var sublevelsOrder="spdfghijklmnopqrstuvwxyz"			
								config = config.replace(/\([^\)]*\)/gi,"");
								config = config.replace(/([a-z])([0-9])/g,"$1@{1}$2");
								if (/\w/.test(config[config.length-1])){
									config = config+"@{1}";			
								}
							
								// проверка на адекватное построение конфигурации (уровень-подуровень-количество электронов)
								if ((/[^0-9][a-z]/g.test(config))||(/[0-9][^0-9a-z\}]/g.test(config))||(/[^0-9a-z\@\{\}\~]/g.test(config))){
									return("Неверное строение конфигурации");				
								}
								
								// проверка на то, цифры ли у нас в фигурных скобках
								if (/[^0-9]/g.test(config.replace(/[^\{]+(\{[^\}]*\})/g,"$1").replace(/[\{\}]/g,""))){
									//alert(config.replace(/[^\{]+(\{[^\}]*\})/g,"$1").replace(/[\{\}]/g,""));
									return("Некорректные символы в количестве электронов");
								}
								
								// проверка на количество электронов на подуровнях и подуровней на уровнях
								var electronsOnSublevels = config.replace(/\}[^\{]+\{/g,"}{").replace(/[^\{]*/,"").replace(/\}/g,"").split("{");
								var levels = config.replace(/\@\{[^}]*\}/g,"").split(/[a-z]/)
								var sublevels = config.replace(/\@[^\}]*\}/g,"").replace(/[0-9]/g,"").split("");
								for (var i = 0; i<sublevels.length; i++){
									if (electronsOnSublevels[i+1]>(4*sublevelsOrder.indexOf(sublevels[i])+2)){
										return("Некорректное количество электронов на подуровнях")
									}
									if (sublevelsOrder.indexOf(sublevels[i])+1>levels[i]){
										return("Некорректное количество подуровней на уровнях");
									}
								}
							
								// считаем, сколько электронов описано в конфигурации
							
								var electronsCount = 0;
								for (var i = 0; i<sublevels.length; i++){
									electronsCount+=(electronsOnSublevels[i+1]*1);
								}		
							
								if (energy == 0){
									var tempstring = config.replace(/\@[^\}]*\}/g,"").replace(/([a-z])/g,"$1,");
									levelsAndSubLevels = tempstring.substring(0,tempstring.length-1).split(",");
									var x = 100,y = 100;
							
									var levelsString = "1s2s2p3s3p4s3d4p5s4d5p6s4f5d6p7s5f6d7p";	
								
									var currentHighestLevel = "1s";
							
									for (var i=0;i<levelsAndSubLevels.length;i++){								
										if (levelsString.indexOf(currentHighestLevel)<levelsString.indexOf(levelsAndSubLevels[i])){
											currentHighestLevel=levelsAndSubLevels[i];
										}
									}			
							
									stringToCountElectrons = levelsString.substring(0, levelsString.indexOf(currentHighestLevel)).replace(/([a-z])/g,"$1,");
									stringToCountElectrons = stringToCountElectrons.substring(0, stringToCountElectrons.length-1);
									arrayToCountElectrons = stringToCountElectrons.split(",");
													
									for (var i=0;i<arrayToCountElectrons.length;i++){
										if (tempstring.substring(0,tempstring.length-1).indexOf(arrayToCountElectrons[i])==-1)	{
											if ((arrayToCountElectrons[i]=="6d")&&((config.indexOf("7p@{1}")!=-1)||(config.indexOf("7p@{2}")!=-1))){
												continue;
											}
											if ((arrayToCountElectrons[i]=="5f")&&((config.indexOf("6d@{1}")!=-1)||(config.indexOf("6d@{2}")!=-1))){
												continue;
											}
											if ((arrayToCountElectrons[i]=="4f")&&((config.indexOf("5d@{1}")!=-1)||(config.indexOf("5d@{2}")!=-1))){
												continue;
											}
											electronsCount+=(sublevelsOrder.indexOf(arrayToCountElectrons[i].replace(/\d/g,""))*4+2);					
										}
									}
							
									if (config=="4d@{10}"){
										electronsCount-=2;
									}
								}
							
								return(electronsCount);				
							}		
						
				});				
							
							
							$('#levels_table tbody tr').live("click", function(){		
							
								//console.log(parent.$('.clicked').find(".lower_level_id").val());
									if (confirm('Поставить этот уровень?')) {						
										var level_id = $(this).find('.row_id').val();
										var act;  
										if (position == "lower")
										{
											act = "setLowerLevel";
											cfg = ".lower_level_config";
											fid = ".lower_level_id";
										}else 
										{	
											act = "setUpperLevel";
											cfg = ".upper_level_config";
											fid = ".upper_level_id";
										}
										
										//console.log("tr:"+transition_id,"lev:"+level_id,"act:"+act);
/*										alert(transition_id);
										alert(level_id);
										alert(act);*/
										$.post("/transitions_admin.php",  { transition_id:transition_id,level_id:level_id , action: act},function(data) {								
											//console.log(data);
											data=data.replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");
											
											parent.$('.clicked').find(cfg).data("cfg", data);
											//alert(level_id);
											parent.$('.clicked').find(fid).val(level_id);											
											parent.$.fancybox.close();							
										});									
								}						
							});				
				
				
				