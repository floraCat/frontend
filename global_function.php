<?php


//获取$dir目录下所有文件名称列表
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


//第几次出现的位置
function newstripos($str, $find, $count, $offset=0){
	$pos = stripos($str, $find, $offset);
	$count--;
	if ($count > 0 && $pos !== FALSE){
		$pos = newstripos($str, $find ,$count, $pos+1);
	}
	return $pos;
}


//获取模块'css/spec/html/js/fun'的数组
function code_arr($page,$folder,$ttl){
	$str=file_get_contents("col_".$page."/pc/_temp/".$folder."/".$ttl.".html");

	$start_css=strpos($str,"/*_css");
	$end_css=strpos($str,"/*css_");
	$len_css=$end_css-$start_css;
	$css=substr($str,$start_css+10,$len_css-12);

	$start_spec=strpos($str,"<!--_spec");
	$end_spec=strpos($str,"<!--spec_");
	$len_spec=$end_spec-$start_spec;
	if($start_spec){ $spec=substr($str,$start_spec+12,$len_spec-14);}
	else{$spec="";}

	$start_html=strpos($str,"<!--_html");
	$end_html=strpos($str,"<!--html_");
	$len_html=$end_html-$start_html;
	$html=substr($str,$start_html+14,$len_html-16);

	$start_js=strpos($str,"/*_js");
	$end_js=strpos($str,"/*js_");
	$len_js=$end_js-$start_js;
	$js=substr($str,$start_js+9,$len_js-11);

	$start_fun=strpos($str,"/*_fun");
	$end_fun=strpos($str,"/*fun_");
	$len_fun=$end_fun-$start_fun;
	if($start_fun){ $fun=substr($str,$start_fun+10,$len_fun-12)."\n";}
	else{$fun="";}

	$arr_code=array();
	array_push($arr_code,$css,$spec,$html,$js,$fun);
	return $arr_code;
}


//模块全部源码
function code_str($arr_code){
	if($arr_code[0]!=""){$style='<style>'."\n".$arr_code[0]."\n".'</style>';}
	else{$style="";};
	if($_REQUEST["page"]=="form"){
		$html='<div class="fForm" style="width:500px; margin:10px auto;">'."\n".$arr_code[2]."\n".'</div>';
	}else{ $html=$arr_code[2];}
	$js=$arr_code[3];
	if($js!=""){ $js='<script>'."\n".$arr_code[4]."\n".'$(function(){'."\n".$arr_code[3]."\n".'});'."\n".'</script>';}
	$code_all=$style."\n".$html."\n".$js;
	return $code_all;
}



//详情页信息数组
function info_arr($page,$ttl,$folder){
	$str=file_get_contents("col_".$page."/pc/_temp/".$folder."/".$ttl.".html");

	$start_hack=strpos($str,"<!--_hack");
	$end_hack=strpos($str,"<!--hack_");
	$len_hack=$end_hack-$start_hack;
	$hack=substr($str,$start_hack+14,$len_hack-16);

	$start_desc=strpos($str,"<!--_desc");
	$end_desc=strpos($str,"<!--desc_");
	$len_desc=$end_desc-$start_desc;
	$desc=substr($str,$start_desc+14,$len_desc-16);
	
	$start_refer=strpos($str,"<!--_refer");
	$end_refer=strpos($str,"<!--refer_");
	$len_refer=$end_refer-$start_refer;
	$refer=substr($str,$start_refer+15,$len_refer-17);

	$start_note=strpos($str,"<!--_note");
	$end_note=strpos($str,"<!--note_");
	$len_note=$end_note-$start_note;
	$note=substr($str,$start_note+14,$len_note-16);

	$arr_code=array();
	array_push($arr_code,$hack,$desc,$refer,$note);
	return $arr_code;
}


//删除全部空格
function trimall($str){
    $qian=array(" ","　","\t","\n","\r");
    $hou=array("","","","","");
    return str_replace($qian,$hou,$str); 
}


//格式化：制表符 & 换行
function htmlTabs($str){
	$str=str_replace("    ", "\t",htmlspecialchars($str));
	$str=str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;",$str);
	$str=str_replace("\n","<br />",$str);
	return $str;
}


//获取依赖js文件
function getRefer($page,$ttl,$folder){
	$arr_info=info_arr($page,$ttl,$folder);
	$refer=trimall($arr_info[2]);
	if($refer!=""){
		$arr_refer=explode(',', $refer);
		$str_script="";
		foreach($arr_refer as $k=>$v){
			$temp=explode(":", $v);
			$script='<script src="'.$temp[0].'"></script>';
			$str_script.=$script."\n";
		}
	}
	return $str_script;
}



?>