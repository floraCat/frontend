<?php
include_once("../include/config_fore-end.php"); 
error_reporting(E_ALL & ~E_NOTICE);
/*********引入通用类*********************/
include_once("sys.db.class.php");
include_once("sys.smarty.class.php");
/*************通用类实例化************/
//实例化SMARTY
$CSmarty=new smarty_class;
$gSmarty=$CSmarty->getSmarty();
include_once("sys.session.class.php");
include_once("sys.jumpurl.class.php");
//include_once("sys.get.class.php");
include_once("sys.page.class.php");//分页
//include_once("sys.upload.class.php");
//include_once("sys.upload2.class.php");
$Cjumpurl=new sys_jumpurl();
/************定义变量**************************/
@$act=$_REQUEST["act"];
?>