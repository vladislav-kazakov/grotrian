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
		$(".various").fancybox({
				fitToView	: false,
				width		: 500,
				height		: 200,
				autoSize	: false,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'}
		);
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

	{# if $bodyclass=="spectrum" || $bodyclass=="compare"#}
	<link rel="stylesheet" type="text/css" href="/css/spectrum2.css?v2" />
	<script type="text/javascript" src="/js/spectrum2/init.js?v3"></script>
	{# if $pagetype == "compare" #}
	<script type="text/javascript" src="/js/spectrum2/compare.js?v2"></script>
	{#/if#}
	
	<script type="text/javascript">
		var spectr_list, spectr_list_uploaded;
		var e_count = "{#$e_count#}";
		var i_AllLines = "{#$l10n.AllLines#}";
		var i_PrincipalSeries = "{#$l10n.PrincipalSeries#}";
		var i_SharpSeries = "{#$l10n.SharpSeries#}";
		var i_DiffuseSeries = "{#$l10n.DiffuseSeries#}";
		var i_FundamentalSeries = "{#$l10n.FundamentalSeries#}";
		var i_LymanSeries = "{#$l10n.LymanSeries#}";
		var i_BalmerSeries = "{#$l10n.BalmerSeries#}";
		var i_PaschenSeries = "{#$l10n.PaschenSeries#}";
		var i_BrackettSeries = "{#$l10n.BrackettSeries#}";
		var i_PfundSeries = "{#$l10n.PfundSeries#}";
		var i_HumphreysSeries = "{#$l10n.HumphreysSeries#}";
		var i_Wavelength = "{#$l10n.Wavelength#}";
		var i_Intensity = "{#$l10n.Intensity#}";
		var i_Levels = "{#$l10n.Levels#}";


		function init_all() {
			var element_name = "{#$atom_name#}";
			var base_level = "{#$base_level#}";
			level_list={#$levels_json#};
			init(spectr_list, element_name, base_level);
			init_levels(level_list);
			{# if $pagetype == "compare" #}
			if (spectr_list_uploaded) init(spectr_list_uploaded, element_name, base_level, 2);
			{#/if#}
		}
		$(document).ready(function() {

			spectr_list={#$spectrum_json#};
			{# if $pagetype == "compare" #}
			spectr_list_uploaded = {#$spectrum_json_uploaded#};
			{#/if#}
			init_all();
			$(document).on('click', '#filter', function() {
				init_all();
			});

		});		
	</script>

	{#/if#}

	{# if $bodyclass=="levels" || $bodyclass=="transitions" || $bodyclass=="bibliography"#}
	<link rel="stylesheet" type="text/css" href="/css/table.css" />
	<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script> 
	<script type="text/javascript" src="/js/tablexport.js"></script>
	<script type="text/javascript" src="/js/bibtex_js.js"></script>

	<script type="text/javascript" charset="windows-1251">var locale="{#$locale#}";</script>
	
	{# if $bodyclass=="levels" #}
	<script type="text/javascript" charset="windows-1251" src="/js/levels.js?v3"></script>
	{# /if #}

	{# if $bodyclass=="transitions" #}
	<script type="text/javascript" src="/js/transitions.js?v2"></script>
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


	{# if $bodyclass=="bibliography" #}
	<script type="text/javascript" src="/js/bibliography.js?v2"></script>
	{#/if#}

	{# if $bodyclass=="periodictable" #}
	<script type="text/javascript" src="/js/periodic_table.js?v2"></script>
	{#/if#}