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
											<input type='button' id='visible' value='{#$l10n.VisibleSpectrum#}' class='bluebtn'><span style="width: 20px">
											<input type='button' id='all_spectrum' value='{#$l10n.AllSpectrum#}' class='bluebtn'>
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
							<div style="margin: auto; margin-top: 10px; width: 520px;">
								<div id="info_intensity"><b>{#$l10n.Sensibility#}</b></div><div id="range_intensity"><input type="range" min=10 max=400 value=160 style="width: 380px;"></div>
							</div>
							<div id='line_info'>
							</div>
							<div id="svg_wrapper" class="svg_wrapper_3">
							</div>
							<div id='map' style="display:none">
								<div id='preview'></div>
								<div id='map_now'></div>
							</div>
							<div style="position:relative;">
								<button onclick="resetZoom()" class="btn btn-default">Reset Zoom</button>
								<canvas id="canvas" style="background: #fff"></canvas>
								<div id="container-tooltip"></div>
								<img src="/images/gradient.png" alt="" id="gradient">
								<style>
									#container-tooltip {
										position:absolute;
										top:0;
										left:0;
									}
								</style>


								<pre>
        $pointStyle['forbidden'] = 'cross';
        $pointStyle[1] = 'circle';
        $pointStyle[3] = 'triangle';
        $pointStyle[5] = 'rect';
        $pointStyle[6] = 'star';
