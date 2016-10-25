<?php /* Smarty version 2.6.12, created on 2016-07-27 12:29:13
         compiled from edit/element_picker.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'edit/element_picker.tpl', 20, false),array('modifier', 'capitalize', 'edit/element_picker.tpl', 25, false),)), $this); ?>
		<div class="element_picker">
					
<div class="newperiodic">		

<div class="empty" style="left:0px; margin-top:0px;">&nbsp;</div>
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
    <div class="empty" style="left:<?php echo $this->_sections['bar']['index']*25+$this->_sections['bar']['index']; ?>
px; margin-top:0px;"><div class="head"><?php echo $this->_sections['bar']['index']; ?>
</div></div>
    
    <?php if ($this->_sections['bar']['index'] < 9): ?>	
		<div class="empty" style="left:0px; margin-top:<?php echo $this->_sections['bar']['index']*26; ?>
px;"><div class="head"><?php echo $this->_sections['bar']['index']; ?>
</div></div>
	<?php endif; ?>
	
<?php endfor; endif; ?>

<div class="empty" style="width:77px; left:0px; margin-top:230px;"><div class="head"><?php echo $this->_tpl_vars['l10n']['Actinide']; ?>
</div></div>
<div class="empty" style="width:77px; left:0px; margin-top:256px;"><div class="head"><?php echo $this->_tpl_vars['l10n']['Lanthanide']; ?>
</div></div>



<span style="display:none;"><?php echo smarty_function_counter(array('start' => 29,'skip' => 1,'direction' => 'down','print' => 'false','assign' => 'i'), $this);?>
</span>
<?php $_from = $this->_tpl_vars['periodic_table']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['myId'] => $this->_tpl_vars['element']):
?>

<?php if ($this->_tpl_vars['element']['Z'] < 125): ?>	
	<div class="<?php echo $this->_tpl_vars['element']['TYPE']; ?>
 pick" style="left:<?php echo $this->_tpl_vars['element']['TABLEGROUP']*25+$this->_tpl_vars['element']['TABLEGROUP']; ?>
px; margin-top:<?php echo $this->_tpl_vars['element']['TABLEPERIOD']*26; ?>
px;"><a title="<?php echo ((is_array($_tmp=$this->_tpl_vars['element']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
" href="<?php echo $this->_tpl_vars['element']['ID']; ?>
" class="plink" ><input type="hidden" name="elemid" value="<?php echo $this->_tpl_vars['element']['ID']; ?>
" /><span class="pnum"><?php echo $this->_tpl_vars['element']['Z']; ?>
</span><span class="pname"><?php echo $this->_tpl_vars['element']['ABBR']; ?>
</span></a></div>
<?php endif; ?>


<?php if (57 < $this->_tpl_vars['element']['Z'] && $this->_tpl_vars['element']['Z'] < 72): ?>
	<?php echo smarty_function_counter(array(), $this);?>

	<div class="<?php echo $this->_tpl_vars['element']['TYPE']; ?>
 pick" style="left:<?php echo $this->_tpl_vars['i']*25+$this->_tpl_vars['i']+52; ?>
px; margin-top:230px;"><a title="<?php echo ((is_array($_tmp=$this->_tpl_vars['element']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
" href="<?php echo $this->_tpl_vars['element']['ID']; ?>
" class="plink" ><input type="hidden" name="elemid" value="<?php echo $this->_tpl_vars['element']['ID']; ?>
" /><span class="pnum"><?php echo $this->_tpl_vars['element']['Z']; ?>
</span><span class="pname"><?php echo $this->_tpl_vars['element']['ABBR']; ?>
</span></a></div> 
<?php endif; ?>

<?php if (89 < $this->_tpl_vars['element']['Z'] && $this->_tpl_vars['element']['Z'] < 104): ?>
	<?php echo smarty_function_counter(array(), $this);?>

	<div class="<?php echo $this->_tpl_vars['element']['TYPE']; ?>
 pick" style="left:<?php echo $this->_tpl_vars['i']*25+$this->_tpl_vars['i']-364+52; ?>
px; margin-top:256px;"><a title="<?php echo ((is_array($_tmp=$this->_tpl_vars['element']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
" class="plink" ><input type="hidden" name="elemid" value="<?php echo $this->_tpl_vars['element']['ID']; ?>
" /><span class="pnum"><?php echo $this->_tpl_vars['element']['Z']; ?>
</span><span class="pname"><?php echo $this->_tpl_vars['element']['ABBR']; ?>
</span></a></div> 
<?php endif; ?>
 
<?php if ($this->_tpl_vars['element']['ID'] == 2817): ?>
	<div class="<?php echo $this->_tpl_vars['element']['TYPE']; ?>
 pick" style="left:468px; margin-top:230px;"><a title="<?php echo ((is_array($_tmp=$this->_tpl_vars['element']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
" href="<?php echo $this->_tpl_vars['element']['ID']; ?>
" class="plink" ><input type="hidden" name="elemid" value="<?php echo $this->_tpl_vars['element']['ID']; ?>
" /><span class="pname_head"><?php echo $this->_tpl_vars['element']['ABBR']; ?>
</span></a></div> 
<?php endif; ?> 
 
<?php if ($this->_tpl_vars['element']['ID'] == 39762): ?>
	<div class="<?php echo $this->_tpl_vars['element']['TYPE']; ?>
 pick" style="left:468px; margin-top:256px;"><a title="<?php echo ((is_array($_tmp=$this->_tpl_vars['element']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
" href="<?php echo $this->_tpl_vars['element']['ID']; ?>
" class="plink" ><input type="hidden" name="elemid" value="<?php echo $this->_tpl_vars['element']['ID']; ?>
" /><span class="pname_head"><?php echo $this->_tpl_vars['element']['ABBR']; ?>
</span></a></div> 
<?php endif; ?>
 
<?php endforeach; endif; unset($_from); ?>

</div>
			
		</div>
<!--End of Periodic Table-->