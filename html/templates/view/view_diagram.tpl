{#if ($transition_count != 0)#}

  		{# if $layout_element_id #}
			<script type="text/javascript" charset="utf-8">
				var id={#$layout_element_id#};				
			</script>  						
  			
  			<script type="text/javascript" src="/js/filter_diagram.js?v3"></script>
     	
		{#/if#}

				<div id="panel">
    				<div class="container_12">        
						<div class="grid_9">
            				<h4>{#$l10n.Data_filter#}</h4>
            				
            				<form name="inputform" action="">
	                		<table class="search_form">
								<tbody>
	                				
                                    <tr>
	                    	 			<td></td>
                                        <td align="center"><div class="froam">{#$l10n.from#}</div><div class="froam" >{#$l10n.to#}</div></td>
                                        <td></td>
                                        <td></td> 
		                			</tr>
									
                                    <tr>
										<td class="name">{#$l10n.Wavelength#}:</td>
										<td>
				                        	<input  size="12" type="text" name="waveMinVal" value="{#$wlmin#}"/>
											<input size="12" type="text" name="waveMaxVal" value="{#$wlmax#}"/>
										</td>
	                        			
                                        <td class="dimension">
	                        				[&#197;]
	                      				 </td>
	               						<td>
	               							&nbsp;
	               						</td> 
	                      				 <td>

	                      				 </td>
									</tr>
			
									<tr>
										<td class="name">{#$l10n.Energy#}:</td>
										<td>
				                        	<input  size="12" type="text" name="energyMinVal" value="{#$enmin#}"/>
											<input size="12" type="text" name="energyMaxVal" value="{#$enmax#}"/>
										</td>
	                        			
                                        <td class="dimension">
	                        				{#$l10n.cm#}<sup>-1</sup>
	                      				 </td>
	               						<td>
	               							&nbsp;
	               						</td> 
	                      				 <td>

	                      				 </td>
									</tr>
									<tr>
										<td class="name">{#$l10n.Auto_states#}:</td>
										<td>
											<input  type="checkbox" name="autoStates" {#if (!$autoStatesOff)#}checked{#/if#}/>
										</td>
										<td class="dimension">
										</td>
										<td>
											&nbsp;
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td class="name">{#$l10n.Max_n#}:</td>
										<td>
											<input size="1" type="text" name="nMaxVal" value="{#$nmax#}"/>
										</td>
										<td class="dimension">
										</td>
										<td>
											&nbsp;
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td class="name">{#$l10n.Max_l#}:</td>
										<td>
											<input size="1" type="text" name="lMaxVal" value="{#$lmax#}"/>
										</td>
										<td class="dimension">
										</td>
										<td>
											&nbsp;
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td class="name">{#$l10n.Group_by_multiplicity#}:</td>
										<td>
											<input  type="checkbox" name="groupbyMu" {#if ($groupbyMu)#}checked{#/if#}/>
										</td>
										<td class="dimension">
										</td>
										<td>
											&nbsp;
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td class="name">{#$l10n.Prohibited_by_multiplicity#}:</td>
										<td>
											<input  type="checkbox" name="prohibitedbyMuOff" {#if (!$prohibitedbyMuOff)#}checked{#/if#}/>
										</td>
										<td class="dimension">
										</td>
										<td>
											&nbsp;
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td class="name">{#$l10n.Prohibited_by_parity#}:</td>
										<td>
											<input  type="checkbox" name="prohibitedbyParOff" {#if (!$prohibitedbyParOff)#}checked{#/if#}/>
										</td>
										<td class="dimension">
										</td>
										<td>
											&nbsp;
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td class="name">{#$l10n.Grouping#}:</td>
										<td>
											<input  type="radio" name="grouping" value="term" {#if ($grouping == "term")#}checked{#/if#}/>{#$l10n.ByTerm#}<br>
											<input  type="radio" name="grouping" value="J" {#if ($grouping == "J")#}checked{#/if#}/>{#$l10n.ByJ#}<br>
											<input  type="radio" name="grouping" value="full" {#if ($grouping == "full")#}checked{#/if#}/>{#$l10n.Full#}<br>
											<input  type="radio" name="grouping" value="auto" {#if (!$grouping)#}checked{#/if#}/>{#$l10n.Auto#}<br>
										</td>
										<td class="dimension">
										</td>
										<td>
											&nbsp;
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td class="name">{#$l10n.Diagram_width#}:</td>
										<td>
											<input  size="5" type="text" name="widthVal"  value="{#$width#}"/>
										</td>

										<td class="dimension">
                                            px
										</td>
										<td>
											&nbsp;
										</td>
										<td>

										</td>
									</tr>

									<tr>
										<td  class="name"></td>
										<td>&nbsp;</td>
									</tr>		
			
            						<tr>
										<td  class="name"></td>
										<td>								
											<input class="button white" id="filterBtn" value="{#$l10n.Apply#}" type="button"/>
											<input class="button white" id="showAllBtn" value="{#$l10n.Show_All#}" type="button"/>
										</td>
									</tr>
                  
								</tbody>
							</table>
							</form> 
	 					</div>	               
					</div>	        		
                    <div class="clear">  </div>          
				</div>
<!--END of Panel-->
	        
				<div class="slide">
					<a href="#" class="btn-slide"></a>
			    </div>

<!--End of Slide-->

			<div id="svg" style="width: 100%; height: 600px; overflow-x:auto">{#$svg#}</div>

			<div class="container_12">
				 	<div class="grid_12" id="main">
							<br/>
							<a class="nav" target="_blank" href="{#$new_window_url#}">[{#$l10n.Open_in_new_window#}]</a>
                    </div>
		    </div>

{#else#}
	<div class="container_12">
		<div class="brake"></div>
		<div>
		{#$l10n.No_transitions#}
			</div>
	</div>

{#/if#}