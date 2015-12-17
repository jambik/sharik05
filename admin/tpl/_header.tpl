<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="{$page.admpath}css/admin.css" type="text/css" rel="stylesheet" />
  {$page.meta}
	<title>{$page.title}</title>
</head>
<body onload="{$page.onload}"><a name="top"></a>
{if $smarty.session.admin}
<table cellpadding="0" cellspacing="0" style="width:100%; margin:0 0 10px 0;">
	<tr>
		<td style="width:33%; text-align:left"><a href="{$page.rootpath}" target="_blank">Сайт</a> <img src="{$page.admpath}img/newwindow.png" alt="" /></td>
		<td style="width:33%; text-align:center;"><div class="admin-caption">Администрирование</div></td>
		<td style="width:33%; text-align:right;">
			{if $smarty.session.admin}
				<img src="{$page.admpath}img/adminicon.gif" alt="" style="vertical-align:middle;" /> {$smarty.session.admin.admin_name} | 
				<a class="logoff" href="login.php?action=logoff">Выход <img src="{$page.admpath}img/logoff.gif" alt="" style="vertical-align:middle; border:0px;" /></a> 
			{/if}
		</td>
	</tr>
	<tr>
		<td colspan="3"><div class="top-hr"></div></td>
	</tr>
</table>
{/if}
<table cellpadding="0" cellspacing="3" class="admin-table">
	<tr>
		{if !$hideMenu}
		<td class="admin-menu">
			<div class="menu-item"><a href="{$page.admpath}pages.php"><img src="{$page.admpath}img/pages.png" alt="" /> Страницы</a></div>
			<div class="menu-hr"></div>
			{if $smarty.session.admin.admin_group == 1}
				<div class="menu-item"><a href="{$page.admpath}log.php"><img src="{$page.admpath}img/log.png" alt="" /> Лог</a></div>
				<div class="menu-item"><a href="{$page.admpath}admins.php"><img src="{$page.admpath}img/user.png" alt="" /> Администраторы</a></div>
			{/if}
		</td>
		{/if}
		<td style="vertical-align:top;" class="admin-content">