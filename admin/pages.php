<?php
	
	$rootPath = "../";
	
	require_once($rootPath."common.php");
	require_once($rootPath.INC_DIR."class.admin.php");
	require_once($rootPath.INC_DIR."class.pages.php");
	
	// Admin
	$admin = new Admin();
	if(!$admin->Admin) return "";
	
	// Smarty
	$smarty = new Smarty();
	$smarty->template_dir = $rootPath.ADMIN_TPL_DIR;
	$smarty->compile_dir  = $rootPath.SMARTY_COMPILE_DIR."admin/";
	
	// Items Class
	$items = new Pages();
	
	// Assign Page properties
	$page["rootpath"] = $config["folder"];
	$page["admpath"]  = $page["rootpath"].ADMIN_DIR;
	$page["incpath"]  = $page["rootpath"].INC_DIR;
	$page["title"]    = "Администрирование - ".$items->ItemConfig["itemNames"];
	$page["meta"]     = "";
	$page["onload"]   = "";

	if(!isset($_GET["quantity"])) $_GET["quantity"] = 100;
	
	### Include controller file ###
	include_once("base.php");
	
	$page["info"]  = $items->Info;
	$page["error"] = $items->Error;
	
	$smarty->assign("page", $page);
	$smarty->assign("config", $config);
	
	$smarty->display($items->ItemConfig["adminTpl"]);
	
	$db->sql_close();
	
?>