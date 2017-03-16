  	<div class="container_12">
		{#if ($transition_count != 0)#}
		<div class="grid_12" id="main">
				<br><h4>{#$l10n.Load_file#}</h4>
				<form id='compare' method='POST' enctype='multipart/form-data'>
					<input type='file' name='file' id='file'>
					<select name='standard_file' id='standard_file'>
						<option value=0>---
						<option value=1>{#$l10n.Mercury_lamp_spectrum#}
						<option value=4>{#$l10n.DDS_lamp_spectrum#} 36msec
						<option value=3>{#$l10n.DDS_lamp_spectrum#} 170msec
						<option value=5>{#$l10n.DDS_lamp_spectrum#} 470msec
						<option value=7>{#$l10n.DVS_lamp_spectrum#} 245msec
						<option value=8>{#$l10n.DVS_lamp_spectrum#} 500msec
						<option value=6>{#$l10n.DVS_lamp_spectrum#} 1000msec
						<option value=11>{#$l10n.Home_lamp_spectrum#} 25msec
						<option value=10>{#$l10n.Home_lamp_spectrum#} 125msec
						<option value=13>{#$l10n.Na_lamp_spectrum#} 170msec
						<option value=12>{#$l10n.Na_lamp_spectrum#} 1700msec
						<option value=9>{#$l10n.Hollow_cathode_lamp_spectrum#} (Hg) 21msec
						<option value=14>{#$l10n.Hollow_cathode_lamp_spectrum#} (Ta) 62msec
						<option value=15>{#$l10n.Hollow_cathode_lamp_spectrum#} (Ta, Kortek) 90msec
						<option value=2>{#$l10n.Hollow_cathode_lamp_spectrum#} (Cu-Zn) 300msec
					</select>
				</form><br>
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
								<input type='button' id='visible' value='{#$l10n.VisibleSpectrum#}' class='bluebtn'><span style="width: 20px">
								<input type='button' id='all_spectrum' value='{#$l10n.AllSpectrum#}' class='bluebtn'>
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
							<input type='button' id='barchart' value='{#$l10n.BarChart#}' class="bluebtn {#if $auto==true#}active{#/if#}"><br><br>
							<div id="series"></div>
						</div>
					</div>
				</div>
			<div style="margin: auto; margin-top: 10px; width: 520px;">
				<div id="info_intensity"><b>{#$l10n.Sensibility#}</b></div><div id="range_intensity"><input type="range" min=10 max=400 value=160 style="width: 380px;"></div>
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