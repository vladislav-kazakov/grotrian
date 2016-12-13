	
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
											<select id="termSelect" name="termSelect">
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
                        
                    {# foreach item=level from=$level_list#}
					<tr>
						<input type="hidden" class="row_id" name="row_id[]" value="{#$level.ID#}" />
						<!-- <td><input type="checkbox" name="selected_tbl[]" value="aliases" /></td>  -->
						<td>{# $level.config_type#}</td>
					 	<td>{# $level.CONFIG#}</td>
				        <td>
				        {#if $level.TERMSECONDPART!="NULL" #}<span>{#$level.TERMSECONDPART#}</span>{#/if#}
						{#if $level.TERMPREFIX!="" #}<sup>{#$level.TERMPREFIX#}</sup>{#/if#}
				        {#if $level.TERMFIRSTPART=="" || $level.TERMFIRSTPART==" " #}?{#else#}<span>{#$level.TERMFIRSTPART#}</span>{#/if#}
				        {#if $level.TERMMULTIPLY == TRUE#}<sup>0</sup>{#/if#}				        
				        </td>
                        <td>{#$level.J#}</td>
						<td>{#$level.TERMMULTIPLY#}</td>
                        <td>{#$level.ENERGY#}</td>
                        <td>{#$level.LIFETIME#}</td>
                        <td><a href="" class="source_id"><input type="hidden" name="source_id" value="{#$level.SOURCE_ID#}">{#$level.SOURCE_ABBR#}</a></td>
                    </tr>
                    {#/foreach#}
                        	
		    		</table>
				</div>
			</div>
<!--End of Main -->