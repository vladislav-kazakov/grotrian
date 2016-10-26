			<script type="text/javascript" charset="utf-8">
			//<![CDATA[	
				$(document).ready(function() {
					var ions="{#$l10n.ions#}";
					var locale="{#$locale#}";
										
					{#*Установка кнопки элемента и ионов*#}
					{# if $layout_element_id #} 					
						var id={#$layout_element_id#};					
						$.post('/1ons.php',{ element_id: id } , function(data) {
	
							$('#ions').html(ions+data);														
						
							if (id == "2511" ) $('#ions').html('{#$l10n.isotopes#} <a href="2817" class="button white" >D<\/a><a href="39762" class="button white" >T<\/a>');
							if (id == "2817" ) $('#ions').html('{#$l10n.isotopes#} <a href="2511" class="button white" >H<\/a><a href="39762" class="button white" >T<\/a>');
							if (id == "39762" ) $('#ions').html('{#$l10n.isotopes#} <a href="2511" class="button white" >H<\/a><a href="2817" class="button white" >D<\/a>');															
						});												
					{#/if#}

				    // Make slide search panel
					$(".btn-slide").click(function(){
						$("#panel").slideToggle("slow");
						$(this).toggleClass("active");
						$("#panel div").addClass('tpanel');
					});

					var locale="{#$locale#}";
					
				});
				//]]>			
			</script>			
			{# if $bodyclass=="element0" #}
				<link rel="stylesheet" type="text/css" href="/js/ui/themes/smoothness/jquery.ui.all.css" />
				<link rel="stylesheet" type="text/css" href="/js/ui/themes/smoothness/jquery.ui.slider.css" />
				<link rel="stylesheet" type="text/css" href="/css/spectrum.css" />
	
				<script type="text/javascript" src="/js/ui/js/jquery.ui.core.js"></script>
				<script type="text/javascript" src="/js/ui/js/jquery.ui.widget.js"></script>
				<script type="text/javascript" src="/js/ui/js/jquery.ui.mouse.js"></script>
				<script type="text/javascript" src="/js/ui/js/jquery.ui.slider.js"></script>
				<script type="text/javascript" src="/js/spectrum/filter_spectrum.js"></script>
				<!--<script type="text/javascript" src="/js/element_en.js"></script>-->
	
				<script type="text/javascript">
					window.onload 	= init;
					function init(evt) {
					//SVGscale(1);
					SVGcontentMove(948);
					//SVGdocumentScale(1);
					sliderMax = 18750; {#*Максимальное значение слайдера*#}
					sliderMin = 0;  {#*Минимальное значение слайдера*#}
					}
				</script>
								 					
			{#/if#}
			
			{# if $bodyclass=="element" #}
				<link rel="stylesheet" type="text/css" href="/js/ui/themes/smoothness/jquery.ui.all.css" />
				<link rel="stylesheet" type="text/css" href="/js/ui/themes/smoothness/jquery.ui.slider.css" />
				<link rel="stylesheet" type="text/css" href="/css/spectrum2.css" />
				
				<script type="text/javascript" src="/js/spectrum2/dragnwheel.js"></script>
					
				<script type="text/javascript" src="/js/ui/js/minified/jquery.ui.core.min.js"></script>
				<script type="text/javascript" src="/js/ui/js/minified/jquery.ui.widget.min.js"></script>
				<script type="text/javascript" src="/js/ui/js/minified/jquery.ui.mouse.min.js"></script>
				<script type="text/javascript" src="/js/ui/js/minified/jquery.ui.slider.min.js"></script>

				<script type="text/javascript" src="/js/spectrum2/jquery.svg.min.js"></script>
				<script type="text/javascript" src="/js/spectrum2/jquery.svgdom.min.js"></script>

				<script type="text/javascript" src="/js/spectrum2/spectrum.js"></script>
	
				<script type="text/javascript">
				$(document).ready(function() {						
					var spectr_list={#$spectrum_json#};	
					spectrum(spectr_list);		
				});		
				</script>
								 					
			{#/if#}
			
			
			{# if $bodyclass=="levels" || $bodyclass=="transitions"#}
				<link rel="stylesheet" type="text/css" href="/css/table.css" />
				<script type="text/javascript" src="/js/jquery.dataTables.js"></script> 
				<script type="text/javascript" src="/js/tablexport.js"></script>				
  				{# if $bodyclass=="levels" #}
  				<script type="text/javascript" src="/js/levels2.js"></script>
  				
  				{# /if #}
  				
				{# if $bodyclass=="transitions" #}
				<script type="text/javascript" src="/js/transitions.js"></script>
				{#/if#}

				<script type="text/javascript" charset="utf-8">
					var locale="{#$locale#}";

					var Tablelookup="{#$l10n.Table_lookup#}";
					var ExporttoExcel="{#$l10n.Export_to_Excel#}";
					
					$("#btn_search").live("click",function(){
						$("#panel").slideToggle("slow");
						$(".btn-slide").toggleClass("active");
						$("#panel div").addClass('tpanel');
					});
					
					/* Add a click handler to the rows - this could be used as a callback */	

	    			$("#table1 tr").live("click", function(){
				    	if ( $(this).hasClass('row_selected') )
							$(this).removeClass('row_selected');
						else
							$(this).addClass('row_selected');
				    });					
				</script>
								 					
			{#/if#}
			
 		{# if $bodyclass=="diagramm"#}
	   											 					
		{#/if#}			