<?php

$url="/1html/bs/";//手动修改
$sitename="_set";//手动修改

if($_GET["act"]){
	$temp=$_POST["data_title"];
	$copy=$_POST["data_name"];
	//echo json_encode($temp);exit;
	$str=file_get_contents("".$temp.".html");

	if($copy=="css3"){
		$start_css3=strpos($str,"/*_css3");
		$end_css3=strpos($str,"/*css3_");
		$len_css3=$end_css3-$start_css3;
		$code=substr($str,$start_css3+11,$len_css3-11);
	}
	if($copy=="own"){
		$start_own=strpos($str,"/*_own");
		$end_own=strpos($str,"/*own_");
		$len_own=$end_own-$start_own;
		$code=substr($str,$start_own+10,$len_own-10);
	}
	if($copy=="style"){
		$start_style=strpos($str,"/*_style");
		$end_style=strpos($str,"/*style_");
		$len_style=$end_style-$start_style;
		$code=substr($str,$start_style+12,$len_style-12);
	}
	if($copy=="all_style"){
		$start_css3=strpos($str,"/*_css3");
		$end_css3=strpos($str,"/*css3_");
		$len_css3=$end_css3-$start_css3;
		$css3=substr($str,$start_css3+11,$len_css3-11);

		$start_own=strpos($str,"/*_own");
		$end_own=strpos($str,"/*own_");
		$len_own=$end_own-$start_own;
		$own=substr($str,$start_own+10,$len_own-10);

		$start_style=strpos($str,"/*_style");
		$end_style=strpos($str,"/*style_");
		$len_style=$end_style-$start_style;
		$style=substr($str,$start_style+13,$len_style-13);

		$code=$css3.$own.$style;
	}
	if($copy=="html"){
		$start_html=strpos($str,"<!--_html");
		$end_html=strpos($str,"<!--html_");
		$len_html=$end_html-$start_html;
		$code=substr($str,$start_html+14,$len_html-14);
	}
	if($copy=="js"){
		$start_js=strpos($str,"<!--_js");
		$end_js=strpos($str,"<!--js_");
		$len_js=$end_js-$start_js;
		$code=substr($str,$start_js+13,$len_js-13);
	}
	if($copy=="all"){
		$start_css3=strpos($str,"/*_css3");
		$end_css3=strpos($str,"/*css3_");
		$len_css3=$end_css3-$start_css3;
		$css3=substr($str,$start_css3+11,$len_css3-11);

		$start_own=strpos($str,"/*_own");
		$end_own=strpos($str,"/*own_");
		$len_own=$end_own-$start_own;
		$own=substr($str,$start_own+10,$len_own-10);

		$start_style=strpos($str,"/*_style");
		$end_style=strpos($str,"/*style_");
		$len_style=$end_style-$start_style;
		$style=substr($str,$start_style+12,$len_style-12);
		
		if(!$style==""){
			$style2='<style>'."\n".$css3.$own.$style.'</style>';
		}

		$start_html=strpos($str,"<!--_html");
		$end_html=strpos($str,"<!--html_");
		$len_html=$end_html-$start_html;
		$html=substr($str,$start_html+14,$len_html-14);

		$start_js=strpos($str,"<!--_js");
		$end_js=strpos($str,"<!--js_");
		$len_js=$end_js-$start_js;
		$js=substr($str,$start_js+12,$len_js-12);
		if(!$js==""){
			$js2='<script>'."\n".'$(function(){'."\n".$js.'});'."\n".'</script>';
		}
		$code=$style2."\n\n".$html."\n".$js2;
	}
	echo json_encode($code);
	
	
	
}else if($_GET["list"]){//列举小分类所有
	$list=$_GET["list"];
	include_once("../base.php");
	
}else if($_GET[$sitename]){//展示正文
	include_once("../base.php");
	
}else{//列举大分类
	$url2="../../..".$url."".$sitename."";
	$files=my_scandir($url2);
	foreach($files as $k0=>$v0){
		$temp[$k0]=substr($v0,0,strpos($v0,"_"));
				$cats[0]=$temp[0];
		if($k0>0){
			if($temp[$k0]==$temp[$k0-1]){
			}else{
				$cats[$k0]=$temp[$k0];
			}
		}
	}
	$unit.='<meta charset="utf-8">';
	$unit.='<link type="text/css" rel="stylesheet" href="../../../../css/pc/h_reset.css" />';
	$unit.='<link type="text/css" rel="stylesheet" href="../../css.css" />';
	$unit.='<style>.modeList li{ background:#dbfbe2;}</style>';
	$unit.='<div class="modeList">';
	foreach($cats as $k=>$v){
		$unit.='<li>';
		$unit.='<a class="a img" href="__index.php?list='.$v.'" target="_blank"><img src="/000/web/images/automode/bs/'.$v.'_01" /></a>';
		$unit.='<a class="a" href="__index.php?list='.$v.'" target="_blank">'.$v.'</a>';
		$unit.='</li>';
	}
	$unit.='</div>';
	echo($unit);
}


function my_scandir($dir){
    $files = array();  
    $dir_list = scandir($dir);  
    foreach($dir_list as $file){  
		$path_parts = pathinfo($file);
		if($path_parts['extension']=='html'){
			if ( $file != ".." && $file != "." ){  
				if ( is_dir($dir . "/" . $file) ){  
					$files[$file] = my_scandir($dir . "/" . $file);  
				}else{  
					$files[] = $file;  
				}  
			}  
		}
    }  
    return $files;  
}  



?>

