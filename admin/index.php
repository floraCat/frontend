<?php
require_once("include.php");
if( empty($_SESSION["login"]["account"]) || empty($_SESSION["login"]["password"]) ){
    sys_jumpurl::jsRedirect("","admin_login.php");
    exit;
}


$sdb=new db();
$g=$_GET;

$rsCol=$sdb->getTableAllResult("sys_col","1=1 Order By id ASC");
$gSmarty->assign("rsCol",$rsCol);

if(@$g["part"]=="top"){
		$gSmarty->display("admin_top.html");
		exit();
}elseif(@$g["part"]=="left"){
		$gSmarty->display("admin_left.html");
		exit();
}elseif(@$g["part"]=="right"){
		$gSmarty->display("admin_right.html");
		exit();
}else{
		$gSmarty->display("index.html");
		exit();
};


?>
