			<div id="main" class="container_12" >
			<div class="brake"></div>	                      
					<table cellpadding="0" cellspacing="0" border="0" class="display view" id="bibliography_table">
						<thead>
							<tr>
								<th>Библиоссылка</th>
								<th>ID</th>		                        
							</tr>	
						</thead>             
                    {# foreach item=bibliolink from=$BiblioList#}
					<tr class="selectable">
					 	<td class="bibliolink" >
					 		{#bibliolink biblioarray=$bibliolink #}			 	
					 	</td>
				        <td >
				        	<a class="source_link" href="{#$bibliolink.ID#}" >{#$bibliolink.ID#}</a>
				        </td>				        
                    </tr>
                    {#/foreach#}

		    		</table>	    		
			</div>
