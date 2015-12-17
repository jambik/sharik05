		<div class="top-info">
			<div class="item-names">{$itemConfig.itemNames}:</div>
			<div class="items-quantity">
				<form action="" method="get" id="form-quantity">
					Показать
					{capture name=quantity}{get_params prefix='&amp;' exclude='quantity,portion'}{/capture}
					<select name="quantity" id="quantity" onchange="document.location = $('#div-quantity-params').text() ? '?'+$('#form-quantity').serialize() + $('#div-quantity-params').text() : '?'+$('#form-quantity').serialize();">
						<option value="10"{if $pagination.quantity == 10} selected="selected"{/if}>10</option>
						<option value="25"{if $pagination.quantity == 25} selected="selected"{/if}>25</option>
						<option value="50"{if $pagination.quantity == 50} selected="selected"{/if}>50</option>
						<option value="100"{if $pagination.quantity == 100} selected="selected"{/if}>100</option>
					</select>
					записей
					<div style="display:none" id="div-quantity-params">{$smarty.capture.quantity}</div>
				</form>
			</div>
			<div class="items-search">
				<form action="" method="get" id="form-search">
					Поиск:
					{capture name=search}{get_params prefix='&amp;' exclude='search,portion'}{/capture}
					<input type="text" name="search" id="search" value="{$smarty.get.search}" /><button onclick="/*alert($('#div-search-params').text()); return false;*/ document.location = $('#div-search-params').text() ? '?'+$('#form-search').serialize() + $('#div-search-params').text() : '?'+$('#form-search').serialize(); return false;">Go</button>
					<span class="delimiter">|</span>
					<div style="display:none" id="div-search-params">{$smarty.capture.search}</div>
				</form>
			</div>
			
			<div class="clear"></div>
		</div>