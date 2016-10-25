<?php /* Smarty version 2.6.12, created on 2016-07-27 12:29:23
         compiled from edit/view_element.tpl */ ?>
 	   <div id="panel" >
    				<div class="container_12">        
						<div class="grid_12">
            				
            				
            				<form id="inputElementform" action="">
	                		<table class="search_form">
								<tbody>
									
                                    <tr>
										<td class="name">Название элемента:</td>
										<td>
											<input type="hidden" id="element_id" name="element_id" value="<?php echo $this->_tpl_vars['atom']['ELEMENT_ID']; ?>
"/>
											<input type="hidden" id="atom_id" name="atom_id" value="<?php echo $this->_tpl_vars['layout_element_id']; ?>
"/>
											<input type="hidden" name="action" value="saveElement"/>
				                        	<input  size="12" type="text" name="Name_ru" value="<?php echo $this->_tpl_vars['atom']['NAME_RU']; ?>
"/>				                        																							
										</td>
										<td>&nbsp;&nbsp;</td>
										<td class="name">Правило склонения:</td>
										<td>
				                        	<input  size="12" type="text" name="Name_ru_alt" value="<?php echo $this->_tpl_vars['atom']['NAME_RU_ALT']; ?>
"/>																						
										</td>										
										<td colspan="4">&nbsp;</td>

									</tr>			

									 <tr>									
										<td class="name">Element name:</td>
										<td>
				                        	<input  size="12" type="text" name="Name_en" value="<?php echo $this->_tpl_vars['atom']['NAME_EN']; ?>
"/>																						
										</td>	                        			
										<td colspan="5">&nbsp;</td>
									</tr> 	
																		
									 <tr>									
										<td class="name">Аббревиатура:</td>
										<td>
				                        	<input  size="1" type="text" name="Abbr" value="<?php echo $this->_tpl_vars['atom']['ABBR']; ?>
"/>																						
										</td>	                        			
      									<td colspan="5">&nbsp;</td>
									</tr> 
									<tr>									
										<td class="name">Z:</td>
										<td>
				                        	<input id="z"  size="1" type="text" name="Z" value="<?php echo $this->_tpl_vars['atom']['Z']; ?>
"/>																						
										</td>	                        			
										<td colspan="5">&nbsp;</td>
									</tr> 
									<tr>									
										<td class="name">Атомная масса:</td>
										<td>
				                        	<input  size="1" type="text" name="atom_Mass" value="<?php echo $this->_tpl_vars['atom']['ATOM_MASS']; ?>
"/>																						
										</td>	                        			
										<td colspan="5">&nbsp;</td>
									</tr> 
									<tr><td colspan="11">&nbsp;</td></tr>
									<tr>									
										<td class="name">Период элемента</td>
										<td>
				                        	<select size="1" name="tablePeriod">
				                        	<?php unset($this->_sections['period']);
$this->_sections['period']['name'] = 'period';
$this->_sections['period']['start'] = (int)1;
$this->_sections['period']['loop'] = is_array($_loop=9) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['period']['show'] = true;
$this->_sections['period']['max'] = $this->_sections['period']['loop'];
$this->_sections['period']['step'] = 1;
if ($this->_sections['period']['start'] < 0)
    $this->_sections['period']['start'] = max($this->_sections['period']['step'] > 0 ? 0 : -1, $this->_sections['period']['loop'] + $this->_sections['period']['start']);
else
    $this->_sections['period']['start'] = min($this->_sections['period']['start'], $this->_sections['period']['step'] > 0 ? $this->_sections['period']['loop'] : $this->_sections['period']['loop']-1);
if ($this->_sections['period']['show']) {
    $this->_sections['period']['total'] = min(ceil(($this->_sections['period']['step'] > 0 ? $this->_sections['period']['loop'] - $this->_sections['period']['start'] : $this->_sections['period']['start']+1)/abs($this->_sections['period']['step'])), $this->_sections['period']['max']);
    if ($this->_sections['period']['total'] == 0)
        $this->_sections['period']['show'] = false;
} else
    $this->_sections['period']['total'] = 0;
if ($this->_sections['period']['show']):

            for ($this->_sections['period']['index'] = $this->_sections['period']['start'], $this->_sections['period']['iteration'] = 1;
                 $this->_sections['period']['iteration'] <= $this->_sections['period']['total'];
                 $this->_sections['period']['index'] += $this->_sections['period']['step'], $this->_sections['period']['iteration']++):
