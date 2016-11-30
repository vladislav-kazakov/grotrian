<div class="container_12">
	<div class="grid_12" id="main">   
		<div class="brake"></div>				
		{#if $locale=="ru"#}			
		<h3>јтом {#$atom.NAME_RU_ALT#}, Z={#$atom.Z#}, I.P.={#$atom.IONIZATION_POTENCIAL#} см<sup>-1</sup> ichi: {#$ichi#}, ichi_key: {#$ichi_key#}</h3>        	   
		{#else#}
		<h3>Atom of {#$atom.NAME_EN#}, Z={#$atom.Z#}, I.P.={#$atom.IONIZATION_POTENCIAL#} см<sup>-1</sup></h3>
		{#/if#}

		{#if $atom.SPECTRUM!=""#}
		<img src="{#$atom.SPECTRUM#}" height="120" width="1000">
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

		<form method='POST'>
			<input type='submit' id='export' value='Ёкспорт в XSAMS' name='export'>
		</form>


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
		<a class="nav" target="_blank" href="/{#$locale#}/newdiagram/{#$layout_element_id#}">[{#$l10n.view#}]</a><br/><b>{#$l10n.To_view_a_chart#} <a href="http://www.adobe.com/svg/viewer/install/main.html" target="_blank">{#$l10n.To_view_a_chart_you_need#} Adobe SVG Viewer</a></b>
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
</div>
<!--End of Main -->
