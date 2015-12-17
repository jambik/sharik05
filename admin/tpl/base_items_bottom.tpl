		<div class="bottom-info">
			<div class="total-info">{if $pagination.total}Записи с {$pagination.from} по {$pagination.to} из {$pagination.total} записей{else}Выбрано 0 записей{/if}{if $smarty.get.search} <span class="filter">(отфильтровано из {$pagination.all} записей)</span>{/if}</div>
			<div class="pagination">
				{pagination count=$pagination.pages selected=$pagination.portion url=$pagination.url}
			</div>
			<div class="clear"></div>
		</div>