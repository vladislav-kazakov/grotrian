<?php /* Smarty version 2.6.12, created on 2016-07-27 11:22:22
         compiled from view/bottom_header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'toRoman', 'view/bottom_header.tpl', 131, false),)), $this); ?>
<script type="text/javascript" charset="windows-1251">
	$(document).ready(function() {
//On clicking in some area - close periodical table
		$("html").click(function(){
			$(".element_picker").hide("fast");					
		});					
//После нажатия на ссылку генерируем ссылки у элементов 
		<?php if ($this->_tpl_vars['bodyclass'] == 'index' || $this->_tpl_vars['bodyclass'] == 'bibliography'): ?>
			$("#menu_primary ul li").click(function(){
				var link = $(':first-child', this).val();
					$(".plink").each(function() {
					//$(this).attr('href', '/<?php echo $this->_tpl_vars['locale']; ?>
/'+$(this).attr("href"));
					$(this).attr('href', '/<?php echo $this->_tpl_vars['locale']; ?>
/'+link+'/'+$(':first-child', this).val());
					//$(this).attr('href', '/<?php echo $this->_tpl_vars['locale']; ?>
/'+link+'/'+$(this).attr("tabindex"));
				});					

				var position = $(this).offset();						
				$(".element_picker").css({'top': position.top, 'left': position.left});					
				$(".element_picker").show("fast");
				return false;
			});
		<?php endif; ?>
		<?php if ($this->_tpl_vars['bodyclass'] != 'index'): ?>
			$("#element_btn").click(function(){					
				var link = "<?php echo $this->_tpl_vars['bodyclass']; ?>
";
				$(".plink").each(function() {								
			   		//var id= $(this).find(".pname").attr("id");
					//$(this).attr('href', '/<?php echo $this->_tpl_vars['locale']; ?>
/'+link+'/'+id);
					$(this).attr('href', '/<?php echo $this->_tpl_vars['locale']; ?>
/'+link+'/'+$(':first-child', this).val());	
					//$(this).attr('href', '/<?php echo $this->_tpl_vars['locale']; ?>
/'+link+'/'+$(this).attr("tabindex"));
				});
							  						
				var position = $(this).offset();						
				$(".element_picker").css({'top': position.top, 'left': position.left});					
				$(".element_picker").show("fast");
				return false;
			});
		<?php endif; ?>
	});
</script>
</head>

<body class="<?php echo $this->_tpl_vars['bodyclass']; ?>
">
	<div id="wrapper">
		<div id="header">
			<div class="container_12">	
				<div id="logo" class="grid_2">
					<a href="/<?php echo $this->_tpl_vars['locale']; ?>
" title="<?php echo $this->_tpl_vars['l10n']['Information_system_Electronic_structure_of_atoms']; ?>
"><img title="" src="/images/logo.png" alt="<?php echo $this->_tpl_vars['l10n']['Information_system_Electronic_structure_of_atoms']; ?>
" /></a>	        
				</div>
				<div class="grid_10">
		        	<h1><?php echo $this->_tpl_vars['l10n']['Information_system_Electronic_structure_of_atoms']; ?>
</h1>
		        </div>
		        <div class="locale">
		        	<a <?php if ($this->_tpl_vars['locale'] == 'ru'): ?>id="act"<?php endif; ?> class="ru_lang" href="/ru/<?php if ($this->_tpl_vars['bodyclass'] != 'index'):  echo $this->_tpl_vars['bodyclass']; ?>
/<?php endif;  echo $this->_tpl_vars['layout_element_id']; ?>
">RU</a> <a <?php if ($this->_tpl_vars['locale'] == 'en'): ?>id="act"<?php endif; ?> class="en_lang" href="/en/<?php if ($this->_tpl_vars['bodyclass'] != 'index'):  echo $this->_tpl_vars['bodyclass']; ?>
/<?php endif;  echo $this->_tpl_vars['layout_element_id']; ?>
">EN</a>
	        	</div>            		
			</div>              
		</div>
<!--End of Header-->            
	<div id="menu">
		<div class="container_12">
			<div class="grid_7" id="menu_primary">					
				<ul>
				<?php if ($this->_tpl_vars['layout_element_id']): ?>
					<li class="menu_elements"><input type="hidden" name="section" value="element" /><a href="/<?php echo $this->_tpl_vars['locale']; ?>
/element/<?php echo $this->_tpl_vars['layout_element_id']; ?>
"><?php echo $this->_tpl_vars['l10n']['Elements']; ?>
</a></li>  
					<li class="menu_levels"><input type="hidden" name="section" value="levels" /><a href="/<?php echo $this->_tpl_vars['locale']; ?>
/levels/<?php echo $this->_tpl_vars['layout_element_id']; ?>
"><?php echo $this->_tpl_vars['l10n']['Levels']; ?>
</a></li>
					<li class="menu_transitions"><input type="hidden" name="section" value="transitions" /><a href="/<?php echo $this->_tpl_vars['locale']; ?>
/transitions/<?php echo $this->_tpl_vars['layout_element_id']; ?>
"><?php echo $this->_tpl_vars['l10n']['Transitions']; ?>
</a></li>  
					<li class="menu_diagrams"><input type="hidden" name="section" value="diagramm" /><a href="/<?php echo $this->_tpl_vars['locale']; ?>
/diagramm/<?php echo $this->_tpl_vars['layout_element_id']; ?>
"><?php echo $this->_tpl_vars['l10n']['Charts']; ?>
</a></li> 
				<?php else: ?>
					<li class="menu_elements"><input type="hidden" name="section" value="element" /><a href="/<?php echo $this->_tpl_vars['locale']; ?>
/element/"><?php echo $this->_tpl_vars['l10n']['Elements']; ?>
</a></li>
					<li class="menu_levels"><input type="hidden" name="section" value="levels" /><a href="/<?php echo $this->_tpl_vars['locale']; ?>
/levels/"><?php echo $this->_tpl_vars['l10n']['Levels']; ?>
</a></li>
					<li class="menu_transitions"><input type="hidden" name="section" value="transitions" /><a href="/<?php echo $this->_tpl_vars['locale']; ?>
/transitions/"><?php echo $this->_tpl_vars['l10n']['Transitions']; ?>
</a></li>
					<li class="menu_diagrams"><input type="hidden" name="section" value="diagramm" /><a href="/<?php echo $this->_tpl_vars['locale']; ?>
/element/"><?php echo $this->_tpl_vars['l10n']['Charts']; ?>
</a></li> 
				<?php endif; ?>                                              
				</ul>
			</div>
			<div id="menu_secondary">
				<?php if ($this->_tpl_vars['locale'] == 'ru'): ?>	
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
				<?php endif; ?>					
				<?php if ($this->_tpl_vars['locale'] == 'en'): ?>                       
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
				<?php endif; ?>				
				</div>					
			</div>
		</div>
<!--End of menu-->
		<div class="container_12">
			<div class="grid_12">
	  		  	<h2>
                 	<?php echo $this->_tpl_vars['headline']; ?>

					<?php if ($this->_tpl_vars['ions']): ?>
						<span class="button white selected" id="element_btn"><?php echo $this->_tpl_vars['layout_element_name']; ?>
</span><span id="ions">                        
						<?php if ($this->_tpl_vars['layout_element_id'] == '2511'): ?>
							<?php echo $this->_tpl_vars['l10n']['isotopes']; ?>
 <a href="2817" class="button white" >D</a><a href="39762" class="button white" >T</a>
                        <?php elseif ($this->_tpl_vars['layout_element_id'] == '2817'): ?>
							<?php echo $this->_tpl_vars['l10n']['isotopes']; ?>
 <a href="2511" class="button white" >H</a><a href="39762" class="button white" >T</a>                                                                        
                        <?php elseif ($this->_tpl_vars['layout_element_id'] == '39762'): ?>
                        	<?php echo $this->_tpl_vars['l10n']['isotopes']; ?>
 <a href="2511" class="button white" >H</a><a href="2817" class="button white" >D</a>                        
                        <?php else: ?>                       
                           	<?php echo $this->_tpl_vars['l10n']['ions']; ?>

                        	<?php $_from = $this->_tpl_vars['ions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['myId'] => $this->_tpl_vars['ion']):
?>
                        		<?php if ($this->_tpl_vars['ion']['ID'] == $this->_tpl_vars['layout_element_id']): ?>
                        			<a href="<?php echo $this->_tpl_vars['ion']['ID']; ?>
" class="button white ions selected" >
                        			<?php else: ?>
                        			<a href="<?php echo $this->_tpl_vars['ion']['ID']; ?>
" class="button white ions" >
                        		<?php endif; ?>
                        		<?php echo ((is_array($_tmp=$this->_tpl_vars['ion']['IVAL']+1)) ? $this->_run_mod_handler('toRoman', true, $_tmp) : numberToRoman($_tmp)); ?>
</a>
                       		<?php endforeach; endif; unset($_from); ?>
						<?php endif; ?>
					</span>                        		                        		
                  	<?php endif; ?>
                </h2>    
			</div>
		</div>
    	<div class="clear"></div>		