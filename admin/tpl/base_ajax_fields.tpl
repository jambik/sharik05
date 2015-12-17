	{if $ajaxFields}
		
		<input type="hidden" alt="ajax" name="{$itemKey}" id="ajax-item-id" value="" />
		<input type="hidden" name="ajax-fields" id="ajax-fields" value="{$ajaxFields}" />
		
		{if $arrayValues}
			{foreach from=$arrayValues key=key item=value}
				<span style="display:none" id="ajax-select-{$key}">
					<select name="">
						{foreach from=$value key=key2 item=value2}
						{if $value2 == "NULL"}<option value=""></option>{else}<option value="{$key2}">{$value2}</option>{/if}
						{/foreach}
					</select>
				</span>
			{/foreach}
		{/if}
		
		{if $keyValues}
			{foreach from=$keyValues key=key item=value}
				<span style="display:none" id="ajax-select-{$key}">
					<select name="">
						{assign var=keyFields value=$keyFieldNames[$key]}
						{if $keyFields.empty}<option value=""></option>{/if}
						{foreach from=$value key=key2 item=value2}
						<option value="{$value2[$keyFields.key]}">{$value2[$keyFields.key_value]}</option>
						{/foreach}
					</select>
				</span>
			{/foreach}
		{/if}
		
	{/if}