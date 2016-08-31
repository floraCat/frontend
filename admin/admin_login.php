<?php
require_once("include.php");

$sdb=new db();


//注册
if(@$_POST["act"]=="register"){
	$addmood=array();
	$addmood["id"]=0;
	$addmood["account"]=$_POST["account"];
	$addmood["password"]=md5($_POST["password"]);
	$rs_add=$sdb->addTableRecode("admin_pass",$addmood);
		$_SESSION["login"]=array();
		$_SESSION["login"]["account"]=$_POST["account"];
		$_SESSION["login"]["password"]=md5($_POST["password"]);
		echo '<script language="javascript">alert("注册成功");location.href="index.php"</script>';		
		exit;
}


//登录
if(@$_POST["act"]=="login"){
	$rs=$sdb->getTableRowResult("admin_pass","id='0'");
	$account=$_POST["account"];
	$password=md5($_POST["password"]);
	if($account<>$rs["account"]){
		echo '<script language="javascript">alert("账户不存在");location.href="admin_login.php";</script>';
	}
	if($password<>$rs["password"]){
		echo '<script language="javascript">alert("密码错误");location.href="admin_login.php";</script>';
	}
	$_SESSION["login"]=array();
	$_SESSION["login"]["account"]=$_POST["account"];
	$_SESSION["login"]["password"]=md5($_POST["password"]);
	echo '<script language="javascript">alert("登录成功");location.href="index.php"</script>';		
	exit;
}		


//修改
if(@$_POST["act"]=="modify"){
	if( empty($_SESSION["login"]["account"]) || empty($_SESSION["login"]["password"]) ){
			echo '<script language="javascript">alert("请先登录");location.href="admin_login.php";</script>';
	}
	$mood=array();
	$mood["account"]=$_POST["account"];
	$mood["password"]=md5($_POST["password"]);
	$rs_modify=$sdb->updateTableCon($mood," sys_admin "," id='0' "); 
	if($rs_modify){
		echo '<script language="javascript">alert("修改成功");location.href="admin_login.php?page=modify&mark=yes";</script>';
		exit;
	} 
}


//退出
if(@$_GET["act"]=="login_out"){
	unset($_SESSION["login"]);
	echo '<script language="javascript">location.href="admin_login.php";</script>';
	exit;
}



if(@$_REQUEST["page"]=="modify"){
	$gSmarty->display("admin_login_modify.html");
}else{
	$rs=$sdb->getTableAllResult("admin_pass","1=1");
	if($rs){
		$gSmarty->assign("rs",$rs);
	}
	$gSmarty->display("admin_login.html");
}


?>