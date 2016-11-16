    				<div class="container_12">
						{#if ($transition_count != 0)#}
						<div class="grid_12" id="main">
							<div class="brake"></div>
							<div>
								<div id='toolbar'>
									<div id='range'>
										<div id='min_container'>
											<b>{#$l10n.MinLength#}</b><br>
											<input type='text' id='min' value='0'>
										</div>
										<div id='max_container'>
											<b>{#$l10n.MaxLength#}</b><br>
											<input type='text' id='max' value='30000'>
										</div>
									</div>
									<div id='zoom_container'>
										<b>{#$l10n.Scale#}</b><br>
										<input type='button' value='1' class='base active'>
										<input type='button' value='10' class='base'>
										<input type='button' value='100' class='base'>
										<br><br>
										<input type='button' value='x2'>
										<input type='button' value='x5'>
									</div>
									<div>
									<input type='button' id='filter' value='{#$l10n.Apply#}'><br><br>
									<input type='button' id='barchart' value='{#$l10n.BarChart#}'>
										</div>
								</div>
							</div>
							<div style="margin: auto; margin-top: 10px; width: 520px;">
								<div id="info_intensity"><b>{#$l10n.Sensibility#}</b><!-- <input type="number" min=0 id="value"> <div id="value" style="display: inline-block;"></div> --></div><div id="range_intensity"></div>
							</div>
							<div id='line_info'>
							</div>
							<div id="svg_wrapper">
							</div>
							<div id='map'>
								<div id='preview'></div>
								<div id='map_now'></div>
							</div>
							<a id='compare' href='/{#$locale#}/compare/{#$layout_element_id#}'>{#$l10n.Compare#}</a> <button id="button" class="button white">{#$l10n.Download_PNG#}</button>
							<br><br>



							<canvas id="canvas" height="150" style="display:none;"></canvas>

							<script>
								function triggerDownload (imgURI) {
									var evt = new MouseEvent('click', {
										view: window,
										bubbles: false,
										cancelable: true
									});

									var a = document.createElement('a');
									a.setAttribute('download', 'Spectrum {#$atom_name#} ' + $('#min').val() + ' - ' + $('#max').val() + ' A.png');
									a.setAttribute('href', imgURI);
									a.setAttribute('target', '_blank');

									a.dispatchEvent(evt);
								}

								var btn = document.getElementById('button');
								btn.addEventListener('click', function () {
									var svg = document.getElementById('svg');
									var data = (new XMLSerializer()).serializeToString(svg);
									var svgBlob = new Blob([data], {type: 'image/svg+xml;charset=utf-8'});

									var DOMURL = window.URL || window.webkitURL || window;
									var url = DOMURL.createObjectURL(svgBlob);

									var rulerSvg = document.getElementById('ruler');
									var rulerData = (new XMLSerializer()).serializeToString(rulerSvg);
									var rulerSvgBlob = new Blob([rulerData], {type: 'image/svg+xml;charset=utf-8'});

									var rulerDOMURL = window.URL || window.webkitURL || window;
									var rulerUrl = rulerDOMURL.createObjectURL(rulerSvgBlob);

									var rulerImgLoaded = false;
									var svgImgLoaded = false;

									var svgImg = new Image();
									svgImg.onload = function () {
										var canvas = document.getElementById('canvas');
										var ctx = canvas.getContext('2d');
										ctx.drawImage(svgImg, 0, 0);
										DOMURL.revokeObjectURL(url);

										if (rulerImgLoaded){
											var imgURI = canvas
													.toDataURL('image/png')
													.replace('image/png', 'image/octet-stream');
											triggerDownload(imgURI);
										}
										else svgImgLoaded = true;
									};
									svgImg.src = url;

									var rulerImg = new Image();
									rulerImg.onload = function () {
										var canvas = document.getElementById('canvas');
										var ctx = canvas.getContext('2d');
										ctx.drawImage(rulerImg, 0, 120);
										rulerDOMURL.revokeObjectURL(rulerUrl);
										if (svgImgLoaded){
											var imgURI = canvas
													.toDataURL('image/png')
													.replace('image/png', 'image/octet-stream');
											triggerDownload(imgURI);
										}
										else rulerImgLoaded = true;
									};
									rulerImg.src = rulerUrl;

								});
							</script>
	 					</div>
						{#else#}
						<div class="brake"></div>
						<div>
							{#$l10n.No_transitions#}
						</div>
						{#/if#}
					</div>
                    <div class="clear">  </div>
</div>
<!--End of Main -->
	
			<div class="clear"></div>
			<div id="empty"></div> 
		</div>
<!--End of wrapper--> 
