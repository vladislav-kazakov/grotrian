<?php /* Smarty version 2.6.12, created on 2016-07-27 12:54:06
         compiled from view/compare_element.tpl */ ?>
    
	<div class="container_12">    
		<div class="grid_12" id="main">
			<h2>Загрузите файл или выберите из стандартных</h2>
			<form id='compare' method='POST' enctype='multipart/form-data'>
				<input type='file' name='file' id='file'>
				<select name='standard_file' id='standard_file'>
					<option value=0>---
					<option value=1>Спектр ртутной лампы
				</select>
			</form>  
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
        			<div id='line_info'>
					</div>
        			<div id="svg_wrapper">
        			</div>
        			<div id='map'>
            			<div id='preview'></div>
            			<div id='map_now'></div>
        			</div>
					
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