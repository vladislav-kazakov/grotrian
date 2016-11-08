{# if $layout_element_id #}
	<script type="text/javascript">										
		var id={#$layout_element_id#};
	</script>  						
	<script type="text/javascript" src="/js/filter_new_diagrams.js"></script>
{#/if#}
							
	</head>

	<body class="{#$bodyclass#}">
				<div id="panel">
    				<div class="container_12">        
						<div class="grid_8">
            				<h4>{#$l10n.Data_filter#}</h4>
            				
            				<form name=inputform>
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
				                        	<input  size=12 type=text name=waveMinVal>
											<input size=12 type=text name=waveMaxVal>											
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
				                        	<input  size=12 type=text name=energyMinVal>
											<input size=12 type=text name=energyMaxVal>											
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
										<td  class="name"></td>
										<td>&nbsp;</td>
									</tr>		
			
            						<tr>
										<td  class="name"></td>
										<td>								
											<input class="button white" id="filterBtn" value="{#$l10n.Apply#}" type=button>
											<input class="button white" id="showAllBtn" value="{#$l10n.Show_All#}" type=button>
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

				 	
<p></p>
							<span id="svg"></span>							 


<!--End of Main -->
	
			<div class="clear"></div>
			<div id="empty"></div> 
		</div>
<!--End of wrapper--> 


{#include file="bottom_footer.tpl"#}
