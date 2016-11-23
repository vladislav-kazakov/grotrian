<div id="txt" class="container_12">
	<div class="grid_12">
	<br/>
<div class="element_table">					
	<div class="periodic">
	<input type="hidden" id="MaxLevels" name="MaxLevels" value="{#$MaxLevels#}" />
		<div class="empty" style="left:0px; margin-top:0px; height:20px; width:20px;">&nbsp;</div>
		{#section name=bar start=1 loop=19 step=1#}
    		<div class="emptyGroup" style="left:{#$smarty.section.bar.index*60+$smarty.section.bar.index-40#}px; margin-top:0px;"><div class="head">{#$smarty.section.bar.index#}</div></div>    
    		{#if $smarty.section.bar.index<9#}	
				<div class="emptyPeriod" style="left:0px; margin-top:{#$smarty.section.bar.index*51-30#}px;"><div class="head">{#$smarty.section.bar.index#}</div></div>
			{#/if#}	
		{#/section#}
		
		<div class="empty" style="width:142px; left:0px; margin-top:458px;"><div class="head">{#$l10n.Lanthanide#} *</div></div>
		<div class="empty" style="width:142px; left:0px; margin-top:509px;"><div class="head">{#$l10n.Actinide#} **</div></div>
		<div class="empty" style="width:142px; left:0px; margin-top:560px;"><div class="head">{#$l10n.Superactinide#} ***</div></div>


		<span style="display:none;">{#counter start=29 skip=1 direction="down" print="false" assign="i"#}</span>
		{#foreach from=$periodic_table key=myId item=element#}
			{#* <!-- Draw All Elements the Table --> *#}
			{#if $element.Z<125 && !(56<$element.Z && $element.Z<72) && !(88<$element.Z && $element.Z<104) && !(120<$element.Z && $element.Z<127)#}
				<div class="{#$element.TYPE#} pick" style="left:{#$element.TABLEGROUP*60+$element.TABLEGROUP-40#}px; margin-top:{#$element.TABLEPERIOD*51-30#}px;"><a title="{#$element.name|capitalize#}" href="/ru/element/{#$element.ID#}" class="plink" ><input type="hidden" class="levelsNum" name="levelsNum" value="{#$element.LEVELS_NUM#}" /><input type="hidden" class="transitionsNum" name="transitionsNum" value="{#$element.TRANSITIONS_NUM#}" /><span class="pnum">{#$element.Z#}</span><span class="pname">{#$element.ABBR#}</span><span class="ptitle">{#$element.name|capitalize#}</span></a></div>
			{#/if#}
			
			{#if $element.Z == 57#}
				<div class="empty" style="left:{#$element.TABLEGROUP*50+$element.TABLEGROUP-10#}px; margin-top:{#$element.TABLEPERIOD*51-30#}px;"><div class="head">*</div></div>
			{#/if#}			
			{#if $element.Z == 89#}
				<div class="empty" style="left:{#$element.TABLEGROUP*50+$element.TABLEGROUP-10#}px; margin-top:{#$element.TABLEPERIOD*51-30#}px;"><div class="head">**</div></div>
			{#/if#}
			{#if $element.Z == 121#}
				<div class="empty" style="left:{#$element.TABLEGROUP*50+$element.TABLEGROUP-10#}px; margin-top:{#$element.TABLEPERIOD*51-30#}px;"><div class="head">***</div></div>
			{#/if#}
			
			
			{#*<!-- Draw Lanthanide -->*#}
			{#if 56<$element.Z && $element.Z<72#}
				{#counter#}
				<div class="{#$element.TYPE#} pick" style="left:{#$i*60+$i+326#}px; margin-top:458px;"><a title="{#$element.name|capitalize#}" href="/ru/element/{#$element.ID#}" class="plink" ><input type="hidden" class="levelsNum" name="levelsNum" value="{#$element.LEVELS_NUM#}" /><input type="hidden" class="transitionsNum" name="transitionsNum" value="{#$element.TRANSITIONS_NUM#}" /><span class="pnum">{#$element.Z#}</span><span class="pname">{#$element.ABBR#}</span><span class="ptitle">{#$element.name|capitalize#}</span></a></div> 
			{#/if#}
			{#*<!-- Draw Actinide -->*#}
			{#if 88<$element.Z && $element.Z<104#}
				{#counter#}
				<div class="{#$element.TYPE#} pick" style="left:{#$i*60+$i-589#}px; margin-top:509px;"><a title="{#$element.name|capitalize#}" href="/ru/element/{#$element.ID#}" class="plink" ><input type="hidden" class="levelsNum" name="levelsNum" value="{#$element.LEVELS_NUM#}" /><input type="hidden" class="transitionsNum" name="transitionsNum" value="{#$element.TRANSITIONS_NUM#}" /><span class="pnum">{#$element.Z#}</span><span class="pname">{#$element.ABBR#}</span><span class="ptitle">{#$element.name|capitalize#}</span></a></div> 
			{#/if#} 

			{#*<!-- Draw Superactinide -->*#}
			{#if 120<$element.Z && $element.Z<127#}
				{#counter#}
				<div class="{#$element.TYPE#} pick" style="left:{#$i*60+$i-1504#}px; margin-top:560px;"><a title="{#$element.name|capitalize#}" href="/ru/element/{#$element.ID#}" class="plink" ><input type="hidden" class="levelsNum" name="levelsNum" value="{#$element.LEVELS_NUM#}" /><input type="hidden" class="transitionsNum" name="transitionsNum" value="{#$element.TRANSITIONS_NUM#}" /><span class="pnum">{#$element.Z#}</span><span class="pname">{#$element.ABBR#}</span><span class="ptitle">{#$element.name|capitalize#}</span></a></div> 
			{#/if#}
			
		{#*<!-- Draw Tritium and Deiterium -->*#}			
			{#if $element.ID==2817#}
						<!--<div class="{#$element.TYPE#} pick" style="left:968px; margin-top:408px;"><a title="{#$element.name|capitalize#}" href="{#$element.ID#}" class="plink" > value="{#$element.ID#}" /><span class="pname_head">{#$element.ABBR#}</span></a></div>--> 
			{#/if#} 
			
			{#if $element.ID==39762#}
				<!--<div class="{#$element.TYPE#} pick" style="left:468px; margin-top:459px;"><a title="{#$element.name|capitalize#}" href="{#$element.ID#}" class="plink" ><span class="pname_head">{#$element.ABBR#}</span></a></div>--> 
			{#/if#} 
		{#/foreach#}
		
		<div class="empty" style="width:705px; left:70px; margin-top:20px; border:0; background:transparent;"><div class="head">{#$l10n.Show_database_filling#}: <a id="showLevelsFilling" href="#">{#$l10n.Levels#}</a> / <a id="showTransitionsFilling" href="#" >{#$l10n.Transitions#}</a></div><div class="legend"></div></div>		

	</div>			
</div>
</div>	
</div>
