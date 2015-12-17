<?php /* Smarty version 2.6.22, created on 2011-03-23 19:46:22
         compiled from admins.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'get_params', 'admins.tpl', 6, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['page']['error']): ?><div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding:5px; font-size:10pt;"><span class="ui-icon ui-icon-alert" style="float:left; margin-right:5px;"></span> <?php echo $this->_tpl_vars['page']['error']; ?>
</div></div><?php endif; ?>
<?php if ($this->_tpl_vars['page']['info']): ?><div class="ui-widget"><div class="ui-state-highlight ui-corner-all" style="padding:5px; font-size:10pt;"><span class="ui-icon ui-icon-info" style="float:left; margin-right:5px;"></span> <?php echo $this->_tpl_vars['page']['info']; ?>
</div></div><?php endif; ?>

<div class="add-link"><a href="?action=add<?php echo smarty_function_get_params(array('prefix' => '&amp;','exclude' => 'edit'), $this);?>
"><img src="<?php echo $this->_tpl_vars['page']['admpath']; ?>
img/add.gif" alt="" /> Добавить</a></div>

<?php if ($this->_tpl_vars['itemConfig']['showImage'] && $this->_tpl_vars['ajaxFields']): ?>
	<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0;"></iframe>
	<input type="hidden" name="image_path" id="image_path" value="<?php echo $this->_tpl_vars['itemConfig']['imagePath']; ?>
" />
<?php endif; ?>

<?php if ($_GET['action'] == 'add' || $this->_tpl_vars['item']): ?>
	<?php if ($this->_tpl_vars['item'][$this->_tpl_vars['itemKey']]): ?>
		<form action="<?php echo $this->_tpl_vars['itemConfig']['adminScript']; ?>
<?php echo smarty_function_get_params(array('prefix' => '?','exclude' => 'action,edit'), $this);?>
" method="post" name="form_change_password">
			<fieldset>
				<legend>Изменить пароль</legend>
				<input type="password" name="admin_password_new" id="admin_password_new" value="" style="width:220px;" />
				<input type="submit" name="change_password_submit" value="Изменить пароль" />
				<input type="hidden" name="admin_id" value="<?php echo $this->_tpl_vars['item']['admin_id']; ?>
" />
			</fieldset>
		</form>
		<p>&nbsp;</p>
	<?php endif; ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "base_item_form.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<?php if (! $_GET['edit'] && ! $_GET['action'] && ! $this->_tpl_vars['item']): ?>
	<div class="items-box">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "base_items_top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "base_items_table.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "base_items_bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "base_ajax_fields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<input type="hidden" name="class-file" id="class-file" value="<?php echo $this->_tpl_vars['itemConfig']['classFile']; ?>
" />
<input type="hidden" name="class-name" id="class-name" value="<?php echo $this->_tpl_vars['itemConfig']['className']; ?>
" />

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>