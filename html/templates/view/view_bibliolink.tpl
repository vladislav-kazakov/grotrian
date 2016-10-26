<div class="bibliolink">
	<h4>Источник данных #{#$BiblioItem.ID#}</h4>
	
	{#if $BiblioItem.LINK !='' #}
		<a href="{#$BiblioItem.LINK#}">{#$BiblioItem.WORK_NAME#}</a>
		<br/>
		{#else#}		
		{#$BiblioItem.WORK_NAME#}
		<br/>
	{#/if#}
	
	{#if $Authors #}
		{# foreach item=author from=$Authors#}
			<a href="">{#$author.NAME#}</a>
		{#/foreach#}<br/>
	{#/if#}
	
	{#if $BiblioItem.ISSUE_NAME #}
		{#$BiblioItem.ISSUE_NAME#}<br/>
	{#/if#}
	
	{#if $BiblioItem.PUBLISHER #}
		{#$BiblioItem.PUBLISHER#},
	{#/if#}
	
	{#if $BiblioItem.CITY #}
		{#$BiblioItem.CITY#} - 
	{#/if#}
	{#if $BiblioItem.YEAR #}
		{#$BiblioItem.YEAR #}
	{#/if#}	
	<br/><br/>
	 <hr/>
	{#bibliolink biblioarray=$BiblioItem #}
</div>	
	
