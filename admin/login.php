<?php

	$rootPath = "../";
	
	require_once($rootPath."common.php");
	require_once($rootPath.INC_DIR."class.admin.php");
	
	// Smarty
	$smarty = new Smarty();
	$smarty->template_dir = $rootPath.ADMIN_TPL_DIR;
	$smarty->compile_dir  = $rootPath.SMARTY_COMPILE_DIR."admin/";
	
	$admin = new Admin(false);
	
	$action = isset($_GET["action"]) ? $_GET["action"] : "";
	
	if($action == "logoff")
	{
		$admin->Logoff();
	}
	
	if($admin->LoginSubmitted())
	{
		if($admin->AdminLogon())
		{
			header("Location:index.php");
		}
	}
	
	// Set Template Variables
	$page["rootpath"] = $config["folder"];
	$page["admpath"]  = $page["rootpath"].ADMIN_DIR;
	$page["incpath"]  = $page["rootpath"].INC_DIR;
	$page["title"]    = "Администрирование - Вход";
	$page["meta"]     = "\n\t".'<script src="'.$page["rootpath"].INC_JQUERY.'jquery.js" type="text/javascript"></script>';
	$page["onload"]   = "";
	$page["info"]     = $admin->Info;
	$page["error"]    = $admin->Error;
	
	$smarty->assign("page", $page);
	
	// Display Template
	$smarty->display('login.tpl');
	// Close db connection
	$db->sql_close();

?>