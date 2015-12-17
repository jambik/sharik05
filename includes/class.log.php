<?php

include_once("class.base.php");

class Log extends Base
{
	
	public $DbFields = array();
	public $DbKey    = "log_id";
	public $DbTable  = TABLE_LOG;
	public $DbAlias  = "l";
	
	public function SetItemDbFields()
	{
		$dbField['name'] = 'Админ';
		$dbField['field'] = 'log_admin';
		$dbField['type'] = 'text';
		$dbField['edit'] = false;
		$dbField['empty'] = true;
		$dbField['default'] = '';
		$dbField['show'] = true;
		$dbField['ajax'] = false;
		$this->DbFields[] = $dbField; $dbField = false;
		
		$dbField['name'] = 'Статус';
		$dbField['field'] = 'log_status';
		$dbField['type'] = 'array';
		$dbField['array'] = '$config["log_status"]';
		$dbField['edit'] = false;
		$dbField['empty'] = false;
		$dbField['default'] = 0;
		$dbField['show'] = true;
		$dbField['ajax'] = false;
		$this->DbFields[] = $dbField; $dbField = false;
		
		$dbField['name'] = 'PHP_SELF';
		$dbField['field'] = 'log_php_self';
		$dbField['type'] = 'text';
		$dbField['edit'] = false;
		$dbField['empty'] = false;
		$dbField['default'] = '';
		$dbField['show'] = true;
		$dbField['ajax'] = false;
		$this->DbFields[] = $dbField; $dbField = false;
		
		$dbField['name'] = 'Текст';
		$dbField['field'] = 'log_text';
		$dbField['type'] = 'text';
		$dbField['edit'] = false;
		$dbField['empty'] = false;
		$dbField['default'] = '';
		$dbField['show'] = true;
		$dbField['ajax'] = false;
		$this->DbFields[] = $dbField; $dbField = false;
		
		$dbField['name'] = 'Файл';
		$dbField['field'] = 'log_file';
		$dbField['type'] = 'text';
		$dbField['edit'] = false;
		$dbField['empty'] = true;
		$dbField['default'] = '';
		$dbField['show'] = true;
		$dbField['ajax'] = false;
		$this->DbFields[] = $dbField; $dbField = false;
		
		$dbField['name'] = 'Строка';
		$dbField['field'] = 'log_line';
		$dbField['type'] = 'integer';
		$dbField['edit'] = false;
		$dbField['empty'] = true;
		$dbField['default'] = 0;
		$dbField['show'] = true;
		$dbField['ajax'] = false;
		$this->DbFields[] = $dbField; $dbField = false;
		
		$dbField['name'] = 'SQL Code';
		$dbField['field'] = 'log_sql_code';
		$dbField['type'] = 'text';
		$dbField['edit'] = false;
		$dbField['empty'] = true;
		$dbField['default'] = '';
		$dbField['show'] = true;
		$dbField['ajax'] = false;
		$this->DbFields[] = $dbField; $dbField = false;
		
		$dbField['name'] = 'SQL Message';
		$dbField['field'] = 'log_sql_message';
		$dbField['type'] = 'text';
		$dbField['edit'] = false;
		$dbField['empty'] = true;
		$dbField['default'] = '';
		$dbField['show'] = true;
		$dbField['ajax'] = false;
		$this->DbFields[] = $dbField; $dbField = false;
		
		$dbField['name'] = 'Дата';
		$dbField['field'] = 'log_date';
		$dbField['type'] = 'date';
		$dbField['edit'] = false;
		$dbField['empty'] = false;
		$dbField['default'] = 0;
		$dbField['show'] = true;
		$dbField['ajax'] = false;
		$this->DbFields[] = $dbField; $dbField = false;
		
		return true;
	}
	
	public function SetAdminConfig()
	{
		$this->ItemConfig['itemName']    = "Лог"; // Item name
		$this->ItemConfig['itemNames']   = "Лог"; // Item plural name
		$this->ItemConfig["adminScript"] = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], "/")+1); // Running file
		$this->ItemConfig["classFile"]   = "class.log.php"; // Current class file
		$this->ItemConfig["className"]   = get_class($this); // Current class name
		$this->ItemConfig["adminTpl"]    = "log.tpl"; // Template file
	}
	
	public function GetItems($portion=1, $quantity=10, $order="", $orderType="ASC", $search="", $whereSql="", $full=false)
	{
		return parent::GetItems($portion, $quantity, ($order ? $order : "log_date"), ($order ? $orderType : "DESC"), $search, $whereSql, $full);
	}
	
}

?>