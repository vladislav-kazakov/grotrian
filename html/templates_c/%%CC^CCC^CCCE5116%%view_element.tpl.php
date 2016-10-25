<?php /* Smarty version 2.6.12, created on 2016-07-27 11:22:42
         compiled from view/view_element.tpl */ ?>
     
<div class="container_12">    
	<div class="grid_12" id="main">   
		<div class="brake"></div>				
		<?php if ($this->_tpl_vars['locale'] == 'ru'): ?>			
		<h3>Атом <?php echo $this->_tpl_vars['atom']['NAME_RU_ALT']; ?>
, Z=<?php echo $this->_tpl_vars['atom']['Z']; ?>
, I.P.=<?php echo $this->_tpl_vars['atom']['IONIZATION_POTENCIAL']; ?>
 см<sup>-1</sup> ichi: <?php echo $this->_tpl_vars['ichi']; ?>
, ichi_key: <?php echo $this->_tpl_vars['ichi_key']; ?>
</h3>        	   
		<?php else: ?>
		<h3>Atom of <?php echo $this->_tpl_vars['atom']['NAME_EN']; ?>
, Z=<?php echo $this->_tpl_vars['atom']['Z']; ?>
, I.P.=<?php echo $this->_tpl_vars['atom']['IONIZATION_POTENCIAL']; ?>
 см<sup>-1</sup></h3>
		<?php endif; ?>

		<?php if ($this->_tpl_vars['locale'] == 'ru'): ?>
		<?php if ($this->_tpl_vars['atom']['CONTAINMENT_RUS'] != ""): ?>
		<h4><?php echo $this->_tpl_vars['l10n']['Overview']; ?>
</h4>
		<?php echo $this->_tpl_vars['atom']['CONTAINMENT_RUS']; ?>

		<?php endif; ?>

		<?php else: ?>

		<?php if ($this->_tpl_vars['atom']['CONTAINMENT_ENG'] != ""): ?>
		<h4><?php echo $this->_tpl_vars['l10n']['Overview']; ?>
</h4>
		<?php echo $this->_tpl_vars['atom']['CONTAINMENT_ENG']; ?>

		<?php endif; ?>

		<?php endif; ?>

		<?php if (( $this->_tpl_vars['transition_count'] != 0 )): ?>
		<p>&nbsp;</p>	
		<h4><?php echo $this->_tpl_vars['l10n']['Emission_spectrum']; ?>
 <?php echo $this->_tpl_vars['layout_element_name']; ?>
</h4>					

		<div>
			<div id='toolbar'>
				<div id='range'>
					<div id='min_container'>
						<b>Минимум</b><br>
						<input type='text' id='min' value='0'>
					</div>
					<div id='max_container'>
						<b>Максимум</b><br>
						<input type='text' id='max' value='30000'>
					</div>
				</div>
				<div id='zoom_container'>
					<b>Масштаб</b><br>
					<input type='button' value='1' class='base active'>
					<input type='button' value='10' class='base'>
					<input type='button' value='100' class='base'>
					<br><br>
					<input type='button' value='x2'>
					<input type='button' value='x5'>
				</div>                        
				<input type='button' id='filter' value='Применить'>  
			</div>
		</div>
		<div style="margin: auto; margin-top: 10px; width: 520px;">
			<div id="info_intensity"><b>Чувствительность</b><!-- <input type="number" min=0 id="value"> <div id="value" style="display: inline-block;"></div> --></div><div id="range_intensity"></div>
		</div> 
		<div id='line_info'>
		</div>
		<div id="svg_wrapper">
		</div>
		<div id='map'>
			<div id='preview'></div>
			<div id='map_now'></div>
		</div>
		<?php endif; ?>

		<form method='POST'>
			<input type='submit' id='export' value='Экспорт в XSAMS' name='export'>
		</form>
		<br>
		<a id='compare' href='/<?php echo $this->_tpl_vars['locale']; ?>
/compare/<?php echo $this->_tpl_vars['layout_element_id']; ?>
'>Сравнить</a>

		<?php if (( $this->_tpl_vars['level_count'] != 0 )): ?>
		<p>&nbsp;</p>
		<h4><?php echo $this->_tpl_vars['l10n']['Electronic_structure']; ?>
</h4>		
		<?php echo $this->_tpl_vars['l10n']['Found']; ?>
 <?php echo $this->_tpl_vars['level_count']; ?>
 <?php echo $this->_tpl_vars['l10n']['levels']; ?>
. <a class="nav" href="/<?php echo $this->_tpl_vars['locale']; ?>
/levels/<?php echo $this->_tpl_vars['element']['ID']; ?>
">[<?php echo $this->_tpl_vars['l10n']['view']; ?>
]</a>

		<?php endif; ?>

		<?php if (( $this->_tpl_vars['transition_count'] != 0 )): ?>
		<p><?php echo $this->_tpl_vars['l10n']['Found']; ?>
 <?php echo $this->_tpl_vars['transition_count']; ?>
 <?php echo $this->_tpl_vars['l10n']['transitions']; ?>
. <a class="nav" href="/<?php echo $this->_tpl_vars['locale']; ?>
/transitions/<?php echo $this->_tpl_vars['element']['ID']; ?>
">[<?php echo $this->_tpl_vars['l10n']['view']; ?>
]</a></p>
		<?php endif; ?>

		<?php if (( $this->_tpl_vars['element']['LIMITS'] != "" )): ?>
		<p>&nbsp;</p>		
		<h4><?php echo $this->_tpl_vars['l10n']['Grotrian_Charts']; ?>
</h4>           
		<a class="nav" target="_blank" href="/<?php echo $this->_tpl_vars['locale']; ?>
/newdiagramm/<?php echo $this->_tpl_vars['layout_element_id']; ?>
">[<?php echo $this->_tpl_vars['l10n']['view']; ?>
]</a><br/><b><?php echo $this->_tpl_vars['l10n']['To_view_a_chart']; ?>
 <a href="http://www.adobe.com/svg/viewer/install/main.html" target="_blank"><?php echo $this->_tpl_vars['l10n']['To_view_a_chart_you_need']; ?>
 Adobe SVG Viewer</a></b>			
		<?php endif; ?>


		<?php if (( $this->_tpl_vars['book_count'] != 0 )): ?>
		<p>            
			<h4><?php echo $this->_tpl_vars['l10n']['Bibliographic_references']; ?>
</h4>
			<ul>
				<?php $_from = $this->_tpl_vars['book_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['book']):
?>
				<li><?php echo $this->_tpl_vars['book']['NAME']; ?>
"</li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</p>
		<?php endif; ?>    

		<br/><br/>       

	</div>
	<div class="clear"></div>
</div>
<!--End of Main -->

<div class="clear"></div>
<div id="empty"></div> 
</div>
<!--End of wrapper--> 