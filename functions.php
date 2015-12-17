<?php

/**
 *  Make timestamp
 *
 *  @param  string  $datetime       Date string
 *  @param  string  $dateDelimiter  Date delimiter
 *  @param  string  $timeDelimiter  Time delimiter
 *
 *  return  integer  Timestamp
 *
 */
function MakeTimestamp($datetime, $dateDelimiter = ".", $timeDelimiter = ":")
{
	$datetime = trim($datetime);
	$DayMonthYear = false;
	$HoursMinutes = false;
	
	if(strpos($datetime, $dateDelimiter) && strpos($datetime, $dateDelimiter, strpos($datetime, $dateDelimiter)+1))
	{
		if(strpos($datetime, " "))
		{
			$DayMonthYear = substr($datetime, 0, strpos($datetime, " "));
			$HoursMinutes = strpos(substr($datetime, strpos($datetime, " ")), $timeDelimiter) ? substr($datetime, strpos($datetime, " ")) : false;
		}
		else
		{
			$DayMonthYear = $datetime;
		}
	}
	
	if($DayMonthYear)
	{
		list($day, $month, $year) = explode($dateDelimiter, $DayMonthYear);
		list($hour, $minute) = $HoursMinutes ? explode($timeDelimiter, $HoursMinutes) : array(date("H"), date("i"));
		$second = date("s");
		
		if(checkdate($month, $day, $year))
		{
			return mktime($hour, $minute, $second, $month, $day, $year);
		}
	}
	
	return false;
}

/**
 * Getting array of fields.
 *
 * @param array  $array      Source Array.
 * @param string $fieldName  Field name.
 * @param bool   $isDistinct OPTIONAL If distinct field values.
 * @param string $separator  OPTIONAL If separator provided array will be returned as string separated by this value.
 * @return array Array of fields.
 */
function GetArrayOfFields(&$array, $fieldName, $distinct=false, $separator="")
{
	if($array)
	{
		$fields = array();
		foreach($array as $key => $value)
		{
			if($distinct)
			{
				if(!in_array($value[$fieldName], $fields))
				{
					$fields[] = $value[$fieldName];
				}
			}
			else
			{
				$fields[] = $value[$fieldName];
			}
		}
	}
	else
	{
		return false;
	}

	if($separator) $fields = implode($separator, $fields);
	
	return $fields;
}

/**
 * Making JavaScript array.
 *
 * @param string $arrayName Array name.
 * @param array  $array     Source array.
 * @return string JavaScript array.
 */
function MakeJsArray($arrayName, $array)
{
	$html = "var $arrayName = new Array(";
	if($array)
	{
		for($i=0; $i<count($array); $i++)
		{
			$html .= "'".$array[$i]."',";
		}
		$html = substr($html, 0, strlen($html)-1);
	}
	$html .= ");";
	return $html;
}

/**
 * Validate email.
 *
 * @param string $email Email for validation.
 * @return bool Email validation result
 */
function ValidateEmail($email)
{
	if(preg_match("/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*?[a-z]+$/is", $email))
	{
		return true;
	}
	
	return false;
}

/**
 * Generate Id.
 *
 * @param int $length Email for validation.
 * @param bool $isNumeric Use numbers in Id.
 * @param bool $isAlpha Use chars in Id.
 * @return string Generated Id
 */
function GenerateId($length=10, $isNumeric=true, $isAlpha=true)
{
	$resultId = "";
	for($i=0; $i<$length; $i++)
	{
		if($isNumeric) $number = rand(0, 9);
		if($isAlpha) $character = chr(rand(65, 90));

		if($isNumeric && $isAlpha)
		{
			if(rand(0,1))
				$resultId .= $number;
			else
				$resultId .= $character;
		}
		elseif($isNumeric)
			$resultId .= $number;
		else
			$resultId .= $character;
	}
	return $resultId;
}

/**
 * Json function.
 */
if(!function_exists('json_encode'))
{
	function json_encode($arr = false, $inside = false)
	{
		if($arr && is_array($arr))
		{
			$json = $inside ? "[" : "{";
			foreach($arr as $key=>$value)
			{
				$json .= $inside ? "" : '"'.$key.'":';
				if(is_int($value) || is_float($value)) $json .= $value;
				elseif(is_string($value))              $json .= '"'.$value.'"';
				elseif(is_bool($value))                $json .= $value ? 'true' : 'false';
				elseif(is_array($value) && $value)     $json .= json_encode($value, true);
				else                                   $json .= 'null';
				$json .= ',';
			}
			$json = substr($json, 0, strlen($json)-1).($inside ? "]" : "}");
			return $json;
		}
		
		return false;
	}
}

/**
 *  Translit by GOST "ГОСТ 16876-71"
 *
 *  @param  string  $content  String for translit
 *
 *  return  string  Translitted string
 *
 */
function Translit($content)
{
	$RuToEn  = array('?' => '', '!' => '', '<' => '', '>' => '', '/' => '', '|' => '', "\\" => '', '-' => '_', "\"" => '', "\'" => '', 'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'jo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'jj', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'eh', 'ю' => 'ju' , 'я' => 'ja' );
	$RuToEn2 = array('A' => 'a', 'Б' => 'b', 'В' => 'v', 'Г' => 'g', 'Д' => 'd', 'Е' => 'e', 'Ё' => 'jo', 'Ж' => 'zh', 'З' => 'z', 'И' => 'i', 'Й' => 'jj', 'К' => 'k', 'Л' => 'l', 'М' => 'm', 'Н' => 'n', 'О' => 'o', 'П' => 'p', 'Р' => 'r', 'С' => 's', 'Т' => 't', 'У' => 'u', 'Ф' => 'f', 'Х' => 'kh', 'Ц' => 'c', 'Ч' => 'ch', 'Ш' => 'sh', 'Щ' => 'shh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'Э' => 'eh', 'Ю' => 'ju' , 'Я' => 'ja' );
	$content = trim(strip_tags($content));
	$content = strtr($content, $RuToEn);
	$content = strtr($content, $RuToEn2);
	$content = preg_replace("/\s+/ms", "_", $content);
	$content = preg_replace("/[ ]+/", "_", $content);
	$content = preg_replace("/[^a-z0-9_\.]+/mi", "", $content);
	return $content;
}

/**
 *  Make Query String
 *
 *  @param  string|array  $excludeParams  Excluded parameters from query string
 *
 *  return  string  Query string
 *
 */
function GetQueryString($excludeParams = false)
{
	if($_GET)
	{
		$queryString = "";
		
		if(is_array($excludeParams))
		{
			foreach($_GET as $key=>$value)
			{
				if(!in_array($key, $excludeParams))
				{
					$queryString .= "&amp;".$key."=".$value;
				}
			}
		}
		elseif(is_string($excludeParams))
		{
			foreach($_GET as $key=>$value)
			{
				if($key != $excludeParams)
				{
					$queryString .= "&amp;".$key."=".$value;
				}
			}
		}
		
		return $queryString;
	}
	
	return "";
}

?>