</pre>
								<script>

                                    window.onload = function() {
                                        var ctx = document.getElementById("canvas").getContext("2d");
                                        var image = document.getElementById('source');

                                        var dataline = [],
                                            pointBackgroundColors = [],
                                            levelsline = [],
                                            pointStyle = [],
                                            max_e,
                                            min_e,
                                            element;

                                        dataline = {#$dataline#};
                                        element = '{#$element_id#}';
                                        max_e = {#$max_e#};
                                        min_e = {#$min_e#};

                                        var img = [];
                                        img[0] = new Image();
                                        img[1] = new Image();
                                        img[2] = new Image();
                                        img[3] = new Image();
                                        img[4] = new Image();
                                        img[5] = new Image();
                                        img[6] = new Image();
                                        img[7] = new Image();
                                        img[0].src = '/images/0.png';
                                        img[1].src = '/images/1.png';
                                        img[2].src = '/images/2.png';
                                        img[3].src = '/images/3.png';
                                        img[4].src = '/images/4.png';
                                        img[5].src = '/images/5.png';
                                        img[6].src = '/images/6.png';
                                        var image = document.getElementById('gradient');

                                        for (var i = 0; i < dataline.length; i++) {
                                            pointBackgroundColors.push('rgba(' + dataline[i]['c']['R'] + ',' + dataline[i]['c']['G'] + ',' + dataline[i]['c']['B'] + ',' + dataline[i]['c']['A'] + ')');
                                            levelsline.push(dataline[i]['lu']);
//            pointStyle.push(img[dataline[i]['pointStyle']]);
//            pointStyle.push(ctx.drawImage(image, 33, 71, 104, 124, 21, 20, 87, 104));
                                        }


                                        var scatterChartData = {
                                            datasets: [
                                                {
                                                    type: 'scatter',
                                                    label: 'Точки ' + element,
                                                    data: dataline,
                                                    levelsline: levelsline,
                                                    pointBackgroundColor: pointBackgroundColors,
                                                    backgroundColor: pointBackgroundColors,
                                                    borderColor: 'rgba(0,0,0,0.1)',
                                                    pointStyle: pointStyle,
                                                    radius: 5
                                                    ,
                                                    showLine: false
                                                }, {
                                                    type: 'line',
                                                    label: 'Линия разделения нечетного/четного ',
                                                    borderColor: 'rgba(114,200,30,0.6)',
                                                    backgroundColor: 'rgb(114,200,30)',
                                                    data: [{
                                                        x: 0,
                                                        y: 0
                                                    }, {
//                    x: max_e,
//                    y: max_e
                                                        x: 100000,
                                                        y: 100000
                                                    }],
                                                    fill: false
                                                }
                                            ],

                                        };
                                        window.myChart = Chart.Scatter(ctx, {
                                            type: 'bar',
                                            data: scatterChartData,
                                            options: {
                                                tooltips: {
                                                    enabled: false,
                                                    callbacks: {
                                                        label: function(tooltipItem, data) {
                                                            if(tooltipItem.datasetIndex == 0) {
                                                                return tooltipItem.index, data.datasets[0].levelsline[tooltipItem.index];
                                                            }
                                                            return null;
                                                        },
                                                    },
                                                    custom: function(tooltipModel) {
                                                        // Tooltip Element





                                                        var tooltipEl = document.getElementById('chartjs-tooltip');

                                                        // Create element on first render
                                                        if (!tooltipEl) {
                                                            tooltipEl = document.createElement('div');
                                                            tooltipEl.id = 'chartjs-tooltip';
                                                            tooltipEl.innerHTML = "<table></table>"
//                            document.body.appendChild(tooltipEl);
                                                            document.getElementById('container-tooltip').appendChild(tooltipEl);
                                                        }

                                                        // Hide if no tooltip
                                                        if (tooltipModel.opacity === 0) {
                                                            tooltipEl.style.opacity = 0;
                                                            return;
                                                        }

                                                        // Set caret Position
                                                        tooltipEl.classList.remove('above', 'below', 'no-transform');
                                                        if (tooltipModel.yAlign) {
                                                            tooltipEl.classList.add(tooltipModel.yAlign);
                                                        } else {
                                                            tooltipEl.classList.add('no-transform');
                                                        }

                                                        function getBody(bodyItem) {
                                                            return bodyItem.lines;
                                                        }

                                                        // Set Text
                                                        if (tooltipModel.body) {
                                                            var titleLines = tooltipModel.title || [];
                                                            var bodyLines = tooltipModel.body.map(getBody);

                                                            var innerHtml = '<thead>';

                                                            titleLines.forEach(function(title) {
                                                                innerHtml += '<tr><th>' + title + '</th></tr>';
                                                            });
                                                            innerHtml += '</thead><tbody>';

                                                            bodyLines.forEach(function(body, i) {
                                                                var colors = tooltipModel.labelColors[i];
                                                                var style = 'background:' + 'rgb(255,0,0)';
                                                                style += '; border-color:' + 'rgb(255,0,0)';
                                                                style += '; border-width: 2px';
                                                                var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
                                                                innerHtml += '<tr><td>' + span + body + '</td></tr>';
                                                            });
                                                            innerHtml += '</tbody>';

                                                            var tableRoot = tooltipEl.querySelector('table');
                                                            tableRoot.innerHTML = innerHtml;
                                                        }

                                                        // `this` will be the overall tooltip
                                                        var position = this._chart.canvas.getBoundingClientRect();

                                                        // Display, position, and set styles for font
                                                        tooltipEl.style.opacity = 1;
                                                        //tooltipEl.style.left = /* position.left + */ tooltipModel.caretX + 'px';
                                                        //tooltipEl.style.top = /* position.top + */ tooltipModel.caretY + 'px';
                                                        tooltipEl.style.fontFamily = tooltipModel._fontFamily;
                                                        tooltipEl.style.fontSize = tooltipModel.fontSize;
                                                        tooltipEl.style.fontStyle = tooltipModel._fontStyle;
                                                        //tooltipEl.style.padding = (tooltipModel.yPadding - position.top)  + 'px ' + (tooltipModel.xPadding - position.left)  + 'px';

                                                    },
                                                },
                                                scales: {
                                                    yAxes: [{
                                                        ticks: {
//                            min: min_e.l,
                                                            max: max_e
//                            beginAtZero: true,
                                                        }
                                                    }],
                                                    xAxes: [{
                                                        ticks: {
//                            min: min_e.u,
                                                            max: max_e
//                            beginAtZero: true,
                                                        }
                                                    }],
                                                },
                                                pan: {
                                                    enabled: true,
                                                    mode: 'xy'
                                                },
                                                zoom: {
                                                    enabled: true,
                                                    mode: 'xy',
                                                    limits: {
                                                        max: 10,
                                                        min: 0.5
                                                    }
                                                },
                                            },
                                        });
                                    };
                                    function resetZoom() {
                                        window.myChart.resetZoom()
                                    }

								</script>
								<script>
                                    $(document).ready(function(){
                                        $(window).mousemove(function (pos) {
                                            $("#container-tooltip").css('left',(pos.offsetX+20)+'px').css('top',(pos.offsetY+20)+'px');
                                        });
                                    });
								</script>
							</div>
							<a id='compare' href='/{#$locale#}/compare/{#$layout_element_id#}'>{#$l10n.Compare#}</a>
							<a id='circle' href='/{#$locale#}/spectrum/{#$layout_element_id#}'>{#$l10n.Regular_spectrum#}</a>
							<button id="button" class="button white">{#$l10n.Download_PNG#}</button>
							<br><br>
							{#if $interface=='admin'#}
							<button id="uploadSpectrum" class="button white">Upload spectrum</button>
							{#/if#}
							<canvas id="canvas" height="600" width="800" style="display:none;"></canvas>

							<script>
								function triggerDownload (imgURI) {
									var evt = new MouseEvent('click', {
										view: window,
										bubbles: false,
										cancelable: true
									});

									var a = document.createElement('a');
									a.setAttribute('download', 'Circle spectrum {#$atom_name#} ' + $('#min').val() + ' - ' + $('#max').val() + ' A.png');
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

                                                 var imgURI = canvas
                                                .toDataURL('image/png')
                                                .replace('image/png', 'image/octet-stream');
                                            triggerDownload(imgURI);
									};
									svgImg.src = url;
/*
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
*/								});
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
