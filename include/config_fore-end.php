<?php
session_start(); 
define("COMPANY_NAME","DH-U.COM");
define("__MYSQL_HOST__",        "localhost");
define("__MYSQL_USER__",	"root");
define("__MYSQL_PORT__", 	8080);
define("__MYSQL_PASSWORD__",    "123");
define("__MYSQL_DATABASE_NAME__", "fore-end");

//后台登录配置
define("__LOING_SESSION_USER__","login_user");
define("__LOING_SESSION_PWS__","login_pws");
define("__LOING_SESSION_ARR__","login_arr");
define("__BACK_ADMIN_LOGIN_TIME__","login_time");

//前台登录配置
define("__LOING_SESSION_USER_USER__","user_login_user");
define("__LOING_SESSION_USER_PWS__","user_login_pws"); 
define("__BACK_USER_LOGIN_TIME__","user_login_time");
define("__LOING_SESSION_USER_USERID__","user_login_id");

/*ALERT 提示*/
define("__ALERT_OPERAT_SUCCESS__",	"操作成功!");
define("__ALERT_OPERAT_ERROR__",	"操作出错!");

define("__SYS_PAGE_SIZE__",	20);
$GLOBALS["pagesize"] = 15;
/*linu配置
$rootPath=".:/alidata/www/dhu/"; 
$includePath = "$rootPath/include/:$rootPath/libs/:$rootPath/module/:$rootPath/module/:$rootPath/dataAccess/:";
set_include_path(get_include_path() . PATH_SEPARATOR.$includePath);
*/

/**windows 配置**/  

//E:\appserv\APMServ5.2.6\www\htdocs\dhu
$rootPath="D:/fang/AppServ/www/000"; //path to root
//$rootPath="E:/fang/soft/Wamp/wamp/www/ZY"; //path to root

$includePath = "$rootPath/include;$rootPath/libs;$rootPath/module/dataAccess;$rootPath/module";
set_include_path(get_include_path() . PATH_SEPARATOR . $includePath);



ini_set('date.timezone','Asia/Shanghai');
define("__UPLOAD_ROOT__", $rootPath."upload");
/*递归方式的对变量中的特殊字符进行转义*/
function addslashes_deep($value)
{
	if(empty($value)){
		return $value;
	}else{
		return is_array($value) ? array_map('addslashes_deep', $value) : addslashes(htmlspecialchars($value));
	}
} 
?>