<?php

header("Content-type: text/html; charset=utf-8");
define('EXAMPLE_IN_YES', true);//用于关闭project
include_once("include/config_fore-end.php");//配置
error_reporting(E_ALL & ~E_NOTICE); //用于上线后隐藏报错，开发是不需要隐藏

//系统默认类
include_once("sys.db.class.php");//数据库
include_once("sys.smarty.class.php");//模板
include_once("sys.page.class.php");//分页

//实例化SMARTY
$CSmarty=new smarty_class;
$smarty=$CSmarty->getChangeSmarty("/templates","<{","}>","templates_c");
$smarty->caching = false;

?>