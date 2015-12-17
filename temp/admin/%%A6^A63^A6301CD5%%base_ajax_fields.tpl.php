<?php /* Smarty version 2.6.22, created on 2011-02-16 02:35:21
         compiled from base_ajax_fields.tpl */ ?>
	<?php if ($this->_tpl_vars['ajaxFields']): ?>
		
		<input type="hidden" alt="ajax" name="<?php echo $this->_tpl_vars['itemKey']; ?>
" id="ajax-item-id" value="" />
		<input type="hidden" name="ajax-fields" id="ajax-fields" value="<?php echo $this->_tpl_vars['ajaxFields']; ?>
" />
		
		<?php if ($this->_tpl_vars['arrayValues']): ?>
			<?php $_from = $this->_tpl_vars['arrayValues']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
				<span style="display:none" id="ajax-select-<?php echo $this->_tpl_vars['key']; ?>
">
					<select name="">
						<?php $_from = $this->_tpl_vars['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key2'] => $this->_tpl_vars['value2']):
?>
						<?php if ($this->_tpl_vars['value2'] == 'NULL'): ?><option value=""></option><?php else: ?><option value="<?php echo $this->_tpl_vars['key2']; ?>
"><?php echo $this->_tpl_vars['value2']; ?>
</option><?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					</select>
				</span>
			<?php endforeach; endif; unset($_from); ?>
		<?php endif; ?>
		
		<?php if ($this->_tpl_vars['keyValues']): ?>
			<?php $_from = $this->_tpl_vars['keyValues']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
				<span style="display:none" id="ajax-select-<?php echo $this->_tpl_vars['key']; ?>
">
					<select name="">
						<?php $this->assign('keyFields', $this->_tpl_vars['keyFieldNames'][$this->_tpl_vars['key']]); ?>
						<?php if ($this->_tpl_vars['keyFields']['empty']): ?><option value=""></option><?php endif; ?>
						<?php $_from = $this->_tpl_vars['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key2'] => $this->_tpl_vars['value2']):
?>
						<option value="<?php echo $this->_tpl_vars['value2'][$this->_tpl_vars['keyFields']['key']]; ?>
"><?php echo $this->_tpl_vars['value2'][$this->_tpl_vars['keyFields']['key_value']]; ?>
</option>
						<?php endforeach; endif; unset($_from); ?>
					</select>
				</span>
			<?php endforeach; endif; unset($_from); ?>
		<?php endif; ?>
		
	<?php endif; ?>