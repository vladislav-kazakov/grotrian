<script type="text/javascript" src="/js/bibtex_js.js"></script>
<div class="bibtex_template" style="display:none;">
	<div class="if author" style="font-weight: bold;">
  <span class="if year">
    <span class="year"></span>,
  </span>
		<span class="author"></span>
  <span class="if url" style="margin-left: 20px">
    <a class="url" style="color:black; font-size:10px">(view online)</a>
  </span>
	</div>
	<div style="margin-left: 10px; margin-bottom:5px;">
		<span class="title"></span>
	</div>
</div>
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
                                            
                    {# foreach item=bibliolink from=$SourceList#}
					<tr class="selectable">					
					 	<td class="bibliolink" >{#$bibliolink.BIBTEX#}</td>
				        <td>
							<div class="source">
				        		<a class="source_link various fancybox.ajax" href="{#$bibliolink.ID#}" >{#$bibliolink.ID#}</a>
							</div>
							<input type="hidden" class="source_id" name="source_id[]" value="{#$bibliolink.ID#}"/>
						</td>
                    </tr>
                    {#/foreach#}  	
		    		</table>	 
		    	</form>   		
				</div>
