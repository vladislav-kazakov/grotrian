$(document).ready(function() {
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
				
				var oTable3 = $('#bibliography_table').DataTable({
//				"bProcessing": true,
				serverSide: true,
				ajax: '/bibliolinks.php',

//				"fnDrawCallback": function() {					
//		            alert( 'DataTables has redrawn the table' );
//					replaceTable();					
//       			},
					"dom": 'l<"toolbar">rtip',
					"language": dataTableslib
					,
					"columns": [
									{ "className": "bibliolink",
										"render": function ( oObj ) {
										return (new BibtexDisplay()).displayBibtex(String(oObj));
									}},
									{ "className": "source_id",
										"type": "numeric" }

								], 
					"pageLength": 25,
					"lengthChange": true,
					"searching": true,
					"processing": true,
//					"bStateSave": true,
					//"bJQueryUI": true,
//					"sScrollY": 652,
//					"bPaginate": false,
					"paginationType": "full_numbers",
					
					"initComplete": function() {
						 // Make custom toolbar
//						$("#bibliography_table_wrapper div.toolbar").html(Search+': <input size="20" type="text" id="biblioSearchField">');
					}
				
				});
				$("#biblioSearchField").on('keyup', function () {
					oTable3.column(0).search(this.value).draw();
				} );



});