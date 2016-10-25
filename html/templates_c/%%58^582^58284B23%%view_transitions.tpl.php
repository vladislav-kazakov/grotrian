<?php /* Smarty version 2.6.12, created on 2016-07-27 11:25:45
         compiled from view/view_transitions.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'explode', 'view/view_transitions.tpl', 191, false),)), $this); ?>
			<div id="tab" >
				<div id="panel">
    				<div class="container_12">        
						<div class="grid_7">
            				<h4><?php echo $this->_tpl_vars['l10n']['Table_lookup']; ?>
:</h4> 
	                		<table class="search_form">
								<tbody>
	                				
                                    <tr>
	                    	 			<td></td>
                                        <td align="center"><div class="froam">от</div><div class="froam" >до</div></td> 
                                        <td></td>
		                			</tr>
									
                                    <tr>
										<td class="name"><?php echo $this->_tpl_vars['l10n']['Wavelength']; ?>
:</td>
										<td>
				                        	<input size="12" id="min_2" name="min_2"  type="text"/>
											<input size="12" id="max_2" name="max_2"  type="text"/>
										</td>
	                        			
                                        <td class="dimension">
	                        				[&#197;]
	                      				 </td>
									</tr>
			
            						<tr>
										<td  class="name"><?php echo $this->_tpl_vars['l10n']['Intensity']; ?>
:</td>
										<td>
				                            <input size="12" id="min_3" name="min_3"  type="text"/>
											<input size="12" id="max_3" name="max_3"  type="text"/>
										</td>
										<td class="dimension"></td>
									</tr>
									
                                    <tr>
										<td class="name"><i>f<sub>ik</sub></i>:</td>
										<td>
	                            			<input size="12" id="min_4" name="min_4"  type="text"/>
											<input size="12" id="max_4" name="max_4"  type="text"/> 
										</td>
										<td class="dimension"></td>
									</tr>
									
                                    <tr>
										<td class="name">A<sub><i>ki</i></sub>:</td>
										<td>
	                           				<input size="12" id="min_5" name="min_5"  type="text"/>
											<input size="12" id="max_5" name="max_5"  type="text"/></td>
										<td class="dimension">
	                        				[<i>10<sup>8</sup><?php echo $this->_tpl_vars['l10n']['sec']; ?>
<sup>-1</sup></i>]
										</td>
										
									</tr>
                                    
									<tr>
										<td class="name"><?php echo $this->_tpl_vars['l10n']['The_absorption_cross_section']; ?>
:</td>
										<td>
	                            			<input size="12" id="min_6" name="min_6"  type="text"/>
											<input size="12" id="max_6" name="max_6"  type="text"/> 
										</td>
										<td class="dimension"></td>
									</tr>                    
									<tr>
										<td class="name"> <?php echo $this->_tpl_vars['l10n']['Serie']; ?>
:</td>
										<td>
											<select id="serieSelect" name="serieSelect" style="width: 210px">										
												<option>&nbsp;</option>
											</select>
										</td>			
									</tr>
									<tr>
										<td class="name"> <?php echo $this->_tpl_vars['l10n']['Lower']; ?>
 <?php echo $this->_tpl_vars['l10n']['Level']; ?>
:</td>
										<td>
											<select id="lowerLevelSelect" name="lowerLevelSelect" style="width: 210px">										
												<option>&nbsp;</option>
											</select>
										</td>			
									</tr>
									<tr>
										<td class="name"> <?php echo $this->_tpl_vars['l10n']['Upper']; ?>
 <?php echo $this->_tpl_vars['l10n']['Level']; ?>
:</td>
										<td>
											<select id="upperLevelSelect" name="upperLevelSelect" style="width: 210px">										
												<option>&nbsp;</option>
											</select>
										</td>			
									</tr>
								</tbody>
							</table> 
	 					</div>	               
					</div>	        		
                    <div class="clear">  </div>          
				</div>
<!--END of Panel-->	        
				<div class="slide">
					<a href="#" class="btn-slide"></a>
			    </div>
<!--End of Slide-->			
			</div> 	
			<div id="main" class="container_12" >
                               
					<table cellpadding="0" cellspacing="0" border="0"  class="display view" id="transitions_table">
						<thead>
							<tr>	
								<th><?php echo $this->_tpl_vars['l10n']['Serie']; ?>
</th>
								<th><?php echo $this->_tpl_vars['l10n']['Lower']; ?>
 <?php echo $this->_tpl_vars['l10n']['Level']; ?>
</th>
								<th><?php echo $this->_tpl_vars['l10n']['Upper']; ?>
 <?php echo $this->_tpl_vars['l10n']['Level']; ?>
</th>
								<th><?php echo $this->_tpl_vars['l10n']['Wavelength']; ?>
[<i>&#197;</i>]</th>
								<th><?php echo $this->_tpl_vars['l10n']['Intensity']; ?>
</th>
								<th><i>f<sub>ik</sub></i></th>
					            <th>A<sub><i>ki</i></sub><br/>[<i>10<sup>8</sup>сек<sup>-1</sup></i>]</th>
					            <th><?php echo $this->_tpl_vars['l10n']['The_absorption_cross_section']; ?>
 <br/> Q<sub>max</sub>* 10<sup>18</sup>, <i><?php echo $this->_tpl_vars['l10n']['cm']; ?>
<sup>2</sup></i></th>
								<th><?php echo $this->_tpl_vars['l10n']['Source']; ?>
</th>                          
							</tr>
						</thead>	
                        
                        <?php $_from = $this->_tpl_vars['transition_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['transition']):
?>
                             <tr>
                             <td>
                            <?php if ($this->_tpl_vars['transition']['lower_level_config'] == "" || $this->_tpl_vars['transition']['lower_level_config'] == ' '): ?>
                            (?)
                            <?php else: ?> 
                            <?php echo $this->_tpl_vars['transition']['lower_level_config']; ?>
 :
                            
                            <?php if ($this->_tpl_vars['transition']['lower_level_termsecondpart'] != 'NULL'):  echo $this->_tpl_vars['transition']['lower_level_termsecondpart'];  endif; ?>
                            
                            <?php if ($this->_tpl_vars['transition']['lower_level_termprefix'] != ""): ?><sup><?php echo $this->_tpl_vars['transition']['lower_level_termprefix']; ?>
</sup><?php endif; ?>                            
                            				 		
					 		<?php if ($this->_tpl_vars['transition']['lower_level_termfirstpart'] == "" || $this->_tpl_vars['transition']['lower_level_termfirstpart'] == ' '): ?> (?) <?php else: ?><span><?php echo $this->_tpl_vars['transition']['lower_level_termfirstpart']; ?>
</span><?php endif; ?>	
					 					 			
							<?php if ($this->_tpl_vars['transition']['lower_level_termmultiply'] == 1): ?><span>&deg;</span><?php endif; ?>
							
					 		<?php if ($this->_tpl_vars['transition']['lower_level_j'] != ""): ?><sub><?php echo $this->_tpl_vars['transition']['lower_level_j']; ?>
</sub><?php endif; ?>  
					 		
					 		<?php if ($this->_tpl_vars['transition']['upper_level_config_type']): ?> - <?php echo $this->_tpl_vars['transition']['upper_level_config_type']; ?>
:
					 		
					 		<?php if ($this->_tpl_vars['transition']['upper_level_termsecondpart'] != 'NULL'):  echo $this->_tpl_vars['transition']['upper_level_termsecondpart'];  endif;  endif; ?>
					 		
					 		<?php if ($this->_tpl_vars['transition']['upper_level_termprefix'] != ""): ?><sup><?php echo $this->_tpl_vars['transition']['upper_level_termprefix']; ?>
</sup><?php endif; ?>
                            
                            <?php if ($this->_tpl_vars['transition']['upper_level_termfirstpart'] == "" || $this->_tpl_vars['transition']['upper_level_termfirstpart'] == ' '): ?> (?) <?php else: ?><span><?php echo $this->_tpl_vars['transition']['upper_level_termfirstpart']; ?>
</span><?php endif; ?>	
                            
                            <?php if ($this->_tpl_vars['transition']['upper_level_termmultiply'] == 1): ?><span>&deg;</span><?php endif; ?>
                            <?php if ($this->_tpl_vars['transition']['upper_level_j'] != ""): ?><sub><?php echo $this->_tpl_vars['transition']['upper_level_j']; ?>
</sub><?php endif; ?>                              
                             
                             <?php endif; ?>
                             </td>
                             
                             
					 			<td>
					 			<?php if ($this->_tpl_vars['transition']['lower_level_config'] == "" || $this->_tpl_vars['transition']['lower_level_config'] == ' '): ?> <?php echo $this->_tpl_vars['transition']['lower_level_energy']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['transition']['lower_level_config']; ?>
 <?php endif; ?>:
					 			
					 			<?php if ($this->_tpl_vars['transition']['lower_level_termsecondpart'] != 'NULL'):  echo $this->_tpl_vars['transition']['lower_level_termsecondpart'];  endif; ?>
					 			
					 			<?php if ($this->_tpl_vars['transition']['lower_level_termprefix'] != ""): ?><sup><?php echo $this->_tpl_vars['transition']['lower_level_termprefix']; ?>
</sup><?php endif; ?>
					 			
					 			<?php if ($this->_tpl_vars['transition']['lower_level_termfirstpart'] == "" || $this->_tpl_vars['transition']['lower_level_termfirstpart'] == ' '): ?> (?) <?php else: ?><span><?php echo $this->_tpl_vars['transition']['lower_level_termfirstpart']; ?>
</span><?php endif; ?>
					 			
					 			<?php if ($this->_tpl_vars['transition']['lower_level_termmultiply'] == 1): ?><span>&deg;</span><?php endif; ?>
					 			
					 			<?php if ($this->_tpl_vars['transition']['lower_level_j'] != ""): ?><sub><?php echo $this->_tpl_vars['transition']['lower_level_j']; ?>
</sub><?php endif; ?>
					 			</td>
					 								 			
                                <td>
                                <?php if ($this->_tpl_vars['transition']['upper_level_config'] == "" || $this->_tpl_vars['transition']['upper_level_config'] == ' '): ?> <?php echo $this->_tpl_vars['transition']['upper_level_energy']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['transition']['upper_level_config']; ?>
 <?php endif; ?>:
                                
                                <?php if ($this->_tpl_vars['transition']['upper_level_termsecondpart'] != 'NULL'):  echo $this->_tpl_vars['transition']['upper_level_termsecondpart'];  endif; ?>
                                
                                <?php if ($this->_tpl_vars['transition']['upper_level_termprefix'] != ""): ?><sup><?php echo $this->_tpl_vars['transition']['upper_level_termprefix']; ?>
</sup><?php endif; ?>
                                
                                <?php if ($this->_tpl_vars['transition']['upper_level_termfirstpart'] == "" || $this->_tpl_vars['transition']['upper_level_termfirstpart'] == ' '): ?> (?) <?php else: ?><span><?php echo $this->_tpl_vars['transition']['upper_level_termfirstpart']; ?>
</span><?php endif; ?>
                                
                                <?php if ($this->_tpl_vars['transition']['upper_level_termmultiply'] == 1): ?><span>&deg;</span><?php endif; ?>
                                
                                <?php if ($this->_tpl_vars['transition']['upper_level_j'] != ""): ?><sub><?php echo $this->_tpl_vars['transition']['upper_level_j']; ?>
</sub><?php endif; ?>
                                
                                </td>
   							 	<td><?php echo $this->_tpl_vars['transition']['WAVELENGTH']; ?>
</td>
						        <td><?php echo $this->_tpl_vars['transition']['INTENSITY']; ?>
</td>
						        <td><?php echo $this->_tpl_vars['transition']['OSCILLATOR_F']; ?>
</td>
				        		<td>
				        			<?php if ($this->_tpl_vars['transition']['PROBABILITY'] != ""): ?>
				        				<?php echo $this->_tpl_vars['transition']['PROBABILITY']/100000000; ?>

				        			<?php endif; ?>	
				        		</td>
        		                <td><?php echo $this->_tpl_vars['transition']['CROSSECTION']; ?>
</td>
								
								<td class="source">	
                        		<?php if ($this->_tpl_vars['transition']['SOURCE_IDS'] != ''): ?>
									<span class="links">						
									<?php $this->assign('sources', ((is_array($_tmp=",")) ? $this->_run_mod_handler('explode', true, $_tmp, $this->_tpl_vars['transition']['SOURCE_IDS']) : explode($_tmp, $this->_tpl_vars['transition']['SOURCE_IDS']))); ?>
									<?php $_from = $this->_tpl_vars['sources']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['source']):
?>
										<?php if ($this->_tpl_vars['source'] != ''): ?>
											<a class="source_link" href="../bibliography/<?php echo $this->_tpl_vars['source']; ?>
" ><?php echo $this->_tpl_vars['source']; ?>
</a>
										<?php endif; ?>
									<?php endforeach; endif; unset($_from); ?>						                        
									</span>
								<?php endif; ?>
                       			</td>
                		    </tr>
		                    
                <?php endforeach; endif; unset($_from); ?>      
                        
                        
		    		</table>
			    <div class="clear"></div>
			</div>
<!--End of Main -->
			<div class="clear"></div>
			<div id="empty"></div> 
		</div>
<!--End of wrapper--> 