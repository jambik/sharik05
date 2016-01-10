<?php

	$rootPath = "./";
	
	// Includes
	require_once($rootPath."common.php");
	require_once($rootPath.INC_DIR."class.pages.php");
	
	// Smarty
	$smarty = new Smarty();
	$smarty->template_dir = SMARTY_TEMPLATES_DIR;
	$smarty->compile_dir  = SMARTY_COMPILE_DIR;
	
	// Page Values
	$page["description"] = "";
	$page["keywords"]    = "";
	$page["title"]       = "Поиск";
	$page["onload"]      = "";
	$page["rootpath"]    = $config["folder"];
	$page["tplpath"]     = $page["rootpath"].SMARTY_TEMPLATES_DIR;
	$page["meta"]        = "\n\t".'<script src="'.$page["rootpath"].INC_JQUERY.'jquery.min.js" type="text/javascript"></script>';
	
	// Items Class
	$pages = new Pages();
	
	$search = isset($_GET["search"]) ? trim($_GET["search"]) : false;

	if(!$search)
	{
		$page["error"] = "Параметры поиска не заданы";
	}
	else
	{
		$searchItems = $items->GetItems(1, 1000000, "", "", $search, "", true);
		$smarty->assign("items", $searchItems);
	}
	
	// Assign Template Values
	$smarty->assign("page", $page);
	$smarty->assign("config", $config);
	
	// Display Template
	$smarty->display("search.tpl");
	
	$db->sql_close();
	
?>