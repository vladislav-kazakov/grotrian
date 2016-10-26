					$(document).ready(function() {						
						waveMinVal=0;
						waveMaxVal=10000000;
						energyMinVal=0;
						energyMaxVal=10000000;									
					
						$.post('/a_svg.php',{ element_id: id }, function(data) {
							$('#svg').html(data);	
							$("#diagram").attr({
								  width: "99%",
								  height: "85%"
								});															
						});

						$("#filterBtn").click(function(){

							waveMinVal = document.inputform.waveMinVal.value;
							waveMaxVal = document.inputform.waveMaxVal.value;

							energyMinVal = document.inputform.energyMinVal.value;
							energyMaxVal = document.inputform.energyMaxVal.value;
							
//							diagramWidthVal = document.inputform.diagramWidth.value;
//							diagramHeightVal = document.inputform.diagramHeight.value;
							
							if (waveMinVal=="") waveMinVal=0;
							if (waveMaxVal=="") waveMaxVal=10000000;
							if (energyMinVal=="") energyMinVal=0;
							if (energyMaxVal=="") energyMaxVal=10000000;
																
							$.post('/a_svg.php',{ element_id: id }, function(data) {
								$('#svg').html(data);
								$("#diagram").attr({
									  //width: diagramWidthVal,
									  //height: diagramHeightVal
									  width: "99%",
									  height: "85%"
									});	
							});
						
						});

						$("#showAllBtn").click(function(){
						
							waveMinVal=0;
							waveMaxVal=10000000;
							energyMinVal=0;
							energyMaxVal=10000000;
							
																						
							$.post('/a_svg.php',{ element_id: id }, function(data) {
								$('#svg').html(data);
								$("#diagram").attr({
									  width: "99%",
									  height: "85%"
									});	
							});
						
						});
						
					    // Make slide search panel
						$(".btn-slide").click(function(){
							$("#panel").slideToggle("slow");
							$(this).toggleClass("active");
							$("#panel div").addClass('tpanel');
						});
						
					});