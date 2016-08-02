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
if($g["page"]=="standard2" && !$g["extra"]){ $smarty->display("top_standard_2.html");}
if($g["extra"]=="standard_html"){ $smarty->display("extra/standard_html.html");}
if($g["extra"]=="standard_reset"){ $smarty->display("extra/standard_reset.html");}

if($g["extra"]=="standard_css_reset"){ $smarty->display("extra/standard_css_reset.html");}
if($g["extra"]=="standard_less_var"){ $smarty->display("extra/standard_less_var.html");}
if($g["extra"]=="standard_less_mix"){ $smarty->display("extra/standard_less_mix.html");}
if($g["extra"]=="standard_naming_html"){ $smarty->display("extra/standard_naming_html.html");}
if($g["extra"]=="standard_naming_css"){ $smarty->display("extra/standard_naming_css.html");}
if($g["extra"]=="standard_naming_js"){ $smarty->display("extra/standard_naming_js.html");}
if($g["extra"]=="standard_attr_css"){ $smarty->display("extra/standard_attr_css.html");}

if($g["extra"]=="naming_html"){ $smarty->display("extra/naming_html.html");}
if($g["extra"]=="naming_style"){ $smarty->display("extra/naming_style.html");}
if($g["extra"]=="naming_js"){ $smarty->display("extra/naming_js.html");}

if($g["page"]=="standard_cssAttr"){ $smarty->display("extra/standard_cssAttr.html");}

//前端框架
if($g["page"]=="frame" && !$g["extra"]){ $smarty->display("top_frame.html");}
if($g["extra"]=="frame_gulpfile"){ $smarty->display("extra/frame_gulpfile.html");}
if($g["extra"]=="frame_index"){ $smarty->display("extra/frame_index.html");}
if($g["extra"]=="frame_list"){ $smarty->display("extra/frame_list.html");}



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