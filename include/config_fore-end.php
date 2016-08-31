<?php
session_start(); 
define("COMPANY_NAME","DH-U.COM");
define("__MYSQL_HOST__",        "localhost");
define("__MYSQL_USER__",	"root");
define("__MYSQL_PORT__", 	8080);
define("__MYSQL_PASSWORD__",    "123");
define("__MYSQL_DATABASE_NAME__", "fore-end");


define("__SYS_PAGE_SIZE__",	20);
$GLOBALS["pagesize"] = 15;


/*linu配置
$rootPath=".:/alidata/www/dhu/"; 
$includePath = "$rootPath/include/:$rootPath/libs/:$rootPath/module/:$rootPath/module/:$rootPath/dataAccess/:";
set_include_path(get_include_path() . PATH_SEPARATOR.$includePath);
*/

/**windows 配置**/  
$rootPath="D:/_wamp/www/_work/dev/FrontPublic/frontend"; //path to root


/**include相对路径**/ 
$includePath = "$rootPath/include;$rootPath/libs;$rootPath/module/dataAccess;$rootPath/module";
set_include_path(get_include_path() . PATH_SEPARATOR . $includePath);



?>