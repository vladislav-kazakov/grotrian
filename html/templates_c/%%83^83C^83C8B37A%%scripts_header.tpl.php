<?php /* Smarty version 2.6.12, created on 2016-07-27 11:22:22
         compiled from view/scripts_header.tpl */ ?>
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

<?php if ($this->_tpl_vars['bodyclass'] == 'element0'): ?>
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
			sliderMax = 18750; 			sliderMin = 0;  		}
	</script>

	<?php endif; ?>

	<?php if ($this->_tpl_vars['bodyclass'] == 'element'): ?>                                                                   
	<link rel="stylesheet" type="text/css" href="/css/spectrum2.css" />
	<script type="text/javascript" src="/js/spectrum2/init.js"></script>
	<?php if ($this->_tpl_vars['pagetype'] == 'compare'): ?>
	<script type="text/javascript" src="/js/spectrum2/compare.js"></script>
	<?php endif; ?>
	
	<script type="text/javascript">
		$(document).ready(function() {						
			var spectr_list=<?php echo $this->_tpl_vars['spectrum_json']; ?>
;
			init(spectr_list);
			$('#filter').live('click', function() {
				init(spectr_list);
			});
			<?php if ($this->_tpl_vars['pagetype'] == 'compare'): ?>
			var spectr_list_uploaded = <?php echo $this->_tpl_vars['spectrum_json_uploaded']; ?>
;
			if (spectr_list_uploaded) {
				init(spectr_list_uploaded, 2);
				$('#filter').die('click');
				$('#filter').live('click', function() {
					init(spectr_list);
					init(spectr_list_uploaded, 2);
				});
			}
			<?php endif; ?>

		});		
	</script>

	<?php endif; ?>

	<?php if ($this->_tpl_vars['bodyclass'] == 'levels' || $this->_tpl_vars['bodyclass'] == 'transitions' || $this->_tpl_vars['bodyclass'] == 'bibliography'): ?>
	<link rel="stylesheet" type="text/css" href="/css/table.css" />
	<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script> 
	<script type="text/javascript" src="/js/tablexport.js"></script>	
	<script type="text/javascript" charset="windows-1251">var locale="<?php echo $this->_tpl_vars['locale']; ?>
";</script>
	
	<?php if ($this->_tpl_vars['bodyclass'] == 'levels'): ?>
	<script type="text/javascript" charset="windows-1251" src="/js/levels.js"></script> 				
	<?php endif; ?>

	<?php if ($this->_tpl_vars['bodyclass'] == 'transitions'): ?>
	<script type="text/javascript" src="/js/transitions.js"></script>
	<?php endif; ?>

	<script type="text/javascript" charset="windows-1251">					

		var Tablelookup="<?php echo $this->_tpl_vars['l10n']['Table_lookup']; ?>
";
		var ExporttoExcel="<?php echo $this->_tpl_vars['l10n']['Export_to_Excel']; ?>
";
		var Search="<?php echo $this->_tpl_vars['l10n']['Search']; ?>
";
		
		$("#btn_search").live("click",function(){
			$("#panel").slideToggle("slow");
			$(".btn-slide").toggleClass("active");
			$("#panel div").addClass('tpanel');
		});

		/* Add a click handler to the rows - this could be used as a callback */	
		$(".display tr").live("click", function(){
			if ( $(this).hasClass('row_selected') )	$(this).removeClass('row_selected');
			else $(this).addClass('row_selected');
		});					
	</script>	

	<?php endif; ?>

		<?php if ($this->_tpl_vars['bodyclass'] == 'diagramm'): ?>
	<!--script type="text/javascript" src="/js/grotrian_chart.js"></script>
	<script type="text/javascript" src="/js/jquery.svg.js"></script-->
		<?php endif; ?>		


		
		<?php if ($this->_tpl_vars['bodyclass'] == 'bibliography'): ?>
		<script type="text/javascript" src="/js/bibliography.js"></script>
		<?php endif; ?>

		<?php if ($this->_tpl_vars['bodyclass'] == 'periodictable'): ?>
		<script type="text/javascript" src="/js/periodic_table.js"></script>
		<?php endif; ?>