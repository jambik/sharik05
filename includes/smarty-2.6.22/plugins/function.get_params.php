<?php

/**
 * Smarty {pagination} function plugin
 *
 * Type:     function
 * Name:     pagination
 * Date:     September 7, 2007
 * Purpose:  automate pagination links creation.
 * Input:
 *         - count = number of pages
 *         - selected = selected page (current page)
 *         - url = URL that can be used before page number
 *
 * Examples:
 * {pagination count=9}
 * {pagination count=5 selected=3 url='/items.php?portion='}
 * 
 * @version  1.0
 * @author   Dzhanbulat Magomaev
 * @param    array
 * @param    Smarty
 * @return   string
 */
function smarty_function_get_params($params, &$smarty)
{
	$prefix = isset($params['prefix']) ? trim($params['prefix']) : "";
	$suffix = isset($params['suffix']) ? trim($params['suffix']) : "";
	$excludeParams = isset($params['exclude']) ? trim($params['exclude']) : false;
	$output = "";
	
	if($excludeParams)
	{
		$excludeParams = explode(",", $excludeParams);
		foreach($excludeParams as $key => $value) $excludeParams[$key] = trim($value);
	}
	
	if($_GET)
	{
		if($excludeParams)
		{
			foreach($_GET as $key=>$value)
			{
				if(!in_array($key, $excludeParams))
				{
					$output .= "&amp;".$key."=".$value;
				}
			}
		}
		else
		{
			foreach($_GET as $key=>$value)
			{
				$output .= "&amp;".$key."=".$value;
			}
		}
		
		$output = $output ? substr($output, 5) : "";
	}
	
	$output = $output ? $prefix.$output.$suffix : "";
	
	return $output;
}

?>
