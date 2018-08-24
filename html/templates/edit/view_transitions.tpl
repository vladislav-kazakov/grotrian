			<div id="tab" >
				<div id="panel">
    				<div class="container_12">        
						<div class="grid_7">
            				<h4>{#$l10n.Table_lookup#}:</h4> 
	                		<table class="search_form">
								<tbody>
	                				
                                    <tr>
	                    	 			<td></td>
                                        <td align="center"><div class="froam">от</div><div class="froam" >до</div></td> 
		                			</tr>
									
                                    <tr>
										<td class="name">{#$l10n.Wavelength#}:</td>
										<td>
				                        	<input size="12" id="min_2" name="min_2"  type="text"/>
											<input size="12" id="max_2" name="max_2"  type="text"/>
										</td>
	                        			
                                        <td class="dimension">
	                        				[&#197;]
	                      				 </td>
									</tr>
			
            						<tr>
										<td  class="name">{#$l10n.Intensity#}:</td>
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
	                        				[<i>10<sup>8</sup>{#$l10n.sec#}<sup>-1</sup></i>]
										</td>
										
									</tr>
                                    
									<tr>
										<td class="name">{#$l10n.The_excitation_cross_section#}:</td>
										<td>
	                            			<input size="12" id="min_6" name="min_6"  type="text"/>
											<input size="12" id="max_6" name="max_6"  type="text"/> 
										</td>
										<td class="dimension"></td>
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
				<input type="hidden" id="type" name="type" value="T"/>	 
				<input type="hidden" id="atom_id" name="atom_id" value="{#$layout_element_id#}"/>                               
					<table cellpadding="0" cellspacing="0" border="0" class="display edit" id="table1">
						<thead>
							<tr>	
								<th>&nbsp;&nbsp;&nbsp;</th>
								<th>{#$l10n.Lower#} {#$l10n.Level#}</th>
								<th>{#$l10n.Upper#} {#$l10n.Level#}</th>
								<th>{#$l10n.Wavelength#}[<i>&#197;</i>]</th>
								<th>{#$l10n.Intensity#}</th>
								<th><i>f<sub>ik</sub></i></th>
					            <th>A<sub><i>ki</i></sub><br/>[<i>10<sup>8</sup>сек<sup>-1</sup></i>]</th>
					            <th>{#$l10n.The_excitation_cross_section#} <br/> Q<sub>max</sub>* 10<sup>18</sup>, <i>{#$l10n.cm#}<sup>2</sup></i></th>
								<th style="width: 120px;">Источник строкой (deprecated)</th>
					            <th>{#$l10n.Source#}</th>
							</tr>
						</thead>	
                        
                        {# foreach item=transition from=$transition_list#}                        	
                             <tr class="selectable">
                             
                             <td>
								<input type="checkbox"/>
								<input type="text" class="row_id" name="row_id[]" value="{#$transition.ID#}" style="display:none;"/>
								
								<!-- <input type="text" class="lower_level_energy" value="{#$transition.lower_level_energy#}" style="display:none;"/>
								<input type="text" class="upper_level_energy" value="{#$transition.upper_level_energy#}" style="display:none;"/>
								<input type="text" class="lower_level_termmultiply" value="{#$transition.lower_level_termmultiply#}" style="display:none;"/>
								<input type="text" class="upper_level_termmultiply" value="{#$transition.upper_level_termmultiply#}" style="display:none;"/> -->
								<input type="text" class="lower_level_id" value="{#$transition.lower_level_id#}" style="display:none;"/>
								<input type="text" class="upper_level_id" value="{#$transition.upper_level_id#}" style="display:none;"/>
							 </td>
                             
					 			<td class="lower_level_config">
					 			{#if $transition.lower_level_config==" " || $transition.lower_level_config=="" #} {# $transition.lower_level_energy#} {#else#} 
					 			
					 			{# $transition.lower_level_config#}{#/if#}:
					 								 			
					 			{#if $transition.lower_level_termsecondpart!="NULL"#}{#$transition.lower_level_termsecondpart#}{#/if#}
					 			
					 			{#if $transition.lower_level_termprefix!=""#}<sup>{#$transition.lower_level_termprefix#}</sup>{#/if#}
					 			{#if $transition.lower_level_termfirstpart=="" || $transition.lower_level_termfirstpart==" "#} (?) {#else#}<span>{#$transition.lower_level_termfirstpart#}</span>{#/if#}
					 			{#if $transition.lower_level_termmultiply==1#}<span>&deg;</span>{#/if#}
					 			{#if $transition.lower_level_j!=""#}<sub>{#$transition.lower_level_j#}</sub>{#/if#}
					 			
					 			
					 			</td>
					 								 			
                                <td class="upper_level_config">
                                {#if $transition.upper_level_config=="" || $transition.upper_level_config==" "#} {# $transition.upper_level_energy#} {#else#}                                 
                                
                                {# $transition.upper_level_config#}{#/if#}:
                                
                                {#if $transition.upper_level_termsecondpart!="NULL" #}{#$transition.upper_level_termsecondpart#}{#else#}{#/if#}
                                {#if $transition.upper_level_termprefix!=""#}
                                	<sup>{#$transition.upper_level_termprefix#}</sup>
                                {#/if#}
                                {#if $transition.upper_level_termfirstpart=="" || $transition.upper_level_termfirstpart==" "#} (?) {#else#}<span>{#$transition.upper_level_termfirstpart#}</span>{#/if#}
                                {#if $transition.upper_level_termmultiply==1#}
									<span>&deg;</span>
                                {#/if#}
                                {#if $transition.upper_level_j!=""#}
                                	<sub>{#$transition.upper_level_j#}</sub>
                                {#/if#}
                                </td>
   							 	<td class="wavelength">{#$transition.WAVELENGTH#}</td>
						        <td class="intensity">{#$transition.INTENSITY#}</td>
						        <td class="f_ik">{#$transition.OSCILLATOR_F#}</td>
				        		<td class="a_ki">{#if $transition.PROBABILITY!=""#}{#$transition.PROBABILITY/100000000#}{#/if#}</td>
        		                <td class="excitation">{#$transition.CROSSECTION#}</td>
								<td class="bibliolink">{#$transition.BIBLIOLINK#}</td>

        		               	<td class="source">        		               											
									{# if $transition.SOURCE_IDS !='' #}	
									<span class="links">									
											{# assign var=sources value=","|explode:$transition.SOURCE_IDS#}
											{#foreach from=$sources item=source#}
												<a class="source_link" href="../bibliography/{#$source#}" >{#$source#}</a>
											{#/foreach#}
									</span>		
									{#else#}
									<span class="links">&nbsp;</span>						
									{#/if#}								                    
									
                       			</td>
                		    </tr>
		                    
                {#/foreach#}
                        
                        
                        
		    		</table>				
			</div>