					$(document).ready(function() {						
						$("#filterBtn").click(function(){
							waveMinVal = document.inputform.waveMinVal.value;
							waveMaxVal = document.inputform.waveMaxVal.value;
							energyMinVal = document.inputform.energyMinVal.value;
							energyMaxVal = document.inputform.energyMaxVal.value;
                            nMaxVal = document.inputform.nMaxVal.value;
                            lMaxVal = document.inputform.lMaxVal.value;
                            widthVal = document.inputform.widthVal.value;
                            groupbyMu = document.inputform.groupbyMu.checked;
                            prohibitedbyMuOff = document.inputform.prohibitedbyMuOff.checked;
                            prohibitedbyParOff = document.inputform.prohibitedbyParOff.checked;
                            autoStates = document.inputform.autoStates.checked;
                            groupingVal = document.inputform.grouping.value;

							var query = new Array();
							if (waveMinVal!="" && waveMinVal!=0)  query.push("wlmin=" + waveMinVal);
							if (waveMaxVal!="" && waveMaxVal!=0) query.push("wlmax=" + waveMaxVal);
							if (energyMinVal!="" && energyMinVal!=0) query.push("enmin=" + energyMinVal);
                            if (energyMaxVal!="" && energyMaxVal!=0) query.push("enmax=" + energyMaxVal);
                            if (nMaxVal!="" && nMaxVal!=0) query.push("nmax=" + nMaxVal);
                            if (lMaxVal!="" && lMaxVal!=0) query.push("lmax=" + lMaxVal);
                            if (widthVal!="" && widthVal!=0) query.push("width=" + widthVal);
                            if (groupbyMu) query.push("groupbyMu");
                            if (!prohibitedbyMuOff) query.push("prohibitedbyMuOff");
                            if (!prohibitedbyParOff) query.push("prohibitedbyParOff");
                            if (!autoStates) query.push("autoStatesOff");
                            if (groupingVal && groupingVal != 'auto') query.push("grouping=" + groupingVal);

							if (query.length > 0)
                            	location.replace("?" + query.join("&"));
							else location.replace("?");
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