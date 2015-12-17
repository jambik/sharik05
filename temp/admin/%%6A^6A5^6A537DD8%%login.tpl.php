<?php /* Smarty version 2.6.22, created on 2011-02-16 02:35:14
         compiled from login.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_header.tpl", 'smarty_include_vars' => array('hideMenu' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div style="height:50px"></div>
<div style="height:20px">
	<?php if ($this->_tpl_vars['page']['error']): ?><div class="error"><?php echo $this->_tpl_vars['page']['error']; ?>
</div><?php endif; ?>
	<?php if ($this->_tpl_vars['page']['info']): ?><div class="info"><?php echo $this->_tpl_vars['page']['info']; ?>
</div><?php endif; ?>
</div>
<div align="center">
	<h1>Администрирование</h1>
	<form name="form_login" action="" method="post">
		<table>
			<tr>
				<td><img style="margin:0 10px 0 0;" src="<?php echo $this->_tpl_vars['page']['admpath']; ?>
img/admin.jpg" alt="" /></td>
				<td align="right">
					<div>логин <input type="text" name="frm_login" id="frm_login" /></div>
					<div>пароль <input type="password" name="frm_password" id="frm_password" value="" /></div>
					<div><input type="submit" name="login_submit" value="Вход" onclick="" /></div>
				</td>
			</tr>
		</table>
	</form>
</div>
<div style="height:60px"></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>