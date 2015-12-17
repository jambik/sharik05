<?php /* Smarty version 2.6.22, created on 2011-02-16 02:35:21
         compiled from base_items_bottom.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'pagination', 'base_items_bottom.tpl', 4, false),)), $this); ?>
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