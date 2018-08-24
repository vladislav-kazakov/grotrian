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
				//]]>			
			</script>
			
	
			{# if $bodyclass=="element" #}
				<script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>	
				<script type="text/javascript" src="/js/ckeditor/adapters/jquery.js"></script>
				<script type="text/javascript" charset="windows-1251" src="/js/edit_element.js?v2" ></script>
			{#/if#}
			
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
					init(spectr_list, element_name, base_level);
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

			{# if $bodyclass=="levels" || $bodyclass=="transitions" ||$bodyclass=="bibliography"#}
			<script type="text/javascript" src="/js/jquery.dataTables-1.10.15.min.js"></script>
				{# /if #}

			{# if $bodyclass=="levels" || $bodyclass=="transitions" || $bodyclass=="bibliography"#}
				<link rel="stylesheet" type="text/css" href="/css/table.css" />
				<link rel="stylesheet" href="/js/jquery-autocomplete/jquery.autocomplete.css" type="text/css" />
				<link rel="stylesheet" href="/css/popuptext.css" type="text/css" />
				<script type="text/javascript" src="/js/jquery-autocomplete/jquery.autocomplete.min.js"></script>
				<script type="text/javascript" src="/js/bibtex_js.js"></script>

				<script type="text/javascript" >var locale="{#$locale#}"; var energyValue = ""; var termmultiplyValue = ""; var isUpperOrLower = "";</script>
				
				<script type="text/javascript" charset="windows-1251">					

					var Tablelookup="{#$l10n.Table_lookup#}";
					var ExporttoExcel="{#$l10n.Export_to_Excel#}";
					var Search="{#$l10n.Search#}";
					var SaveLevels="Сохранить";
					var CreateLevel="Добавить";
					var DeleteLevels="Удалить";

					$(document).on("click", "#btn_search", function(){
						$("#panel").slideToggle("slow");
						$(".btn-slide").toggleClass("active");
						$("#panel div").addClass('tpanel');
					});				
					
				</script>  				  				
				
				
  				{# if $bodyclass=="levels" #}
  				<script type="text/javascript" src="/js/edit_levels.js?v5"></script>
  				<script type="text/javascript" src="/js/manage_source.js?v2"></script>
				{# /if #}
  				
  				
				{# if $bodyclass=="transitions" #}
  				<script type="text/javascript" src="/js/edit_transitions.js?v5"></script>
  				<script type="text/javascript" src="/js/manage_source.js?v2"></script>
				{#/if#}
				
				{# if $bodyclass=="bibliography" #}
				<script type="text/javascript" charset="windows-1251">
			var CheckType= function (source_type) {	
			
			switch (source_type) {

				case "j_article":
					$('#article_name, #issue_name, #publisher, #year,  #publish_page, #link, #vol_num, #bibtex').show();
					$('#collection_type, #city, #publish_vol, #publish_tome,#page_num, #tome_num').hide();
					break;
				case "c_article":
					$('#article_name, #issue_name,#collection_type,#city, #publisher, #year, #publish_page, #link, #vol_num, #tome_num, #bibtex').show();
					$('#page_num, #publish_tome, #publish_vol').hide();
					break;
				case "e_book":
					$('#article_name,#link, #bibtex').show();
					$('#issue_name,#collection_type,#publish_tome, #city, #publisher, #year, #publish_vol, #publish_page,#page_num, #vol_num, #tome_num').hide();
					break;
				case "book":
					$('#issue_name, #city, #publisher, #year, #link, #page_num, #bibtex').show();
					$('#article_name,#collection_type,#publish_tome, #publish_vol, #publish_page, #vol_num, #tome_num').hide();
					break;
				case "journal":
					$('#issue_name, #vol_num, #tome_num, #publisher, #year, #link, #page_num, #bibtex').show();
					$('#article_name, #city, #collection_type, #publisher, #publish_page,#publish_tome, #publish_vol').hide();
					break;
				case "collection":
					$('#issue_name, #collection_type, #city, #publisher, #year, #link, #page_num,#tome_num,#vol_num, #bibtex').show();
					$('#article_name, #publish_page, #publish_tome, #publish_vol').hide();
					break;
				case "bibtex":
					$('#bibtex').show();
					$('#issue_name,#collection_type,#publish_tome, #city, #publisher, #year, #publish_vol, #publish_page,#page_num, #vol_num, #tome_num,#article_name,#link').hide();
					break;
			}
		}
				</script>
				<script type="text/javascript" src="/js/edit_bibliography.js?v2"></script>
				<script type="text/javascript" src="/js/manage_source.js?v2"></script>
			
				{#/if#}
								 					
			{#/if#}
			
 		{# if $bodyclass=="diagram"#}
	   											 					
		{#/if#}

		{# if $bodyclass=="periodictable" #}
		<script type="text/javascript" src="/js/periodic_table.js?v2"></script>
		{#/if#}