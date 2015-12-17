<?php
	//$start = (float) array_sum(explode(' ', microtime()));
	require_once($rootPath.INC_CKEDITOR."ckeditor.php");
	
	// Set GET parameters
	$action   = isset($_GET["action"]) ? $_GET["action"] : false;
	$portion  = isset($_GET["portion"]) && is_numeric($_GET["portion"]) ? intval($_GET["portion"]) : 1;
	$quantity = isset($_GET["quantity"]) && is_numeric($_GET["quantity"]) ? intval($_GET["quantity"]) : 10;
	$sort     = isset($_GET["sort"]) ? $_GET["sort"] : false;
	$order    = (isset($_GET["order"]) && strtolower($_GET["order"]) == "desc") ? "desc" : "asc";
	$search   = isset($_GET["search"]) ? $_GET["search"] : false;
	$where    = isset($where) ? $where : "";
	$select   = isset($select) ? $select : "";
	
	// Save Item if submitted
	if($items->ItemSubmitted())
	{
		if($items->ValidateItem($invalidItem))
		{
			$itemId = $items->SaveItem();
		}
		else
		{
			$item = $invalidItem;
		}
	}
	
	// Edit Item
	if(isset($_GET["edit"]) && is_numeric($_GET["edit"]))
	{
		$item = $items->GetItem(intval($_GET["edit"]));
	}
	
	// Delete Item
	if(isset($_GET["delete"]) && is_numeric($_GET["delete"]))
	{
		$items->DeleteItem(intval($_GET["delete"]));
	}

	// Delete Items
	if(isset($_POST["action_group"]) && $_POST["action_group"] == "delete" && isset($_POST["ids"]))
	{
		$items->DeleteItems($_POST["ids"]);
	}
	
	// Change Item order
	if($items->DbOrder)
	{
		if(isset($_GET["up"]) && is_numeric($_GET["up"]))
		{
			$items->ChangeItemOrder(intval($_GET["up"]), "up", $where);
		}
		if(isset($_GET["down"]) && is_numeric($_GET["down"]))
		{
			$items->ChangeItemOrder(intval($_GET["down"]), "down", $where);
		}
	}
	
	########## Set Template Variables ##########
	
	$smarty->assign("itemKey", $items->DbKey);
	$smarty->assign("itemOrder", $items->DbOrder);
	$smarty->assign("itemFields", $items->DbFields);
	$smarty->assign("ajaxFields", $items->AjaxFields);
	$smarty->assign("itemConfig", $items->ItemConfig);
	$smarty->assign("itemImageUrl", $items->ItemImageUrl);
	
	// Assign Array fields values
	if($items->ArrayFields)
	{
		$arrayValues = false;
		foreach($items->ArrayFields as $key)
		{
			eval('$array = '.$items->DbFields[$key]['array'].";");
			if($items->DbFields[$key]['empty']) array_unshift($array, "NULL");
			$arrayValues[$items->DbFields[$key]['field']] = $array;
		}
		$smarty->assign("arrayValues", $arrayValues);
	}
	
	// Assign Join fields values
	if($items->JoinFields)
	{
		$keyValues = false;
		$keyFieldNames = false;
		foreach($items->JoinFields as $key)
		{
			$keyValues[$items->DbFields[$key]['field']] = $items->GetJoinItems($items->DbFields[$key]['field']);
			$keyFieldNames[$items->DbFields[$key]['field']]['key'] = $items->DbFields[$key]['field'];
			$keyFieldNames[$items->DbFields[$key]['field']]['key_value'] = $items->DbFields[$key]['key_value'];
			$keyFieldNames[$items->DbFields[$key]['field']]['empty'] = $items->DbFields[$key]['empty'];
		}
		$smarty->assign("keyValues", $keyValues);
		$smarty->assign("keyFieldNames", $keyFieldNames);
	}
	
	if(isset($item) || $action=="add") // Show Item
	{
		$item = isset($item) ? $item : false;
		
		// If Html fields exists create FCKeditor objects
		if($items->HtmlFields)
		{
			foreach($items->HtmlFields as $key)
			{
				$htmlCode = "";
				$ckEditor[$items->DbFields[$key]['field']] = new CKEditor($items->DbFields[$key]['field']);
				$ckEditor[$items->DbFields[$key]['field']]->basePath = $rootPath.INC_CKEDITOR;
				$ckEditor[$items->DbFields[$key]['field']]->returnOutput = true;
				$ckEditor[$items->DbFields[$key]['field']]->config['toolbar'] = "Full";
				$ckEditor[$items->DbFields[$key]['field']]->config['height'] = 150;
				$ckEditor[$items->DbFields[$key]['field']]->config['contentsCss'] = $page["rootpath"].SMARTY_TEMPLATES_DIR."css/global.css";
				$ckEditor[$items->DbFields[$key]['field']]->config['bodyClass'] = "content";
				if($item) $htmlCode = $item[$items->DbFields[$key]['field']];
				$htmlValues[$items->DbFields[$key]['field']] = $ckEditor[$items->DbFields[$key]['field']]->editor($items->DbFields[$key]['field'], $htmlCode);
			}
			$smarty->assign("htmlValues", $htmlValues);
		}
		
		// If Set fields exist select all set items
		if($items->SetFields)
		{
			foreach($items->SetFields as $key)
			{
				$setValues[$items->DbFields[$key]['field']] = $items->GetSetItems($key, isset($item) ? $item[$items->DbKey] : false);
			}
			$smarty->assign("setValues", $setValues);
		}

		$smarty->assign("item", $item);
	}
	else // Show all items
	{
		$smarty->assign("items", $items->GetItems($portion, $quantity, $sort, $order, $search, $where, true, $select));
		$pagination["total"] = $items->GetItemsCount($search, $where);
		$pagination["all"] = $search ? $items->GetItemsCount(false, $where) : false;
		$pagination["quantity"] = $quantity;
		$pagination["portion"] = $portion;
		$pagination["from"] = $portion*$quantity-$quantity+1;
		$pagination["to"] = ($portion*$quantity > $pagination["total"]) ? $pagination["total"] : $portion*$quantity;
		$pagination["pages"] = ceil($pagination["total"]/$quantity);
		$pagination["url"] = $items->ItemConfig["adminScript"]."?".GetQueryString('portion')."&amp;portion=";
		$smarty->assign("pagination", $pagination);
		
		$page["where"] = $where; // Where Sql string for js MoveItem() function
	}
	
	$page["meta"].= "\n\t".'<script src="/'.ADMIN_DIR.'js/base.js" type="text/javascript"></script>'.
									"\n\t".'<script src="/'.INC_JQUERY.'jquery.min.js" type="text/javascript"></script>'.
									"\n\t".'<script src="/'.INC_JQUERY_UI.'jquery-ui.min.js" type="text/javascript"></script>'.
									"\n\t".'<script src="/'.INC_JQUERY_UI.'lang/ui.datepicker-ru.min.js" type="text/javascript"></script>'.
									"\n\t".'<link href="/'.INC_JQUERY_UI.'theme/jquery-ui.css" type="text/css" rel="stylesheet" />'.
									"\n\t".'<script src="/'.INC_JQUERY_PLUGINS.'jquery.string.1.0-min.js" type="text/javascript"></script>'.
									"\n\t".'<script src="/'.INC_CKEDITOR.'ckeditor.js" type="text/javascript"></script>'.
									"\n\t".'<script type="text/javascript">CKEDITOR.basePath = "/'.INC_CKEDITOR.'";</script>';
	$page["onload"] .= "InitializeForm('form_item');";
	
	//$end = (float) array_sum(explode(' ', microtime()));
	//echo "Processing time: ". sprintf("%.4f", ($end-$start))." seconds";
?>