$this->_sections['period']['rownum'] = $this->_sections['period']['iteration'];
$this->_sections['period']['index_prev'] = $this->_sections['period']['index'] - $this->_sections['period']['step'];
$this->_sections['period']['index_next'] = $this->_sections['period']['index'] + $this->_sections['period']['step'];
$this->_sections['period']['first']      = ($this->_sections['period']['iteration'] == 1);
$this->_sections['period']['last']       = ($this->_sections['period']['iteration'] == $this->_sections['period']['total']);
?>    											
    											
    											<?php if ($this->_tpl_vars['atom']['TABLEPERIOD'] == $this->_sections['period']['index']): ?>
    											<option selected value="<?php echo $this->_sections['period']['index']; ?>
"><?php echo $this->_sections['period']['index']; ?>
</option>
    											<?php else: ?>
    											<option value="<?php echo $this->_sections['period']['index']; ?>
"><?php echo $this->_sections['period']['index']; ?>
</option>
    											<?php endif; ?>
    											
											<?php endfor; endif; ?>
											</select>																																	
										</td>
										<td>&nbsp;&nbsp;</td>
											                        			
										<td class="name">Группа элемента</td>
										<td>
				                        	<select size="1" name="tableGroup">
				                        	<?php unset($this->_sections['group']);
$this->_sections['group']['name'] = 'group';
$this->_sections['group']['start'] = (int)1;
$this->_sections['group']['loop'] = is_array($_loop=19) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['group']['show'] = true;
$this->_sections['group']['max'] = $this->_sections['group']['loop'];
$this->_sections['group']['step'] = 1;
if ($this->_sections['group']['start'] < 0)
    $this->_sections['group']['start'] = max($this->_sections['group']['step'] > 0 ? 0 : -1, $this->_sections['group']['loop'] + $this->_sections['group']['start']);
else
    $this->_sections['group']['start'] = min($this->_sections['group']['start'], $this->_sections['group']['step'] > 0 ? $this->_sections['group']['loop'] : $this->_sections['group']['loop']-1);
if ($this->_sections['group']['show']) {
    $this->_sections['group']['total'] = min(ceil(($this->_sections['group']['step'] > 0 ? $this->_sections['group']['loop'] - $this->_sections['group']['start'] : $this->_sections['group']['start']+1)/abs($this->_sections['group']['step'])), $this->_sections['group']['max']);
    if ($this->_sections['group']['total'] == 0)
        $this->_sections['group']['show'] = false;
} else
    $this->_sections['group']['total'] = 0;
if ($this->_sections['group']['show']):

            for ($this->_sections['group']['index'] = $this->_sections['group']['start'], $this->_sections['group']['iteration'] = 1;
                 $this->_sections['group']['iteration'] <= $this->_sections['group']['total'];
                 $this->_sections['group']['index'] += $this->_sections['group']['step'], $this->_sections['group']['iteration']++):
$this->_sections['group']['rownum'] = $this->_sections['group']['iteration'];
$this->_sections['group']['index_prev'] = $this->_sections['group']['index'] - $this->_sections['group']['step'];
$this->_sections['group']['index_next'] = $this->_sections['group']['index'] + $this->_sections['group']['step'];
$this->_sections['group']['first']      = ($this->_sections['group']['iteration'] == 1);
$this->_sections['group']['last']       = ($this->_sections['group']['iteration'] == $this->_sections['group']['total']);
?>    											
    											
    											<?php if ($this->_tpl_vars['atom']['TABLEGROUP'] == $this->_sections['group']['index']): ?>
    											<option selected value="<?php echo $this->_sections['group']['index']; ?>
"><?php echo $this->_sections['group']['index']; ?>
</option>
    											<?php else: ?>
    											<option value="<?php echo $this->_sections['group']['index']; ?>
