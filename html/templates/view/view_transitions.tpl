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
                                        <td></td>
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
										<td class="name">{#$l10n.The_absorption_cross_section#}:</td>
										<td>
	                            			<input size="12" id="min_6" name="min_6"  type="text"/>
											<input size="12" id="max_6" name="max_6"  type="text"/> 
										</td>
										<td class="dimension"></td>
									</tr>                    
									<tr>
										<td class="name"> {#$l10n.Serie#}:</td>
										<td>
											<select id="serieSelect" name="serieSelect" style="width: 210px">										
												<option>&nbsp;</option>
											</select>
										</td>			
									</tr>
									<tr>
										<td class="name"> {#$l10n.Lower#} {#$l10n.Level#}:</td>
										<td>
											<select id="lowerLevelSelect" name="lowerLevelSelect" style="width: 210px">										
												<option>&nbsp;</option>
											</select>
										</td>			
									</tr>
									<tr>
										<td class="name"> {#$l10n.Upper#} {#$l10n.Level#}:</td>
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
								<th>{#$l10n.Serie#}</th>
								<th>{#$l10n.Lower#} {#$l10n.Level#}</th>
								<th>{#$l10n.Upper#} {#$l10n.Level#}</th>
								<th>{#$l10n.Wavelength#}[<i>&#197;</i>]</th>
								<th>{#$l10n.Intensity#}</th>
								<th><i>f<sub>ik</sub></i></th>
					            <th>A<sub><i>ki</i></sub><br/>[<i>10<sup>8</sup>сек<sup>-1</sup></i>]</th>
					            <th>{#$l10n.The_absorption_cross_section#} <br/> Q<sub>max</sub>* 10<sup>18</sup>, <i>{#$l10n.cm#}<sup>2</sup></i></th>
								<th>{#$l10n.Source#}</th>                          
							</tr>
						</thead>	
                        
                        {# foreach item=transition from=$transition_list#}
                             <tr>
                             <td>
                            	{#if $transition.lower_level_config=="" || $transition.lower_level_config==" " #}(?)
                            	{#else#} {#$transition.lower_level_config#}
						 			{#if $transition.upper_level_config_type#} - {#$transition.upper_level_config_type#} {#/if#}
								{#/if#}
                             </td>
					 			<td>
					 			{#if $transition.lower_level_config=="" || $transition.lower_level_config==" "#} {#$transition.lower_level_energy#} {#else#} {#$transition.lower_level_config#} {#/if#}:
					 			
					 			{#if $transition.lower_level_termsecondpart!="NULL"#}{#$transition.lower_level_termsecondpart #}{#/if#}
					 			
					 			{#if $transition.lower_level_termprefix!=""#}<sup>{#$transition.lower_level_termprefix#}</sup>{#/if#}
					 			
					 			{#if $transition.lower_level_termfirstpart=="" || $transition.lower_level_termfirstpart==" "#} (?) {#else#}<span>{#$transition.lower_level_termfirstpart#}</span>{#/if#}
					 			
					 			{#if $transition.lower_level_termmultiply==1#}<span>&deg;</span>{#/if#}
					 			
					 			{#if $transition.lower_level_j!=""#}<sub>{#$transition.lower_level_j#}</sub>{#/if#}
					 			</td>
					 								 			
                                <td>
                                {#if $transition.upper_level_config=="" || $transition.upper_level_config==" "#} {#$transition.upper_level_energy#} {#else#} {#$transition.upper_level_config#} {#/if#}:
                                
                                {#if $transition.upper_level_termsecondpart!="NULL"#}{#$transition.upper_level_termsecondpart#}{#/if#}
                                
                                {#if $transition.upper_level_termprefix!=""#}<sup>{#$transition.upper_level_termprefix#}</sup>{#/if#}
                                
                                {#if $transition.upper_level_termfirstpart=="" || $transition.upper_level_termfirstpart==" "#} (?) {#else#}<span>{#$transition.upper_level_termfirstpart#}</span>{#/if#}
                                
                                {#if $transition.upper_level_termmultiply==1#}<span>&deg;</span>{#/if#}
                                
                                {#if $transition.upper_level_j!=""#}<sub>{#$transition.upper_level_j#}</sub>{#/if#}
                                
                                </td>
   							 	<td>{#$transition.WAVELENGTH#}</td>
						        <td>{#$transition.INTENSITY#}</td>
						        <td>{#$transition.OSCILLATOR_F#}</td>
				        		<td>
				        			{#if $transition.PROBABILITY!=""#}
				        				{#$transition.PROBABILITY/100000000#}
				        			{#/if#}	
				        		</td>
        		                <td>{#$transition.CROSSECTION#}</td>
								
								<td class="source">	
                        		{# if $transition.SOURCE_IDS !='' #}
									<span class="links">						
									{# assign var=sources value=","|explode:$transition.SOURCE_IDS#}
									{#foreach from=$sources item=source#}
										{# if $source !='' #}
											<a class="source_link various fancybox.ajax" href="../bibliography/{#$source#}" >{#$source#}</a>
										{#/if#}
									{#/foreach#}						                        
									</span>
								{#/if#}
                       			</td>
                		    </tr>
		                    
                {#/foreach#}      
                        
                        
		    		</table>
			</div>