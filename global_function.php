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
	$str=file_get_contents("col_".$page."/".$_REQUEST["col"]."/".$folder."/".$ttl.".html");

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
	if($start_js){ $js=substr($str,$start_js+9,$len_js-11)."\n";}
	else{$js="";}
	

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
	if($arr_code[0]!=""){
		$style='<style>'."\n".$arr_code[0]."\n".'</style>'."\n";
	}else{$style="";};
	if($_REQUEST["page"]=="form"){
		$html='<div class="fForm" style="width:500px; margin:10px auto;">'."\n".$arr_code[2]."\n".'</div>'."\n";
	}else{ $html=$arr_code[2]."\n";}
	if($arr_code[3]!=""){ $js='<script>'."\n".$arr_code[4].'$(function(){'."\n".$arr_code[3].'});'."\n".'</script>'."\n";
	}else{$js="";}
	$code_all=$style.$html.$js;
	return $code_all;
}



function code_str_all($arr_all){
	$style='<style>'."\n".$arr_all[0]."\n".'</style>';
	$html='<form class="fForm" style="width:500px; margin:0 auto;">'."\n".$arr_all[2].'</form>';
	$js=$arr_all[3];
	if(!$js==""){ $js='<script>'."\n".$arr_all[4].'$(function(){'."\n".$arr_all[3].'});'."\n".'</script>';}
	$code_all=$style."\n".$html."\n".$js;
	return $code_all;
}

	

//详情页信息数组
function info_arr($page,$ttl,$folder){
	$str=file_get_contents("col_".$page."/".$_REQUEST["col"]."/".$folder."/".$ttl.".html");

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



//表单全部控件(html/css/js)arr数组
function code_all($page,$folder,$form){
	$cookie_arr=explode("#",substr($form,14));
	$arr_all=array();
	foreach($cookie_arr as $k=>$v){
		$arr[$k]=explode(",",$v);
		$sCode=code_arr($page,$folder,$arr[$k][0]);
		$arr_css=$arr_css.$sCode[0]."\n";
		$arr_spec=$arr_spec.$sCode[1];
		$arr_html=$arr_html.$sCode[2]."\n";
		$arr_js=$arr_js.$sCode[3];
		if($sCode[4]){$arr_fun=$arr_fun.$sCode[4];}
	};

	//样式去重
	$class=array();
	$len_cls=substr_count($arr_css,"}",0);
	for($x=1;$x<=$len_cls;$x++){
		$cls_1[$x]=newstripos($arr_css,"}",$x);			
		if($x>1){ $start_pos=newstripos($arr_css,"}",$x-1);
		}else{ $start_pos=0;}
		$cls_2=stripos($arr_css,".",$start_pos);		
		$len=$cls_1[$x]-$cls_2+1;
		$class[$x]=substr($arr_css,$cls_2,$len);
		$css[1]=$class[1];
		if($x>1){
			$flag=true;
			for($y=1;$y<$x;$y++){
				if($class[$x]==$class[$y]){ $flag=flase;}
			}
			if($flag===true){ $css[$x]=$class[$x];}
		}
	}
	$arr_css=implode("\n\t",$css);

	//脚本去重
	if($arr_js!=""){
		$arr_js=explode("\n", $arr_js);
		$arr_js2=array();
		$arr_exFun2=array();
		foreach($arr_js as $k=>$v){
			if (preg_match('/^[^\.]\w+[\(]/',trim($v))) {
				if(empty($arr_exFun2)){
					$arr_js2[$k]=$v;
					$arr_exFun2[$k]=$v;
				}else{
					$pushIn=1;
					foreach($arr_exFun2 as $k2=>$v2){
						if(trim($v)==trim($v2)){
							$pushIn=0;
						}
					};
					if($pushIn==1){
						$arr_exFun2[$k]=$v;
						$arr_js2[$k]=$v;
					}
				}
			}else{
				$arr_js2[$k]=$v;
			}
		};
		$str_js=implode("\n", $arr_js2);
	}

	//函数去重
	if($arr_fun!=""){
		$str_fun=preg_replace('/}\s*function/','}function',$arr_fun);
		// $size_fun=substr_count($str_fun,"}function ",0);
		// for($x=1;$x<=$size_fun+1;$x++){
		// 	$start_pos=newstripos($str_fun,"function ",$x);
		// 	$end_pos=strpos($str_fun,"}function",$start_pos+9);
		// 	if(!$end_pos){ $end_pos=strlen($str_fun);}
		// 	$len=$end_pos-$start_pos+1;
		// 	$fun=substr($str_fun,$start_pos,$len);
		// 	preg_match('/function\s+([^\(]+)/',$fun,$result);
		// 	$rs[$x]=$result[1];
		// 	$arr_funName[$x]=$rs[$x];
		// 	if($x>1){
		// 		$flag=0;
		// 		foreach($arr_funName as $k2=>$v2){
		// 			if($rs[$x]==$v2){ $flag=1;}
		// 		};
		// 		if($flag==1){ $str_fun=substr_replace($str_fun,'',$start_pos,$len);}
		// 	}
		// }
		$str_fun=str_replace("}function","}"."\n"."function",$str_fun);
	}
	
	array_push($arr_all,"\t".$arr_css,$arr_spec,$arr_html,$str_js,$str_fun);
	return($arr_all);
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
function getRefer($page,$ttl,$folder,$basename){
	$arr_info=info_arr($page,$ttl,$folder);
	$refer=trimall($arr_info[2]);
	if($refer!=""){
		$arr_refer=explode(',', $refer);
		$str_script="";
		foreach($arr_refer as $k=>$v){
			$temp=explode(":", $v);
			if($basename){
				$url_js=basename($temp[0]);
			}else{ $url_js=$temp[0];}
			$script='<script src="'.$url_js.'"></script>';
			$str_script.=$script."\n";
		}
	}
	return $str_script;
}



?>