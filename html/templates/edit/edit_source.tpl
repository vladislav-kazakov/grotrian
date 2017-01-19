<div id="main" class="container_12 manage_source" >


	           
		<table cellpadding="0" cellspacing="0" border="0" id="edit_source_table">
			<thead>
				<tr>
					<th>Редактирование источника # {#$SourceItem.ID#}</th>                       
					<th>Авторы</th>
				</tr>	
			</thead>
           	<tbody>
           	<tr>
           	<td id="source_edit">   
           	
           	<form enctype="multipart/form-data" id="saveSourceForm" action="">
           	<table >        	
				<tr>		
					<td>
						<input class="current_source" type="hidden" value="{#$SourceItem.ID#}" /> 
						<b>Тип источника</b>		 	
					</td>
					<td>
						<select id="source_type" name="source_type">
						{# foreach key=val item=opt from=$source_types#}
							{# if $SourceItem.SOURCE_TYPE == $val #}
            				<option selected="selected" value="{#$val#}">{#$opt#}</option>
            				{#else#}
            				<option value="{#$val#}">{#$opt#}</option>
            				{#/if#}  
            			{#/foreach#}        	            	
            			</select>
					</td>				        
				</tr>				
				<tr id="article_name">		
					<td>
						<b>Название работы</b>		 	
					</td>
					<td>
						<input type="text" class="input_text100" name="name" value="{#$SourceItem.WORK_NAME#}" />
					</td>				        
				</tr>	
							
				<tr id="issue_name">		
					<td>
						<b>Название журнала/сборника</b>		 	
					</td>
					<td>
						 <input type="text" name="issue_name" value="{#$SourceItem.ISSUE_NAME#}" />
					</td>				        
				</tr>				
				
				<tr id="collection_type">		
					<td>
						<b>Вид сборника</b>		 	
					</td>
					<td>
						<select name="collection_type">
						{# foreach item=opt from=$collection_types#}
						
							{# if $SourceItem.COLLECTION_TYPE == $opt #}
            				<option selected="selected">{#$opt#}</option>
            				{#else#}
            				<option>{#$opt#}</option>
            				{#/if#}						            	            	
            				  
            			{#/foreach#}
						</select>
					</td>				        
				</tr>				

				<tr id="city">		
					<td>
						<b>Город</b>		 	
					</td>
					<td>
						<input type="text"  name="city" value="{#$SourceItem.CITY#}" />
					</td>				        
				</tr>				

				<tr id="publisher">		
					<td>
						<b>Издательство</b>		 	
					</td>
					<td>
						<input type="text" name="publisher" value="{#$SourceItem.PUBLISHER#}" />
					</td>				        
				</tr>

				<tr id="year">		
					<td>
						<b>Год издания</b>		 	
					</td>
					<td>
						<input type="text" name="year" value="{#$SourceItem.YEAR#}" />
					</td>				        
				</tr>		
				
				<tr id="tome_num">		
					<td>
						<b>Том</b>		 	
					</td>
					<td>
						<input type="text" name="vol_first" value="{#$SourceItem.VOLUME_FIRST#}" />
					</td>				        
				</tr>		
				
				<tr id="publish_tome">		
					<td>
						<b>Номер тома (первый)</b>		 	
					</td>
					<td>
						<input type="text" name="vol_first" value="{#$SourceItem.VOLUME_FIRST#}" />
					</td>				        
				</tr>				

				<tr id="publish_tome">		
					<td>
						<b>Номер тома (последний)</b>		 	
					</td>
					<td>
						<input type="text" name="vol_last" value="{#$SourceItem.VOLUME_LAST#}" />
					</td>				        
				</tr>			
				
				<tr id="vol_num">		
					<td>
						<b> Номер выпуска</b>		 	
					</td>
					<td>
						 <input type="text" name="vol_first" value="{#$SourceItem.VOLUME_FIRST#}" />
					</td>				        
				</tr>	
 
				<tr id="publish_vol">		
					<td>
						<b> Номер выпуска (первый)</b>		 	
					</td>
					<td>
						 <input type="text" name="vol_first" value="{#$SourceItem.VOLUME_FIRST#}" />
					</td>				        
				</tr>				

				<tr id="publish_vol">		
					<td>
						<b>Номер выпуска (последний)</b>		 	
					</td>
					<td>
						<input type="text" name="vol_last" value="{#$SourceItem.VOLUME_LAST#}" />
					</td>				        
				</tr>			
				
				<tr id="page_num">		
					<td>
						<b>Количество страниц</b>		 	
					</td>
					<td>
						<input type="text" name="page_first"  value="{#$SourceItem.PAGE_FIRST#}" />
					</td>				        
				</tr>
					

				<tr id="publish_page">		
					<td>
						<b>Номер страницы (первой)</b>		 	
					</td>
					<td>
						<input type="text" name="page_first"  value="{#$SourceItem.PAGE_FIRST#}" />
					</td>				        
				</tr>				

				<tr id="publish_page">		
					<td>
						<b>Номер страницы (последней)</b>		 	
					</td>
					<td>
						<input type="text" name="page_last" value="{#$SourceItem.PAGE_LAST#}" />
					</td>				        
				</tr>				

				<tr id="link">		
					<td>
						<b>Ссылка</b>		 	
					</td>
					<td>
						<input type="text" name="link" {#if $SourceItem.LINK !=" "#} value='{#$SourceItem.LINK#}'{#/if#}/>
					</td>				        
				</tr>

				<tr id="bibtex">
					<td>
						<b>Bibtex</b>
					</td>
					<td>
						<textarea name="bibtex" style="width:100%; height: 100px;resize: none;">{#if $SourceItem.BIBTEX !=" "#}{#$SourceItem.BIBTEX#}{#/if#}</textarea>
					</td>
				</tr>
			</table>
				
				</td>
				</form>	
				<td id="authors_edit">				
				<form enctype="multipart/form-data" id="saveSourceAuthors" action="">
				<table id="authors_edit_table">
    	{#if $Authors #}
		{# foreach item=author from=$Authors#}
		<tr>			
			<td class="author_name">{#$author.NAME#}</td>
			
			<td class="author_controls"> 
			<select class="author_role" name="author_role" disabled="disabled">				
				{# foreach key=val item=opt from=$author_roles#}
					{# if $author.ROLE == $val #}
            			<option selected="selected" value="{#$val#}">{#$opt#}</option>
            		{#else#}
	            		<option value="{#$val#}">{#$opt#}</option>
            		{#/if#}  
            	{#/foreach#}				
			</select>			
			

				<input type="hidden" name="author_id" class="author_id" value="{#$author.ID#}" />
				<span><a class="button white" id="edit_author">Редактировать</a></span>
				<span><a class="button white" id="delete_author">Х</a></span>
			</td>	
		</tr>		
		{#/foreach#}		
		{#/if#}
		
				
				</table>
				<div id="adding_button">
					<a id="add_author" class="button white">Добавить автора</a>
				</div>
				</form>
				</td>
				
				</tr>
				
				
			</tbody>			  	
		</table>	    		

 	

	
 <!--   <div><input class="button white" type="submit" value="Сохранить изменения" /><input class="button white" id="clear" type="reset" value="Очистить форму" /></div>-->

	
	
		
	<div id="accept_button"><a href="#" class="button white" id="save_source">Сохранить изменения</a></div>

				
</div>
