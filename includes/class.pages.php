<?php

include_once("class.base.php");

class Pages extends Base
{
	
	public $DbFields = array();
	public $DbKey    = "page_id";
	public $DbTable  = TABLE_PAGES;
	public $DbAlias  = "p";
	public $DbOrder  = "page_order";
	
	public function SetItemDbFields()
	{
		$dbField['name'] = 'Название';
		$dbField['field'] = 'page_name';
		$dbField['type'] = 'text';
		$dbField['empty'] = false;
		$dbField['default'] = '';
		$dbField['edit'] = true;
		$dbField['show'] = true;
		$dbField['ajax'] = true;
		$this->DbFields[] = $dbField; $dbField = false;
		
		$dbField['name'] = 'Alias';
		$dbField['field'] = 'page_alias';
		$dbField['type'] = 'text';
		$dbField['hint'] = 'Alias страницы';
		$dbField['empty'] = true;
		$dbField['default'] = '';
		$dbField['edit'] = true;
		$dbField['show'] = true;
		$dbField['ajax'] = true;
		$this->DbFields[] = $dbField; $dbField = false;
		
		$dbField['name'] = 'Title';
		$dbField['field'] = 'page_title';
		$dbField['type'] = 'text';
		$dbField['empty'] = true;
		$dbField['default'] = '';
		$dbField['edit'] = true;
		$dbField['show'] = true;
		$dbField['ajax'] = true;
		$this->DbFields[] = $dbField; $dbField = false;
		
		$dbField['name'] = 'Description';
		$dbField['field'] = 'page_description';
		$dbField['type'] = 'textarea';
		$dbField['empty'] = true;
		$dbField['default'] = '';
		$dbField['edit'] = true;
		$dbField['show'] = false;
		$dbField['ajax'] = false;
		$this->DbFields[] = $dbField; $dbField = false;
		
		$dbField['name'] = 'Keywords';
		$dbField['field'] = 'page_keywords';
		$dbField['type'] = 'textarea';
		$dbField['empty'] = true;
		$dbField['default'] = '';
		$dbField['edit'] = true;
		$dbField['show'] = false;
		$dbField['ajax'] = false;
		$this->DbFields[] = $dbField; $dbField = false;
		
		$dbField['name'] = 'Текст';
		$dbField['field'] = 'page_text';
		$dbField['type'] = 'html';
		$dbField['empty'] = true;
		$dbField['default'] = '';
		$dbField['edit'] = true;
		$dbField['show'] = false;
		$dbField['ajax'] = false;
		$this->DbFields[] = $dbField; $dbField = false;
		
		return true;
	}
	
	public function SetAdminConfig()
	{
		$this->ItemConfig['itemName']    = "Страница"; // Item name
		$this->ItemConfig['itemNames']   = "Страницы"; // Item plural name
		$this->ItemConfig["adminScript"] = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], "/")+1); // Running file
		$this->ItemConfig["classFile"]   = "class.pages.php"; // Current class file
		$this->ItemConfig["className"]   = get_class($this); // Current class name
		$this->ItemConfig["adminTpl"]    = "base.tpl"; // Template file
	}
	
	public function ValidateItem(&$invalidItem)
	{
		global $db, $rootPath;
		
		$rootFiles = scandir($rootPath);
		$rootDirs = false;
		foreach($rootFiles as $filename) if( $filename != "." && $filename != ".." && is_dir($rootPath.$filename) ) $rootDirs[] = $filename;
		
		$reservedAlias = array("catalog", "reviews", "pricelist", "page", "news", "articles", "personal", "user");
		$reservedAlias = array_merge($reservedAlias, $rootDirs);
		
		if(isset($_POST["page_alias"]) && trim($_POST["page_alias"]))
		{
			$alias = trim($_POST["page_alias"]);
			$aliasGenerated = false;
		}
		else
		{
			$alias = Translit($_POST["page_name"]);
			$aliasGenerated = true;
		}
		
		do
		{
			if(is_numeric($alias[0]))
			{
				if($aliasGenerated) { $alias = substr($alias, 1); continue; };
				$this->SetError("Alias не может начинаться с цифры.");
				break;
			}
			elseif( in_array($alias, $reservedAlias) )
			{
				if($aliasGenerated) { $alias.= "_"; continue; };
				$this->SetError("Alias - ".$alias." зарезервирован и не может использоваться.");
				break;
			}
			else
			{
				$pageId = $_POST[$this->DbKey] ? $_POST[$this->DbKey] : 0;
				$sql = "SELECT page_alias
								FROM {$this->DbTable}
								WHERE page_id <> {$pageId}";
				if(!$result = $db->sql_query($sql))
				{
					$this->SetError("Ошибка при выборе записей", __FILE__, __LINE__, $db->sql_error());
					return false;
				}
				else
				{
					$items = $db->sql_fetchrowset($result);
					$db->sql_freeresult($result);
					$pageAliases = GetArrayOfFields($items, "page_alias");
					if( in_array($alias, $pageAliases) )
					{
						if($aliasGenerated) { $alias.= "_"; continue; };
						$this->SetError("Alias - ".$alias." уже используется в другой странице.");
						break;
					}
					else
					{
						$_POST["page_alias"] = $alias;
						break;
					}
				}
			}
		}	while(true);
			
		return parent::ValidateItem($invalidItem);
	}

}

?>