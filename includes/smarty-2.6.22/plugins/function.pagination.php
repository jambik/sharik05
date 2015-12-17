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
function smarty_function_pagination($params, &$smarty)
{
		$count    = (is_numeric($params['count'])) ? intval($params['count']) : 1;
		$selected = (is_numeric($params['selected'])) ? intval($params['selected']) : 1;
		$url = isset($params['url']) ? trim($params['url']) : "";
		//var_dump($_GET);
		$html = "";
		
		if($count > 1)
		{
			for($i=1; $i<=$count; $i++)
			{
				if($selected == $i)
				{
					$html .= '<span class="selected">'.$i.'</span> ';
				}
				else
				{
					$html .= '<a href="'.$url.$i.'">'.$i.'</a> ';
				}
			}
		}
		
		return $html;
}

?>
