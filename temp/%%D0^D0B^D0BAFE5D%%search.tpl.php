<?php /* Smarty version 2.6.22, created on 2011-12-21 08:22:56
         compiled from search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'search.tpl', 9, false),array('modifier', 'price', 'search.tpl', 11, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="content">
	<h1>Результат поиска</h1>
	<?php if ($this->_tpl_vars['page']['error']): ?><div class="error-text"><?php echo $this->_tpl_vars['page']['error']; ?>
</div><?php endif; ?>
	<?php if ($this->_tpl_vars['products']): ?>
		<div class="products">
			<?php $_from = $this->_tpl_vars['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<div class="product-item">
					<a href="<?php echo $this->_tpl_vars['page']['rootpath']; ?>
products.php?id=<?php echo $this->_tpl_vars['item']['product_id']; ?>
"><img src="<?php echo $this->_tpl_vars['item']['image_path']; ?>
icon/<?php echo $this->_tpl_vars['item']['image']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['product_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /></a>
					<div class="product-name"><a href="<?php echo $this->_tpl_vars['page']['rootpath']; ?>
products.php?id=<?php echo $this->_tpl_vars['item']['product_id']; ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['product_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo $this->_tpl_vars['item']['product_name']; ?>
</a></div>
					<div class="product-price"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['product_price'])) ? $this->_run_mod_handler('price', true, $_tmp) : smarty_modifier_price($_tmp)); ?>
</div>
					<a href="#" onclick="AddToCart2(this, <?php echo $this->_tpl_vars['item']['product_id']; ?>
); return false;" class="add-basket">в корзину</a>
				</div>
			<?php endforeach; endif; unset($_from); ?>
			<div class="clear"></div>
		</div>
	<?php else: ?>
		- Ничего не найдено -
	<?php endif; ?>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>