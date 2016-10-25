<?php /* Smarty version 2.6.12, created on 2016-07-27 12:58:29
         compiled from edit/add_levels.tpl */ ?>
	
			<div id="tab">
				<div id="panel" > 					
		    		<div>        
						<div class="grid_7">
            				<h4>Поиск по таблице:</h4> 							
	               			<table class="search_form">
								<tbody>
				                	<tr>
				                    	  <td></td>
                                          <td align="center"><div class="froam">От</div><div class="froam" >до</div></td> 
					                </tr>
									<tr>
										<td class="name">Энергия:</td>
										<td>
				                        	<input size="12" id="min_3" name="min_3"  type="text"/>
											<input size="12" id="max_3" name="max_3"  type="text"/>
										</td>
			                            
									</tr>			
            						
									<tr>
										<td class="name">Тип конфигурации:</td>
										<td>
											<select id="configurationType" name="configurationType">										
												<option></option>
											</select>
										</td>
			
									</tr>
									<tr>
										<td class="name">Конфигурация:</td>
										<td>
											<select id="configurationSelect" name="configurationSelect" >										
												<option></option>
											</select>
										</td>
			
									</tr>
									<tr>
										<td class="name">Терм:</td>
										<td>
											<select id="thermSelect" name="thermSelect">										
												<option></option>
											</select>
										</td>
			
									</tr>
									<tr>
										<td class="name">Значение J:</td>
										<td>
											<select id="jvalueSelect" name="jvalueSelect">										
												<option></option>
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
				<div id="main">  
				                                
					<table cellpadding="0" cellspacing="0" border="0" class="display view" id="levels_table">
						<thead>
							<tr>								
								<th class="sorting_asc" style="width: 173px; ">Тип конфигурации</th>	
								<th class="sorting" style="width: 164px; ">Конфигурация</th>
								<th class="sorting" style="width: 53px; ">Терм</th>
		                        <th class="sorting" style="width: 36px; ">J  </th>
								<th class="sorting" style="width: 0px; ">Чётность</th>
								<th class="sorting" style="width: 135px; ">Энергия (см <sup>-1</sup>)</th>
								<th class="sorting" style="width: 131px; ">Время жизни <br>(нс)</th>   
								<th class="sorting" style="width: 92px; ">Источник</th>								
							</tr>	
						</thead>	
                        
                    <?php $_from = $this->_tpl_vars['level_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['level']):
?>
					<tr>
						<input type="hidden" class="row_id" name="row_id[]" value="<?php echo $this->_tpl_vars['level']['ID']; ?>
" />
						<!-- <td><input type="checkbox" name="selected_tbl[]" value="aliases" /></td>  -->
						<td><?php echo $this->_tpl_vars['level']['config_type']; ?>
</td>
					 	<td><?php echo $this->_tpl_vars['level']['CONFIG']; ?>
</td>
				        <td>
				        <?php if ($this->_tpl_vars['level']['TERMSECONDPART'] != 'NULL'): ?><span><?php echo $this->_tpl_vars['level']['TERMSECONDPART']; ?>
</span><?php endif; ?>
						<?php if ($this->_tpl_vars['level']['TERMPREFIX'] != ""): ?><sup><?php echo $this->_tpl_vars['level']['TERMPREFIX']; ?>
</sup><?php endif; ?>
				        <?php if ($this->_tpl_vars['level']['TERMFIRSTPART'] == "" || $this->_tpl_vars['level']['TERMFIRSTPART'] == ' '): ?>?<?php else: ?><span><?php echo $this->_tpl_vars['level']['TERMFIRSTPART']; ?>
</span><?php endif; ?>
				        <?php if ($this->_tpl_vars['level']['TERMMULTIPLY'] == TRUE): ?><sup>0</sup><?php endif; ?>				        
				        </td>
                        <td><?php echo $this->_tpl_vars['level']['J']; ?>
</td>
						<td><?php echo $this->_tpl_vars['level']['TERMMULTIPLY']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['level']['ENERGY']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['level']['LIFETIME']; ?>
</td>
                        <td><a href="" class="source_id"><input type="hidden" name="source_id" value="<?php echo $this->_tpl_vars['level']['SOURCE_ID']; ?>
"><?php echo $this->_tpl_vars['level']['SOURCE_ABBR']; ?>
</a></td>
                    </tr>
                    <?php endforeach; endif; unset($_from); ?>
                        	
		    		</table>
				</div>
			    <div class="clear"></div>
			</div>
<!--End of Main -->
		</div>
<!--End of wrapper--> 