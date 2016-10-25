<?php /* Smarty version 2.6.12, created on 2016-07-27 13:18:49
         compiled from view/view_new_diagramm.tpl */ ?>
<?php if ($this->_tpl_vars['layout_element_id']): ?>
	<script type="text/javascript">										
		var id=<?php echo $this->_tpl_vars['layout_element_id']; ?>
;
	</script>  						
	<script type="text/javascript" src="/js/filter_new_diagrams.js"></script>
<?php endif; ?>
							
	</head>

	<body class="<?php echo $this->_tpl_vars['bodyclass']; ?>
">
				<div id="panel">
    				<div class="container_12">        
						<div class="grid_8">
            				<h4><?php echo $this->_tpl_vars['l10n']['Data_filter']; ?>
</h4>
            				
            				<form name=inputform>
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
										<td class="name"><?php echo $this->_tpl_vars['l10n']['Energy']; ?>
:</td>
										<td>
				                        	<input  size=12 type=text name=energyMinVal>
											<input size=12 type=text name=energyMaxVal>											
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
									
									<!--tr>
										<td class="name">Width, Height:</td>
										<td>
				                        	<input size=12 type=text name=diagramWidth>											
											<input size=12 type=text name=diagramHeight>
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
									</tr-->	

									<tr>
										<td  class="name"></td>
										<td>&nbsp;</td>
									</tr>		
			
            						<tr>
										<td  class="name"></td>
										<td>								
											<input class="button white" id="filterBtn" value="<?php echo $this->_tpl_vars['l10n']['Apply']; ?>
" type=button>
											<input class="button white" id="showAllBtn" value="<?php echo $this->_tpl_vars['l10n']['Show_All']; ?>
" type=button>
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


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottom_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>