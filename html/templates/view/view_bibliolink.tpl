<script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="/js/bibtex_js.js"></script>
<script type="text/javascript">
$(document).ready(function () {
	$(document).ready(function () {
		$(".bibtex_display").each(function() {
			$(this).prop("innerHTML", (new BibtexDisplay()).displayBibtex($(this).prop("innerText")));
		});
	});
});
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
<div class="bibliolink">
	<h4>Источник данных #{#$BiblioItem.ID#}</h4>
	{# if $BiblioItem.LINK !="" #}
		<a href="http://{#$BiblioItem.LINK#}">{#$BiblioItem.WORK_NAME#}</a>
		<br/>
		{#else#}
		{#if $BiblioItem.WORKNAME#}{#$BiblioItem.WORK_NAME#}<br/>{#/if#}
	{#/if#}
	
	{#if $Authors #}
		{# foreach item=author from=$Authors#}
			{#$author.NAME#}
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
	<div class="bibtex_display">{#$BiblioItem.BIBTEX#}</div>
	 <hr/>
	{#$BiblioItem.BIBTEX#}
	{#*bibliolink biblioarray=$BiblioItem *#}
</div>	
	
