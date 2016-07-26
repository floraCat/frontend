<?php
include_once("include.php");
$sdb=new db();


$g=$_GET;
$p=$_POST;
$r=$_REQUEST;


//首页
if(!$g["page"]){ $smarty->display("top_index.html");}

//前端规范
if($g["page"]=="standard" && !$g["extra"]){ $smarty->display("top_standard.html");}
if($g["extra"]=="naming_html"){ $smarty->display("extra/naming_html.html");}
if($g["extra"]=="naming_style"){ $smarty->display("extra/naming_style.html");}
if($g["extra"]=="naming_js"){ $smarty->display("extra/naming_js.html");}

if($g["page"]=="cssAttr"){ $smarty->display("top_standard_cssAttr.html");}
if($g["page"]=="naming"){ $smarty->display("top_standard_naming.html");}

//前端框架
if($g["page"]=="frame" && !$g["extra"]){ $smarty->display("top_frame.html");}
if($g["extra"]=="gulpfile"){ $smarty->display("extra/top_frame_gulpfile.html");}
if($g["extra"]=="index"){ $smarty->display("extra/html_index.html");}
if($g["extra"]=="list"){ $smarty->display("extra/html_list.html");}
if($g["extra"]=="html"){ $smarty->display("extra/html.html");}
if($g["extra"]=="reset"){ $smarty->display("extra/reset.html");}


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

//其他
if($g["page"]=="others"){ $smarty->display("top_others.html");}



?>