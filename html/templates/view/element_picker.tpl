<div class="element_picker">					
	<div class="newperiodic">
		<div class="empty" style="left:0px; margin-top:0px;">&nbsp;</div>
		{#section name=bar start=1 loop=19 step=1#}
    		<div class="empty" style="left:{#$smarty.section.bar.index*25+$smarty.section.bar.index#}px; margin-top:0px;"><div class="head">{#$smarty.section.bar.index#}</div></div>    
    		{#if $smarty.section.bar.index<9#}<div class="empty" style="left:0px; margin-top:{#$smarty.section.bar.index*26#}px;"><div class="head">{#$smarty.section.bar.index#}</div></div>{#/if#}
		{#/section#}
		<div class="empty" style="width:85px; left:0px; margin-top:240px;"><div class="head"></div>{#$l10n.Lanthanide#}</div>
		<div class="empty" style="width:85px; left:0px; margin-top:266px;"><div class="head">{#$l10n.Actinide#}</div></div>
		<div class="empty" style="width:85px; left:0px; margin-top:292px;"><div class="head">{#$l10n.Superactinide#}</div></div>
		<span style="display:none;">{#counter start=29 skip=1 direction="down" print="false" assign="i"#}</span>
{#foreach from=$periodic_table key=myId item=element#}
{#if 57<$element.Z && $element.Z<72#}{#*<!-- Draw Lanthanide -->*#}
	{#counter#}<div class="{#$element.TYPE#} pick" style="left:{#$i*25+$i+112#}px; margin-top:240px;"><a title="{#$element.name|capitalize#}" class="plink" ><input type="hidden" name="elemid" value="{#$element.ID#}" /><span class="pnum">{#$element.Z#}</span><span class="pname">{#$element.ABBR#}</span></a></div>
{#else#}{#if 89<$element.Z && $element.Z<104#}{#*<!-- Draw Actinide -->*#}
	{#counter#}<div class="{#$element.TYPE#} pick" style="left:{#$i*25+$i-364+112#}px; margin-top:266px;"><a title="{#$element.name|capitalize#}" class="plink" ><input type="hidden" name="elemid" value="{#$element.ID#}" /><span class="pnum">{#$element.Z#}</span><span class="pname">{#$element.ABBR#}</span></a></div>
{#else#}{#if 120<$element.Z && $element.Z<127#}{#*<!-- Draw Superactinide -->*#}
	{#counter#}<div class="{#$element.TYPE#} pick" style="left:{#$i*25+$i-616#}px; margin-top:292px;"><a title="{#$element.name|capitalize#}" class="plink" ><input type="hidden" name="elemid" value="{#$element.ID#}" /><span class="pnum">{#$element.Z#}</span><span class="pname">{#$element.ABBR#}</span></a></div>
{#else#}{#if $element.ID==2817#}{#*<!-- Draw Tritium and Deiterium -->*#}
	<div class="{#$element.TYPE#} pick" style="left:468px; margin-top:240px;"><a title="{#$element.name|capitalize#}" class="plink" ><input type="hidden" name="elemid" value="{#$element.ID#}" /><span class="pname_head">{#$element.ABBR#}</span></a></div>
{#else#}{#if $element.ID==39762#}
	<div class="{#$element.TYPE#} pick" style="left:468px; margin-top:266px;"><a title="{#$element.name|capitalize#}" class="plink" ><input type="hidden" name="elemid" value="{#$element.ID#}" /><span class="pname_head">{#$element.ABBR#}</span></a></div>
{#else#}{#if $element.Z<121#}{#* <!-- Draw All Other Elements the Table --> *#}
	<div class="{#$element.TYPE#} pick" style="left:{#$element.TABLEGROUP*25+$element.TABLEGROUP#}px; margin-top:{#$element.TABLEPERIOD*26#}px;"><a title="{#$element.name|capitalize#}" class="plink" ><input type="hidden" name="elemid" value="{#$element.ID#}" /><span class="pnum">{#$element.Z#}</span><span class="pname">{#$element.ABBR#}</span></a></div>
{#/if#}{#/if#}{#/if#}{#/if#}{#/if#}{#/if#}
{#/foreach#}
	</div>			
</div>
{#*<!--End of Periodic Table-->*#}