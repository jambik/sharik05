		{if $items}
			<table class="table1" cellspacing="1">
				<tr>
					<th class="td-id">#</th>
					{if $itemConfig.showImage}<th>Фото</th>{/if}
					{foreach from=$itemFields key=key item=value}
						{if $value.show}<th><a href="?sort={$value.field}{if !$smarty.get.order}&amp;order=desc{/if}{get_params prefix='&amp;' exclude='sort,order'}">{$value.name}</a> {if $smarty.get.sort == $value.field}<img src="{$page.admpath}img/{if $smarty.get.order}desc{else}asc{/if}.gif" alt="" />{/if}</th>{/if}
					{/foreach}
					{if $itemOrder && !$smarty.get.sort && !$smarty.get.search}<th class="td-order"><img src="{$page.admpath}img/up.gif" alt="Наверх" /> | <img src="{$page.admpath}img/down.gif" alt="Вниз" /></th>{/if}
					{if $ajaxFields}<th class="td-ajax">Ajax</th>{/if}
					<th class="td-edit"><img src="{$page.admpath}img/edit.gif" alt="Редактировать" /></th>
					<th class="td-delete"><img src="{$page.admpath}img/delete.gif" alt="Удалить" /></th>
				</tr>
				{foreach name=f_i from=$items item=value}
				<tr class="{cycle values='tr1,tr2'}">
					<td class="td-id">{$value[$itemKey]}</td>
					{if $itemConfig.showImage}<td><div id="image_{$value[$itemKey]}" class="field-image">{if $value.image}<img src="{$itemConfig.imagePath}{$value.image}" alt="" />{/if}</div></td>{/if}
					{foreach name=f_f from=$itemFields item=field}
						{if $field.show}
							<td{if $smarty.get.sort == $field.field} class="td-sort"{/if}>
							{if $field.type=='text'}<div id="{$field.field}_{$value[$itemKey]}" class="field-text">{$value[$field.field]}</div>{/if}
							{if $field.type=='integer' || $field.type=='float'}<div id="{$field.field}_{$value[$itemKey]}" class="field-number">{$value[$field.field]}</div>{/if}
							{if $field.type=='array'}<div id="{$field.field}_{$value[$itemKey]}" class="field-select">{if $value[$field.field]}{assign var=arrayIndex value=$value[$field.field]}{$arrayValues[$field.field][$arrayIndex]}{/if}</div>{/if}
							{if $field.type=='key'}<div id="{$field.field}_{$value[$itemKey]}" class="field-select">{$value[$field.key_value]}</div>{/if}
							{if $field.type=='textarea'}<div id="{$field.field}_{$value[$itemKey]}" class="field-textarea">{$value[$field.field]}</div>{/if}
							{if $field.type=='html'}<div id="{$field.field}_{$value[$itemKey]}" class="field-html">{$value[$field.field]|strip_tags|strip|escape|truncate:240}</div><div style="display:none">{$value[$field.field]}</div>{/if}
							{if $field.type=='flag'}<div id="{$field.field}_{$value[$itemKey]}" class="field-flag"><a href="#" onclick="ToggleField(this, {$value[$itemKey]}, '{$field.field}'); return false;"><span class="{if $value[$field.field]}icon-on{else}icon-off{/if}"></span></a></div>{/if}
							{if $field.type=='date'}<div id="{$field.field}_{$value[$itemKey]}" class="field-date">{if $value[$field.field]}{$value[$field.field]|date_format:'%d.%m.%Y'}{/if}</div>{/if}
							</td>
						{/if}
					{/foreach}
					{if $itemOrder && !$smarty.get.sort && !$smarty.get.search}<td class="td-order"><a href="?up={$value[$itemKey]}{get_params prefix='&amp;'}" onclick="MoveItem(this, {$value[$itemKey]}, 'up', '{$page.where}'); return false;"><img src="{$page.admpath}img/up.gif" alt="Наверх" /></a> | <a href="?down={$value[$itemKey]}{get_params prefix='&amp;'}" onclick="MoveItem(this, {$value[$itemKey]}, 'down', '{$page.where}'); return false;"><img src="{$page.admpath}img/down.gif" alt="Вниз" /></a></td>{/if}
					{if $ajaxFields}<td class="td-ajax"><button id="item_button_{$value[$itemKey]}" class="ajax-edit-button" onclick="CreateAjaxForm({$value[$itemKey]}); return false;">Edit...</button> <span style="white-space:nowrap; display:none;"><button class="ajax-save-button" onclick="SaveAjaxForm({$value[$itemKey]}); return false;">Save</button> <button class="ajax-cancel-button" onclick="CancelAjaxForm({$value[$itemKey]}); return false;">Cancel</button></span><span style="display:none;">Saving...</span></td>{/if}
					<td class="td-edit"><a href="?edit={$value[$itemKey]}{get_params prefix='&amp;'}"><img src="{$page.admpath}img/edit.gif" alt="Редактировать" /></a></td>
					<td class="td-delete"><a href="?delete={$value[$itemKey]}{get_params prefix='&amp;'}" onclick="return DeleteItem(this, {$value[$itemKey]});"><img src="{$page.admpath}img/delete.gif" alt="Удалить" /></a></td>
				</tr>
				{/foreach}
			</table>
		{else}
			<div class="no-items">- Нет записей -</div>
		{/if}