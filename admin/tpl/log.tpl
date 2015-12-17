{include file="_header.tpl"}

{if $page.error}<div class="error">{$page.error}</div>{/if}
{if $page.info}<div class="info">{$page.info}</div>{/if}

{if !$smarty.get.edit && !$smarty.get.action && !$item}
	<div class="items-box">
		<div class="top-info">
			<div class="item-names">{$itemConfig.itemNames}:</div>
			<div class="items-quantity">
				<form action="" method="get" id="form-quantity">
					Показать
					<select name="quantity" id="quantity" onchange="$('#form-quantity').get(0).submit();">
						<option value="10"{if $pagination.quantity == 10} selected="selected"{/if}>10</option>
						<option value="25"{if $pagination.quantity == 25} selected="selected"{/if}>25</option>
						<option value="50"{if $pagination.quantity == 50} selected="selected"{/if}>50</option>
						<option value="100"{if $pagination.quantity == 100} selected="selected"{/if}>100</option>
					</select>
					записей
					{if $smarty.get.search}<input type="hidden" name="search" value="{$smarty.get.search}" />{/if}
					{if $smarty.get.order}<input type="hidden" name="order" value="{$smarty.get.order}" />{/if}
					{if $smarty.get.ordertype}<input type="hidden" name="ordertype" value="{$smarty.get.ordertype}" />{/if}
				</form>
			</div>
			<div class="items-search">
				<form action="" method="get" id="form-search">
					Поиск:
					<input type="text" name="search" id="search" value="{$smarty.get.search}" /><button onclick="$('#form-search').get(0).submit(); return false;">Go</button>
					{if $smarty.get.quantity}<input type="hidden" name="quantity" value="{$smarty.get.quantity}" />{/if}
					{if $smarty.get.order}<input type="hidden" name="order" value="{$smarty.get.order}" />{/if}
					{if $smarty.get.ordertype}<input type="hidden" name="ordertype" value="{$smarty.get.ordertype}" />{/if}
					<span class="delimiter">|</span>
				</form>
			</div>
			<div class="clear"></div>
		</div>
		{if $items}
			<table class="table1" cellspacing="0">
				<tr>
					{foreach from=$itemFields key=key item=value}
						{if $value.show}<th><a href="?sort={$value.field}{if !$smarty.get.order}&amp;order=desc{/if}{get_params prefix='&amp;' exclude='sort,order'}">{$value.name}</a> {if $smarty.get.sort == $value.field}<img src="{$page.admpath}img/{if $smarty.get.order}desc{else}asc{/if}.gif" alt="" />{/if}</th>{/if}
					{/foreach}
				</tr>
				{foreach name=f_i from=$items item=value}
				<tr class="{cycle values='tr1,tr2'}">
					{foreach name=f_f from=$itemFields item=field}
						{if $field.show}
							<td{if $smarty.get.sort == $field.field} class="td-sort"{/if}>
							{if $field.type=='text'}<div class="field-text">{$value[$field.field]}</div>{/if}
							{if $field.type=='integer' || $field.type=='float'}<div class="field-number">{$value[$field.field]}</div>{/if}
							{if $field.type=='array'}<div class="field-select">{assign var=arrayIndex value=$value[$field.field]}{$arrayValues[$field.field][$arrayIndex]}</div>{/if}
							{if $field.type=='key'}<div class="field-select">{$value[$field.key_value]}</div>{/if}
							{if $field.type=='textarea'}<div class="field-textarea">{$value[$field.field]}</div>{/if}
							{if $field.type=='html'}<div class="field-html">{$value[$field.field]|strip_tags|strip|escape|truncate:240}</div>{/if}
							{if $field.type=='flag'}<div class="field-flag"><a href="#" onclick="ToggleField(this, {$value[$itemKey]}, '{$field.field}'); return false;"><img src="{$page.admpath}img/{if $value[$field.field]}on.gif{else}off.gif{/if}" alt="" /></a></div>{/if}
							{if $field.type=='date'}<div class="field-date">{if $value[$field.field]}{$value[$field.field]|date_format:'%d.%m.%Y %H:%M:%S'}{/if}</div>{/if}
							</td>
						{/if}
					{/foreach}
				</tr>
				{/foreach}
			</table>
		{else}
			<div class="no-items">- Нет записей -</div>
		{/if}
		<div class="bottom-info">
			<div class="total-info">{if $pagination.total}Записи с {$pagination.from} по {$pagination.to} из {$pagination.total} записей{else}Выбрано 0 записей{/if}{if $smarty.get.search} <span class="filter">(отфильтровано из {$pagination.all} записей)</span>{/if}</div>
			<div class="pagination">
				{pagination count=$pagination.pages selected=$pagination.portion url=$pagination.url}
			</div>
			<div class="clear"></div>
		</div>
	</div>
	
{/if}

{include file="_footer.tpl"}