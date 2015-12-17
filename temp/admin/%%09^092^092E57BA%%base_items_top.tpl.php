<?php /* Smarty version 2.6.22, created on 2011-02-16 02:35:21
         compiled from base_items_top.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'get_params', 'base_items_top.tpl', 6, false),)), $this); ?>
		<div class="top-info">
			<div class="item-names"><?php echo $this->_tpl_vars['itemConfig']['itemNames']; ?>
:</div>
			<div class="items-quantity">
				<form action="" method="get" id="form-quantity">
					Показать
					<?php ob_start(); ?><?php echo smarty_function_get_params(array('prefix' => '&amp;','exclude' => 'quantity,portion'), $this);?>
<?php $this->_smarty_vars['capture']['quantity'] = ob_get_contents(); ob_end_clean(); ?>
					<select name="quantity" id="quantity" onchange="document.location = $('#div-quantity-params').text() ? '?'+$('#form-quantity').serialize() + $('#div-quantity-params').text() : '?'+$('#form-quantity').serialize();">
						<option value="10"<?php if ($this->_tpl_vars['pagination']['quantity'] == 10): ?> selected="selected"<?php endif; ?>>10</option>
						<option value="25"<?php if ($this->_tpl_vars['pagination']['quantity'] == 25): ?> selected="selected"<?php endif; ?>>25</option>
						<option value="50"<?php if ($this->_tpl_vars['pagination']['quantity'] == 50): ?> selected="selected"<?php endif; ?>>50</option>
						<option value="100"<?php if ($this->_tpl_vars['pagination']['quantity'] == 100): ?> selected="selected"<?php endif; ?>>100</option>
					</select>
					записей
					<div style="display:none" id="div-quantity-params"><?php echo $this->_smarty_vars['capture']['quantity']; ?>
</div>
				</form>
			</div>
			<div class="items-search">
				<form action="" method="get" id="form-search">
					Поиск:
					<?php ob_start(); ?><?php echo smarty_function_get_params(array('prefix' => '&amp;','exclude' => 'search,portion'), $this);?>
<?php $this->_smarty_vars['capture']['search'] = ob_get_contents(); ob_end_clean(); ?>
					<input type="text" name="search" id="search" value="<?php echo $_GET['search']; ?>
" /><button onclick="/*alert($('#div-search-params').text()); return false;*/ document.location = $('#div-search-params').text() ? '?'+$('#form-search').serialize() + $('#div-search-params').text() : '?'+$('#form-search').serialize(); return false;">Go</button>
					<span class="delimiter">|</span>
					<div style="display:none" id="div-search-params"><?php echo $this->_smarty_vars['capture']['search']; ?>
</div>
				</form>
			</div>
			
			<div class="clear"></div>
		</div>