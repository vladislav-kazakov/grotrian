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
							<a id='compare' href='/{#$locale#}/compare/{#$layout_element_id#}'>{#$l10n.Compare#}</a> <button id="button" class="button white">{#$l10n.Download_PNG#}</button>
							<br><br>
							{#if $interface=='admin'#}
							<button id="uploadSpectrum" class="button white">Upload spectrum</button>
							{#/if#}
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
								{#if $interface=='admin'#}
								var uploadSpectrumBtn = document.getElementById('uploadSpectrum');
								uploadSpectrumBtn.addEventListener('click', function () {
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

									var svgUploadImg = new Image();
									svgUploadImg.onload = function () {
										var canvas = document.getElementById('canvas');
										canvas.height = 120;
										var ctx = canvas.getContext('2d');
										ctx.drawImage(svgUploadImg, 0, 0);
										DOMURL.revokeObjectURL(url);

//										var imgURI = canvas
//												.toDataURL('image/png')
//												.replace('image/png', 'image/octet-stream');

										canvas.toBlob(function (blob) {
											var fd = new FormData();
											fd.append('fname', 'spectrum.png');
											fd.append('action', 'makeSpectrogram');
											fd.append('atom_id', '{#$layout_element_id#}');
											fd.append('imgMedia', blob);
											$.ajax({
												type: 'POST',
												url: '/element_admin.php',
												data: fd,
												processData: false,
												contentType: false
											}).done(function(data) {
												{#if $auto==true#}
													//alert("1");
													next();
												{#else#}
													alert("Data uploaded!");
												{#/if#}
											});
										});
									};
									svgUploadImg.src = url;
								});
								{#if $auto==true#}
								function next() {
									document.location.replace("/admin/{#$locale#}/spectrum/{#$next_element_id#}/auto");
								}
								window.onload = function() {
									if (lines_count > 0)
										uploadSpectrumBtn.click();
									else next();
								}
								{#/if#}
								{#/if#}
							</script>
	 					</div>
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
                    <div class="clear">  </div>
