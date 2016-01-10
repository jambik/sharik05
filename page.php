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
	$page["title"]       = "";
	$page["onload"]      = "";
	$page["rootpath"]    = $config["folder"];
	$page["tplpath"]     = $page["rootpath"].SMARTY_TEMPLATES_DIR;
	$page["meta"]        = "\n\t".'<script src="'.$page["rootpath"].INC_JQUERY.'jquery.min.js" type="text/javascript"></script>';
	$page["meta"]       .= "\n\t".'<script src="'.$page["rootpath"].INC_JQUERY_PLUGINS.'fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>';
	$page["meta"]       .= "\n\t".'<script src="'.$page["rootpath"].INC_JQUERY_PLUGINS.'fancybox-1.3.4/jquery.easing-1.3.pack.js" type="text/javascript"></script>';
	$page["meta"]       .= "\n\t".'<link rel="stylesheet" href="'.$page["rootpath"].INC_JQUERY_PLUGINS.'fancybox-1.3.4/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />';
	
	$pageId = isset($_GET["page"]) && is_numeric($_GET["page"]) ? intval($_GET["page"]) : false;
	$pageAlias = isset($_GET["alias"]) ? $_GET["alias"] : false;
	
	$pages = new Pages();
	
	if($pageId)
	{
		$item = $pages->GetItem($pageId);
		if($item)
		{
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: /".$item["page_alias"]);
			return;
		}
		else
		{
			header("HTTP/1.1 404 Not Found");
			header("Location: /404.php");
			return;
		}
	}
	
	if($pageAlias)
	{
		if( $pageAlias[strlen($pageAlias)-1] == "/" ) $pageAlias = substr ($pageAlias, 0, strlen($pageAlias)-1);
		$pageItem = $pages->GetItems(false, false, "", "", "", " AND {$pages->DbAlias}.page_alias = '{$pageAlias}' ", true);
		if($pageItem)
		{
			$page["title"] = $pageItem[0]["page_title"] ? $pageItem[0]["page_title"] : $pageItem[0]["page_name"];
			$page["description"] = $pageItem[0]["page_description"];
			$page["keywords"] = $pageItem[0]["page_keywords"];
			$page["content"] = $pageItem[0]["page_text"];
		}
		else
		{
			header("HTTP/1.1 404 Not Found");
			header("Location: /404.php");
			return;
			//var_dump($pageAlias);
		}
	}

	// Assign Template Values
	$smarty->assign("page", $page);
	$smarty->assign("config", $config);
	
	// Display Template
	$smarty->display("page.tpl");
	
	$db->sql_close();
	
?>