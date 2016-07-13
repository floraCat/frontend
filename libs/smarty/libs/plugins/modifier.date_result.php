<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty replace modifier plugin
 *
 * Type:     modifier<br>
 * Name:     replace<br>
 * Purpose:  simple search/replace
 * @link http://smarty.php.net/manual/en/language.modifier.replace.php
 *          replace (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param string
 * @param string
 * @return string
 */
/*function smarty_modifier_replace($string, $search, $replace)
{
    return str_replace($search, $replace, $string);
}*/
function smarty_modifier_date_result($date,$a) 
{
	if($a%30==0)
	{
		$month=$a/30;
		return strtotime($date."$month month ");
	}
	else
	{
		return strtotime($date."$a day");
	}
	
}

/* vim: set expandtab: */

?>
