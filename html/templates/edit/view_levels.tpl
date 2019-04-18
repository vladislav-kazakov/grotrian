<div id="electronNumber" style="display:none;">
				{#$atom.Z-$atom.IONIZATION#}
			</div>
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
				<div id="main" class="container_12" >  
				<div style="display:none; position='absolute';"  id="popupBaloon">!!!1!!!</div>
				<input type="hidden" id="type" name="type" value="L"/>					
				    <form id="inputLevelsform" action="">     
				    <input type="hidden" id="atom_id" name="atom_id" value="{#$layout_element_id#}"/>                    
					<table cellpadding="0" cellspacing="0" border="0" class="display" id="table1">
						<thead>
							<tr>
								<th>&nbsp;</th>
								<!-- <th>{#$l10n.ConfigurationType#}</th> -->	
								<th>{#$l10n.Configuration#}</th>
								<th style="width: 120px;">{#$l10n.Term#}</th>
		                        <th>&nbsp;&nbsp;J&nbsp;&nbsp;</th>
								<th>&nbsp;&nbsp;F&nbsp;&nbsp;</th>
								<th>{#$l10n.Energy#} ({#$l10n.cm#} <sup>-1</sup>)</th>
								<th>{#$l10n.Energy#} ({#$l10n.MHz#})</th>
								<th>{#$l10n.Lifetime#} <br/>({#$l10n.ns#})</th>
								<th style="width: 120px;">Источник строкой (deprecated)</th>
								<th>{#$l10n.Source#}</th>
							</tr>	
						</thead>
                    {# foreach item=level from=$level_list#}
					<tr class="selectable">						
						<td><input type="hidden" class="row_id" name="row_id[]" value="{#$level.ID#}" /><input type="checkbox" value=""/></td>
						<!--  <td>{# $level.config_type#}</td>-->
					 	<td class="level_config">{#if  $level.CONFIG ==NULL || $level.CONFIG ==""#}{#else#} {# $level.CONFIG#} {#/if#} </td>
				        <td class="term">
						{#if $level.TERMSECONDPART!="NULL" #}<span>{#$level.TERMSECONDPART#}</span>{#else#}<span></span>{#/if#}
				        {#if $level.TERMPREFIX!="" #}<sup>{#$level.TERMPREFIX#}</sup>{#else#}<sup></sup>{#/if#}
				        {#if $level.TERMFIRSTPART=="" || $level.TERMFIRSTPART==" " #}<span></span>{#else#}<span>{#$level.TERMFIRSTPART#}</span>{#/if#}
				        {#if $level.TERMMULTIPLY==TRUE#}<sup>0</sup>{#else#}<sup></sup>{#/if#}
				        </td>
				        <td class="j">{#$level.J#}</td>
						<td class="f">{#$level.F#}</td>
                        <td class="energy">{#$level.ENERGY#}</td>
						<td class="energy_mhz">{#$level.ENERGY_MHZ#}</td>
                        <td class="lifetime">{#$level.LIFETIME#}</td>

						<td class="bibliolink">{#$level.BIBLIOLINK#}</td>
						<td class="source">
							{# if $level.SOURCE_IDS !='' #}
							<span class="links">							
								{# assign var=sources value=","|explode:$level.SOURCE_IDS#}
								{#foreach from=$sources item=source#}
									<a class="source_link various fancybox.ajax" href="../bibliography/{#$source#}" >{#$source#}</a>
								{#/foreach#}
							</span>
								{#else#}
							<span class="links">&nbsp;</span>																	
						{#/if#}                        
							
                       	</td>
                    </tr>
                    {#/foreach#}

		    		</table>
		    		</form>	    		
				</div>
			</div>