			$(document).ready(function() {	
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
				
				var oTable3 = $('#bibliography_table').dataTable({	
//				"bProcessing": true,
//				"bServerSide": true,
//				"sAjaxSource": '/ind.php',

//				"fnDrawCallback": function() {					
//		            alert( 'DataTables has redrawn the table' );
//					replaceTable();					
//       			},

					"sDom": 'l<"toolbar">rtip',	
					"oLanguage": dataTableslib											
					,
					"aoColumns": [									
									{ "sType": "numeric" },									
									{ "sType": "html" }
									
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
						$("#bibliography_table_wrapper div.toolbar").html(Search+': <input size="20" type="text" id="biblioSearchField">');
					}
				
				});						
		
				$("#biblioSearchField").keyup( function () {											
					oTable3.fnFilter( this.value, 0);					
				} );
			});	