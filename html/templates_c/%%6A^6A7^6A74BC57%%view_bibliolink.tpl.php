<?php /* Smarty version 2.6.12, created on 2016-07-27 16:44:38
         compiled from view/view_bibliolink.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'bibliolink', 'view/view_bibliolink.tpl', 34, false),)), $this); ?>
<div class="bibliolink">
	<h4>Источник данных #<?php echo $this->_tpl_vars['BiblioItem']['ID']; ?>
</h4>
	
	<?php if ($this->_tpl_vars['BiblioItem']['LINK'] != ''): ?>
		<a href="<?php echo $this->_tpl_vars['BiblioItem']['LINK']; ?>
"><?php echo $this->_tpl_vars['BiblioItem']['WORK_NAME']; ?>
</a>
		<br/>
		<?php else: ?>		
		<?php echo $this->_tpl_vars['BiblioItem']['WORK_NAME']; ?>

		<br/>
	<?php endif; ?>
	
	<?php if ($this->_tpl_vars['Authors']): ?>
		<?php $_from = $this->_tpl_vars['Authors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['author']):
?>
			<a href=""><?php echo $this->_tpl_vars['author']['NAME']; ?>
</a>
		<?php endforeach; endif; unset($_from); ?><br/>
	<?php endif; ?>
	
	<?php if ($this->_tpl_vars['BiblioItem']['ISSUE_NAME']): ?>
		<?php echo $this->_tpl_vars['BiblioItem']['ISSUE_NAME']; ?>
<br/>
	<?php endif; ?>
	
	<?php if ($this->_tpl_vars['BiblioItem']['PUBLISHER']): ?>
		<?php echo $this->_tpl_vars['BiblioItem']['PUBLISHER']; ?>
,
	<?php endif; ?>
	
	<?php if ($this->_tpl_vars['BiblioItem']['CITY']): ?>
		<?php echo $this->_tpl_vars['BiblioItem']['CITY']; ?>
 - 
	<?php endif; ?>
	<?php if ($this->_tpl_vars['BiblioItem']['YEAR']): ?>
		<?php echo $this->_tpl_vars['BiblioItem']['YEAR']; ?>

	<?php endif; ?>	
	<br/><br/>
	 <hr/>
	<?php echo smarty_function_bibliolink(array('biblioarray' => $this->_tpl_vars['BiblioItem']), $this);?>

</div>	
	