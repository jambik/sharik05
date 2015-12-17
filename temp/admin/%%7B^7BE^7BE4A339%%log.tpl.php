<?php /* Smarty version 2.6.22, created on 2011-02-15 16:27:22
         compiled from log.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'get_params', 'log.tpl', 41, false),array('function', 'cycle', 'log.tpl', 45, false),array('function', 'pagination', 'log.tpl', 69, false),array('modifier', 'strip_tags', 'log.tpl', 54, false),array('modifier', 'strip', 'log.tpl', 54, false),array('modifier', 'escape', 'log.tpl', 54, false),array('modifier', 'truncate', 'log.tpl', 54, false),array('modifier', 'date_format', 'log.tpl', 56, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['page']['error']): ?><div class="error"><?php echo $this->_tpl_vars['page']['error']; ?>
</div><?php endif; ?>
<?php if ($this->_tpl_vars['page']['info']): ?><div class="info"><?php echo $this->_tpl_vars['page']['info']; ?>
</div><?php endif; ?>

<?php if (! $_GET['edit'] && ! $_GET['action'] && ! $this->_tpl_vars['item']): ?>
	<div class="items-box">
		<div class="top-info">
			<div class="item-names"><?php echo $this->_tpl_vars['itemConfig']['itemNames']; ?>
:</div>
			<div class="items-quantity">
				<form action="" method="get" id="form-quantity">
					Показать
					<select name="quantity" id="quantity" onchange="$('#form-quantity').get(0).submit();">
						<option value="10"<?php if ($this->_tpl_vars['pagination']['quantity'] == 10): ?> selected="selected"<?php endif; ?>>10</option>
						<option value="25"<?php if ($this->_tpl_vars['pagination']['quantity'] == 25): ?> selected="selected"<?php endif; ?>>25</option>
						<option value="50"<?php if ($this->_tpl_vars['pagination']['quantity'] == 50): ?> selected="selected"<?php endif; ?>>50</option>
						<option value="100"<?php if ($this->_tpl_vars['pagination']['quantity'] == 100): ?> selected="selected"<?php endif; ?>>100</option>
					</select>
					записей
					<?php if ($_GET['search']): ?><input type="hidden" name="search" value="<?php echo $_GET['search']; ?>
" /><?php endif; ?>
					<?php if ($_GET['order']): ?><input type="hidden" name="order" value="<?php echo $_GET['order']; ?>
" /><?php endif; ?>
					<?php if ($_GET['ordertype']): ?><input type="hidden" name="ordertype" value="<?php echo $_GET['ordertype']; ?>
" /><?php endif; ?>
				</form>
			</div>
			<div class="items-search">
				<form action="" method="get" id="form-search">
					Поиск:
					<input type="text" name="search" id="search" value="<?php echo $_GET['search']; ?>
" /><button onclick="$('#form-search').get(0).submit(); return false;">Go</button>
					<?php if ($_GET['quantity']): ?><input type="hidden" name="quantity" value="<?php echo $_GET['quantity']; ?>
" /><?php endif; ?>
					<?php if ($_GET['order']): ?><input type="hidden" name="order" value="<?php echo $_GET['order']; ?>
" /><?php endif; ?>
					<?php if ($_GET['ordertype']): ?><input type="hidden" name="ordertype" value="<?php echo $_GET['ordertype']; ?>
" /><?php endif; ?>
					<span class="delimiter">|</span>
				</form>
			</div>
			<div class="clear"></div>
		</div>
		<?php if ($this->_tpl_vars['items']): ?>
			<table class="table1" cellspacing="0">
				<tr>
					<?php $_from = $this->_tpl_vars['itemFields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
						<?php if ($this->_tpl_vars['value']['show']): ?><th><a href="?sort=<?php echo $this->_tpl_vars['value']['field']; ?>
<?php if (! $_GET['order']): ?>&amp;order=desc<?php endif; ?><?php echo smarty_function_get_params(array('prefix' => '&amp;','exclude' => 'sort,order'), $this);?>
"><?php echo $this->_tpl_vars['value']['name']; ?>
</a> <?php if ($_GET['sort'] == $this->_tpl_vars['value']['field']): ?><img src="<?php echo $this->_tpl_vars['page']['admpath']; ?>
img/<?php if ($_GET['order']): ?>desc<?php else: ?>asc<?php endif; ?>.gif" alt="" /><?php endif; ?></th><?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				</tr>
				<?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f_i'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f_i']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['value']):
        $this->_foreach['f_i']['iteration']++;
?>
				<tr class="<?php echo smarty_function_cycle(array('values' => 'tr1,tr2'), $this);?>
">
					<?php $_from = $this->_tpl_vars['itemFields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f_f'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f_f']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['field']):
        $this->_foreach['f_f']['iteration']++;
?>
						<?php if ($this->_tpl_vars['field']['show']): ?>
							<td<?php if ($_GET['sort'] == $this->_tpl_vars['field']['field']): ?> class="td-sort"<?php endif; ?>>
							<?php if ($this->_tpl_vars['field']['type'] == 'text'): ?><div class="field-text"><?php echo $this->_tpl_vars['value'][$this->_tpl_vars['field']['field']]; ?>
</div><?php endif; ?>
							<?php if ($this->_tpl_vars['field']['type'] == 'integer' || $this->_tpl_vars['field']['type'] == 'float'): ?><div class="field-number"><?php echo $this->_tpl_vars['value'][$this->_tpl_vars['field']['field']]; ?>
</div><?php endif; ?>
							<?php if ($this->_tpl_vars['field']['type'] == 'array'): ?><div class="field-select"><?php $this->assign('arrayIndex', $this->_tpl_vars['value'][$this->_tpl_vars['field']['field']]); ?><?php echo $this->_tpl_vars['arrayValues'][$this->_tpl_vars['field']['field']][$this->_tpl_vars['arrayIndex']]; ?>
</div><?php endif; ?>
							<?php if ($this->_tpl_vars['field']['type'] == 'key'): ?><div class="field-select"><?php echo $this->_tpl_vars['value'][$this->_tpl_vars['field']['key_value']]; ?>
</div><?php endif; ?>
							<?php if ($this->_tpl_vars['field']['type'] == 'textarea'): ?><div class="field-textarea"><?php echo $this->_tpl_vars['value'][$this->_tpl_vars['field']['field']]; ?>
</div><?php endif; ?>
							<?php if ($this->_tpl_vars['field']['type'] == 'html'): ?><div class="field-html"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['value'][$this->_tpl_vars['field']['field']])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 240) : smarty_modifier_truncate($_tmp, 240)); ?>
</div><?php endif; ?>
							<?php if ($this->_tpl_vars['field']['type'] == 'flag'): ?><div class="field-flag"><a href="#" onclick="ToggleField(this, <?php echo $this->_tpl_vars['value'][$this->_tpl_vars['itemKey']]; ?>
, '<?php echo $this->_tpl_vars['field']['field']; ?>
'); return false;"><img src="<?php echo $this->_tpl_vars['page']['admpath']; ?>
img/<?php if ($this->_tpl_vars['value'][$this->_tpl_vars['field']['field']]): ?>on.gif<?php else: ?>off.gif<?php endif; ?>" alt="" /></a></div><?php endif; ?>
							<?php if ($this->_tpl_vars['field']['type'] == 'date'): ?><div class="field-date"><?php if ($this->_tpl_vars['value'][$this->_tpl_vars['field']['field']]): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['value'][$this->_tpl_vars['field']['field']])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%d.%m.%Y %H:%M:%S') : smarty_modifier_date_format($_tmp, '%d.%m.%Y %H:%M:%S')); ?>
<?php endif; ?></div><?php endif; ?>
							</td>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				</tr>
				<?php endforeach; endif; unset($_from); ?>
			</table>
		<?php else: ?>
			<div class="no-items">- Нет записей -</div>
		<?php endif; ?>
		<div class="bottom-info">
			<div class="total-info"><?php if ($this->_tpl_vars['pagination']['total']): ?>Записи с <?php echo $this->_tpl_vars['pagination']['from']; ?>
 по <?php echo $this->_tpl_vars['pagination']['to']; ?>
 из <?php echo $this->_tpl_vars['pagination']['total']; ?>
 записей<?php else: ?>Выбрано 0 записей<?php endif; ?><?php if ($_GET['search']): ?> <span class="filter">(отфильтровано из <?php echo $this->_tpl_vars['pagination']['all']; ?>
 записей)</span><?php endif; ?></div>
			<div class="pagination">
				<?php echo smarty_function_pagination(array('count' => $this->_tpl_vars['pagination']['pages'],'selected' => $this->_tpl_vars['pagination']['portion'],'url' => $this->_tpl_vars['pagination']['url']), $this);?>

			</div>
			<div class="clear"></div>
		</div>
	</div>
	
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>