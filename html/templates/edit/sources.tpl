{# assign var=sources value=","|explode:$IDS.SOURCE_IDS#}
	{#foreach from=$sources item=source#}
		<a class="source_link" href="../bibliography/{#$source#}" >{#$source#}</a>
	{#/foreach#}                  
