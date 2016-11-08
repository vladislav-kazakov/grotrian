$(document).ready(function() {	
	
	var config = {
			toolbar : 'MyToolbar'
		};

		// Initialize the editor.
		// Callback function can be passed and executed after full instance creation.
	$('.jquery_ckeditor').ckeditor(config);
	
	
	$("#saveElement").click(function(){
		
		var str = $("#inputElementform").serialize();
		//alert(str);
		if (confirm('Сохранить изменения?')) {
			$.post("/element_admin.php", str,function(data) {
				//alert(data);
				//window.location.href = "/admin/ru/element/"+$("input#atom_id").val();
			});
		}
		
	});
	
	$("#deleteElement").click(function(){
		
		if (confirm('Вы уверены, что хотите удалить этот элемент?')) {
			$.post("/element_admin.php",  { element_id: id , action: "delete" } );
		}
	});
	
	$("#createAtom").click(function(){	
		if (confirm('Создать атомную систему?')) {
			var element_id = $("input#element_id").val();			
			$.post("/element_admin.php",  { element_id: element_id , action: "createAtom" },function(data) {
				window.location.href = "/admin/ru/element/"+data;
			});		
		}
	});
	
	$("#deleteAtom").click(function(){	
		var element_id = $("input#element_id").val();
		var atom_id = $("input#atom_id").val();
		
		if (confirm('Удалить атомную систему?')) {
			
			$.post("/element_admin.php",  { element_id: element_id, atom_id:atom_id , action: "deleteAtom" },function(data) {
				window.location.href = "/admin/ru/element/"+data;
			});		
		}
	});
	
	$("input#saveAtom").click(function(){
		//alert("sdf");
		
		var ionization = parseInt($('#atomIonization').val());
		var z=parseInt($('#z').val());
		
		if (ionization < z) {
			var str = $("#inputAtomform").serialize();
			str+="&atom_id="+$("#atom_id").val();
			//alert(str);
			$.post("/element_admin.php", str,function(data) {
				//alert(data);
				window.location.href = "/admin/ru/element/"+$("input#atom_id").val();
			});				
		} else alert('Невозможная степень ионизации');
	});
	
	$("#makeDiagram").click(function(){		
		
		var str = "action=makeDiagram";
		str+="&atom_id="+$("#atom_id").val();
		str+="&atomLimits="+$("#atomLimits").val();
		str+="&atomBreaks="+$("#atomBreaks").val()
		//alert(str);
		$.post("/element_admin.php", str,function(data) {
			//console.log(data);
			//alert(data);
			//window.location.href = "/admin/ru/element/"+$("input#atom_id").val();
		});				
	});
	
	

});