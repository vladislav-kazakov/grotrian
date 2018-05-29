					$(document).ready(function() {						
						$("#filterBtn").click(function(){
							waveMinVal = document.inputform.waveMinVal.value;
							waveMaxVal = document.inputform.waveMaxVal.value;
							energyMinVal = document.inputform.energyMinVal.value;
							energyMaxVal = document.inputform.energyMaxVal.value;
                            widthVal = document.inputform.widthVal.value;

							var query = new Array();
							if (waveMinVal!="" && waveMinVal!=0)  query.push("wlmin=" + waveMinVal);
							if (waveMaxVal!="" && waveMaxVal!=0) query.push("wlmax=" + waveMaxVal);
							if (energyMinVal!="" && energyMinVal!=0) query.push("enmin=" + energyMinVal);
							if (energyMaxVal!="" && energyMaxVal!=0) query.push("enmax=" + energyMaxVal);
                            if (widthVal!="" && widthVal!=0) query.push("width=" + widthVal);
							if (query.length > 0)
                            	location.replace("?" + query.join("&"));
						
						});
						$("#showAllBtn").click(function(){
							location.replace("?");
						});

                        // Make slide search panel
                        $(".btn-slide").unbind('click');
                        $(".btn-slide").click(function(){
                            $("#panel").slideToggle("slow");
                            $(this).toggleClass("active");
                            $("#panel div").addClass('tpanel');
                        });
						
					});