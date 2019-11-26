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

						<div id="chartCont">
							<canvas id="canvas" width="600" height="600"></canvas>
						</div>

						<div id="container">

							<br><div class='resize'>
								<input type='button' id="resetZoom" value="Reset Zoom" class='bluebtn'>
								<input type='button' id="fullScreen" value="Full screen" class='bluebtn' onclick="resize(0)">
                                <input type="checkbox"  id="intens" value=1 onclick="click_intens()" checked>отображение интенсивности прозрачностью

							</div>


							<div id="scale">
								<div class="radio_buttons">
									<div>
										<input type="radio" name="option" id="eUp" checked/>
										<label for="eUp">y=E<sub>up</sub>, x=E<sub>d</sub></label>
									</div>
									<div>
										<input type="radio" name="option" id="parity"/>
										<label for="parity">parity_of_term</label>
									</div>
									<div>
										<input type="radio" name="option" id="eUp_eD"/>
										<label for="eUp_eD">y=E<sub>up</sub> - E<sub>d</sub>, x=E<sub>d</sub></label>
									</div>
								</div>
								<div id ="myForm">
									<input type="radio" name="myRadios"  value="1" checked/>[1/см]
									<input type="radio" name="myRadios"  value="2" />[э¬]
								</div>
							</div>
							<a id='compare' href='/{#$locale#}/compare/{#$layout_element_id#}'>{#$l10n.Compare#}</a>
							<a id='circle' href='/{#$locale#}/spectrum/{#$layout_element_id#}'>{#$l10n.Regular_spectrum#}</a>
							<a id='circle' href='/{#$locale#}/circle/{#$layout_element_id#}'>{#$l10n.Circle_spectrum#}</a>
						</div>

						<div id="canvas-holder" style="width: 300px;">
							<div id="chartjs-tooltip">
								<table></table>
							</div>
						</div>

						<script>
							{#if ($atom_json) #}
							var atom_json = {#$atom_json#};
							{#/if#}
                            {#if ($transitions_json) #}
                            var transitions_json = {#$transitions_json#};
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
					</div>
                    <div class="clear"> </div> <br><br><br><br>
