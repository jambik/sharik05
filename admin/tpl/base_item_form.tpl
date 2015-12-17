	<div id="itemForm">
		<form action="{$itemConfig.adminScript}{get_params prefix='?' exclude='action,edit'}" method="post" name="form_item" id="form_item"{if $itemImageUrl} enctype="multipart/form-data"{/if}>
			<fieldset>
				<legend>{$itemConfig.itemName}</legend>
				<table class="table-form">
				{foreach from=$itemFields key=key item=value}
					{if $value.edit !== false}
						{if $value.type=='text'}
							<tr>
								<td class="td-name">{$value.name}</td>
								<td><input type="text" class="input-text{if !$value.empty} not-empty{/if}" name="{$value.field}" id="{$value.field}" value="{$item[$value.field]|escape}" />{if $value.hint} <span class="hint">{$value.hint}</span>{/if}</td>
							</tr>
						{elseif $value.type=='integer' || $value.type=='float'}
							<tr>
								<td class="td-name">{$value.name}</td>
								<td><input type="text" class="input-number{if !$value.empty} not-empty{/if}" name="{$value.field}" id="{$value.field}" value="{$item[$value.field]}" />{if $value.hint} <span class="hint">{$value.hint}</span>{/if}</td>
							</tr>
						{elseif $value.type=='array'}
							<tr>
								<td class="td-name">{$value.name}</td>
								<td{if $value.control == "radio"} class="td-flag"{/if}>
									{if $value.control == "radio"}
										{foreach name=f_arr from=$arrayValues[$value.field] key=key2 item=value2}
											{if $value2 == "NULL"}<span class="flag-field"><input type="radio" name="{$value.field}" id="{$value.field}_{$key2}" value=""{if !$item[$value.field]} checked="checked"{/if} /> <label for="{$value.field}_{$key2}">- нет -</label></span>{else}<span class="flag-field"><input type="radio" name="{$value.field}" id="{$value.field}_{$key2}" value="{$key2}"{if $item[$value.field] == $key2 || (!$item && $smarty.foreach.f_arr.first && !$value.empty)} checked="checked"{/if} /> <label for="{$value.field}_{$key2}">{$value2}</label></span>{/if}
										{/foreach}
									{else}
										<select class="input-select" name="{$value.field}" id="{$value.field}">
											{foreach from=$arrayValues[$value.field] key=key2 item=value2}
												{if $value2 == "NULL"}<option value=""></option>{else}<option value="{$key2}"{if $key2 == $item[$value.field]} selected="selected"{/if}>{$value2}</option>{/if}
											{/foreach}
										</select>
									{/if}
									{if $value.hint} <span class="hint">{$value.hint}</span>{/if}
								</td>
							</tr>
						{elseif $value.type=='key'}
							<tr>
								<td class="td-name">{$value.name}</td>
								<td{if $value.control == "radio"} class="td-flag"{/if}>
									{if $value.control == "radio"}
										{if $value.empty}<span class="flag-field"><input type="radio" name="{$value.field}" id="{$value.field}_empty" value=""{if !$item[$value.field]} checked="checked"{/if} /> <label for="{$value.field}_empty">- нет -</label></span>{/if}
										{foreach name=f_key from=$keyValues[$value.field] key=key2 item=value2}
											<span class="flag-field"><input type="radio" name="{$value.field}" id="{$value.field}_{$key2}" value="{$value2[$value.field]}"{if $item[$value.field] == $value2[$value.field] || (!$item && $smarty.foreach.f_key.first && !$value.empty)} checked="checked"{/if} /> <label for="{$value.field}_{$key2}">{$value2[$value.key_value]}</label></span>
										{/foreach}
									{else}
										<select class="input-select" name="{$value.field}" id="{$value.field}">
											{if $value.empty}<option value=""></option>{/if}
											{foreach from=$keyValues[$value.field] key=key2 item=value2}
												<option value="{$value2[$value.field]}"{if $value2[$value.field] == $item[$value.field]} selected="selected"{/if}>{$value2[$value.key_value]}</option>
											{/foreach}
										</select>
									{/if}
									{if $value.hint} <span class="hint">{$value.hint}</span>{/if}
								</td>
							</tr>
						{elseif $value.type=='textarea'}
							<tr>
								<td class="td-name">{$value.name}</td>
								<td><textarea class="input-textarea{if !$value.empty} not-empty{/if}" name="{$value.field}" id="{$value.field}" rows="5" cols="50">{$item[$value.field]}</textarea>{if $value.hint} <span class="hint">{$value.hint}</span>{/if}</td>
							</tr>
						{elseif $value.type=='flag'}
							<tr>
								<td class="td-name">&nbsp;</td>
								<td class="td-flag"><span class="flag-field"><input type="checkbox" class="input-flag" name="{$value.field}" id="{$value.field}" {if $item[$value.field] || (!$item[$itemKey] && $value.default)}checked="checked" {/if}/> <label for="{$value.field}">{$value.name}</label></span>{if $value.hint} <span class="hint">{$value.hint}</span>{/if}</td>
							</tr>
						{elseif $value.type=='html'}
							<tr>
								<td class="td-name">{$value.name}</td>
								<td>{$htmlValues[$value.field]}{if $value.hint}<div class="hint" style="padding:0 0 15px 0;">{$value.hint}</div>{/if}</td>
							</tr>
						{elseif $value.type=='date'}
							<tr>
								<td class="td-name">{$value.name}</td>
								<td><input type="text" class="input-date{if !$value.empty} not-empty{/if}" name="{$value.field}" id="{$value.field}" value="{if $item[$value.field]}{$item[$value.field]|date_format:'%d.%m.%Y'}{/if}" />{if $value.hint} <span class="hint">{$value.hint}</span>{/if}</td>
							</tr>
						{elseif $value.type=='set'}
							<tr>
								<td class="td-name">{$value.name}</td>
								<td>
									<input type="hidden" class="input-set" name="{$value.field}" id="{$value.field}" />
									{if $value.control=="button"}
										{foreach from=$setValues[$value.field] item=item2}
											<span class="set-item{if $item2.set_on} set-item-on{/if}" title="{$item2[$value.field]}" onclick="ToggleSetItem(this);">{$item2[$value.set_value]} <strong>(#{$item2[$value.field]})</strong></span>
										{/foreach}
									{else}
										{foreach from=$setValues[$value.field] item=item2}
											<span class="set-item{if $item2.set_on} set-item-on{/if}" title="{$item2[$value.field]}">
												<input type="checkbox" name="checkbox-{$value.field}[]" id="checkbox-{$item2[$value.field]}"{if $item2.set_on} checked="checked"{/if} onchange="ToggleSetItem($(this).parent());" />
												<label for="checkbox-{$item2[$value.field]}">{$item2[$value.set_value]}</label>
											</span>
										{/foreach}
									{/if}
									{if $value.hint} <span class="hint">{$value.hint}</span>{/if}
								</td>
							</tr>
						{/if}
					{/if}
				{/foreach}
				{if $itemImageUrl}
					<tr>
						<td class="td-name">Фото</td>
						<td><input type="file" class="input-file" name="image" id="image" value="" /></td>
					</tr>
				{/if}
				{if $item.image}
					<tr>
						<td class="td-name">&nbsp;</td>
						<td>
							<div>
								<img src="{$item.image_path}{$item.image}" alt="" style="border:0;" /><br />
								<a href="#" onclick="DeleteImage(this, '{$item.image}'); return false;">удалить</a>
							</div>
						</td>
					</tr>
				{/if}
				</table>
			</fieldset>
			<div style="text-align:center; margin:10px 0;">
				<input type="submit" name="submit" value="Сохранить" />
				<input type="button" value="Отмена" onclick="document.location = '{$itemConfig.adminScript}{get_params prefix='?' exclude='action,edit'}';" />
			</div>
			<input type="hidden" name="{$itemKey}" id="{$itemKey}" value="{$item[$itemKey]}" />
		</form>
		<p>&nbsp;</p>
	</div>