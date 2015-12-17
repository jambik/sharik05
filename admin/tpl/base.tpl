{include file="_header.tpl"}

{if $page.error}<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding:5px; font-size:10pt;"><span class="ui-icon ui-icon-alert" style="float:left; margin-right:5px;"></span> {$page.error}</div></div>{/if}
{if $page.info}<div class="ui-widget"><div class="ui-state-highlight ui-corner-all" style="padding:5px; font-size:10pt;"><span class="ui-icon ui-icon-info" style="float:left; margin-right:5px;"></span> {$page.info}</div></div>{/if}

<div class="add-link"><a href="?action=add{get_params prefix='&amp;' exclude='action,edit'}"><img src="{$page.admpath}img/add.gif" alt="" /> Добавить</a></div>

{if $itemConfig.showImage && $ajaxFields}
	<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0;"></iframe>
	<input type="hidden" name="image_path" id="image_path" value="{$itemConfig.imagePath}" />
{/if}

{if $smarty.get.action == "add" || $item}
	{include file="base_item_form.tpl"}
{/if}

{if !$smarty.get.edit && !$smarty.get.action && !$item}
	<div class="items-box">
		{include file="base_items_top.tpl"}
		{include file="base_items_table.tpl"}
		{include file="base_items_bottom.tpl"}
	</div>
	{include file="base_ajax_fields.tpl"}
{/if}

<div id="ajax-dialog" style="display:none;"><div style="padding-top:38px; text-align:center;"><img src="{$page.admpath}img/loading-bar.gif" alt="" /></div></div>
<input type="hidden" name="class-file" id="class-file" value="{$itemConfig.classFile}" />
<input type="hidden" name="class-name" id="class-name" value="{$itemConfig.className}" />

{include file="_footer.tpl"}