"><?php echo $this->_sections['group']['index']; ?>
</option>
    											<?php endif; ?>
    											
											<?php endfor; endif; ?>
											</select>																																	
										</td>
										<td class="name">Тип элемента</td>
										<td>
				                        	<select size="1" name="Type">
				                        	
				                        	
				                        	<?php $_from = $this->_tpl_vars['elemet_types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['type'] => $this->_tpl_vars['elemet_type']):
?>			
    											
    											<?php if ($this->_tpl_vars['atom']['ELEMENT_TYPE'] == $this->_tpl_vars['type']): ?>
    											<option selected value="<?php echo $this->_tpl_vars['type']; ?>
"><?php echo $this->_tpl_vars['elemet_type']['ru']; ?>
</option>
    											<?php else: ?>
    											
    											<option value="<?php echo $this->_tpl_vars['type']; ?>
"><?php echo $this->_tpl_vars['elemet_type']['ru']; ?>
</option>
    											<?php endif; ?>
    											
											<?php endforeach; endif; unset($_from); ?>
											</select>																																	
										</td>
									</tr> 
									
									<tr><td colspan="11">&nbsp;</td></tr>
									<tr>
										<td colspan="6">
				                        	<input class="button white" id="saveElement" value="Сохранить" type="button"/>
				                        	<!--  <input class="button white" id="deleteElement" value="Удалить" type="button"/>
				                        	<input class="button white" id="newElement" value="Добавить" type="button"/>-->																						
										</td>										
										<td >&nbsp;</td>

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
		<div class="grid_12 toolbar" id="main">   
     	
			<p>&nbsp;</p>
        	    <h3>Атом <?php echo $this->_tpl_vars['atom']['NAME_RU_ALT']; ?>
</h3>
        	    
        	    <form id="inputAtomform" action="">
        	    	<input type="hidden" name="action" value="saveAtom"/>        	    	
        	    	Степень ионизации: <input id="atomIonization" size="1" maxlength="3" type="text" name="atomIonization" value="<?php echo $this->_tpl_vars['atom']['IONIZATION']; ?>
"/>
        	    	Потенциал ионизации: <input maxlength="20" type="text" name="atomIonizationPotencial" value="<?php echo $this->_tpl_vars['atom']['IONIZATION_POTENCIAL']; ?>
"/>
        	    	
        	   		<input class="button white" id="saveAtom" value="Сохранить" type="button"/>
					<input class="button white" id="deleteAtom" value="Удалить" type="button"/>

        	     	<p>&nbsp;</p>
        	     		<h4>Описание на русском языке</h4>				
					
						<textarea class="jquery_ckeditor" rows="40" cols="115" name="atomDescription_ru"><?php echo $this->_tpl_vars['atom']['CONTAINMENT_RUS']; ?>
</textarea>
						<br/>
					<input class="button white" id="saveAtom" value="Сохранить" type="button"/>
					<p>&nbsp;</p>
					
						<h4>Описание на английском языке</h4>		
						<textarea  class="jquery_ckeditor" rows="40" cols="115" name="atomDescription_en"><?php echo $this->_tpl_vars['atom']['CONTAINMENT_ENG']; ?>
</textarea>
						<br/>
						<input class="button white" id="saveAtom" value="Сохранить" type="button"/>	
					<p>&nbsp;</p>
					</form>
				
				<form id="inputAtomDiagramForm" action="">
					<input type="hidden" id="element_id" name="element_id" value="<?php echo $this->_tpl_vars['atom']['ELEMENT_ID']; ?>
"/>
					<input type="hidden" id="atom_id" name="atom_id" value="<?php echo $this->_tpl_vars['layout_element_id']; ?>
"/>
					<input type="hidden" name="action" value="makeDiagramm"/> 
        	     	<h4>Пределы</h4>				
						<textarea rows="6" cols="115" id="atomLimits"><?php echo $this->_tpl_vars['atom']['LIMITS']; ?>
</textarea>
        	     	<p>&nbsp;</p>
        	     	<h4>Разрывы</h4>				
					<textarea rows="6" cols="115" id="atomBreaks"><?php echo $this->_tpl_vars['atom']['BREAKS']; ?>
</textarea>
					<p>&nbsp;</p>
					<input class="button white" id="makeDiagramm" value="Построить диаграмму" type="button"/>	
				</form>
								
				 
			
			
			<?php if (( $this->_tpl_vars['book_count'] != 0 )): ?>
				<p>            
           			<h4><?php echo $this->_tpl_vars['l10n']['Bibliographic_references']; ?>
</h4>
                		<ul>
                		<?php $_from = $this->_tpl_vars['book_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['book']):
?>
                    		<li><?php echo $this->_tpl_vars['book']['NAME']; ?>
"</li>
                		<?php endforeach; endif; unset($_from); ?>
                		</ul>
        		</p>
			<?php endif; ?>    
        
		<br/><br/>       

		</div>
	    <div class="clear"></div>
    </div>
<!--End of Main -->
	
	<div class="clear"></div>
		<div id="empty"></div> 
	</div>
<!--End of wrapper--> 