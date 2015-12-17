<?php

include_once("class.base.php");

class Admin extends Base
{
	
	public $DbFields = array();
	public $DbKey    = "admin_id";
	public $DbTable  = TABLE_ADMIN;
	public $DbAlias  = "a";
	
	public $Admin    = false;
	public $IdleTime = ADMIN_EXPIRED;
	
	public function SetItemDbFields()
	{
		$dbField['name'] = 'Логин';
		$dbField['field'] = 'admin_name';
		$dbField['type'] = 'text';
		$dbField['empty'] = false;
		$dbField['default'] = '';
		$dbField['edit'] = true;
		$dbField['show'] = true;
		$this->DbFields[] = $dbField; $dbField = false;
		
		$dbField['name'] = 'Пароль';
		$dbField['field'] = 'admin_password';
		$dbField['type'] = 'text';
		$dbField['empty'] = false;
		$dbField['default'] = '';
		$dbField['edit'] = true;
		$dbField['show'] = false;
		$this->DbFields[] = $dbField; $dbField = false;
		
		$dbField['name'] = 'Роль';
		$dbField['field'] = 'admin_group';
		$dbField['type'] = 'array';
		$dbField['array'] = '$config["admin_group"]';
		$dbField['empty'] = false;
		$dbField['default'] = 2;
		$dbField['edit'] = true;
		$dbField['show'] = true;
		$this->DbFields[] = $dbField; $dbField = false;
		
		$dbField['name'] = 'Последняя дата';
		$dbField['field'] = 'admin_last_date';
		$dbField['type'] = 'date';
		$dbField['empty'] = true;
		$dbField['default'] = 0;
		$dbField['edit'] = false;
		$dbField['show'] = true;
		$this->DbFields[] = $dbField; $dbField = false;
		
		return true;
	}
	
