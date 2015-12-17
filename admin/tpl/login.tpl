{include file="_header.tpl" hideMenu=true}
<div style="height:50px"></div>
<div style="height:20px">
	{if $page.error}<div class="error">{$page.error}</div>{/if}
	{if $page.info}<div class="info">{$page.info}</div>{/if}
</div>
<div align="center">
	<h1>Администрирование</h1>
	<form name="form_login" action="" method="post">
		<table>
			<tr>
				<td><img style="margin:0 10px 0 0;" src="{$page.admpath}img/admin.jpg" alt="" /></td>
				<td align="right">
					<div>логин <input type="text" name="frm_login" id="frm_login" /></div>
					<div>пароль <input type="password" name="frm_password" id="frm_password" value="" /></div>
					<div><input type="submit" name="login_submit" value="Вход" onclick="" /></div>
				</td>
			</tr>
		</table>
	</form>
</div>
<div style="height:60px"></div>
{include file="_footer.tpl"}