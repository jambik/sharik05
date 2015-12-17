<?php

	session_start();
	error_reporting(E_ALL);
	if(!ini_get('display_errors'))
	{ 
		ini_set('display_errors', true); 
	}
	
	require_once($rootPath."config.php");
	require_once($rootPath."constants.php");
	require_once($rootPath."functions.php");
	require_once($rootPath.INC_DB.$dbType.".php");
	require_once($rootPath.INC_SMARTY."Smarty.class.php");
	
	// Make the database connection.
	$db = new $sql_db();
	$db->sql_connect($dbHost, $dbUser, $dbPass, $dbName);
	
	if(!$db->db_connect_id)
	{
		die("No connection to database");
	}
	else
	{
		$db->sql_query("SET NAMES utf8");
	}
	
?>