<?php

	if(strpos($_SERVER['HTTP_HOST'], ".ru"))
	{
		// Mysql - remote
		$dbType = "mysqli";
		$dbHost = "localhost";
		$dbName = "sharik05";
		$dbUser = "sharik05";
		$dbPass = "5BRNwn76hchS8yGT";
		
		$config["folder"] = "/";
	}
	else
	{
		// Mysql - local
		$dbType = "mysqli";
		$dbHost = "localhost";
		$dbName = "sharik05";
		$dbUser = "root";
		$dbPass = "root";
		
		$config["folder"] = "/";
	}
	
	$config["admin_group"][1] = "Администратор";
	$config["admin_group"][2] = "Модератор";
	
	$config["log_status"][0] = "<span style='color:red;'>Ошибка</span>";
	$config["log_status"][1] = "<span style='color:green;'>Инфо</span>";

	$config["site_name"] = "Оформление шарами, салюты, спецэффекты";

?>