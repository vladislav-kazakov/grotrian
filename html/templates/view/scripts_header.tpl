<script type="text/javascript" charset="windows-1251">
	//<![CDATA[
	$(document).ready(function() {
		var locale="{#$locale#}";
		// Make slide search panel
		$(".btn-slide").click(function(){
			$("#panel").slideToggle("slow");
			$(this).toggleClass("active");
			$("#panel div").addClass('tpanel');
		});	

		$("a.source_link").fancybox({
			'hideOnContentClick': false,
			'overlayColor'		: '#000',
			'overlayOpacity'	: 0.8
		});						
	});
	jQuery.ajax({
		type: "POST",
		url: location.protocol+ "/counter",
		data: {"uri": location.href, "user_agent": navigator.userAgent},
		success: function(data){
			if(data) console.log( "Прибыли данные: " + data  );
		}
	});
	//]]>			
</script>

{#*Оставлено как я вставлял старый спектроскоп*#}
{# if $bodyclass=="element0" #}
<link rel="stylesheet" type="text/css" href="/js/ui/themes/smoothness/jquery.ui.all.css" />
<link rel="stylesheet" type="text/css" href="/js/ui/themes/smoothness/jquery.ui.slider.css" />
<link rel="stylesheet" type="text/css" href="/css/spectrum.css" />

<script type="text/javascript" src="/js/ui/js/jquery.ui.core.js"></script>
<script type="text/javascript" src="/js/ui/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/js/ui/js/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="/js/ui/js/jquery.ui.slider.js"></script>
<script type="text/javascript" src="/js/spectrum/filter_spectrum.js"></script>

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

	{# if $bodyclass=="spectrum" || $bodyclass=="element"#}
	<link rel="stylesheet" type="text/css" href="/css/spectrum2.css" />
	<script type="text/javascript" src="/js/spectrum2/init.js"></script>
	{# if $pagetype == "compare" #}
	<script type="text/javascript" src="/js/spectrum2/compare.js"></script>
	{#/if#}
	
	<script type="text/javascript">
		$(document).ready(function() {						
			var spectr_list={#$spectrum_json#};
			init(spectr_list);
			$(document).on('click', '#filter', function() {
				init(spectr_list);
			});
			{# if $pagetype == "compare" #}
			var spectr_list_uploaded = {#$spectrum_json_uploaded#};
			if (spectr_list_uploaded) {
				init(spectr_list_uploaded, 2);
				$(document).off('click', '#filter');
				$(document).on('click', '#filter', function() {

					init(spectr_list);
					init(spectr_list_uploaded, 2);
				});
			}
			{#/if#}

		});		
	</script>

	{#/if#}

	{# if $bodyclass=="levels" || $bodyclass=="transitions" || $bodyclass=="bibliography"#}
	<link rel="stylesheet" type="text/css" href="/css/table.css" />
	<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script> 
	<script type="text/javascript" src="/js/tablexport.js"></script>	
	<script type="text/javascript" charset="windows-1251">var locale="{#$locale#}";</script>
	
	{# if $bodyclass=="levels" #}
	<script type="text/javascript" charset="windows-1251" src="/js/levels.js"></script> 				
	{# /if #}

	{# if $bodyclass=="transitions" #}
	<script type="text/javascript" src="/js/transitions.js"></script>
	{#/if#}

	<script type="text/javascript" charset="windows-1251">					

		var Tablelookup="{#$l10n.Table_lookup#}";
		var ExporttoExcel="{#$l10n.Export_to_Excel#}";
		var Search="{#$l10n.Search#}";

		$(document).on("click", "#btn_search", function(){
			$("#panel").slideToggle("slow");
			$(".btn-slide").toggleClass("active");
			$("#panel div").addClass('tpanel');
		});

		/* Add a click handler to the rows - this could be used as a callback */	
		$(document).on("click", ".display tr", function(){
			if ( $(this).hasClass('row_selected') )	$(this).removeClass('row_selected');
			else $(this).addClass('row_selected');
		});					
	</script>	

	{#/if#}

	{#*Вот эти файлы пока не надо вставлять в диаграммы, временно закомментил*#}
	{# if $bodyclass=="diagram"#}
	<!--script type="text/javascript" src="/js/grotrian_chart.js"></script>
	<script type="text/javascript" src="/js/jquery.svg.js"></script-->
		{#/if#}		


		
		{# if $bodyclass=="bibliography" #}
		<script type="text/javascript" src="/js/bibliography.js"></script>
		{#/if#}

		{# if $bodyclass=="periodictable" #}
		<script type="text/javascript" src="/js/periodic_table.js"></script>
		{#/if#}