  	<div class="container_12">
		<div class="grid_12" id="main">
			{#if ($transition_count != 0)#}
				<h4>{#$l10n.Load_file#}</h4>
				<form id='compare' method='POST' enctype='multipart/form-data'>
					<input type='file' name='file' id='file'>
					<select name='standard_file' id='standard_file'>
						<option value=0>---
						<option value=1>{#$l10n.Mercury_lamp_spectrum#}
					</select>
				</form>
				<div>
					<div id='toolbar'>
						<div id='range'>
							<div id='min_container'>
								<b>{#$l10n.MinLength#} (&#8491;)</b><br>
								<input type='text' id='min' value='{#if $auto==true#}3000{#else#}0{#/if#}'>
							</div>
							<div id='max_container'>
								<b>{#$l10n.MaxLength#} (&#8491;)</b><br>
								<input type='text' id='max' value='{#if $auto==true#}8000{#else#}30000{#/if#}'>
							</div>
							<div class='top_div'>
								<input type='button' id='filter' value='OK' class="bluebtn">
							</div>
							<div id='visible_container' style="clear:both; margin-top: 10px;">
								<input type='button' id='visible' value='Visible spectrum' class='bluebtn'><span style="width: 20px">
											<input type='button' id='all_spectrum' value='All spectrum' class='bluebtn'>
							</div>

						</div>
						<div id='zoom_container'>
							<b>{#$l10n.Scale#}</b><br>
							<input type='button' id='x1' value='1' class='bluebtn base active'>
							<input type='button' value='10' class='bluebtn base'>
							<input type='button' value='100' class='bluebtn base'>
							<br><br>
							<input type='button' id='x2' value='x2' class="bluebtn {#if $auto==true#}active{#/if#}">
							<input type='button' value='x5' class="bluebtn">
						</div>
						<div>
							<input type='button' id='barchart' value='{#$l10n.BarChart#}' class="bluebtn {#if $auto==true#}active{#/if#}">
						</div>
					</div>
				</div>
			<div style="margin: auto; margin-top: 10px; width: 520px;">
				<div id="info_intensity"><b>{#$l10n.Sensibility#}</b></div><div id="range_intensity"><input type="range" min=10 max=400 value=160 style="width: 390px;"></div>
			</div>
				<div id='line_info'>
				</div>
				<div id="svg_wrapper">
				</div>
				<div id='map'>
					<div id='preview'></div>
					<div id='map_now'></div>
				</div>
			{#else#}
				<div class="brake"></div>
				<div>
					{#$l10n.No_transitions#}
				</div>
			{#/if#}
    	</div>
	</div>
<!--End of Main -->