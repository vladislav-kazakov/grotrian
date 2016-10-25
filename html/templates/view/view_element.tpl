     
<div class="container_12">    
	<div class="grid_12" id="main">   
		<div class="brake"></div>				
		{#if $locale=="ru"#}			
		<h3>Атом {#$atom.NAME_RU_ALT#}, Z={#$atom.Z#}, I.P.={#$atom.IONIZATION_POTENCIAL#} см<sup>-1</sup> ichi: {#$ichi#}, ichi_key: {#$ichi_key#}</h3>        	   
		{#else#}
		<h3>Atom of {#$atom.NAME_EN#}, Z={#$atom.Z#}, I.P.={#$atom.IONIZATION_POTENCIAL#} см<sup>-1</sup></h3>
		{#/if#}

		{#if $locale=="ru"#}
		{#if $atom.CONTAINMENT_RUS!=""#}
		<h4>{#$l10n.Overview#}</h4>
		{#$atom.CONTAINMENT_RUS#}
		{#/if#}

		{#else#}

		{#if $atom.CONTAINMENT_ENG!=""#}
		<h4>{#$l10n.Overview#}</h4>
		{#$atom.CONTAINMENT_ENG#}
		{#/if#}

		{#/if#}

		{#if ($transition_count != 0)#}
		<p>&nbsp;</p>	
		<h4>{#$l10n.Emission_spectrum#} {#$layout_element_name#}</h4>					

		<div>
			<div id='toolbar'>
				<div id='range'>
					<div id='min_container'>
						<b>Минимум</b><br>
						<input type='text' id='min' value='0'>
					</div>
					<div id='max_container'>
						<b>Максимум</b><br>
						<input type='text' id='max' value='30000'>
					</div>
				</div>
				<div id='zoom_container'>
					<b>Масштаб</b><br>
					<input type='button' value='1' class='base active'>
					<input type='button' value='10' class='base'>
					<input type='button' value='100' class='base'>
					<br><br>
					<input type='button' value='x2'>
					<input type='button' value='x5'>
				</div>                        
				<input type='button' id='filter' value='Применить'>  
			</div>
		</div>
		<div style="margin: auto; margin-top: 10px; width: 520px;">
			<div id="info_intensity"><b>Чувствительность</b><!-- <input type="number" min=0 id="value"> <div id="value" style="display: inline-block;"></div> --></div><div id="range_intensity"></div>
		</div> 
		<div id='line_info'>
		</div>
		<div id="svg_wrapper">
		</div>
		<div id='map'>
			<div id='preview'></div>
			<div id='map_now'></div>
		</div>
		{#/if#}

		<form method='POST'>
			<input type='submit' id='export' value='Экспорт в XSAMS' name='export'>
		</form>
		<br>
		<a id='compare' href='/{#$locale#}/compare/{#$layout_element_id#}'>Сравнить</a>

		{#if ($level_count != 0)#}
		<p>&nbsp;</p>
		<h4>{#$l10n.Electronic_structure#}</h4>		
		{#$l10n.Found#} {#$level_count#} {#$l10n.levels#}. <a class="nav" href="/{#$locale#}/levels/{#$element.ID#}">[{#$l10n.view#}]</a>

		{#/if#}

		{#if ($transition_count != 0)#}
		<p>{#$l10n.Found#} {#$transition_count#} {#$l10n.transitions#}. <a class="nav" href="/{#$locale#}/transitions/{#$element.ID#}">[{#$l10n.view#}]</a></p>
		{#/if#}

		{#if ($element.LIMITS != "")#}
		<p>&nbsp;</p>		
		<h4>{#$l10n.Grotrian_Charts#}</h4>           
		<a class="nav" target="_blank" href="/{#$locale#}/newdiagramm/{#$layout_element_id#}">[{#$l10n.view#}]</a><br/><b>{#$l10n.To_view_a_chart#} <a href="http://www.adobe.com/svg/viewer/install/main.html" target="_blank">{#$l10n.To_view_a_chart_you_need#} Adobe SVG Viewer</a></b>			
		{#/if#}


		{#if ($book_count != 0)#}
		<p>            
			<h4>{#$l10n.Bibliographic_references#}</h4>
			<ul>
				{#foreach from=$book_list item=book#}
				<li>{#$book.NAME#}"</li>
				{#/foreach#}
			</ul>
		</p>
		{#/if#}    

		<br/><br/>       

	</div>
	<div class="clear"></div>
</div>
<!--End of Main -->

<div class="clear"></div>
<div id="empty"></div> 
</div>
<!--End of wrapper--> 
