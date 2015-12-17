<?php /* Smarty version 2.6.22, created on 2011-02-16 02:35:28
         compiled from base_item_form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'get_params', 'base_item_form.tpl', 2, false),array('modifier', 'escape', 'base_item_form.tpl', 11, false),array('modifier', 'date_format', 'base_item_form.tpl', 74, false),)), $this); ?>
	<div id="itemForm">
		<form action="<?php echo $this->_tpl_vars['itemConfig']['adminScript']; ?>
<?php echo smarty_function_get_params(array('prefix' => '?','exclude' => 'action,edit'), $this);?>
" method="post" name="form_item" id="form_item"<?php if ($this->_tpl_vars['itemImageUrl']): ?> enctype="multipart/form-data"<?php endif; ?>>
			<fieldset>
				<legend><?php echo $this->_tpl_vars['itemConfig']['itemName']; ?>
</legend>
				<table class="table-form">
				<?php $_from = $this->_tpl_vars['itemFields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
					<?php if ($this->_tpl_vars['value']['edit'] !== false): ?>
						<?php if ($this->_tpl_vars['value']['type'] == 'text'): ?>
							<tr>
								<td class="td-name"><?php echo $this->_tpl_vars['value']['name']; ?>
</td>
								<td><input type="text" class="input-text<?php if (! $this->_tpl_vars['value']['empty']): ?> not-empty<?php endif; ?>" name="<?php echo $this->_tpl_vars['value']['field']; ?>
" id="<?php echo $this->_tpl_vars['value']['field']; ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['item'][$this->_tpl_vars['value']['field']])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /><?php if ($this->_tpl_vars['value']['hint']): ?> <span class="hint"><?php echo $this->_tpl_vars['value']['hint']; ?>
</span><?php endif; ?></td>
							</tr>
						<?php elseif ($this->_tpl_vars['value']['type'] == 'integer' || $this->_tpl_vars['value']['type'] == 'float'): ?>
							<tr>
								<td class="td-name"><?php echo $this->_tpl_vars['value']['name']; ?>
</td>
								<td><input type="text" class="input-number<?php if (! $this->_tpl_vars['value']['empty']): ?> not-empty<?php endif; ?>" name="<?php echo $this->_tpl_vars['value']['field']; ?>
" id="<?php echo $this->_tpl_vars['value']['field']; ?>
" value="<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['value']['field']]; ?>
" /><?php if ($this->_tpl_vars['value']['hint']): ?> <span class="hint"><?php echo $this->_tpl_vars['value']['hint']; ?>
</span><?php endif; ?></td>
							</tr>
						<?php elseif ($this->_tpl_vars['value']['type'] == 'array'): ?>
							<tr>
								<td class="td-name"><?php echo $this->_tpl_vars['value']['name']; ?>
</td>
								<td<?php if ($this->_tpl_vars['value']['control'] == 'radio'): ?> class="td-flag"<?php endif; ?>>
									<?php if ($this->_tpl_vars['value']['control'] == 'radio'): ?>
										<?php $_from = $this->_tpl_vars['arrayValues'][$this->_tpl_vars['value']['field']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f_arr'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f_arr']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key2'] => $this->_tpl_vars['value2']):
        $this->_foreach['f_arr']['iteration']++;
?>
											<?php if ($this->_tpl_vars['value2'] == 'NULL'): ?><span class="flag-field"><input type="radio" name="<?php echo $this->_tpl_vars['value']['field']; ?>
" id="<?php echo $this->_tpl_vars['value']['field']; ?>
_<?php echo $this->_tpl_vars['key2']; ?>
" value=""<?php if (! $this->_tpl_vars['item'][$this->_tpl_vars['value']['field']]): ?> checked="checked"<?php endif; ?> /> <label for="<?php echo $this->_tpl_vars['value']['field']; ?>
_<?php echo $this->_tpl_vars['key2']; ?>
">- нет -</label></span><?php else: ?><span class="flag-field"><input type="radio" name="<?php echo $this->_tpl_vars['value']['field']; ?>
" id="<?php echo $this->_tpl_vars['value']['field']; ?>
_<?php echo $this->_tpl_vars['key2']; ?>
" value="<?php echo $this->_tpl_vars['key2']; ?>
"<?php if ($this->_tpl_vars['item'][$this->_tpl_vars['value']['field']] == $this->_tpl_vars['key2'] || ( ! $this->_tpl_vars['item'] && ($this->_foreach['f_arr']['iteration'] <= 1) && ! $this->_tpl_vars['value']['empty'] )): ?> checked="checked"<?php endif; ?> /> <label for="<?php echo $this->_tpl_vars['value']['field']; ?>
_<?php echo $this->_tpl_vars['key2']; ?>
"><?php echo $this->_tpl_vars['value2']; ?>
</label></span><?php endif; ?>
										<?php endforeach; endif; unset($_from); ?>
									<?php else: ?>
										<select class="input-select" name="<?php echo $this->_tpl_vars['value']['field']; ?>
" id="<?php echo $this->_tpl_vars['value']['field']; ?>
">
											<?php $_from = $this->_tpl_vars['arrayValues'][$this->_tpl_vars['value']['field']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key2'] => $this->_tpl_vars['value2']):
?>
												<?php if ($this->_tpl_vars['value2'] == 'NULL'): ?><option value=""></option><?php else: ?><option value="<?php echo $this->_tpl_vars['key2']; ?>
"<?php if ($this->_tpl_vars['key2'] == $this->_tpl_vars['item'][$this->_tpl_vars['value']['field']]): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['value2']; ?>
</option><?php endif; ?>
											<?php endforeach; endif; unset($_from); ?>
										</select>
									<?php endif; ?>
									<?php if ($this->_tpl_vars['value']['hint']): ?> <span class="hint"><?php echo $this->_tpl_vars['value']['hint']; ?>
</span><?php endif; ?>
								</td>
							</tr>
						<?php elseif ($this->_tpl_vars['value']['type'] == 'key'): ?>
							<tr>
								<td class="td-name"><?php echo $this->_tpl_vars['value']['name']; ?>
</td>
								<td<?php if ($this->_tpl_vars['value']['control'] == 'radio'): ?> class="td-flag"<?php endif; ?>>
									<?php if ($this->_tpl_vars['value']['control'] == 'radio'): ?>
										<?php if ($this->_tpl_vars['value']['empty']): ?><span class="flag-field"><input type="radio" name="<?php echo $this->_tpl_vars['value']['field']; ?>
" id="<?php echo $this->_tpl_vars['value']['field']; ?>
_empty" value=""<?php if (! $this->_tpl_vars['item'][$this->_tpl_vars['value']['field']]): ?> checked="checked"<?php endif; ?> /> <label for="<?php echo $this->_tpl_vars['value']['field']; ?>
_empty">- нет -</label></span><?php endif; ?>
										<?php $_from = $this->_tpl_vars['keyValues'][$this->_tpl_vars['value']['field']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f_key'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f_key']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key2'] => $this->_tpl_vars['value2']):
        $this->_foreach['f_key']['iteration']++;
?>
											<span class="flag-field"><input type="radio" name="<?php echo $this->_tpl_vars['value']['field']; ?>
" id="<?php echo $this->_tpl_vars['value']['field']; ?>
_<?php echo $this->_tpl_vars['key2']; ?>
" value="<?php echo $this->_tpl_vars['value2'][$this->_tpl_vars['value']['field']]; ?>
"<?php if ($this->_tpl_vars['item'][$this->_tpl_vars['value']['field']] == $this->_tpl_vars['value2'][$this->_tpl_vars['value']['field']] || ( ! $this->_tpl_vars['item'] && ($this->_foreach['f_key']['iteration'] <= 1) && ! $this->_tpl_vars['value']['empty'] )): ?> checked="checked"<?php endif; ?> /> <label for="<?php echo $this->_tpl_vars['value']['field']; ?>
_<?php echo $this->_tpl_vars['key2']; ?>
"><?php echo $this->_tpl_vars['value2'][$this->_tpl_vars['value']['key_value']]; ?>
</label></span>
										<?php endforeach; endif; unset($_from); ?>
									<?php else: ?>
										<select class="input-select" name="<?php echo $this->_tpl_vars['value']['field']; ?>
" id="<?php echo $this->_tpl_vars['value']['field']; ?>
">
											<?php if ($this->_tpl_vars['value']['empty']): ?><option value=""></option><?php endif; ?>
											<?php $_from = $this->_tpl_vars['keyValues'][$this->_tpl_vars['value']['field']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key2'] => $this->_tpl_vars['value2']):
?>
												<option value="<?php echo $this->_tpl_vars['value2'][$this->_tpl_vars['value']['field']]; ?>
"<?php if ($this->_tpl_vars['value2'][$this->_tpl_vars['value']['field']] == $this->_tpl_vars['item'][$this->_tpl_vars['value']['field']]): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['value2'][$this->_tpl_vars['value']['key_value']]; ?>
</option>
											<?php endforeach; endif; unset($_from); ?>
										</select>
									<?php endif; ?>
									<?php if ($this->_tpl_vars['value']['hint']): ?> <span class="hint"><?php echo $this->_tpl_vars['value']['hint']; ?>
</span><?php endif; ?>
								</td>
							</tr>
						<?php elseif ($this->_tpl_vars['value']['type'] == 'textarea'): ?>
							<tr>
								<td class="td-name"><?php echo $this->_tpl_vars['value']['name']; ?>
</td>
								<td><textarea class="input-textarea<?php if (! $this->_tpl_vars['value']['empty']): ?> not-empty<?php endif; ?>" name="<?php echo $this->_tpl_vars['value']['field']; ?>
" id="<?php echo $this->_tpl_vars['value']['field']; ?>
" rows="5" cols="50"><?php echo $this->_tpl_vars['item'][$this->_tpl_vars['value']['field']]; ?>
</textarea><?php if ($this->_tpl_vars['value']['hint']): ?> <span class="hint"><?php echo $this->_tpl_vars['value']['hint']; ?>
</span><?php endif; ?></td>
							</tr>
						<?php elseif ($this->_tpl_vars['value']['type'] == 'flag'): ?>
							<tr>
								<td class="td-name">&nbsp;</td>
								<td class="td-flag"><span class="flag-field"><input type="checkbox" class="input-flag" name="<?php echo $this->_tpl_vars['value']['field']; ?>
" id="<?php echo $this->_tpl_vars['value']['field']; ?>
" <?php if ($this->_tpl_vars['item'][$this->_tpl_vars['value']['field']] || ( ! $this->_tpl_vars['item'][$this->_tpl_vars['itemKey']] && $this->_tpl_vars['value']['default'] )): ?>checked="checked" <?php endif; ?>/> <label for="<?php echo $this->_tpl_vars['value']['field']; ?>
"><?php echo $this->_tpl_vars['value']['name']; ?>
</label></span><?php if ($this->_tpl_vars['value']['hint']): ?> <span class="hint"><?php echo $this->_tpl_vars['value']['hint']; ?>
</span><?php endif; ?></td>
							</tr>
						<?php elseif ($this->_tpl_vars['value']['type'] == 'html'): ?>
							<tr>
								<td class="td-name"><?php echo $this->_tpl_vars['value']['name']; ?>
</td>
								<td><?php echo $this->_tpl_vars['htmlValues'][$this->_tpl_vars['value']['field']]; ?>
<?php if ($this->_tpl_vars['value']['hint']): ?><div class="hint" style="padding:0 0 15px 0;"><?php echo $this->_tpl_vars['value']['hint']; ?>
</div><?php endif; ?></td>
							</tr>
						<?php elseif ($this->_tpl_vars['value']['type'] == 'date'): ?>
							<tr>
								<td class="td-name"><?php echo $this->_tpl_vars['value']['name']; ?>
</td>
								<td><input type="text" class="input-date<?php if (! $this->_tpl_vars['value']['empty']): ?> not-empty<?php endif; ?>" name="<?php echo $this->_tpl_vars['value']['field']; ?>
" id="<?php echo $this->_tpl_vars['value']['field']; ?>
" value="<?php if ($this->_tpl_vars['item'][$this->_tpl_vars['value']['field']]): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][$this->_tpl_vars['value']['field']])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%d.%m.%Y') : smarty_modifier_date_format($_tmp, '%d.%m.%Y')); ?>
<?php endif; ?>" /><?php if ($this->_tpl_vars['value']['hint']): ?> <span class="hint"><?php echo $this->_tpl_vars['value']['hint']; ?>
</span><?php endif; ?></td>
							</tr>
						<?php elseif ($this->_tpl_vars['value']['type'] == 'set'): ?>
							<tr>
								<td class="td-name"><?php echo $this->_tpl_vars['value']['name']; ?>
</td>
								<td>
									<input type="hidden" class="input-set" name="<?php echo $this->_tpl_vars['value']['field']; ?>
" id="<?php echo $this->_tpl_vars['value']['field']; ?>
" />
									<?php if ($this->_tpl_vars['value']['control'] == 'button'): ?>
										<?php $_from = $this->_tpl_vars['setValues'][$this->_tpl_vars['value']['field']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item2']):
?>
											<span class="set-item<?php if ($this->_tpl_vars['item2']['set_on']): ?> set-item-on<?php endif; ?>" title="<?php echo $this->_tpl_vars['item2'][$this->_tpl_vars['value']['field']]; ?>
" onclick="ToggleSetItem(this);"><?php echo $this->_tpl_vars['item2'][$this->_tpl_vars['value']['set_value']]; ?>
 <strong>(#<?php echo $this->_tpl_vars['item2'][$this->_tpl_vars['value']['field']]; ?>
)</strong></span>
										<?php endforeach; endif; unset($_from); ?>
									<?php else: ?>
										<?php $_from = $this->_tpl_vars['setValues'][$this->_tpl_vars['value']['field']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item2']):
?>
											<span class="set-item<?php if ($this->_tpl_vars['item2']['set_on']): ?> set-item-on<?php endif; ?>" title="<?php echo $this->_tpl_vars['item2'][$this->_tpl_vars['value']['field']]; ?>
">
												<input type="checkbox" name="checkbox-<?php echo $this->_tpl_vars['value']['field']; ?>
[]" id="checkbox-<?php echo $this->_tpl_vars['item2'][$this->_tpl_vars['value']['field']]; ?>
"<?php if ($this->_tpl_vars['item2']['set_on']): ?> checked="checked"<?php endif; ?> onchange="ToggleSetItem($(this).parent());" />
												<label for="checkbox-<?php echo $this->_tpl_vars['item2'][$this->_tpl_vars['value']['field']]; ?>
"><?php echo $this->_tpl_vars['item2'][$this->_tpl_vars['value']['set_value']]; ?>
</label>
											</span>
										<?php endforeach; endif; unset($_from); ?>
									<?php endif; ?>
									<?php if ($this->_tpl_vars['value']['hint']): ?> <span class="hint"><?php echo $this->_tpl_vars['value']['hint']; ?>
</span><?php endif; ?>
								</td>
							</tr>
						<?php endif; ?>
					<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?>
				<?php if ($this->_tpl_vars['itemImageUrl']): ?>
					<tr>
						<td class="td-name">Фото</td>
						<td><input type="file" class="input-file" name="image" id="image" value="" /></td>
					</tr>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['item']['image']): ?>
					<tr>
						<td class="td-name">&nbsp;</td>
						<td>
							<div>
								<img src="<?php echo $this->_tpl_vars['item']['image_path']; ?>
<?php echo $this->_tpl_vars['item']['image']; ?>
" alt="" style="border:0;" /><br />
								<a href="#" onclick="DeleteImage(this, '<?php echo $this->_tpl_vars['item']['image']; ?>
'); return false;">удалить</a>
							</div>
						</td>
					</tr>
				<?php endif; ?>
				</table>
			</fieldset>
			<div style="text-align:center; margin:10px 0;">
				<input type="submit" name="submit" value="Сохранить" />
				<input type="button" value="Отмена" onclick="document.location = '<?php echo $this->_tpl_vars['itemConfig']['adminScript']; ?>
<?php echo smarty_function_get_params(array('prefix' => '?','exclude' => 'action,edit'), $this);?>
';" />
			</div>
			<input type="hidden" name="<?php echo $this->_tpl_vars['itemKey']; ?>
" id="<?php echo $this->_tpl_vars['itemKey']; ?>
" value="<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['itemKey']]; ?>
" />
		</form>
		<p>&nbsp;</p>
	</div>