<?php /* Smarty version 2.6.22, created on 2011-02-16 02:35:21
         compiled from base_items_table.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'get_params', 'base_items_table.tpl', 7, false),array('function', 'cycle', 'base_items_table.tpl', 15, false),array('modifier', 'strip_tags', 'base_items_table.tpl', 26, false),array('modifier', 'strip', 'base_items_table.tpl', 26, false),array('modifier', 'escape', 'base_items_table.tpl', 26, false),array('modifier', 'truncate', 'base_items_table.tpl', 26, false),array('modifier', 'date_format', 'base_items_table.tpl', 28, false),)), $this); ?>
		<?php if ($this->_tpl_vars['items']): ?>
			<table class="table1" cellspacing="1">
				<tr>
					<th class="td-id">#</th>
					<?php if ($this->_tpl_vars['itemConfig']['showImage']): ?><th>Фото</th><?php endif; ?>
					<?php $_from = $this->_tpl_vars['itemFields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
						<?php if ($this->_tpl_vars['value']['show']): ?><th><a href="?sort=<?php echo $this->_tpl_vars['value']['field']; ?>
<?php if (! $_GET['order']): ?>&amp;order=desc<?php endif; ?><?php echo smarty_function_get_params(array('prefix' => '&amp;','exclude' => 'sort,order'), $this);?>
"><?php echo $this->_tpl_vars['value']['name']; ?>
</a> <?php if ($_GET['sort'] == $this->_tpl_vars['value']['field']): ?><img src="<?php echo $this->_tpl_vars['page']['admpath']; ?>
img/<?php if ($_GET['order']): ?>desc<?php else: ?>asc<?php endif; ?>.gif" alt="" /><?php endif; ?></th><?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
					<?php if ($this->_tpl_vars['itemOrder'] && ! $_GET['sort'] && ! $_GET['search']): ?><th class="td-order"><img src="<?php echo $this->_tpl_vars['page']['admpath']; ?>
img/up.gif" alt="Наверх" /> | <img src="<?php echo $this->_tpl_vars['page']['admpath']; ?>
img/down.gif" alt="Вниз" /></th><?php endif; ?>
					<?php if ($this->_tpl_vars['ajaxFields']): ?><th class="td-ajax">Ajax</th><?php endif; ?>
					<th class="td-edit"><img src="<?php echo $this->_tpl_vars['page']['admpath']; ?>
img/edit.gif" alt="Редактировать" /></th>
					<th class="td-delete"><img src="<?php echo $this->_tpl_vars['page']['admpath']; ?>
img/delete.gif" alt="Удалить" /></th>
				</tr>
				<?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f_i'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f_i']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['value']):
        $this->_foreach['f_i']['iteration']++;
?>
				<tr class="<?php echo smarty_function_cycle(array('values' => 'tr1,tr2'), $this);?>
">
					<td class="td-id"><?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
</td>
					<?php if ($this->_tpl_vars['itemConfig']['showImage']): ?><td><div id="image_<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
" class="field-image"><?php if ($this->_tpl_vars['value']['image']): ?><img src="<?php echo $this->_tpl_vars['itemConfig']['imagePath']; ?>
<?php echo $this->_tpl_vars['value']['image']; ?>
" alt="" /><?php endif; ?></div></td><?php endif; ?>
					<?php $_from = $this->_tpl_vars['itemFields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f_f'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f_f']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['field']):
        $this->_foreach['f_f']['iteration']++;
?>
						<?php if ($this->_tpl_vars['field']['show']): ?>
							<td<?php if ($_GET['sort'] == $this->_tpl_vars['field']['field']): ?> class="td-sort"<?php endif; ?>>
							<?php if ($this->_tpl_vars['field']['type'] == 'text'): ?><div id="<?php echo $this->_tpl_vars['field']['field']; ?>
_<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
" class="field-text"><?php echo $this->_tpl_vars['value'][$this->_tpl_vars['field']['field']]; ?>
</div><?php endif; ?>
							<?php if ($this->_tpl_vars['field']['type'] == 'integer' || $this->_tpl_vars['field']['type'] == 'float'): ?><div id="<?php echo $this->_tpl_vars['field']['field']; ?>
_<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
" class="field-number"><?php echo $this->_tpl_vars['value'][$this->_tpl_vars['field']['field']]; ?>
</div><?php endif; ?>
							<?php if ($this->_tpl_vars['field']['type'] == 'array'): ?><div id="<?php echo $this->_tpl_vars['field']['field']; ?>
_<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
" class="field-select"><?php if ($this->_tpl_vars['value'][$this->_tpl_vars['field']['field']]): ?><?php $this->assign('arrayIndex', $this->_tpl_vars['value'][$this->_tpl_vars['field']['field']]); ?><?php echo $this->_tpl_vars['arrayValues'][$this->_tpl_vars['field']['field']][$this->_tpl_vars['arrayIndex']]; ?>
<?php endif; ?></div><?php endif; ?>
							<?php if ($this->_tpl_vars['field']['type'] == 'key'): ?><div id="<?php echo $this->_tpl_vars['field']['field']; ?>
_<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
" class="field-select"><?php echo $this->_tpl_vars['value'][$this->_tpl_vars['field']['key_value']]; ?>
</div><?php endif; ?>
							<?php if ($this->_tpl_vars['field']['type'] == 'textarea'): ?><div id="<?php echo $this->_tpl_vars['field']['field']; ?>
_<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
" class="field-textarea"><?php echo $this->_tpl_vars['value'][$this->_tpl_vars['field']['field']]; ?>
</div><?php endif; ?>
							<?php if ($this->_tpl_vars['field']['type'] == 'html'): ?><div id="<?php echo $this->_tpl_vars['field']['field']; ?>
_<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
" class="field-html"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['value'][$this->_tpl_vars['field']['field']])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 240) : smarty_modifier_truncate($_tmp, 240)); ?>
</div><div style="display:none"><?php echo $this->_tpl_vars['value'][$this->_tpl_vars['field']['field']]; ?>
</div><?php endif; ?>
							<?php if ($this->_tpl_vars['field']['type'] == 'flag'): ?><div id="<?php echo $this->_tpl_vars['field']['field']; ?>
_<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
" class="field-flag"><a href="#" onclick="ToggleField(this, <?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
, '<?php echo $this->_tpl_vars['field']['field']; ?>
'); return false;"><span class="<?php if ($this->_tpl_vars['value'][$this->_tpl_vars['field']['field']]): ?>icon-on<?php else: ?>icon-off<?php endif; ?>"></span></a></div><?php endif; ?>
							<?php if ($this->_tpl_vars['field']['type'] == 'date'): ?><div id="<?php echo $this->_tpl_vars['field']['field']; ?>
_<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
" class="field-date"><?php if ($this->_tpl_vars['value'][$this->_tpl_vars['field']['field']]): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['value'][$this->_tpl_vars['field']['field']])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%d.%m.%Y') : smarty_modifier_date_format($_tmp, '%d.%m.%Y')); ?>
<?php endif; ?></div><?php endif; ?>
							</td>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
					<?php if ($this->_tpl_vars['itemOrder'] && ! $_GET['sort'] && ! $_GET['search']): ?><td class="td-order"><a href="?up=<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
<?php echo smarty_function_get_params(array('prefix' => '&amp;'), $this);?>
" onclick="MoveItem(this, <?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
, 'up', '<?php echo $this->_tpl_vars['page']['where']; ?>
'); return false;"><img src="<?php echo $this->_tpl_vars['page']['admpath']; ?>
img/up.gif" alt="Наверх" /></a> | <a href="?down=<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
<?php echo smarty_function_get_params(array('prefix' => '&amp;'), $this);?>
" onclick="MoveItem(this, <?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
, 'down', '<?php echo $this->_tpl_vars['page']['where']; ?>
'); return false;"><img src="<?php echo $this->_tpl_vars['page']['admpath']; ?>
img/down.gif" alt="Вниз" /></a></td><?php endif; ?>
					<?php if ($this->_tpl_vars['ajaxFields']): ?><td class="td-ajax"><button id="item_button_<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
" class="ajax-edit-button" onclick="CreateAjaxForm(<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
); return false;">Edit...</button> <span style="white-space:nowrap; display:none;"><button class="ajax-save-button" onclick="SaveAjaxForm(<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
); return false;">Save</button> <button class="ajax-cancel-button" onclick="CancelAjaxForm(<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
); return false;">Cancel</button></span><span style="display:none;">Saving...</span></td><?php endif; ?>
					<td class="td-edit"><a href="?edit=<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
<?php echo smarty_function_get_params(array('prefix' => '&amp;'), $this);?>
"><img src="<?php echo $this->_tpl_vars['page']['admpath']; ?>
img/edit.gif" alt="Редактировать" /></a></td>
					<td class="td-delete"><a href="?delete=<?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
<?php echo smarty_function_get_params(array('prefix' => '&amp;'), $this);?>
" onclick="return DeleteItem(this, <?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
);"><img src="<?php echo $this->_tpl_vars['page']['admpath']; ?>
img/delete.gif" alt="Удалить" /></a></td>
				</tr>
				<?php endforeach; endif; unset($_from); ?>
			</table>
		<?php else: ?>
			<div class="no-items">- Нет записей -</div>
		<?php endif; ?>