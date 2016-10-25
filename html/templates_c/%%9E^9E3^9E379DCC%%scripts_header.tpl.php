<?php /* Smarty version 2.6.12, created on 2016-07-27 12:29:13
         compiled from edit/scripts_header.tpl */ ?>
			<script type="text/javascript" charset="windows-1251">
			//<![CDATA[	
				$(document).ready(function() {
				
					var locale="<?php echo $this->_tpl_vars['locale']; ?>
";
					
				    // Make slide search panel
					$(".btn-slide").click(function(){
						$("#panel").slideToggle("slow");
						$(this).toggleClass("active");
						$("#panel div").addClass('tpanel');
					});					
				});
				//]]>			
			</script>
			
	
			<?php if ($this->_tpl_vars['bodyclass'] == 'element'): ?>
				<script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>	
				<script type="text/javascript" src="/js/ckeditor/adapters/jquery.js"></script>
				<script type="text/javascript" charset="windows-1251" src="/js/edit_element.js" ></script>						
			<?php endif; ?>
			
			
			<?php if ($this->_tpl_vars['bodyclass'] == 'levels' || $this->_tpl_vars['bodyclass'] == 'transitions' || $this->_tpl_vars['bodyclass'] == 'bibliography'): ?>
				<link rel="stylesheet" type="text/css" href="/css/table.css" />
				<link rel="stylesheet" href="/css/jquery.autocomplete.css" type="text/css" />
				<link rel="stylesheet" href="/css/popuptext.css" type="text/css" />
				<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script> 
				<script type="text/javascript" src="/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
				<script type="text/javascript" src="/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>  				 				
				<script type="text/javascript" src="/js/jquery.autocomplete.min.js"></script>	
		
				<script type="text/javascript" >var locale="<?php echo $this->_tpl_vars['locale']; ?>
"; var energyValue = ""; var termmultiplyValue = ""; var isUpperOrLower = "";</script>
				
				<script type="text/javascript" charset="windows-1251">					

					var Tablelookup="<?php echo $this->_tpl_vars['l10n']['Table_lookup']; ?>
";
					var ExporttoExcel="<?php echo $this->_tpl_vars['l10n']['Export_to_Excel']; ?>
";
					var Search="<?php echo $this->_tpl_vars['l10n']['Search']; ?>
";
					var SaveLevels="Сохранить";
					var CreateLevel="Добавить";
					var DeleteLevels="Удалить";
				
					$("#btn_search").live("click",function(){
						$("#panel").slideToggle("slow");
						$(".btn-slide").toggleClass("active");
						$("#panel div").addClass('tpanel');
					});				
					
				</script>  				  				
				
				
  				<?php if ($this->_tpl_vars['bodyclass'] == 'levels'): ?>
  				<script type="text/javascript" src="/js/edit_levels.js"></script> 
  				<script type="text/javascript" src="/js/manage_source.js"></script>	
				<?php endif; ?>
  				
  				
				<?php if ($this->_tpl_vars['bodyclass'] == 'transitions'): ?>
  				<script type="text/javascript" src="/js/edit_transitions.js"></script>
  				<script type="text/javascript" src="/js/manage_source.js"></script>
				<?php endif; ?>
				
				<?php if ($this->_tpl_vars['bodyclass'] == 'bibliography'): ?>
				<script type="text/javascript" charset="windows-1251">
			var CheckType= function (source_type) {	
			
			switch (source_type) {
			
			case "j_article": 
				$('#article_name, #issue_name, #publisher, #year,  #publish_page, #link, #vol_num').show();
				$('#collection_type, #city, #publish_vol, #publish_tome,#page_num, #tome_num').hide();
		    break;
			case "c_article": 
				$('#article_name, #issue_name,#collection_type,#city, #publisher, #year, #publish_page, #link, #vol_num, #tome_num').show();
				$('#page_num, #publish_tome, #publish_vol').hide();
		    break;
			case "e_book":				
				$('#article_name,#link').show();
				$('#issue_name,#collection_type,#publish_tome, #city, #publisher, #year, #publish_vol, #publish_page,#page_num, #vol_num, #tome_num').hide();
		    break;
			case "book":				
				$('#issue_name, #city, #publisher, #year, #link, #page_num').show();
				$('#article_name,#collection_type,#publish_tome, #publish_vol, #publish_page, #vol_num, #tome_num').hide();
			break;
			case "journal":				
				$('#issue_name, #vol_num, #tome_num, #publisher, #year, #link, #page_num').show();
				$('#article_name, #city, #collection_type, #publisher, #publish_page,#publish_tome, #publish_vol').hide();
			break;
			case "collection":				
				$('#issue_name, #collection_type, #city, #publisher, #year, #link, #page_num,#tome_num,#vol_num').show();
				$('#article_name, #publish_page, #publish_tome, #publish_vol').hide();
			break;			
			}
		}
				</script>
				<script type="text/javascript" src="/js/edit_bibliography.js"></script>
				<script type="text/javascript" src="/js/manage_source.js"></script>	
			
				<?php endif; ?>
								 					
			<?php endif; ?>
			
 		<?php if ($this->_tpl_vars['bodyclass'] == 'diagramm'): ?>
	   											 					
		<?php endif; ?>			