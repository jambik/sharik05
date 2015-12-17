<?php

	$rootPath = "../";
	
	require_once($rootPath."common.php");
	require_once($rootPath.INC_DIR."class.admin.php");
	
	// Admin
	$admin = new Admin();
	if(!$admin->Admin) return "";
	
	// Smarty
	$smarty = new Smarty();
	$smarty->template_dir = $rootPath.ADMIN_TPL_DIR;
	$smarty->compile_dir  = $rootPath.SMARTY_COMPILE_DIR."admin/";
	
	// Items Class
	$items = new Admin();
	
	// Assign Page properties
	$page["rootpath"] = $config["folder"];
	$page["admpath"]  = $page["rootpath"].ADMIN_DIR;
	$page["incpath"]  = $page["rootpath"].INC_DIR;
	$page["title"]    = "Администрирование - ".$items->ItemConfig["itemNames"];
	$page["meta"]     = "";
	$page["onload"]   = "";
	
	// If change password
	if($items->ChangePasswordSubmitted())
	{
		if($items->ValidateNewPassword())
		{
			$items->SaveNewPassword();
		}
	}
	
	### Include controller file ###
	include_once("base.php");
	
	// Hide password field
	if(isset($_GET["edit"]) && is_numeric($_GET["edit"]))
	{
		$fields = $items->DbFields;
		$fields[1]["edit"] = false;
		$smarty->assign("itemFields", $fields);
	}
	
	$page["info"]  = $items->Info;
	$page["error"] = $items->Error;
	
	$smarty->assign("page", $page);
	$smarty->assign("config", $config);
	
	$smarty->display($items->ItemConfig["adminTpl"]);
	
	$db->sql_close();

?>