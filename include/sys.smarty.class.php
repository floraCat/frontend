<?php
require_once("smarty/libs/Smarty.class.php");
/**
 *类说明: Smarty配置类
 *表名 t_execute_log_slow_file, 
 *     t_execute_log_file_counter,
 *     t_execute_log_ip_counter,
 *     t_execute_log_die_catcher
 *
 */
class smarty_class{ 
 
	//默认SMARTY配置
    public function getSmarty()
	{
		$gSmarty = new Smarty;		
		$gSmarty->template_dir = "tpl/";
        $gSmarty->compile_dir = 'templates_c/';
		$gSmarty->left_delimiter = "<{";
		$gSmarty->right_delimiter = "}>";
        
		return $gSmarty;
	}
    
    //可变SMARTY配置的方法
	public function getChangeSmarty($tpl_dir="tpl/",$l="<{",$r="}>",$compiledir="templates_c/")
	{
		$gSmarty = new Smarty;		
		$gSmarty->template_dir = $tpl_dir;
        $gSmarty->compile_dir = $compiledir;
        
		$gSmarty->left_delimiter =$l;
		$gSmarty->right_delimiter =$r;
		$gSmarty->caching=false;
		$gSmarty->compile_check=false;
		$gSmarty->force_compile=true;
		return $gSmarty;
	}	
	
}


?> 