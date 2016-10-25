<script type="text/javascript" charset="windows-1251">
	$(document).ready(function() {
//On clicking in some area - close periodical table
		$("html").click(function(){
			$(".element_picker").hide("fast");					
		});					
//После нажатия на ссылку генерируем ссылки у элементов 
		{# if $bodyclass=="index" || $bodyclass=="bibliography" #}
			$("#menu_primary ul li").click(function(){
				var link = $(':first-child', this).val();
					$(".plink").each(function() {
					//$(this).attr('href', '/{#$locale#}/'+$(this).attr("href"));
					$(this).attr('href', '/{#$locale#}/'+link+'/'+$(':first-child', this).val());
					//$(this).attr('href', '/{#$locale#}/'+link+'/'+$(this).attr("tabindex"));
				});					

				var position = $(this).offset();						
				$(".element_picker").css({'top': position.top, 'left': position.left});					
				$(".element_picker").show("fast");
				return false;
			});
		{#/if#}
		{#if $bodyclass!="index"#}
			$("#element_btn").click(function(){					
				var link = "{#$bodyclass#}";
				$(".plink").each(function() {								
			   		//var id= $(this).find(".pname").attr("id");
					//$(this).attr('href', '/{#$locale#}/'+link+'/'+id);
					$(this).attr('href', '/{#$locale#}/'+link+'/'+$(':first-child', this).val());	
					//$(this).attr('href', '/{#$locale#}/'+link+'/'+$(this).attr("tabindex"));
				});
							  						
				var position = $(this).offset();						
				$(".element_picker").css({'top': position.top, 'left': position.left});					
				$(".element_picker").show("fast");
				return false;
			});
		{#/if#}
	});
</script>
</head>

<body class="{#$bodyclass#}">
	<div id="wrapper">
		<div id="header">
			<div class="container_12">	
				<div id="logo" class="grid_2">
					<a href="/{#$locale#}" title="{#$l10n.Information_system_Electronic_structure_of_atoms#}"><img title="" src="/images/logo.png" alt="{#$l10n.Information_system_Electronic_structure_of_atoms#}" /></a>	        
				</div>
				<div class="grid_10">
		        	<h1>{#$l10n.Information_system_Electronic_structure_of_atoms#}</h1>
		        </div>
		        <div class="locale">
		        	<a {# if $locale=='ru'#}id="act"{#/if#} class="ru_lang" href="/ru/{# if $bodyclass!='index'#}{#$bodyclass#}/{#/if#}{#$layout_element_id#}">RU</a> <a {# if $locale=='en'#}id="act"{#/if#} class="en_lang" href="/en/{# if $bodyclass!='index'#}{#$bodyclass#}/{#/if#}{#$layout_element_id#}">EN</a>
	        	</div>            		
			</div>              
		</div>
<!--End of Header-->            
	<div id="menu">
		<div class="container_12">
			<div class="grid_7" id="menu_primary">					
				<ul>
				{# if $layout_element_id #}
					<li class="menu_elements"><input type="hidden" name="section" value="element" /><a href="/{#$locale#}/element/{#$layout_element_id#}">{#$l10n.Elements#}</a></li>  
					<li class="menu_levels"><input type="hidden" name="section" value="levels" /><a href="/{#$locale#}/levels/{#$layout_element_id#}">{#$l10n.Levels#}</a></li>
					<li class="menu_transitions"><input type="hidden" name="section" value="transitions" /><a href="/{#$locale#}/transitions/{#$layout_element_id#}">{#$l10n.Transitions#}</a></li>  
					<li class="menu_diagrams"><input type="hidden" name="section" value="diagramm" /><a href="/{#$locale#}/diagramm/{#$layout_element_id#}">{#$l10n.Charts#}</a></li> 
				{#else#}
					<li class="menu_elements"><input type="hidden" name="section" value="element" /><a href="/{#$locale#}/element/">{#$l10n.Elements#}</a></li>
					<li class="menu_levels"><input type="hidden" name="section" value="levels" /><a href="/{#$locale#}/levels/">{#$l10n.Levels#}</a></li>
					<li class="menu_transitions"><input type="hidden" name="section" value="transitions" /><a href="/{#$locale#}/transitions/">{#$l10n.Transitions#}</a></li>
					<li class="menu_diagrams"><input type="hidden" name="section" value="diagramm" /><a href="/{#$locale#}/element/">{#$l10n.Charts#}</a></li> 
				{#/if#}                                              
				</ul>
			</div>
			<div id="menu_secondary">
				{# if $locale=="ru" #}	
					<ul class="dropdown dropdown-horizontal">
						<li>
							<a href="/ru/" class="dir">О проекте</a>
							<ul>
								<li><a href="/ru/">Описание</a></li>									
								<li><a href="/ru/team/">Коллектив</a></li>
								<li><a href="/ru/articles/">Публикации</a></li>									
								<li><a href="/ru/sponsors/">Спонсоры</a></li>
								<li><a href="/ru/awards/">Награды</a></li>
							</ul>
						</li>
							
						<li><a href="/ru/bibliography/">Библиография</a></li>
						<li><a href="/ru/links/">Ссылки</a></li>
						<li><a href="/ru/periodictable/">Таблица</a></li>			
					</ul>
				{#/if#}					
				{# if $locale=="en" #}                       
					<ul class="dropdown dropdown-horizontal">
						<li>
							<a href="/en/" class="dir">About</a>
							<ul>
								<li><a href="/en/articles/">Articles</a></li>									
							</ul>
						</li>
						<li><a href="/en/links/">Links</a></li>
						<li><a href="/en/periodictable/">Table</a></li>		
					</ul>
				{#/if#}				
				</div>					
			</div>
		</div>
<!--End of menu-->
		<div class="container_12">
			<div class="grid_12">
	  		  	<h2>
                 	{#$headline#}
					{# if $ions #}
						<span class="button white selected" id="element_btn">{#$layout_element_name#}</span><span id="ions">                        
						{#if $layout_element_id == "2511" #}
							{#$l10n.isotopes#} <a href="2817" class="button white" >D</a><a href="39762" class="button white" >T</a>
                        {#elseif $layout_element_id == "2817" #}
							{#$l10n.isotopes#} <a href="2511" class="button white" >H</a><a href="39762" class="button white" >T</a>                                                                        
                        {#elseif $layout_element_id == "39762" #}
                        	{#$l10n.isotopes#} <a href="2511" class="button white" >H</a><a href="2817" class="button white" >D</a>                        
                        {#else#}                       
                           	{#$l10n.ions#}
                        	{#foreach from=$ions key=myId item=ion#}
                        		{#if $ion.ID==$layout_element_id#}
                        			<a href="{#$ion.ID#}" class="button white ions selected" >
                        			{#else#}
                        			<a href="{#$ion.ID#}" class="button white ions" >
                        		{#/if#}
                        		{#$ion.IVAL+1|toRoman#}</a>
                       		{#/foreach#}
						{#/if#}
					</span>                        		                        		
                  	{#/if#}
                </h2>    
			</div>
		</div>
    	<div class="clear"></div>		