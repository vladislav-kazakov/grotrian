    				<div class="container_12">
						{#if ($transition_count != 0)#}
                        <div class="grid_12" id="main">
                            <div class="brake"></div>
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
                                            <input type='button' id='filter' value='OK' class="bluebtn" onclick="show_selected()">
                                        </div>
                                        <div id='visible_container' style="clear:both; margin-top: 10px;">
                                            <input type='button' id='visible' value='{#$l10n.VisibleSpectrum#}' class='bluebtn'  onclick="show_visible()"><span style="width: 20px"></span>
                                            <input type='button' id='all_spectrum' value='{#$l10n.AllSpectrum#}' class='bluebtn' onclick="show_all()">
                                        </div>

                                    </div>
                                    <div id='zoom_container' style="display:none">
                                        <b>{#$l10n.Scale#}</b><br>
                                        <input type='button' id='x1' value='1' class='bluebtn base active'>
                                        <input type='button' value='10' class='bluebtn base'>
                                        <input type='button' value='100' class='bluebtn base'>
                                        <br><br>
                                        <input type='button' id='x2' value='x2' class="bluebtn {#if $auto==true#}active{#/if#}">
                                        <input type='button' value='x5' class="bluebtn">
                                    </div>
                                    <div>
                                        <input type='button' id='barchart' style="display:none" value='{#$l10n.BarChart#}' class="bluebtn {#if $auto==true#}active{#/if#}"><br><br>
                                        <div id="series"></div>
                                    </div>
                                </div>

                            </div>
					    </div>
					</div>
						<div class="clear"> </div>
						<div id="chartCont" class="chartCont">
							<canvas id="canvas" width="600" height="600"></canvas>
						</div>

						<div class="tools">
							<div class="nav">
								<div id="chartZoom" class="chartZoom" >
									<canvas id="zoom_chart" width="250" height="200"></canvas>
								</div>
							</div>
							<div class="nav">
								<table border="0">
									<tbody>
									<tr>
										<td><b>lower level: </b></td>
										<td id="low_l"></td>
									</tr>
									<tr>
										<td><b>upper level: </b></td>
										<td id="up_l"></td>
									</tr>
									</tbody>
								</table>
							</div>
							<div id="first_cont">
								<div class="nav">
									<input type='button' id="resetZoom" value="Reset Zoom" >
								</div>
								<div class="nav">
									<input type='button' id="fullScreen" value="Full screen" onclick="resize(1)">
								</div>
								<div class="nav">
									<input type="radio" name="myRadios"  value="1" checked/>[1/cm]
									<input type="radio" name="myRadios"  value="2" />[eV]
								</div>
							</div>
							<div id="second_cont">
								<div class="nav">
									<div class="radio_buttons">
										<div>
											<input type="radio" name="option" id="eUp" checked>
											<label for="eUp" >y=E<sub>up</sub>, x=E<sub>l</sub></label>
										</div>
										<div>
											<input type="radio" name="option" id="parity"/>
											<label for="parity">Parity of term</label>
										</div>
										<div>
											<input type="radio" name="option" id="eUp_eD"/>
											<label for="eUp_eD">y=E<sub>up</sub> - E<sub>l</sub>, x=E<sub>l</sub></label>
										</div>
									</div>
								</div>
							</div>
							<div class="nav">
								<input type="checkbox"  id="intens" value=1 onclick="click_intens()" checked>display intensity by transparency
							</div>
							<div class="nav">
								<input type="checkbox"  id="random" value=1 onclick="click_random()"> display multiplets
							</div>
							<div class="nav">
								<table>
									<tr>
										<td>
											Show Width:
										</td>
										<td>
											<input type="radio" name="width" value="1"/>configuration<br>
											<input type="radio" name="width" value="2"/>
											configurations with atomic residues<br>
											<input type="radio" name="width" value="3"/>terms<br>
											<input type="radio" name="width" value="4" checked/>---<br>
										</td>
									</tr>
								</table>
							</div>
						</div>



						<div id="canvas-holder" style="width: 300px;">
							<div id="chartjs-tooltip">
								<table></table>
							</div>
						</div>

						<div id="canvas-holder1" style="width: 300px;">
							<div id="zoom-tooltip">
								<table></table>
							</div>
						</div>

						<script>
                            var atom = {};
							{#if ($atom_json) #}
							var atom_json = {#$atom_json#};
							atom.atom = atom_json;
							{#/if#}
                            {#if ($transitions_json) #}
                            var transitions_json = {#$transitions_json#};
                            atom.transitions = transitions_json;
                            {#/if#}
                            {#if ($levels_json) #}
                            var levels_json = {#$levels_json#};
                            atom.levels = levels_json;
                            {#/if#}

						</script>
						<script src="/js/cf.js?v2"></script>


						{#else#}
						<div class="brake"></div>
						<div>
							{#$l10n.No_transitions#}
						</div>
						{#if $auto==true#}
						<script>
							document.location.replace("/admin/{#$locale#}/spectrum/{#$next_element_id#}/auto");
						</script>
						{#/if#}
						{#/if#}
                    <div class="clear"> </div> <br><br><br><br>
