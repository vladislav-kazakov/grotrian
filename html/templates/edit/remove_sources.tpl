<script type="text/javascript" charset="windows-1251" src="/js/bibliography.js" ></script>
<script type="text/javascript" charset="windows-1251">
			//<![CDATA[	
				$(document).ready(function() {	
					$("#bibliography_table_wrapper div.toolbar").html(Search+': <input size="20" type="text" id="biblioSearchField"><a href="#" class="button white" id="apply_removing">Отсоединить выделенные</a>');	
				});
				//]]>			
</script>
<div id="main" class="container_12 manage_source"" >
	<table cellpadding="0" cellspacing="0" border="0"  class="display view" id="bibliography_table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Источники</th>									                        
			</tr>	
		</thead>	
                    
        <form id="removeSourceForm" action="">
            <input type="hidden" id="atom_id" name="atom_id" value=""/>
            {# foreach item=bibliolink from=$Sourcelist#}
				<tr class="{#cycle values='odd,even'#}">
					<td>
						{#$bibliolink.ID#} 
					</td>
					<td class="bibliolink">
						<input type="hidden" class="source_id" name="source_id[]" value="{#$bibliolink.ID#}"/>
						{#bibliolink biblioarray=$bibliolink #}			 	
					</td>				        					        
            	</tr>
        	{#/foreach#}
		</form> 	
	</table>
	
			
</div>
