			<div id="main" class="container_12" >
				<form id="inputBibliolinkform" action="">  															
					<table cellpadding="0" cellspacing="0" border="0" class="display edit" id="bibliography_table">
						<thead>
							<tr>								
								<th>
									Библиоссылка
								</th>
								<th>ID</th>		                        
							</tr>	
						</thead>
                                            
                    {# foreach item=bibliolink from=$BiblioList#}
					<tr class="selectable">					
					 	<td class="bibliolink" >
					 		{#bibliolink biblioarray=$bibliolink #}		
					 		<input type="hidden" class="source_id" name="source_id[]" value="{#$bibliolink.ID#}"/>	 	
					 	</td>
				        <td class="source">
				        	<a class="source_link" href="{#$bibliolink.ID#}" >{#$bibliolink.ID#}</a>
				        </td>				        
                    </tr>
                    {#/foreach#}  	
		    		</table>	 
		    	</form>   		
				</div>
