<!-- 	   <div id="panel">
    				<div class="container_12">        
						<div class="grid_8">
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
										<td class="name">{#$l10n.Wavelengt#}:</td>
										<td>
				                        	<input  size="12" type="text" name="waveMinVal"/>
											<input size="12" type="text" name="waveMaxVal"/>											
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
										<td class="name">Accuracy:</td>
										<td>
				                        	<select size="1" name="accuracy">
    											<option value="0">1</option>
											    <option value="1">0.1</option>
    											<option value="2">0.01</option>  
   											</select>										
										</td>
	                        			
                                        <td class="dimension">
	                        				&nbsp;
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
				 -->
<!--END of Panel-->
<!-- 	        
				<div class="slide">
					<a href="#" class="btn-slide"></a>
			    </div>
 -->
<!--End of Slide-->	 
        
	<div class="container_12">    
		<div class="grid_12" id="main">   
     	
			<p>&nbsp;</p>
        	    <h3>{#$element.NAME#}</h3>
				<h4>{#$l10n.Overview#}</h4>
				
				{#$element.DESCRIPTION#}
				
			
			{#if ($transition_count != 0)#}
			<p>&nbsp;</p>	
				<h4>{#$l10n.Emission_spectrum#}</h4>
					
				<div id="spectrum">
				
<br> 				

					<form action="" name="inputform">
    					{#$l10n.MinLength#} <input type="text" value="0" maxlength="8" size="8" id="minLength" style="color:#f6931f; font-weight:bold;" />
    					{#$l10n.MaxLength#} <input type="text" value="30000" maxlength="8" size="8" id="maxLength" style="color:#f6931f; font-weight:bold;" />
    					{#$l10n.Center#} <input type="text" value="4800" maxlength="8" size="8" id="centerValue" style="color:#f6931f; font-weight:bold;" />
    					{#$l10n.Scale#} <input type="text" value="1" maxlength="4" size="4" id="scaleValue" style="color:#f6931f; font-weight:bold;" />
					   <input type="button" value="Применить" id="Btn" class="button white">        
    				</form>

					{#$l10n.Wavelength#}: <span id="LengthValue" style="color:#f6931f; font-weight:bold;" >0</span> 
											
<!-- 				<span style="font-size:12px;">{#$l10n.Scale#}:</span>
			  
		
					
 					<span id="scaleValue" >&nbsp;</span> -->					
					<br/>	
					
					<div id="centerPoint"></div>
					<div id="spectrum_container">
						<div id="spectrum_holder"></div>
					</div>
					
					<div class="ruler">&#197;
						<span id="positionMinValue" ></span>
						<span id="centerRulerValue" ></span>
											
						<span id="positionMaxValue" ></span>
					</div> 
<br/>
        <div id="positionSlider"></div>
        <br/>
        <div id="secondaryPositionSlider"></div>
        <br/>
        <div id="scaleSlider"></div>
        <br/>
<!--    Min:<span id="positionMinValue"></span>
        Max:<span id="positionMaxValue"></span><br/>
 -->


						
				</div>			
<!-- 					
					<div id="spectrum_container">
					
					<div id="container">        	
        				<div id="holder"></div>        	
        			</div>
						
						<div id="scaleSliderContainer">	
							<div id="scaleSlider"></div>
						</div>
										
					</div>
					


					<div id="bottomslider">
											
					<div class="ruler">&#197;
						<span id="positionMinValue" ></span>
						<span id="positionMaxValue" ></span>
					</div> 
					
					
						<div id="positionSlider"></div>
					</div>  -->
		
			{#/if#}
			
			{#if ($level_count != 0)#}
				<p>&nbsp;</p>
					<h4>{#$l10n.Electronic_structure#}</h4>		
					{#$l10n.Found#} {#$level_count#} {#$l10n.levels#}. <a class="nav" href="/{#$locale#}/levels/{#$element.ID#}">[{#$l10n.view#}]</a>

			{#/if#}
			
			{#if ($transition_count != 0)#}
				<p>{#$l10n.Found#} {#$transition_count#} {#$l10n.transitions#}. <a class="nav" href="/{#$locale#}/transitions/{#$element.ID#}">[{#$l10n.view#}]</a></p>
			{#/if#}
			
			{#if ($element.LIMITS != "")#}
				<p>&nbsp;</p>		
					<h4>{#$l10n.Grotrian_Charts#}</h4>           
			 		<a class="nav" target="_blank" href="/{#$locale#}/newdiagramm/{#$layout_element_id#}">[{#$l10n.view#}]</a><br/><b>{#$l10n.To_view_a_chart#} <a href="http://www.adobe.com/svg/viewer/install/main.html" target="_blank">{#$l10n.To_view_a_chart_you_need#} Adobe SVG Viewer</a></b>			
			{#/if#}
			
			
			{#if ($book_count != 0)#}
				<p>            
           			<h4>{#$l10n.Bibliographic_references#}</h4>
                		<ul>
                		{#foreach from=$book_list item=book#}
                    		<li>{#$book.NAME#}"</li>
                		{#/foreach#}
                		</ul>
        		</p>
			{#/if#}    
        
		<br/><br/>       

		</div>
	    <div class="clear"></div>
    </div>
<!--End of Main -->
	
	<div class="clear"></div>
		<div id="empty"></div> 
	</div>
<!--End of wrapper--> 
