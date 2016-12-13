<div class="container_12">
	<div class="grid_12" id="main">   
		<div class="brake"></div>				
		{#if $locale=="ru"#}			
		<h3>Атом {#$atom.NAME_RU_ALT#}, Z={#$atom.Z#}, I.P.={#$atom.IONIZATION_POTENCIAL#} см<sup>-1</sup> ichi: {#$ichi#}, ichi_key: {#$ichi_key#}</h3>        	   
		{#else#}
		<h3>Atom of {#$atom.NAME_EN#}, Z={#$atom.Z#}, I.P.={#$atom.IONIZATION_POTENCIAL#} см<sup>-1</sup></h3>
		{#/if#}

		{#if $atom.SPECTRUM_IMG!=""#}
			{#if $locale=="ru"#}
				<a href="/{#$locale#}/spectrum/{#$layout_element_id#}">
				<img src="/{#$locale#}/spectrumpng/{#$layout_element_id#}" height="120" width="1000"
					 title="Спектр {#if $atom.IONIZATION==0#}атома{#else#}иона{#/if#} {#$atom.NAME_RU_ALT#} ({#$atom_name#})"
					 alt="Спектр {#if $atom.IONIZATION==0#}атома{#else#}иона{#/if#}  {#$atom.NAME_RU_ALT#} ({#$atom_name#})">
				</a>
			{#else#}
				<a href="/{#$locale#}/spectrum/{#$layout_element_id#}">
					<img src="/{#$locale#}/spectrumpng/{#$layout_element_id#}" height="120" width="1000"
						 title="Spectrum of {#$atom.NAME_EN#} {#if $atom.IONIZATION==0#}atom{#else#}ion{#/if#} ({#$atom_name#})"
						 alt="Spectrum of {#$atom.NAME_EN#} {#if $atom.IONIZATION==0#}atom{#else#}ion{#/if#} ({#$atom_name#})">
				</a>
			{#/if#}
			<br>
		{#/if#}

		<br>

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
			<input type='submit' id='export' value='{#$l10n.XSAMS_Export#}' name='export' class="button white commonbuttom" download>
		</form>


		{#if ($level_count != 0)#}
		<p>&nbsp;</p>
		<h4>{#$l10n.Electronic_structure#}</h4>		
		{#$l10n.Found#} {#$level_count#} {#$l10n.levels#}. <a class="nav" href="/{#$locale#}/levels/{#$layout_element_id#}">[{#$l10n.view#}]</a>

		{#/if#}

		{#if ($transition_count != 0)#}
		<p>{#$l10n.Found#} {#$transition_count#} {#$l10n.transitions#}. <a class="nav" href="/{#$locale#}/transitions/{#$layout_element_id#}">[{#$l10n.view#}]</a></p>
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
