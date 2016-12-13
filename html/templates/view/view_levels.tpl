			<div id="tab">
				<div id="panel" > 					
		    		<div class="container_12">        
						<div class="grid_7">
            				<h4>{#$l10n.Table_lookup#}:</h4> 
	               			<table class="search_form">
								<tbody>
				                	<tr>
				                    	  <td></td>
                                          <td align="center"><div class="froam">{#$l10n.from#}</div><div class="froam" >{#$l10n.to#}</div></td> 
					                </tr>
									<tr>
										<td class="name">{#$l10n.Energy#}:</td>
										<td>
				                        	<input size="12" id="min_3" name="min_3"  type="text"/>
											<input size="12" id="max_3" name="max_3"  type="text"/>
										</td>
			                            
									</tr>			
            						
									<tr>
										<td class="name">{#$l10n.ConfigurationType#}:</td>
										<td>
											<select id="configurationType" name="configurationType" style="width: 210px">
												<option>&nbsp;</option>
											</select>
										</td>
			
									</tr>
									<tr>
										<td class="name">{#$l10n.Configuration#}:</td>
										<td>
											<select id="configurationSelect" name="configurationSelect" style="width: 210px">										
												<option>&nbsp;</option>
											</select>
										</td>
			
									</tr>
									<tr>
										<td class="name">{#$l10n.Term#}:</td>
										<td>
											<select id="termSelect" name="termSelect" style="width: 210px">
												<option>&nbsp;</option>
											</select>
										</td>
			
									</tr>
									<tr>
										<td class="name"> {#$l10n.Jvalue#}:</td>
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
			</div>	
<!--End of Tab-->				
				<div id="main" class="container_12" >
                                
					<table cellpadding="0" cellspacing="0" border="0" class="display view" id="levels_table">
						<thead>
							<tr>
								
								<th>{#$l10n.ConfigurationType#}</th>	
								<th>{#$l10n.Configuration#}</th>
								<th>{#$l10n.Term#}</th>
		                        <th>J  </th>
								<th>{#$l10n.Energy#} ({#$l10n.cm#} <sup>-1</sup>)</th>
								<th>{#$l10n.Lifetime#} <br/>({#$l10n.ns#})</th>   
								<th>{#$l10n.Source#}</th>
							</tr>	
						</thead>	
                        
                    {# foreach item=level from=$level_list#}
					<tr class="selectable">
						<!-- <td><input type="checkbox" name="selected_tbl[]" value="aliases" /></td>  -->
						<td>{#if $level.config_type#} {# $level.config_type#} {#else#} (?) {#/if#}</td>
					 	<td>{#if  $level.CONFIG ==NULL || $level.CONFIG ==""#} (?) {#else#} {# $level.CONFIG#} {#/if#} </td>
				        <td>
				        {#if $level.TERMSECONDPART!="NULL" #}<span>{#$level.TERMSECONDPART#}</span>{#/if#}
						{#if $level.TERMPREFIX!="" #}<sup>{#$level.TERMPREFIX#}</sup>{#/if#}
				        {#if $level.TERMFIRSTPART=="" || $level.TERMFIRSTPART==" " #}(?){#else#}<span>{#$level.TERMFIRSTPART#}</span>{#/if#}
				        {#if $level.TERMMULTIPLY == TRUE#}<span>&deg;</span>{#/if#}
				        
				        </td>
                        <td>{#$level.J#}</td>
                        <td>{#$level.ENERGY#}</td>
                        <td>{#$level.LIFETIME#}</td>
                        <td class="source">	
                        {# if $level.SOURCE_IDS !='' #}
							<span class="links">						
							{# assign var=sources value=","|explode:$level.SOURCE_IDS#}
							{#foreach from=$sources item=source#}
								{# if $source !='' #}
									<a class="source_link" href="../bibliography/{#$source#}" >{#$source#}</a>
								{#/if#}
							{#/foreach#}						                        
							</span>
						{#/if#}
                       	</td>
                    </tr>
                    {#/foreach#}
                        	
		    		</table>				
			</div>
