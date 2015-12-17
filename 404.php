<?php

	$rootPath = "./";
	
	// Includes
	require_once($rootPath."common.php");
	
	// Smarty
	$smarty = new Smarty();
	$smarty->template_dir = SMARTY_TEMPLATES_DIR;
	$smarty->compile_dir  = SMARTY_COMPILE_DIR;
	
	// Page Values
	$page["description"] = "";
	$page["keywords"]    = "";
	$page["title"]       = "404 - Страница не найдена";
	$page["onload"]      = "";
	$page["rootpath"]    = $config["folder"];
	$page["tplpath"]     = $page["rootpath"].SMARTY_TEMPLATES_DIR;
	$page["meta"]        = "\n\t".'<script src="'.$page["rootpath"].INC_JQUERY.'jquery.min.js" type="text/javascript"></script>';
	
	// Assign Template Values
	$smarty->assign("page", $page);
	$smarty->assign("config", $config);
	
	// Display Template
	$smarty->display("404.tpl");
	
	$db->sql_close();
	
?>