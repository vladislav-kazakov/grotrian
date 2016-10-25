<?php /* Smarty version 2.6.12, created on 2016-07-27 12:32:39
         compiled from edit/view_levels.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'explode', 'edit/view_levels.tpl', 100, false),)), $this); ?>
			<div id="electronNumber" style="display:none;">
				<?php echo $this->_tpl_vars['atom']['Z']-$this->_tpl_vars['atom']['IONIZATION']; ?>

			</div>
			<div id="tab">
				<div id="panel" > 					
		    		<div class="container_12">        
						<div class="grid_7">
            				<h4><?php echo $this->_tpl_vars['l10n']['Table_lookup']; ?>
:</h4> 
	               			<table class="search_form">
								<tbody>
				                	<tr>
				                    	  <td></td>
                                          <td align="center"><div class="froam"><?php echo $this->_tpl_vars['l10n']['from']; ?>
</div><div class="froam" ><?php echo $this->_tpl_vars['l10n']['to']; ?>
</div></td> 
					                </tr>
									<tr>
										<td class="name"><?php echo $this->_tpl_vars['l10n']['Energy']; ?>
:</td>
										<td>
				                        	<input size="12" id="min_3" name="min_3"  type="text"/>
											<input size="12" id="max_3" name="max_3"  type="text"/>
										</td>
			                            
									</tr>											
									<tr>
										<td class="name"><?php echo $this->_tpl_vars['l10n']['Configuration']; ?>
:</td>
										<td>
											<select id="configurationSelect" name="configurationSelect" style="width: 210px">										
												<option>&nbsp;</option>
											</select>
										</td>
			
									</tr>
									<tr>
										<td class="name"><?php echo $this->_tpl_vars['l10n']['Therm']; ?>
:</td>
										<td>
											<select id="thermSelect" name="thermSelect" style="width: 210px">										
												<option>&nbsp;</option>
											</select>
										</td>
			
									</tr>
									<tr>
										<td class="name"> <?php echo $this->_tpl_vars['l10n']['Jvalue']; ?>
:</td>
										<td>
											<select id="jvalueSelect" name="jvalueSelect" style="width: 210px">										
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
				<div id="main" class="container_12" >  
				<div style="display:none; position='absolute';"  id="popupBaloon">!!!1!!!</div>
				<input type="hidden" id="type" name="type" value="L"/>					
				    <form id="inputLevelsform" action="">     
				    <input type="hidden" id="atom_id" name="atom_id" value="<?php echo $this->_tpl_vars['layout_element_id']; ?>
"/>                    
					<table cellpadding="0" cellspacing="0" border="0" class="display" id="table1">
						<thead>
							<tr>
								<th>&nbsp;</th>
								<!-- <th><?php echo $this->_tpl_vars['l10n']['ConfigurationType']; ?>
</th> -->	
								<th><?php echo $this->_tpl_vars['l10n']['Configuration']; ?>
</th>
								<th><?php echo $this->_tpl_vars['l10n']['Therm']; ?>
</th>
		                        <th>&nbsp;&nbsp;J&nbsp;&nbsp;</th>
								<th><?php echo $this->_tpl_vars['l10n']['Energy']; ?>
 (<?php echo $this->_tpl_vars['l10n']['cm']; ?>
 <sup>-1</sup>)</th>
								<th><?php echo $this->_tpl_vars['l10n']['Lifetime']; ?>
 <br/>(<?php echo $this->_tpl_vars['l10n']['ns']; ?>
)</th>   
								<th><?php echo $this->_tpl_vars['l10n']['Source']; ?>
</th>
							</tr>	
						</thead>
                    <?php $_from = $this->_tpl_vars['level_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['level']):
?>
					<tr class="selectable">						
						<td><input type="hidden" class="row_id" name="row_id[]" value="<?php echo $this->_tpl_vars['level']['ID']; ?>
" /><input type="checkbox" value=""/></td>
						<!--  <td><?php echo $this->_tpl_vars['level']['config_type']; ?>
</td>-->
					 	<td class="level_config"><?php if ($this->_tpl_vars['level']['CONFIG'] == NULL || $this->_tpl_vars['level']['CONFIG'] == ""):  else: ?> <?php echo $this->_tpl_vars['level']['CONFIG']; ?>
 <?php endif; ?> </td>
				        <td class="term">
						<?php if ($this->_tpl_vars['level']['TERMSECONDPART'] != 'NULL'): ?><span><?php echo $this->_tpl_vars['level']['TERMSECONDPART']; ?>
</span><?php else: ?><span></span><?php endif; ?>
				        <?php if ($this->_tpl_vars['level']['TERMPREFIX'] != ""): ?><sup><?php echo $this->_tpl_vars['level']['TERMPREFIX']; ?>
</sup><?php else: ?><sup></sup><?php endif; ?>
				        <?php if ($this->_tpl_vars['level']['TERMFIRSTPART'] == "" || $this->_tpl_vars['level']['TERMFIRSTPART'] == ' '): ?><span></span><?php else: ?><span><?php echo $this->_tpl_vars['level']['TERMFIRSTPART']; ?>
</span><?php endif; ?>
				        <?php if ($this->_tpl_vars['level']['TERMMULTIPLY'] == TRUE): ?><sup>0</sup><?php else: ?><sup></sup><?php endif; ?>
				        </td>
				        <td class="j"><?php echo $this->_tpl_vars['level']['J']; ?>
</td>
                        <td class="energy"><?php echo $this->_tpl_vars['level']['ENERGY']; ?>
</td>
                        <td class="lifetime"><?php echo $this->_tpl_vars['level']['LIFETIME']; ?>
</td>                        
                        
                           
						<td class="source">							
							<?php if ($this->_tpl_vars['level']['SOURCE_IDS'] != ''): ?>
							<span class="links">							
								<?php $this->assign('sources', ((is_array($_tmp=",")) ? $this->_run_mod_handler('explode', true, $_tmp, $this->_tpl_vars['level']['SOURCE_IDS']) : explode($_tmp, $this->_tpl_vars['level']['SOURCE_IDS']))); ?>
								<?php $_from = $this->_tpl_vars['sources']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['source']):
?>
									<a class="source_link" href="../bibliography/<?php echo $this->_tpl_vars['source']; ?>
" ><?php echo $this->_tpl_vars['source']; ?>
</a>
								<?php endforeach; endif; unset($_from); ?>	
							</span>	
								<?php else: ?>
							<span class="links">&nbsp;</span>																	
						<?php endif; ?>                        
							
                       	</td>
                    </tr>
                    <?php endforeach; endif; unset($_from); ?>
                        	
		    		</table>
		    		</form>	    		
				</div>
			    <div class="clear"></div>
			</div>
<!--End of Main -->
			<div class="clear"></div>
			<div id="empty"></div> 
		</div>
<!--End of wrapper--> 