<?php /* Smarty version 2.6.12, created on 2016-07-27 15:11:14
         compiled from view/view_periodictable.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'view/view_periodictable.tpl', 20, false),array('modifier', 'capitalize', 'view/view_periodictable.tpl', 24, false),)), $this); ?>
<div id="txt" class="container_12">
	<div class="grid_12">
	<br/>
<div class="element_table">					
	<div class="periodic">
	<input type="hidden" id="MaxLevels" name="MaxLevels" value="<?php echo $this->_tpl_vars['MaxLevels']; ?>
" />
		<div class="empty" style="left:0px; margin-top:0px; height:20px; width:20px;">&nbsp;</div>
		<?php unset($this->_sections['bar']);
$this->_sections['bar']['name'] = 'bar';
$this->_sections['bar']['start'] = (int)1;
$this->_sections['bar']['loop'] = is_array($_loop=19) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['bar']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['bar']['show'] = true;
$this->_sections['bar']['max'] = $this->_sections['bar']['loop'];
if ($this->_sections['bar']['start'] < 0)
    $this->_sections['bar']['start'] = max($this->_sections['bar']['step'] > 0 ? 0 : -1, $this->_sections['bar']['loop'] + $this->_sections['bar']['start']);
else
    $this->_sections['bar']['start'] = min($this->_sections['bar']['start'], $this->_sections['bar']['step'] > 0 ? $this->_sections['bar']['loop'] : $this->_sections['bar']['loop']-1);
if ($this->_sections['bar']['show']) {
    $this->_sections['bar']['total'] = min(ceil(($this->_sections['bar']['step'] > 0 ? $this->_sections['bar']['loop'] - $this->_sections['bar']['start'] : $this->_sections['bar']['start']+1)/abs($this->_sections['bar']['step'])), $this->_sections['bar']['max']);
    if ($this->_sections['bar']['total'] == 0)
        $this->_sections['bar']['show'] = false;
} else
    $this->_sections['bar']['total'] = 0;
if ($this->_sections['bar']['show']):

            for ($this->_sections['bar']['index'] = $this->_sections['bar']['start'], $this->_sections['bar']['iteration'] = 1;
                 $this->_sections['bar']['iteration'] <= $this->_sections['bar']['total'];
                 $this->_sections['bar']['index'] += $this->_sections['bar']['step'], $this->_sections['bar']['iteration']++):
$this->_sections['bar']['rownum'] = $this->_sections['bar']['iteration'];
$this->_sections['bar']['index_prev'] = $this->_sections['bar']['index'] - $this->_sections['bar']['step'];
$this->_sections['bar']['index_next'] = $this->_sections['bar']['index'] + $this->_sections['bar']['step'];
$this->_sections['bar']['first']      = ($this->_sections['bar']['iteration'] == 1);
$this->_sections['bar']['last']       = ($this->_sections['bar']['iteration'] == $this->_sections['bar']['total']);
?>
    		<div class="emptyGroup" style="left:<?php echo $this->_sections['bar']['index']*60+$this->_sections['bar']['index']-40; ?>
px; margin-top:0px;"><div class="head"><?php echo $this->_sections['bar']['index']; ?>
</div></div>    
    		<?php if ($this->_sections['bar']['index'] < 9): ?>	
				<div class="emptyPeriod" style="left:0px; margin-top:<?php echo $this->_sections['bar']['index']*51-30; ?>
px;"><div class="head"><?php echo $this->_sections['bar']['index']; ?>
</div></div>
			<?php endif; ?>	
		<?php endfor; endif; ?>
		
		<div class="empty" style="width:142px; left:0px; margin-top:458px;"><div class="head"><?php echo $this->_tpl_vars['l10n']['Lanthanide']; ?>
 *</div></div>
		<div class="empty" style="width:142px; left:0px; margin-top:509px;"><div class="head"><?php echo $this->_tpl_vars['l10n']['Actinide']; ?>
 **</div></div>
		<div class="empty" style="width:142px; left:0px; margin-top:560px;"><div class="head"><?php echo $this->_tpl_vars['l10n']['Superactinide']; ?>
 ***</div></div>


		<span style="display:none;"><?php echo smarty_function_counter(array('start' => 29,'skip' => 1,'direction' => 'down','print' => 'false','assign' => 'i'), $this);?>
</span>
		<?php $_from = $this->_tpl_vars['periodic_table']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['myId'] => $this->_tpl_vars['element']):
?>
						<?php if ($this->_tpl_vars['element']['Z'] < 125): ?>	
				<div class="<?php echo $this->_tpl_vars['element']['TYPE']; ?>
 pick" style="left:<?php echo $this->_tpl_vars['element']['TABLEGROUP']*60+$this->_tpl_vars['element']['TABLEGROUP']-40; ?>
px; margin-top:<?php echo $this->_tpl_vars['element']['TABLEPERIOD']*51-30; ?>
px;"><a title="<?php echo ((is_array($_tmp=$this->_tpl_vars['element']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
" href="/ru/element/<?php echo $this->_tpl_vars['element']['ID']; ?>
" class="plink" ><input type="hidden" class="levelsNum" name="levelsNum" value="<?php echo $this->_tpl_vars['element']['LEVELS_NUM']; ?>
" /><input type="hidden" class="transitionsNum" name="transitionsNum" value="<?php echo $this->_tpl_vars['element']['TRANSITIONS_NUM']; ?>
" /><span class="pnum"><?php echo $this->_tpl_vars['element']['Z']; ?>
</span><span class="pname"><?php echo $this->_tpl_vars['element']['ABBR']; ?>
</span><span class="ptitle"><?php echo ((is_array($_tmp=$this->_tpl_vars['element']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</span></a></div>
			<?php endif; ?>
			
			<?php if ($this->_tpl_vars['element']['Z'] == 57): ?>
				<div class="empty" style="left:<?php echo $this->_tpl_vars['element']['TABLEGROUP']*50+$this->_tpl_vars['element']['TABLEGROUP']-10; ?>
px; margin-top:<?php echo $this->_tpl_vars['element']['TABLEPERIOD']*51-30; ?>
px;"><div class="head">*</div></div>
			<?php endif; ?>			
			<?php if ($this->_tpl_vars['element']['Z'] == 89): ?>
				<div class="empty" style="left:<?php echo $this->_tpl_vars['element']['TABLEGROUP']*50+$this->_tpl_vars['element']['TABLEGROUP']-10; ?>
px; margin-top:<?php echo $this->_tpl_vars['element']['TABLEPERIOD']*51-30; ?>
px;"><div class="head">**</div></div>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['element']['Z'] == 121): ?>
				<div class="empty" style="left:<?php echo $this->_tpl_vars['element']['TABLEGROUP']*50+$this->_tpl_vars['element']['TABLEGROUP']-10; ?>
px; margin-top:<?php echo $this->_tpl_vars['element']['TABLEPERIOD']*51-30; ?>
px;"><div class="head">***</div></div>
			<?php endif; ?>
			
			
						<?php if (56 < $this->_tpl_vars['element']['Z'] && $this->_tpl_vars['element']['Z'] < 72): ?>
				<?php echo smarty_function_counter(array(), $this);?>

				<div class="<?php echo $this->_tpl_vars['element']['TYPE']; ?>
 pick" style="left:<?php echo $this->_tpl_vars['i']*60+$this->_tpl_vars['i']+326; ?>
px; margin-top:458px;"><a title="<?php echo ((is_array($_tmp=$this->_tpl_vars['element']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
" href="/ru/element/<?php echo $this->_tpl_vars['element']['ID']; ?>
" class="plink" ><input type="hidden" class="levelsNum" name="levelsNum" value="<?php echo $this->_tpl_vars['element']['LEVELS_NUM']; ?>
" /><input type="hidden" class="transitionsNum" name="transitionsNum" value="<?php echo $this->_tpl_vars['element']['TRANSITIONS_NUM']; ?>
" /><span class="pnum"><?php echo $this->_tpl_vars['element']['Z']; ?>
</span><span class="pname"><?php echo $this->_tpl_vars['element']['ABBR']; ?>
</span><span class="ptitle"><?php echo ((is_array($_tmp=$this->_tpl_vars['element']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</span></a></div> 
			<?php endif; ?>
						<?php if (88 < $this->_tpl_vars['element']['Z'] && $this->_tpl_vars['element']['Z'] < 104): ?>
				<?php echo smarty_function_counter(array(), $this);?>

				<div class="<?php echo $this->_tpl_vars['element']['TYPE']; ?>
 pick" style="left:<?php echo $this->_tpl_vars['i']*60+$this->_tpl_vars['i']-589; ?>
px; margin-top:509px;"><a title="<?php echo ((is_array($_tmp=$this->_tpl_vars['element']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
" href="/ru/element/<?php echo $this->_tpl_vars['element']['ID']; ?>
" class="plink" ><input type="hidden" class="levelsNum" name="levelsNum" value="<?php echo $this->_tpl_vars['element']['LEVELS_NUM']; ?>
" /><input type="hidden" class="transitionsNum" name="transitionsNum" value="<?php echo $this->_tpl_vars['element']['TRANSITIONS_NUM']; ?>
" /><span class="pnum"><?php echo $this->_tpl_vars['element']['Z']; ?>
</span><span class="pname"><?php echo $this->_tpl_vars['element']['ABBR']; ?>
</span><span class="ptitle"><?php echo ((is_array($_tmp=$this->_tpl_vars['element']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</span></a></div> 
			<?php endif; ?> 

						<?php if (120 < $this->_tpl_vars['element']['Z'] && $this->_tpl_vars['element']['Z'] < 127): ?>
				<?php echo smarty_function_counter(array(), $this);?>

				<div class="<?php echo $this->_tpl_vars['element']['TYPE']; ?>
 pick" style="left:<?php echo $this->_tpl_vars['i']*60+$this->_tpl_vars['i']-1504; ?>
px; margin-top:560px;"><a title="<?php echo ((is_array($_tmp=$this->_tpl_vars['element']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
" href="/ru/element/<?php echo $this->_tpl_vars['element']['ID']; ?>
" class="plink" ><input type="hidden" class="levelsNum" name="levelsNum" value="<?php echo $this->_tpl_vars['element']['LEVELS_NUM']; ?>
" /><input type="hidden" class="transitionsNum" name="transitionsNum" value="<?php echo $this->_tpl_vars['element']['TRANSITIONS_NUM']; ?>
" /><span class="pnum"><?php echo $this->_tpl_vars['element']['Z']; ?>
</span><span class="pname"><?php echo $this->_tpl_vars['element']['ABBR']; ?>
</span><span class="ptitle"><?php echo ((is_array($_tmp=$this->_tpl_vars['element']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</span></a></div> 
			<?php endif; ?>
			
					
			<?php if ($this->_tpl_vars['element']['ID'] == 2817): ?>
						<!--<div class="<?php echo $this->_tpl_vars['element']['TYPE']; ?>
 pick" style="left:968px; margin-top:408px;"><a title="<?php echo ((is_array($_tmp=$this->_tpl_vars['element']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
" href="<?php echo $this->_tpl_vars['element']['ID']; ?>
" class="plink" > value="<?php echo $this->_tpl_vars['element']['ID']; ?>
" /><span class="pname_head"><?php echo $this->_tpl_vars['element']['ABBR']; ?>
</span></a></div>--> 
			<?php endif; ?> 
			
			<?php if ($this->_tpl_vars['element']['ID'] == 39762): ?>
				<!--<div class="<?php echo $this->_tpl_vars['element']['TYPE']; ?>
 pick" style="left:468px; margin-top:459px;"><a title="<?php echo ((is_array($_tmp=$this->_tpl_vars['element']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
" href="<?php echo $this->_tpl_vars['element']['ID']; ?>
" class="plink" ><span class="pname_head"><?php echo $this->_tpl_vars['element']['ABBR']; ?>
</span></a></div>--> 
			<?php endif; ?> 
		<?php endforeach; endif; unset($_from); ?>
		
		<div class="empty" style="width:705px; left:70px; margin-top:20px; border:0; background:transparent;"><div class="head"><?php echo $this->_tpl_vars['l10n']['Show_database_filling']; ?>
: <a id="showLevelsFilling" href="#"><?php echo $this->_tpl_vars['l10n']['Levels']; ?>
</a> / <a id="showTransitionsFilling" href="#" ><?php echo $this->_tpl_vars['l10n']['Transitions']; ?>
</a></div><div class="legend"></div></div>		

	</div>			
</div>
</div>	
</div>
<!--End of content-->       
<div class="clear"></div>
<div id="empty"></div> 
</div>
<!--End of wrapper--> 