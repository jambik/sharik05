{include file="_header.tpl"}
<div class="content">
	<h1>Результат поиска</h1>
	{if $page.error}<div class="error-text">{$page.error}</div>{/if}
	{if $products}
		<div class="products">
			{foreach from=$products item=item}
				<div class="product-item">
					<a href="{$page.rootpath}products.php?id={$item.product_id}"><img src="{$item.image_path}icon/{$item.image}" alt="{$item.product_name|escape}" /></a>
					<div class="product-name"><a href="{$page.rootpath}products.php?id={$item.product_id}" title="{$item.product_name|escape}">{$item.product_name}</a></div>
					<div class="product-price">{$item.product_price|price}</div>
					<a href="#" onclick="AddToCart2(this, {$item.product_id}); return false;" class="add-basket">в корзину</a>
				</div>
			{/foreach}
			<div class="clear"></div>
		</div>
	{else}
		- Ничего не найдено -
	{/if}
</div>
{include file="_footer.tpl"}