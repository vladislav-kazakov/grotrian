		<div class="element_picker">
					
<div class="newperiodic">		

<div class="empty" style="left:0px; margin-top:0px;">&nbsp;</div>
{#section name=bar start=1 loop=19 step=1#}
    <div class="empty" style="left:{#$smarty.section.bar.index*25+$smarty.section.bar.index#}px; margin-top:0px;"><div class="head">{#$smarty.section.bar.index#}</div></div>
    
    {#if $smarty.section.bar.index<9#}	
		<div class="empty" style="left:0px; margin-top:{#$smarty.section.bar.index*26#}px;"><div class="head">{#$smarty.section.bar.index#}</div></div>
	{#/if#}
	
{#/section#}

<div class="empty" style="width:77px; left:0px; margin-top:230px;"><div class="head">{#$l10n.Actinide#}</div></div>
<div class="empty" style="width:77px; left:0px; margin-top:256px;"><div class="head">{#$l10n.Lanthanide#}</div></div>



<span style="display:none;">{#counter start=29 skip=1 direction="down" print="false" assign="i"#}</span>
{#foreach from=$periodic_table key=myId item=element#}

{#*<!-- Draw All Elements the Table -->*#}
{#if $element.Z<125#}	
	<div class="{#$element.TYPE#} pick" style="left:{#$element.TABLEGROUP*25+$element.TABLEGROUP#}px; margin-top:{#$element.TABLEPERIOD*26#}px;"><a title="{#$element.name|capitalize#}" href="{#$element.ID#}" class="plink" ><input type="hidden" name="elemid" value="{#$element.ID#}" /><span class="pnum">{#$element.Z#}</span><span class="pname">{#$element.ABBR#}</span></a></div>
{#/if#}


{#*<!-- Draw Actinide -->*#}
{#if 57<$element.Z && $element.Z<72#}
	{#counter#}
	<div class="{#$element.TYPE#} pick" style="left:{#$i*25+$i+52#}px; margin-top:230px;"><a title="{#$element.name|capitalize#}" href="{#$element.ID#}" class="plink" ><input type="hidden" name="elemid" value="{#$element.ID#}" /><span class="pnum">{#$element.Z#}</span><span class="pname">{#$element.ABBR#}</span></a></div> 
{#/if#}

{#*<!-- Draw Lanthanide -->*#}
{#if 89<$element.Z && $element.Z<104#}
	{#counter#}
	<div class="{#$element.TYPE#} pick" style="left:{#$i*25+$i-364+52#}px; margin-top:256px;"><a title="{#$element.name|capitalize#}" class="plink" ><input type="hidden" name="elemid" value="{#$element.ID#}" /><span class="pnum">{#$element.Z#}</span><span class="pname">{#$element.ABBR#}</span></a></div> 
{#/if#}
 
{#*<!-- Draw Tritium and Deiterium --> *#}
{#if $element.ID==2817#}
	<div class="{#$element.TYPE#} pick" style="left:468px; margin-top:230px;"><a title="{#$element.name|capitalize#}" href="{#$element.ID#}" class="plink" ><input type="hidden" name="elemid" value="{#$element.ID#}" /><span class="pname_head">{#$element.ABBR#}</span></a></div> 
{#/if#} 
 
{#if $element.ID==39762#}
	<div class="{#$element.TYPE#} pick" style="left:468px; margin-top:256px;"><a title="{#$element.name|capitalize#}" href="{#$element.ID#}" class="plink" ><input type="hidden" name="elemid" value="{#$element.ID#}" /><span class="pname_head">{#$element.ABBR#}</span></a></div> 
{#/if#}
 
{#/foreach#}

</div>
			
		</div>
<!--End of Periodic Table-->