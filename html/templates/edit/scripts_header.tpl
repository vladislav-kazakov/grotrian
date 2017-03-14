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
			
	{# if $bodyclass=="spectrum"#}
	<link rel="stylesheet" type="text/css" href="/css/spectrum2.css?v2" />
	<script type="text/javascript" src="/js/spectrum2/init.js?v2"></script>
	{# if $pagetype == "compare" #}
	<script type="text/javascript" src="/js/spectrum2/compare.js?v2"></script>
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
				<link rel="stylesheet" href="/js/jquery-autocomplete/jquery.autocomplete.css" type="text/css" />
				<link rel="stylesheet" href="/css/popuptext.css" type="text/css" />
				<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
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
  				<script type="text/javascript" src="/js/edit_levels.js?v3"></script>
  				<script type="text/javascript" src="/js/manage_source.js?v2"></script>
				{# /if #}
  				
  				
				{# if $bodyclass=="transitions" #}
  				<script type="text/javascript" src="/js/edit_transitions.js?v2"></script>
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