<?php /* Smarty version 2.6.12, created on 2016-07-27 13:12:58
         compiled from edit/view_diagramm.tpl */ ?>
  		<?php if ($this->_tpl_vars['layout_element_id']): ?>
			<script type="text/javascript" charset="utf-8">										
				var id=<?php echo $this->_tpl_vars['layout_element_id']; ?>
;
			</script>  						
  			
  			<script type="text/javascript" src="/js/filter_diagramm.js"></script>
     	
		<?php endif; ?>

				<div id="panel">
    				<div class="container_12">        
						<div class="grid_8">
            				<h4><?php echo $this->_tpl_vars['l10n']['Data_filter']; ?>
</h4>
            				
            				<form name="inputform" action="">
	                		<table class="search_form">
								<tbody>
	                				
                                    <tr>
	                    	 			<td></td>
                                        <td align="center"><div class="froam"><?php echo $this->_tpl_vars['l10n']['from']; ?>
</div><div class="froam" ><?php echo $this->_tpl_vars['l10n']['to']; ?>
</div></td>
                                        <td></td>
                                        <td></td> 
		                			</tr>
									
                                    <tr>
										<td class="name"><?php echo $this->_tpl_vars['l10n']['Wavelengt']; ?>
:</td>
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
										<td class="name"><?php echo $this->_tpl_vars['l10n']['Energy']; ?>
:</td>
										<td>
				                        	<input  size="12" type="text" name="energyMinVal"/>
											<input size="12" type="text" name="energyMaxVal"/>											
										</td>
	                        			
                                        <td class="dimension">
	                        				<?php echo $this->_tpl_vars['l10n']['cm']; ?>
<sup>-1</sup>
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
											<input class="button white" id="filterBtn" value="<?php echo $this->_tpl_vars['l10n']['Apply']; ?>
" type="button"/>
											<input class="button white" id="showAllBtn" value="<?php echo $this->_tpl_vars['l10n']['Show_All']; ?>
" type="button"/>
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
        
        
			<div class="container_12">
				 	<div class="grid_12" id="main">
							<br/>
							<div id="svg"></div>
							<a class="nav" target="_blank" href="/<?php echo $this->_tpl_vars['locale']; ?>
/newdiagramm/<?php echo $this->_tpl_vars['layout_element_id']; ?>
">[<?php echo $this->_tpl_vars['l10n']['Open_in_new_window']; ?>
]</a><br/><b><?php echo $this->_tpl_vars['l10n']['To_view_a_chart_you_need']; ?>
 <a href="http://www.adobe.com/svg/viewer/install/main.html" target="_blank">Adobe SVG Viewer</a></b> 

                    </div> 
		    </div>
<!--End of Main -->
	
			<div class="clear"></div>
			<div id="empty"></div> 
		</div>
<!--End of wrapper--> 