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
function smarty_modifier_date_day($date1,$date2) 
{

	return (strtotime($date2)-strtotime($date1))/(3600*24);
	
}

/* vim: set expandtab: */

?>
