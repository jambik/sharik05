<?php

	$rootPath = "../";
	
	require_once($rootPath."common.php");
	require_once($rootPath.INC_DIR."class.admin.php");
	
	$admin = new Admin();
	if(!$admin->Admin) return "";
	
	// Smarty
	$smarty = new Smarty();
	$smarty->template_dir = $rootPath.ADMIN_TPL_DIR;
	$smarty->compile_dir  = $rootPath.SMARTY_COMPILE_DIR."admin/";
	
	// Set Template Variables
	$page["rootpath"] = $config["folder"];
	$page["admpath"]  = $page["rootpath"].ADMIN_DIR;
	$page["incpath"]  = $page["rootpath"].INC_DIR;
	$page["title"]    = "Администрирование";
	$page["meta"]     = "\n\t".'<script src="'.$page["rootpath"].INC_JQUERY.'jquery.js" type="text/javascript"></script>';
	$page["onload"]   = "";
	
	$smarty->assign("page", $page);
	
	// Display Template
	$smarty->display('index.tpl');
	// Close db connection
	$db->sql_close();

?>