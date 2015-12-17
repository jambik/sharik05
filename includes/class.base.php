<?php

class Base
{
	
	public $Valid   = true;
	public $InAdmin = false;
	public $Error   = "";
	public $Info    = "";
	
	public $ItemConfig         = array();
	public $ItemImagePrefix    = "";
	public $ItemImagePath      = "";
	public $ItemImageUrl       = "";
	public $ItemImageMaxWidth  = 400;
	public $ItemImageMaxHeight = 400;
	
	public $DbFields = array();
	public $DbKey    = "";
	public $DbOrder  = "";
	public $DbTable  = "";
	public $DbAlias  = "";
	
	public $AjaxFields  = "";
	public $JoinFields  = false;
	public $ArrayFields = false;
	public $HtmlFields  = false;
	public $DateFields  = false;
  public $SetFields   = false;
	
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->SetItemDbFields();
		
		if($this->ItemImagePath) $this->ItemImageUrl = strpos($this->ItemImagePath, "./") === 0 ? substr($this->ItemImagePath, 2) : $this->ItemImagePath;
		
		if(strpos($_SERVER['PHP_SELF'], "admin/") !== false) $this->InAdmin = true;
		
		$this->PrepareFeatures();
		
		if($this->InAdmin) $this->SetAdminConfig();
	}
	
	/**
	 *  Setting Item table fields
	 *
	 */
	public function SetItemDbFields()
	{
		## DESCRIBE TABLE INFORMATION ##
		#
		# $dbField['name'] = 'Бренд';  - Имя поля
		# $dbField['field'] = 'brand_id';  - Название поля в таблице
		# $dbField['type'] = 'key';  - Тип поля (integer, float, text, textarea, html, array, key, date, set)
		# $dbField['hint'] = 'Подсказка';  - Подсказка для поля
		# $dbField['control'] = 'radio';  - Тип отображения поля (radio, button). Используется для типов - array, key, set
		# $dbField['key_table'] = 'brands';  - Таблица для связки. Используется для типов - array, key
		# $dbField['key_alias'] = 'b';  - Alias таблицы для связки. Используется для типов - array, key
		# $dbField['key_value'] = 'brand_name';  - Имя поля выбираемого по ключу из таблица для связки. Используется для типов - array, key
		# $dbField['set_table'] = 'stones';  - Таблица для связки. Используется для типов - set
    # $dbField['set_alias'] = 's';  - Alias таблицы для связки. Используется для типов - set
    # $dbField['set_value'] = 'stone_name';  - Имя выбираемого поля из таблица для связки. Используется для типов - set;
    # $dbField['set_bind_table'] = 'products_stones';  - Имя таблицы для связки ключей. Используется для типов - set;
		# $dbField['edit'] = true;  - Возможность редактировать поле
		# $dbField['empty'] = true;  - Возможность осталвять поле пустым
		# $dbField['default'] = 0;  - Значение по умолчанию
		# $dbField['show'] = true;  - Отображение поля в таблице
		# $dbField['ajax'] = true;  - Возможность редактирования поля через AJAX
		#
		# $this->DbFields[] = $dbField; $dbField = false;
		
		return true;
	}
	
	/**
	 *  Setting Item configs
	 *
	 */
	public function SetAdminConfig()
	{
		## DESCRIBE ADMIN CONFIGURATIONS ##
		#
		# $this->ItemConfig['itemName']    = "Продукт"; // Item name
		# $this->ItemConfig['itemNames']   = "Продукты"; // Item plural name
		# $this->ItemConfig["adminScript"] = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], "/")+1); // Running file
		# $this->ItemConfig["classFile"]   = "class.products.php"; // Current class file
		# $this->ItemConfig["className"]   = get_class($this); // Current class name
		# $this->ItemConfig["showImage"]   = true; // Show image
		# $this->ItemConfig["imagePath"]   = $this->ItemImageUrl."icon/"; // Image path
		# $this->ItemConfig["adminTpl"]    = "base.tpl"; // Template file
		
		return true;
	}
	
	/**
	 *  Is Post Submitted
	 *
	 *  return  boolean  True if form posted, False if not
	 *
	 */
	public function ItemSubmitted()
	{
		return (isset($_POST["submit"]))? true: false;
	}
	
	/**
	 *  Validate Item values
	 *
	 *  @param  array  &$invalidItem  Item with invalid fields if validate is failed
	 *
	 *  return  boolean  True if validate success, False if validate failed
	 *
	 */
	public function ValidateItem(&$invalidItem)
	{
		foreach($this->DbFields as $value)
		{
			if     ( (!isset($_POST[$value['field']]) && !isset($value['ajax'])) || (!isset($_POST[$value['field']]) && !$value['show']) ) continue;
			elseif (in_array($value['type'], array("text","textarea","html")) && !$value['empty'] && !trim($_POST[$value['field']]) ) $this->SetError("Введите поле: <strong>".$value['name']."</strong>. Это поле не может быть пустым");
			elseif (in_array($value['type'], array("integer","float")) && !$value['empty'] && !is_numeric(trim($_POST[$value['field']])) ) $this->SetError("Введите поле: <strong>".$value['name']."</strong>. Значение должно быть числовым");
			elseif (in_array($value['type'], array("array","key")) && !$value['empty'] && !is_numeric($_POST[$value['field']]) ) $this->SetError("Выберите поле: <strong>".$value['name']."</strong>. Нужно выбрать значение из списка");
			elseif (in_array($value['type'], array("date")) && !$value['empty'] && !MakeTimestamp($_POST[$value['field']]) )  $this->SetError("Введите поле: <strong>".$value['name']."</strong>. Укажите дату в правильном формате - дд.мм.гггг");
		}
		
		// if some of item fields invalid then return it
		if(!$this->Valid)
		{
			$invalidItem[$this->DbKey] = $_POST[$this->DbKey];
			if($this->ItemImagePath) $invalidItem["image"] = $this->GetItemImage($this->ItemImagePrefix.$_POST[$this->DbKey]);
			
			foreach($this->DbFields as $value)
			{
				$invalidItem[$value['field']] = isset($_POST[$value['field']]) ? (in_array($value['type'], array("text","textarea","html")) ? stripslashes($_POST[$value['field']]) : $_POST[$value['field']]) : $value['default'];
			}
		}
		
		return $this->Valid;
	}
	
	/**
	 *  Save Item
	 *
	 *  return  integer  Key of inserted of updated item
	 *
	 */
	public function SaveItem()
	{
		global $db;
		
		$item = $this->AssignPostValues();
		
		if($item[$this->DbKey]) // Update item
		{
			$sql = "UPDATE $this->DbTable
							SET ".$this->PrepareUpdateValues($item)."
							WHERE $this->DbKey = {$item[$this->DbKey]}";
			if(!$result = $db->sql_query($sql))
			{
				$this->SetError("Ошибка при обновлении записи", __FILE__, __LINE__, $db->sql_error());
				return false;
			}
			else//if($db->sql_affectedrows())
			{
				$this->SetInfo("Запись обновлена", __FILE__, __LINE__);
				if($this->ItemImagePath) $this->SaveItemImage($item[$this->DbKey]);
				if($this->SetFields) $this->SaveSetItems($item[$this->DbKey]);
				return $item[$this->DbKey];
			}
		}
		else // Insert item
		{
			$sql = "INSERT INTO $this->DbTable
								(".$this->PrepareInsertFields().")
							VALUES
								(".$this->PrepareInsertValues($item).")";
			if(!$result = $db->sql_query($sql))
			{
				$this->SetError("Ошибка при добавлении записи", __FILE__, __LINE__, $db->sql_error());
				return false;
			}
			else
			{
				$id = $db->sql_nextid();
				$this->SetInfo("Запись добавлена", __FILE__, __LINE__);
				if($this->ItemImagePath) $this->SaveItemImage($id);
				if($this->SetFields) $this->SaveSetItems($id);
				return $id;
			}
		}
		
		return "";
	}
	
	/**
	 *  Assign POST values to one variable
	 *
	 *  return  array  Item
	 *
	 */
	public function AssignPostValues()
	{
		$item[$this->DbKey] = isset($_POST[$this->DbKey]) ? intval($_POST[$this->DbKey]) : false;
		
		foreach($this->DbFields as $value)
		{
			if     ( (!isset($_POST[$value['field']]) && !isset($value['ajax'])) || (!isset($_POST[$value['field']]) && !$value['show']) ) continue;
			elseif (in_array($value['type'], array("text","textarea","html"))) $item[$value['field']] = trim($_POST[$value['field']]) ? trim($_POST[$value['field']]) : $value['default'];
			elseif (in_array($value['type'], array("integer","float"))) $item[$value['field']] = is_numeric(trim($_POST[$value['field']])) ? trim($_POST[$value['field']]) : $value['default'];
			elseif (in_array($value['type'], array("array","key"))) $item[$value['field']] = $_POST[$value['field']] ? $_POST[$value['field']] : $value['default'];
			elseif (in_array($value['type'], array("flag"))) $item[$value['field']] = isset($_POST[$value['field']]) ? 1 : 0;
			elseif (in_array($value['type'], array("date"))) $item[$value['field']] = MakeTimestamp($_POST[$value['field']]) ? MakeTimestamp($_POST[$value['field']]) : $value['default'];
		}
		
		return $item;
	}
	
	/**
	 *  Prepare insert fields
	 *
	 *  return  string  Fields string for inserting
	 *
	 */
	public function PrepareInsertFields()
	{
		$insertFields = "";
		
		foreach($this->DbFields as $value)
		{
			if($value["edit"] && $value["type"]!="set")
			{
				$insertFields .= $value['field'].",";
			}
		}
		
		if($this->DbOrder) $insertFields .= $this->DbOrder.",";
		$insertFields = substr($insertFields, 0, strlen($insertFields)-1);
		
		return $insertFields;
	}
	
	/**
	 *  Prepare insert values 
	 *
	 *  @param  array  $fieldsValues  Item fields values
	 *
	 *  return  string  Values string for inserting
	 *
	 */
	public function PrepareInsertValues($fieldsValues)
	{
		$insertValues = "";
		
		foreach($this->DbFields as $value)
		{
			if($value["edit"] && $value["type"]!="set")
			{
				$quote = in_array($value['type'], array("text","textarea","html")) ? "'" : "";
				$insertValues .= $quote.$fieldsValues[$value['field']].$quote.",";
			}
		}
		
		if($this->DbOrder) $insertValues .= $this->GetNextItemOrder().",";
		$insertValues = substr($insertValues, 0, strlen($insertValues)-1);
		
		return $insertValues;
	}
	
	/**
	 *  Prepare update values 
	 *
	 *  @param  array  $fieldsValues  Item fields values
	 *
	 *  return  string  Values string for updating
	 *
	 */
	public function PrepareUpdateValues($fieldsValues)
	{
		$updateValues = "";
		
		foreach($this->DbFields as $value)
		{
			if(isset($fieldsValues[$value['field']]))
			{
				$quote = in_array($value['type'], array("text","textarea","html")) ? "'" : "";
				$updateValues .= $value['field']." = ".$quote.$fieldsValues[$value['field']].$quote.",";
			}
		}
		
		$updateValues = substr($updateValues, 0, strlen($updateValues)-1);
		
		return $updateValues;
	}
	
	/**
	 *  Prepare features
	 */
	public function PrepareFeatures()
	{
		$ajaxFields  = "";
		$joinFields  = false;
		$arrayFields = false;
		$htmlFields  = false;
		$dateFields  = false;
    $setFields   = false;
		
		foreach($this->DbFields as $key=>$value)
		{
			if(isset($value['ajax']) && $value['ajax'] && $value['show']) $ajaxFields .= $value['field'].","; // Prepare Ajax fields
			if($value['type'] == "key")   $joinFields[]  = $key; // Prepare Join fields
			if($value['type'] == "array") $arrayFields[] = $key; // Prepare Array fields
			if($value['type'] == "html")  $htmlFields[]  = $key; // Prepare Html fields
			if($value['type'] == "date")  $dateFields[]  = $key; // Prepare Date fields
      if($value['type'] == "set")   $setFields[]   = $key; // Prepare Set fields
		}
		
		$this->AjaxFields  = $ajaxFields ? substr($ajaxFields, 0, strlen($ajaxFields)-1) : "";
		$this->JoinFields  = $joinFields;
		$this->ArrayFields = $arrayFields;
		$this->HtmlFields  = $htmlFields;
		$this->DateFields  = $dateFields;
    $this->SetFields   = $setFields;
	}
	
	/**
	 *  Get Join Item
	 *
	 *  @param  integer|string  $fieldKey  Item field key|Item field name
	 *
	 *  return  array  Join Item
	 *
	 */
	public function GetJoinItems($fieldKey)
	{
		global $db;
		
		if(!is_numeric($fieldKey))
		{
			foreach($this->DbFields as $key=>$value)
			{
				if($value['field'] == $fieldKey)
				{
					$fieldKey = $key;
					break;
				}
			}
		}
		
		$sql = "SELECT {$this->DbFields[$fieldKey]['field']}, {$this->DbFields[$fieldKey]['key_value']}
						FROM {$this->DbFields[$fieldKey]['key_table']}";
		if(!$result = $db->sql_query($sql))
		{
			$this->SetError("Ошибка при выборе записи", __FILE__, __LINE__, $db->sql_error());
			return false;
		}
		elseif($db->sql_numrows($result))
		{
			$joinItems = $db->sql_fetchrowset($result);
			$db->sql_freeresult($result);
			return $joinItems;
		}
		
		return "";
	}
	
	/**
	 *  Prepare Join string
	 *
	 *  @param  integer|string  $fieldKey  Item field key|Item field name
	 *
	 *  return  string  Join string
	 *
	 */
	public function PrepareJoinString($fieldKey)
	{
		global $db;
		
		if(!is_numeric($fieldKey))
		{
			foreach($this->DbFields as $key=>$value)
			{
				if($value['field'] == $fieldKey)
				{
					$fieldKey = $key;
					break;
				}
			}
		}
		
		if(isset($this->DbFields[$fieldKey]))
		{
			$joinString = " {$this->DbFields[$fieldKey]['key_table']} AS {$this->DbFields[$fieldKey]['key_alias']} ON ({$this->DbAlias}.{$this->DbFields[$fieldKey]['field']} = {$this->DbFields[$fieldKey]['key_alias']}.{$this->DbFields[$fieldKey]['field']}) ";
			return $joinString;
		}
		
		return false;
	}

	/**
	 *  Select Set items
	 *
	 *  @param  integer|string  $fieldKey  Item field key|Item field name
	 *  @param  integer         $id        Item ID
	 *  @param  boolean         $onlyOn    If true then select only on set items, if false select all set items
	 *
	 *  return  array  Set items
	 *
	 */
	public function GetSetItems($fieldKey, $id=false, $onlyOn=false)
	{
		global $db;

		if(!is_numeric($fieldKey))
		{
			foreach($this->DbFields as $key=>$value)
			{
				if($value['field'] == $fieldKey)
				{
					$fieldKey = $key;
					break;
				}
			}
		}

		$havingSql = $onlyOn ? "HAVING set_on > 0" : "";
		$orderSql  = (isset($this->DbFields[$fieldKey]['set_order']) && $this->DbFields[$fieldKey]['set_order']) ? " ORDER BY {$this->DbFields[$fieldKey]['set_order']} " : "";

		if($id)
		{
			$sql = "SELECT {$this->DbFields[$fieldKey]['set_alias']}.{$this->DbFields[$fieldKey]['field']}, {$this->DbFields[$fieldKey]['set_alias']}.{$this->DbFields[$fieldKey]['set_value']}, COUNT(sbt.{$this->DbFields[$fieldKey]['field']}) AS set_on
							FROM {$this->DbFields[$fieldKey]['set_table']} AS {$this->DbFields[$fieldKey]['set_alias']}
							LEFT JOIN {$this->DbFields[$fieldKey]['set_bind_table']} AS sbt ON ({$this->DbFields[$fieldKey]['set_alias']}.{$this->DbFields[$fieldKey]['field']} = sbt.{$this->DbFields[$fieldKey]['field']} AND sbt.{$this->DbKey} = $id)
							GROUP BY {$this->DbFields[$fieldKey]['set_alias']}.{$this->DbFields[$fieldKey]['field']}
							$havingSql
							$orderSql";
		}
		else
		{
			$sql = "SELECT {$this->DbFields[$fieldKey]['field']}, {$this->DbFields[$fieldKey]['set_value']}
							FROM {$this->DbFields[$fieldKey]['set_table']}
							$orderSql";
		}
		
		if(!$result = $db->sql_query($sql))
		{
			$this->SetError("Ошибка при выборе записей", __FILE__, __LINE__, $db->sql_error());
			return false;
		}
		elseif($db->sql_numrows($result))
		{
			$setItems = $db->sql_fetchrowset($result);
			$db->sql_freeresult($result);
			return $setItems;
		}

		return "";
	}

	/**
	 *  Save Set items
	 *
	 *  @param  integer  $id  Item ID
	 *
	 *  return  boolean  True on save success, False on save error
	 *
	 */
	function SaveSetItems($id)
	{
		global $db;

		foreach($this->SetFields as $key)
		{
			if(isset($_POST[$this->DbFields[$key]['field']]))
			{
				$this->DeleteSetItems($key, $id);
				$setItems = $_POST[$this->DbFields[$key]['field']];

				if($setItems)
				{
					$setItems = explode(",", $_POST[$this->DbFields[$key]['field']]);
					$insertValues = "";
					foreach($setItems as $value) $insertValues .= "($id, $value),";
					$insertValues = substr($insertValues, 0, strlen($insertValues)-1);

					$sql = "INSERT INTO {$this->DbFields[$key]['set_bind_table']}
										({$this->DbKey}, {$this->DbFields[$key]['field']})
									VALUES
										$insertValues";
					if(!$result = $db->sql_query($sql))
					{
						$this->SetError("Ошибка при добавлении записей", __FILE__, __LINE__, $db->sql_error());
					}
					else
					{
						$this->SetInfo("Записи успешно сохранены", __FILE__, __LINE__, 2);
					}
				}
			}
		}

		return "";
	}

	/**
	 *  Delete Set Items
	 *
	 *  @param  integer|string  $fieldKey  Item field key|Item field name
	 *  @param  integer         $id        Item ID
	 *
	 *  return  boolean  True on delete success, False on delete error
	 *
	 */
	public function DeleteSetItems($fieldKey, $id)
	{
		global $db;

		if(!is_numeric($fieldKey))
		{
			foreach($this->DbFields as $key=>$value)
			{
				if($value['field'] == $fieldKey)
				{
					$fieldKey = $key;
					break;
				}
			}
		}

		$sql = "DELETE FROM {$this->DbFields[$fieldKey]['set_bind_table']}
						WHERE {$this->DbKey} = $id";
		if(!$result = $db->sql_query($sql))
		{
			$this->SetError("Ошибка при удалении записей", __FILE__, __LINE__, $db->sql_error());
			return false;
		}
		elseif($db->sql_affectedrows())
		{
			$this->SetInfo("Записи успешно удалены", __FILE__, __LINE__, 2);
			return true;
		}

		return "";
	}
	
	/**
	 *  Prepare Search value for select filter
	 *
	 *  @param  string  $search  Search value for search filter
	 *
	 *  return  string  Search Sql text
	 *
	 */
	public function PrepareSearchSql($search)
	{
		$searchSql = "";
		
		if($search)
		{
			foreach($this->DbFields as $value)
			{
				if($value["show"])
				{
					if(in_array($value['type'], array("text","textarea","html","integer","float")))
					{
						$searchSql .= $this->DbAlias.".".$value['field']." LIKE '%".$search."%' OR ";
					}
					elseif(in_array($value['type'], array("key")))
					{
						$searchSql .= $value['key_alias'].".".$value['key_value']." LIKE '%".$search."%' OR ";
					}
					elseif(in_array($value['type'], array("array")))
					{
						eval('global '.substr($value['array'], 0, (strpos($value['array'], "[") ? strpos($value['array'], "[") : strlen($value['array']))).";");
						eval('$array = '.$value['array'].";");
						$arrayKeys = false;
						foreach($array as $arrKey=>$arrValue)
						{
							if(strpos(strtolower($arrValue), strtolower($search)) > -1) $arrayKeys[] = $arrKey;
						}
						$searchSql .= $arrayKeys ? $this->DbAlias.".".$value['field']." IN (".implode(",", $arrayKeys).") OR " : "";
					}
				}
			}
			$searchSql = $searchSql ? " AND (".substr($searchSql, 0, strlen($searchSql)-4).") " : "";
		}
		
		return $searchSql;
	}
	
	/**
	 *  Get Item
	 *
	 *  @param  integer  $id  Item ID
	 *
	 *  return  array  Item
	 *
	 */
	public function GetItem($id)
	{
		global $db;
		
		$selectString = "";
		$joinString = "";
		
		if($this->JoinFields)
		{
			foreach($this->JoinFields as $key)
			{
				$selectString .= ",".$this->DbFields[$key]['key_alias'].".".$this->DbFields[$key]['key_value'];
				$joinString .= " LEFT JOIN ".$this->PrepareJoinString($key);
			}
		}
		
		$sql = "SELECT {$this->DbAlias}.* $selectString
						FROM $this->DbTable AS {$this->DbAlias}
						$joinString
						WHERE $this->DbKey = $id";
		if(!$result = $db->sql_query($sql))
		{
			$this->SetError("Ошибка при выборе записи", __FILE__, __LINE__, $db->sql_error());
			return false;
		}
		elseif($db->sql_numrows($result))
		{
			$item = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			if($this->ItemImagePath)
			{
				$item["image"] = $this->GetItemImage($this->ItemImagePrefix.$id, $this->ItemImagePath);
				$item["image_path"] = $this->ItemImageUrl;
			}
			if($this->SetFields)
			{
				foreach($this->SetFields as $value)
				{
					$item[$this->DbFields[$value]["field"]] = $this->GetSetItems($value, $item[$this->DbKey], $this->InAdmin ? false: true);
				}
			}
			return $item;
		}
		
		return "";
	}
	
	/**
	 *  Get Items
	 *
	 *  @param  integer  $portion    Portion of select
	 *  @param  integer  $quantity   Quantity of selected items
	 *  @param  string   $order      Order field
	 *  @param  string   $orderType  Order type ['ASC', 'DESC']
	 *  @param  string   $whereSql   SQL where string
	 *  @param  boolean  $full       If True select all fields, if False select few fields
	 *  @param  string   $selectSql  Select fields
	 *
	 *  return  array  All Items
	 *
	 */
	public function GetItems($portion=1, $quantity=10, $order="", $orderType="ASC", $search="", $whereSql="", $full=false, $selectSql="")
	{
		global $db;

		if(!$portion)  $portion  = 1;
		if(!$quantity) $quantity = 1000000;
		
		$selectString = "";
		$joinString = "";
		
		foreach($this->DbFields as $value)
		{
			$selectString .= (($value['type']=="html" && !$full) || $value['type']=="set") ? "" : ",".$this->DbAlias.".".$value['field'];
		}
		
		if($this->JoinFields)
		{
			foreach($this->JoinFields as $key)
			{
				$selectString .= ",".$this->DbFields[$key]['key_alias'].".".$this->DbFields[$key]['key_value'];
				$joinString .= " LEFT JOIN ".$this->PrepareJoinString($key);
			}
		}

		if($order && $this->JoinFields) foreach($this->JoinFields as $key) if($this->DbFields[$key]['field'] == $order) $order = $this->DbFields[$key]['key_value'];
		
		$fieldsSql = "{$this->DbAlias}.{$this->DbKey} $selectString".($selectSql ? ",".$selectSql : "");
		$searchSql = $search ? $this->PrepareSearchSql($search) : "";
		$orderSql  = $order ? " $order $orderType " : ($this->DbOrder ? " $this->DbOrder $orderType " : " $this->DbKey $orderType ");
		$limitSql  = ($portion == 1 ? 0 : $portion * $quantity - $quantity).", $quantity ";
		
		$sql = "SELECT $fieldsSql
						FROM $this->DbTable AS $this->DbAlias
						$joinString
						WHERE 1=1 $whereSql $searchSql
						ORDER BY $orderSql
						LIMIT $limitSql";
		if(!$result = $db->sql_query($sql))
		{
			$this->SetError("Ошибка при выборе записей", __FILE__, __LINE__, $db->sql_error());
			return false;
		}
		elseif($db->sql_numrows($result))
		{
			$items = $db->sql_fetchrowset($result);
			$db->sql_freeresult($result);
			if($full)
			{
				if($this->ItemImagePath)
				{
					foreach($items as $key=>$value)
					{
						$items[$key]["image"] = $this->GetItemImage($this->ItemImagePrefix.$value[$this->DbKey]);
						$items[$key]["image_path"] = $this->ItemImageUrl;
					}
				}
				if($this->SetFields)
				{
					foreach($this->SetFields as $setIndex)
					{
						foreach($items as $key=>$value)
						{
							$items[$key][$this->DbFields[$setIndex]["field"]] = $this->GetSetItems($setIndex, $value[$this->DbKey], $this->InAdmin ? false: true);
						}
					}
				}
			}
			return $items;
		}
		
		return "";
	}
	
	/**
	 *  Get Items count
	 *
	 *  @param  string   $search    Search value for select filter
	 *  @param  string   $whereSql  SQL where string
	 *
	 *  return  integer  Items count
	 *
	 */
	public function GetItemsCount($search="", $whereSql="")
	{
		global $db;
		
		$searchSql  = $search ? $this->PrepareSearchSql($search) : "";
		$joinString = "";

		$whereSql .= $this->InAdmin ? "" : " AND {$this->DbAlias}.product_visible = 1 ";
		
		if($search && $this->JoinFields) foreach($this->JoinFields as $key) $joinString .= " LEFT JOIN ".$this->PrepareJoinString($key);
		
		$sql = "SELECT COUNT({$this->DbKey}) AS rows_count
						FROM $this->DbTable AS $this->DbAlias
						$joinString
						WHERE 1=1 $whereSql $searchSql";
		if(!$result = $db->sql_query($sql))
		{
			$this->SetError("Ошибка при выборе записей", __FILE__, __LINE__, $db->sql_error());
			return false;
		}
		elseif($db->sql_numrows($result))
		{
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			return intval($row["rows_count"]);
		}
		
		return "";
	}
	
	/**
	 *  Toggle field in db table
	 *
	 *  @param  integer  $id     Item ID
	 *  @param  string   $field  Item field
	 *
	 *  return  boolean|integer  False on error, new field value on success
	 *
	 */
	public function ToggleField($id, $field)
	{
		global $db;
		
		$sql = "SELECT $field
						FROM $this->DbTable
						WHERE $this->DbKey = $id";
		if(!$result = $db->sql_query($sql))
		{
			$this->SetError("Ошибка при выборе записи", __FILE__, __LINE__, $db->sql_error());
			return false;
		}
		elseif($db->sql_numrows($result))
		{
			$item = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			$fieldValue = intval($item[$field]) ? 0 : 1;
			
			$sql = "UPDATE $this->DbTable
							SET $field = $fieldValue
							WHERE $this->DbKey = $id";
			if(!$result = $db->sql_query($sql))
			{
				$this->SetError("Ошибка при обновлении записи", __FILE__, __LINE__, $db->sql_error());
				return false;
			}
			else
			{
				$this->SetInfo("Запись обновлена", __FILE__, __LINE__);
				return $fieldValue;
			}
		}
		
		return "";
	}
	
	/**
	 *  Delete Item
	 *
	 *  @param  integer  $id  Item ID
	 *
	 *  return  boolean  True on delete success, False on delete error
	 *
	 */
	public function DeleteItem($id)
	{
		global $db;
		
		$sql = "DELETE FROM {$this->DbTable}
						WHERE {$this->DbKey} = $id";
		if(!$result = $db->sql_query($sql))
		{
			$this->SetError("Ошибка при удалении записи", __FILE__, __LINE__, $db->sql_error());
			return false;
		}
		elseif($db->sql_affectedrows())
		{
			$this->SetInfo("Запись удалена", __FILE__, __LINE__);
			if($this->ItemImagePath) $this->DeleteItemImage($this->GetItemImage($this->ItemImagePrefix.$id));
			return true;
		}
		
		return "";
	}
	
	/**
	 *  Get next available order
	 *
	 *  return  integer  Next available order
	 *
	 */
	public function GetNextItemOrder()
	{
		global $db;
		
		$sql = "SELECT *
						FROM $this->DbTable
						ORDER BY $this->DbOrder DESC
						LIMIT 1";
		if(!$result = $db->sql_query($sql))
		{
			$this->SetError("Ошибка при выборе записи", __FILE__, __LINE__, $db->sql_error());
			return false;
		}
		elseif($db->sql_numrows($result))
		{
			$page = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			return $page[$this->DbOrder]+1;
		}
		
		return 1;
	}
	
	/**
	 *  Change Item order
	 *
	 *  @param  integer  $id         Item ID
	 *  @param  string   $direction  Order direction ['up', 'down']
	 *  @param  string   $whereSql   Where Sql string
	 *
	 *  return  boolean  True if change order success, False if change order failed
	 *
	 */
	public function ChangeItemOrder($id, $direction, $whereSql="")
	{
		global $db;
		
		if(!$item = $this->GetItem($id)) return false;
		
		if(strtolower($direction) == "up")
		{
			$sign = "<";
			$sort = "DESC";
		}
		elseif(strtolower($direction) == "down")
		{
			$sign = ">";
			$sort = "ASC";
		}
		
		$sql = "SELECT *
						FROM $this->DbTable AS $this->DbAlias
						WHERE $this->DbOrder $sign ".$item[$this->DbOrder]." AND $this->DbKey <> $id $whereSql
						ORDER BY $this->DbOrder $sort
						LIMIT 1";
		if(!$result = $db->sql_query($sql))
		{
			$this->SetError("Ошибка при выборе записи", __FILE__, __LINE__, $db->sql_error());
			return false;
		}
		else
		{
			if($db->sql_numrows($result))
			{
				$item2 = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);
				$this->SetItemOrder($item[$this->DbKey], $item2[$this->DbOrder]);
				$this->SetItemOrder($item2[$this->DbKey], $item[$this->DbOrder]);
			}
			return true;
		}
	}
	
	/**
	 *  Set Item order
	 *
	 *  @param  integer  $id     Item ID
	 *  @param  integer  $order  New Item order
	 *
	 *  return  boolean  True if change order success, False if change order failed
	 *
	 */
	public function SetItemOrder($id, $order)
	{
		global $db;
		
		$sql = "UPDATE $this->DbTable
						SET $this->DbOrder = $order
						WHERE $this->DbKey = $id";
		if(!$result = $db->sql_query($sql))
		{
			$this->SetError("Ошибка при обновлении записи", __FILE__, __LINE__, $db->sql_error());
			return false;
		}
		elseif($db->sql_affectedrows())
		{
			return true;
		}
		
		return "";
	}
	
	/**
	 *  Save Item image
	 *
	 *  @param  integer  $id         Item ID
	 *  @param  string   $imagePath  Image destination directory
	 *
	 *  return  boolean|string  Image name if save success, False if image save failed
	 *
	 */
	public function SaveItemImage($id, $imagePath="")
	{
		$imagePath = $imagePath ? $imagePath : $this->ItemImagePath;
		
		if(isset($_FILES["image"]) && $_FILES["image"]["name"])
		{
			if($fileName = $this->UploadItemImage($_FILES["image"], $this->ItemImagePrefix.$id, $imagePath))
			{
				$this->ResizeImage($imagePath.$fileName, $imagePath.$fileName, $this->ItemImageMaxWidth, $this->ItemImageMaxHeight);
				return $fileName;
			}
			else
			{
				return false;
			}
		}
		
		return "";
	}
	
	/**
	 *  Upload Image file
	 *
	 *  @param  file    $file       File object
	 *  @param  string  $fileName   Image file name (without extension)
	 *  @param  string  $imagePath  Image destination directory
	 *
	 *  return  boolean  True if upload success, False if upload failed
	 *
	 */
	public function UploadItemImage($file, $fileName, $imagePath="")
	{
		global $rootPath;
		
		$imagePath = $imagePath ? $imagePath : $this->ItemImagePath;
		
		if(is_uploaded_file($file["tmp_name"])) // If file has been uploaded on server
		{
			$validFileExtensions = array("jpg","gif","png","jpeg");
			
			$fileExt = strtolower(substr($file["name"], strrpos($file["name"], ".") + 1)); // File extension
			
			if(in_array($fileExt, $validFileExtensions)) // If file extension is correct
			{
				$fileName .= ".".$fileExt; // file name with extension
				
				if(@move_uploaded_file($file["tmp_name"], $imagePath.$fileName)) // If file has been moved to destination directory
				{
					$this->SetInfo("Файл ".$file["name"]." загружен на сервер", __FILE__, __LINE__);
					return $fileName;
				}
				else
				{
					$this->SetError("Ошибка при перемещении файла ".$file["name"]." на сервере", __FILE__, __LINE__);
				}
			}
			else
			{
				$this->SetError("Неправильное расширение файла ".$file["name"], __FILE__, __LINE__);
			}
		}
		else
		{
			$this->SetError("Ошибка при закачке файла ".$file["name"]." на сервер", __FILE__, __LINE__);
		}
		
		return false;
	}
	
	/**
	 *  Get Image if exist
	 *
	 *  @param  string  $fileName   Image file name (without extension)
	 *  @param  string  $imagePath  Image directory
	 *
	 *  return  string  Image file name
	 *
	 */
	public function GetItemImage($fileName, $imagePath="")
	{
		global $rootPath;
		
		$imagePath = $imagePath ? $imagePath : $this->ItemImagePath;
		
		$extArray = array("jpg","gif","png","jpeg");
		$image = false;
		
		for($i=0; $i<count($extArray); $i++)
		{
			if(file_exists($imagePath.$fileName.".".$extArray[$i]))
			{
				$image = $fileName.".".$extArray[$i];
				break;
			}
		}
		
		return $image;
	}
	
	/**
	 *  Delete Item image
	 *
	 *  @param  string  $fileName   Image file name
	 *  @param  string  $imagePath  Image directory
	 *
	 *  return  boolean  True if delete success, False if delete failed
	 *
	 */
	public function DeleteItemImage($fileName, $imagePath="")
	{
		$imagePath = $imagePath ? $imagePath : $this->ItemImagePath;
		
		if(@unlink($imagePath.$fileName))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 *  Resize Image
	 *
	 *  @param  string   $sourceFile           Source image file
	 *  @param  string   $targetFile           Target image file
	 *  @param  integer  $width                Image width
	 *  @param  integer  $height               Image height
	 *  @param  boolean  $resizeIfSmaller      Resize if image size smaller
	 *  @param  boolean  $maintainAspectRatio  Maintain aspect ration of image
	 *  @param  boolean  $fixedResize          Fixed resize (crop if needed)
	 *
	 *  return  boolean  True if resized, False if not resized
	 *
	 */
	public function ResizeImage($sourceFile, $targetFile, $width, $height, $resizeIfSmaller=false, $maintainAspectRatio=true, $fixedResize=false)
	{
		global $rootPath;
		
		require_once($rootPath.INC_IMAGETRANSFORM."class.imagetransform.php");
		$imgTransformer = new imageTransform();
		
		$imgTransformer->jpegOutputQuality = 90;
		$imgTransformer->sourceFile = $sourceFile;
		$imgTransformer->targetFile = $targetFile;
		$imgTransformer->resizeIfSmaller = $resizeIfSmaller;
		$imgTransformer->maintainAspectRatio = $maintainAspectRatio;
		
		if($fixedResize && $maintainAspectRatio)
		{
			$imgTransformer->readSourceImageSize();
			
			$relativePercent = $height * 100 / $width;
			
			$correctHeight = floor($imgTransformer->sourceImageWidth / 100 * $relativePercent);
			
			if( abs($imgTransformer->sourceImageHeight - $correctHeight) > 1 && $imgTransformer->sourceImageHeight > $correctHeight )
			{
				$imgTransformer->resizeToWidth = $width;
				$imgTransformer->resize();
				$imgTransformer->readTargetImageSize();
				$imgTransformer->sourceFile = $targetFile;
				$imgTransformer->crop(0, round(($imgTransformer->targetImageHeight - $height)/2), $width, $height + round(($imgTransformer->targetImageHeight - $height)/2));
			}
			elseif( abs($imgTransformer->sourceImageHeight - $correctHeight) > 1 && $imgTransformer->sourceImageHeight < $correctHeight )
			{
				$imgTransformer->resizeToHeight = $height;
				$imgTransformer->resize();
				$imgTransformer->readTargetImageSize();
				$imgTransformer->sourceFile = $targetFile;
				$imgTransformer->crop(round(($imgTransformer->targetImageWidth - $width)/2), 0, $width + round(($imgTransformer->targetImageWidth - $width)/2), $height);
			}
			else
			{
				$imgTransformer->resizeToWidth  = $width;
				$imgTransformer->resizeToHeight = $height;
				$imgTransformer->resize();
			}
		}
		else
		{
			$imgTransformer->resizeToWidth  = $width;
			$imgTransformer->resizeToHeight = $height;
			$imgTransformer->resize();
		}
		
		if($imgTransformer->error != "")
		{
			$this->SetError($imgTransformer->error, __FILE__, __LINE__);
			return false;
		}
		else
		{
			return true;
		}
	}
	
	/**
	 *  Resize All Images
	 *
	 *  @param  string   $sourceFiles          Source image files (../files/images/product-*.*)
	 *  @param  string   $targetPath           Target image filepath (../files/images/icon/)
	 *  @param  integer  $width                Image width
	 *  @param  integer  $height               Image height
	 *  @param  boolean  $resizeIfSmaller      Resize if image size smaller
	 *  @param  boolean  $maintainAspectRatio  Maintain aspect ration of image
	 *  @param  boolean  $fixedResize          Fixed resize (crop if needed)
	 *
	 *  return  boolean  True if images resized, False if not resized
	 *
	 */
	public function ResizeAllImages($sourceFiles, $targetPath, $width, $height, $resizeIfSmaller=false, $maintainAspectRatio=true, $fixedResize=false)
	{
		//$this->ResizeAllImages($this->ItemImagePath."original/*", $this->ItemImagePath."/icon", 100, 100, true, true, true);
		if(!$maskImages = glob($sourceFiles)) return false;
		
		for($i=0; $i<count($maskImages); $i++)
		{
			$imgName = substr($maskImages[$i], strrpos($maskImages[$i], "/") + 1);
			//$imgName = substr($imgName, 0, strrpos($imgName, ".")).".jpg";
			$this->ResizeImage($maskImages[$i], $targetPath.$imgName, $width, $height, $resizeIfSmaller, $maintainAspectRatio, $fixedResize);
			$this->SetInfo("Файл $imgName обработан", __FILE__, __LINE__);
		}
		
		return true;
	}
	
	/**
	 *  Set Error
	 *
	 *  @param  string  $error  Error text
	 *  @param  string  $file   File where error
	 *  @param  string  $line   Line where error
	 *  @param  array   $sql    SQL explanation of error
	 *  @param  bool    $valid  Make code invalid when error
	 *  @param  bool    $log    Log error or not (0 - no log and no show, 1 log and show, 2 log and no show)
	 *
	 */
	public function SetError($error, $file = false, $line = false, $sql = false, $valid = false, $log = 1)
	{
		$errorText = "<div>";
		if($error) $errorText .= $error;
		if($file)  $errorText .= " | File: ".$file;
		if($line)  $errorText .= " | Line: ".$line;
		if($sql)   $errorText .= " | SQL Error #".$sql["code"].": ".$sql["message"];
		$errorText .= "</div>\n";
		
		if($log) $this->WriteLog(0, $error, $file, $line, $sql);
		
		$this->Valid  = $valid;
		if($log == 1) $this->Error .= $errorText;
	}
	
	/**
	 *  Set Info
	 *
	 *  @param  string  $info  Info text
	 *  @param  string  $file   File where error
	 *  @param  string  $line   Line where error
	 *  @param  array   $log    Log error or not (0 - no log and no show, 1 log and show, 2 log and no show)
	 *
	 */
	public function SetInfo($info, $file = false, $line = false, $log = 1)
	{
		$infoText = "<div>";
		if($info != "") $infoText .= $info;
		$infoText .= "</div>\n";
		
		if($log) $this->WriteLog(1, $info, $file, $line);
		
		if($log == 1) $this->Info .= $infoText;
	}
	
	/**
	 *  Write Log
	 *
	 *  @param  integer  $status  Log Status (0=error; 1=info)
	 *  @param  string   $text    Error text
	 *  @param  string   $file    File where error
	 *  @param  string   $line    Line where error
	 *  @param  array    $sql     SQL explanation of error
	 *
	 */
	public function WriteLog($status, $text, $file = false, $line = false, $sql = false)
	{
		global $db;
		
		$admin      = $this->InAdmin && isset($_SESSION["admin"]) ? $_SESSION["admin"]["admin_name"] : "";
		$phpSelf    = $_SERVER['PHP_SELF'];
		$text       = $db->sql_escape($text);
		$file       = $file ? $db->sql_escape($file) : "";
		$line       = $line ? $line : 0;
		$sqlCode    = $sql ? $db->sql_escape($sql["code"]) : "";
		$sqlMessage = $sql ? $db->sql_escape($sql["message"]) : "";
		$date       = time();
		
		$sql = "INSERT INTO ".TABLE_LOG."
								(log_admin, log_status, log_php_self, log_text, log_file, log_line, log_sql_code, log_sql_message, log_date)
							VALUES
								('$admin', $status, '$phpSelf', '$text', '$file', $line, '$sqlCode', '$sqlMessage', $date)";
		if(!$result = $db->sql_query($sql))
		{
			$this->SetError("Ошибка при логгировании", __FILE__, __LINE__, $db->sql_error(), false, false);
			return false;
		}
		else
		{
			return true;
		}
		
		return "";
	}
	
}

?>