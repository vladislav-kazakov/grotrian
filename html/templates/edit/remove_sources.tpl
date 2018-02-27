<script type="text/javascript" charset="windows-1251" src="/js/remove_sources.js?v2" ></script>
<script type="text/javascript" charset="windows-1251">
			//<![CDATA[	
//				$(document).ready(function() {
//					$("#bibliography_table_wrapper div.toolbar").html(Search+': <input size="20" type="text" id="biblioSearchField"><a href="#" class="button white" id="apply_removing">Отсоединить выделенные</a>');
//				});
				//]]>			
</script>
<div class="bibtex_template" style="display:none;">
	<div class="if author" style="font-weight: bold;">
  <span class="if year">
    <span class="year"></span>,
  </span>
		<span class="author"></span>
  <span class="if url" style="margin-left: 20px">
    <a class="url" style="color:black; font-size:10px" target="_blank">(view online)</a>
  </span>
	</div>
	<div style="margin-left: 10px; margin-bottom:5px;">
		<span class="title"></span>
	</div>
</div>
<div id="main" class="container_12 manage_source">
Search: <input size="20" type="text" id="biblioSearchField"><a href="#" class="button white" id="apply_removing">Отсоединить выделенные</a>
	<table cellpadding="0" cellspacing="0" border="0"  class="display view" id="bibliography_table">
		<thead>
			<tr>
				<th>Источники</th>
				<th>ID</th>
			</tr>	
		</thead>	
                    
        <form id="removeSourceForm" action="">
            <input type="hidden" id="atom_id" name="atom_id" value=""/>
            {# foreach item=bibliolink from=$Sourcelist#}
				<tr class="{#cycle values='odd,even'#}">
					<td class="bibliolink">{#$bibliolink.BIBTEX#}</td>
					<td>
						{#$bibliolink.ID#}
						<input type="hidden" class="source_id" name="source_id[]" value="{#$bibliolink.ID#}"/>
					</td>
            	</tr>
        	{#/foreach#}
		</form> 	
	</table>
	
			
</div>
