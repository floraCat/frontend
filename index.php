<?php
include_once("include.php");
$sdb=new db();


/*默认值 [暂时]*/
// $db_name="db_".$_GET["col"]."";
// $tpl_con="content.html";
// $tpl_list="list.html";
// $tpl_list_body="list_body_ttl.html";
// $smarty->assign("tpl_list_body",$tpl_list_body);
// $smarty->assign("iHeight","1000px");
// $smarty->display("index.html");




$g=$_GET;
$p=$_POST;
$r=$_REQUEST;


//首页
if(!$g["page"]){ $smarty->display("top_index.html");}

//前端规范
if($g["page"]=="standard"){ $smarty->display("top_standard.html");}
if($g["page"]=="cssAttr"){ $smarty->display("top_standard_cssAttr.html");}
if($g["page"]=="naming"){ $smarty->display("top_standard_naming.html");}

//前端框架
if($g["page"]=="frame"){ $smarty->display("top_frame.html");}
if($g["page"]=="gulpfile"){ $smarty->display("top_frame_gulpfile.html");}

//常用模块
if($g["page"]=="module"){ $smarty->display("top_module.html");}

//插件
if($g["page"]=="plus"){ $smarty->display("top_plus.html");}

//组件
if($g["page"]=="unit"){ $smarty->display("top_unit.html");}

//部件
if($g["page"]=="part"){ $smarty->display("top_part.html");}

//表单
if($g["page"]=="form"){ $smarty->display("top_form.html");}













?>