	public function SetAdminConfig()
	{
		$this->ItemConfig['itemName']    = "Администратор"; // Item name
		$this->ItemConfig['itemNames']   = "Администраторы"; // Item plural name
		$this->ItemConfig["adminScript"] = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], "/")+1); // Running file
		$this->ItemConfig["classFile"]   = "class.admin.php"; // Current class file
		$this->ItemConfig["className"]   = get_class($this); // Current class name
		$this->ItemConfig["adminTpl"]    = "admins.tpl"; // Template file
	}
	
	/**
	 * Constructor
	 *
	 * @param  boolean  $redirect  Redirect to login page
	 */
	public function __construct($redirect = true)
	{
		parent::__construct();
		
		$this->Checking($redirect);
	}
	
	/**
	 * Checking.
	 *
	 * @param  boolean  $redirect        Redirect to login page
	 * @param  boolean  $updateLastDate  Update last admin date
	 */
	function Checking($redirect = true, $updateLastDate = true)
	{
		if(isset($_SESSION["admin"]))
		{
			if($_SESSION["admin"]["admin_last_date"] + $this->IdleTime > time())
			{
				if($updateLastDate)
				{
					$this->UpdateLastDate();
				}
			}
			else
			{
				unset($_SESSION["admin"]);
			}
			
			$this->Admin = isset($_SESSION["admin"]) ? $_SESSION["admin"] : false;
		}
		
		if($redirect && !$this->Admin)
		{
			$this->Redirect("login.php");
		}
		
		return true;
	}
	
	/**
	 * Redirect
	 *
	 * @param  string  $file  File name
	 */
	function Redirect($file)
	{
		header("Location: $file");
		return true;
	}
	
	/**
	 * Logging Off
	 *
	 */
	function Logoff()
	{
		unset($_SESSION["admin"]);
		return true;
	}
	
	/**
	 * Checking if login form submitted
	 *
	 * @return  boolean  True if login form submitted, False if not
	 */
	function LoginSubmitted()
	{
		return (isset($_POST["login_submit"]))? true: false;
	}
	
	/**
	 * Admin Logon. Checking login and password
	 *
	 * @return  boolean  True if login and password match, False if not match
	 */
	function AdminLogon()
	{
		global $db;
		
		$login    = strtolower(trim($_POST["frm_login"]));
		$password = $_POST["frm_password"];
		
		$sql = "SELECT *
						FROM ".TABLE_ADMIN;
		if(!$result = $db->sql_query($sql))
		{
			$this->SetError("Ошибка при выборе записей", __FILE__, __LINE__, $db->sql_error());
			return false;
		}
		else
		{
			if($db->sql_numrows($result))
			{
				$admins = $db->sql_fetchrowset($result);
				$db->sql_freeresult($result);
				
				foreach($admins as $admin)
				{
					if(strtolower($admin["admin_name"]) == $login)
					{
						if($admin["admin_password"] == md5($password))
						{
							$_SESSION["admin"] = $admin;
							$this->UpdateLastDate();
							return true;
						}
						else
						{
							$this->SetError("Неверный пароль", __FILE__, __LINE__);
							return false;
						}
					}
				}
				
				$this->SetError("Администратор не найден", __FILE__, __LINE__);
				return false;
			}
			else
			{
				$this->SetError("В базе нет записей", __FILE__, __LINE__);
				return false;
			}
		}
		
		return false;
	}
	
	/**
	 * Updates Administrator last date
	 *
	 * @return  boolean  True if update successful, False if update failed
	 */
	function UpdateLastDate()
	{
		global $db;
		
		$id   = $_SESSION["admin"]["admin_id"];
		$time = time();
		
		$sql = "UPDATE ".TABLE_ADMIN."
						SET admin_last_date = $time
						WHERE admin_id = $id";
		if(!$result = $db->sql_query($sql))
		{
			$this->SetError("Ошибка при обновлении записи", __FILE__, __LINE__, $db->sql_error());
			return false;
		}
		else
		{
			$_SESSION["admin"]["admin_last_date"] = $time;
			return true;
		}
	}
	
	function ValidateItem(&$invalidItem)
	{
		global $db;
		
		$id = $_POST[$this->DbKey];
		$adminName = strtolower(trim($_POST["admin_name"]));
		
		if(parent::ValidateItem($invalidItem))
		{
			$sql = "SELECT admin_id
							FROM ".TABLE_ADMIN."
							WHERE admin_name LIKE '$adminName'";
			if(!$result = $db->sql_query($sql))
			{
				$this->SetError("Ошибка при выборе записей", __FILE__, __LINE__, $db->sql_error());
				return false;
			}
			elseif($db->sql_numrows($result))
			{
				$admin = $db->sql_fetchrow($result);
				
				if($id != "" && $admin[$this->DbKey] == $id)
				{
					// nothing
				}
				else
				{
					$this->SetError("Администратор с логином $adminName уже существует", __FILE__, __LINE__);
					$this->Valid = false;
				}
			}
		}
		
		return $this->Valid;
	}
	
	function DeleteItem($id)
	{
		global $db;
		
		if($_SESSION["admin"]["admin_id"] == $id)
		{
			$this->SetError("Вы не можете удалить самого себя", __FILE__, __LINE__);
			return false;
		}
		else
		{
			return parent::DeleteItem($id);
		}
	}
	
	function ChangePasswordSubmitted()
	{
		return (isset($_POST["change_password_submit"]))? true: false;
	}
	
	function ValidateNewPassword()
	{
		$password = trim($_POST["admin_password_new"]);
		if($password == "")
		{
			$this->SetError("Пароль не может быть пустым", __FILE__, __LINE__);
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function SaveNewPassword()
	{
		global $db;
		
		$id = $_POST["admin_id"];
		$newPassword = md5($_POST["admin_password_new"]);
		
		$sql = "UPDATE ".$this->DbTable."
						SET admin_password = '$newPassword'
						WHERE admin_id = $id";
		if(!$result = $db->sql_query($sql))
		{
			$this->SetError("Ошибка при обновлении пароля", __FILE__, __LINE__, $db->sql_error());
			return false;
		}
		else
		{
			$this->SetInfo("Пароль обновлен", __FILE__, __LINE__);
			return true;
		}
	}
	
}

?>