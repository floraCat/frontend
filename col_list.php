<?php
include_once("include.php");
$sdb=new db();






//列举小分类
if($_GET["list"]){
	$list=$_GET["list"];
	$page=$_REQUEST['page'];
	$url2="col_".$page."/pc/_temp";
	$sort=$_GET["sort"];
	$handle=scandir($url2);
	$index=0;
	if($sort){//有指定筛选
		$files=@my_scandir($url2."/".$sort);
		foreach($files as $k0=>$v0){
			if(strstr($v0,$list)){
				$ttl=substr($v0,0,-5);
				$temp[$index]["ttl"]=$ttl;
				$arr_code=code_arr($page,$sort,$ttl);
				if($arr_code[0]!=""){$style='<style>'."\n".$arr_code[0]."\n".'</style>';}
				else{$style="";};
				if(!$arr_code[3]==""){ $js="\n".'<script>'."\n".'$(function(){'."\n".$arr_code[3].'});'."\n".'</script>';}
				$code_all=$style."\n".$arr_code[2]."\n".$js;
				$temp[$index]["code"]=$code_all;
				$temp[$index]["folder"]=$sort;
				$index++;
			}
		}
	}
	else{//全部
		foreach($handle as $folder){
			if($folder!='.' || $folder!='..'){
				$files=my_scandir($url2."/".$folder);
				foreach($files as $k0=>$v0){
					if(strstr($v0,$list)){
						$ttl=substr($v0,0,-5);
						$temp[$index]["ttl"]=$ttl;
						$arr_code=code_arr($page,$folder,$ttl);
						if($arr_code[0]!=""){$style='<style>'."\n".$arr_code[0]."\n".'</style>'."\n";}else{$style="";};
						if(!$arr_code[3]==""){ $js="\n".'<script>'."\n".'$(function(){'."\n".$arr_code[3]."\n".'});'."\n".'</script>';}
						$code_all=$style.$arr_code[2].$js;
						$temp[$index]["code"]=$code_all;
						$temp[$index]["folder"]=$folder;
						$index++;
					}
				}
			}
		};

	}
	$smarty->assign("temp",$temp);
	if($page=="module"){
		$sorts=array('base:基本结构模块','refer:参考样式模块');
	}
	if($page=="plus"){
		$sorts=array('self:自主封装插件','common:常用插件','recommend:推荐插件');
	}
	if($page=="part"){
		$sorts=array('mark:符号');
	}
	if($page=="unit"){
		$sorts=array('common:常用');
	}
	foreach($sorts as $k=>$v){
		$arr_sort[$k]=array();
		$arr_sort[$k]=explode(":",$v);

	};
	//print_r($arr_sort);die;
	$smarty->assign("arr_sort",$arr_sort);
	if($page=='part'){
		$smarty->display("list_2.html");
	}else{
		$smarty->display("list_1.html");
	}
}


//获取模板'css/html/js'的数组
function code_arr($page,$folder,$ttl){
	$str=file_get_contents("col_".$page."/pc/_temp/".$folder."/".$ttl.".html");

	$start_css=strpos($str,"/*_css");
	$end_css=strpos($str,"/*css_");
	$len_css=$end_css-$start_css;
	$css=substr($str,$start_css+10,$len_css-12);

	$start_spec=strpos($str,"<!--_spec");
	$end_spec=strpos($str,"<!--spec_");
	$len_spec=$end_spec-$start_spec;
	$spec=substr($str,$start_spec+12,$len_spec-14);
	if(!$spec){$spec="";}

	$start_html=strpos($str,"<!--_html");
	$end_html=strpos($str,"<!--html_");
	$len_html=$end_html-$start_html;
	$html=substr($str,$start_html+14,$len_html-16);

	$start_js=strpos($str,"/*_js");
	$end_js=strpos($str,"/*js_");
	$len_js=$end_js-$start_js;
	$js=substr($str,$start_js+9,$len_js-11);
	$arr_code=array();
	array_push($arr_code,$css,$spec,$html,$js);
	return $arr_code;
}


//模块详情页信息
function code_arr2($page,$ttl,$folder){
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

//第几次出现的位置
function newstripos($str, $find, $count, $offset=0){
	$pos = stripos($str, $find, $offset);
	$count--;
	if ($count > 0 && $pos !== FALSE){
		$pos = newstripos($str, $find ,$count, $pos+1);
	}
	return $pos;
}



//样式设置之'改后查看效果'
if($_REQUEST["setting"]=="render"){
	$newCode=stripcslashes($_REQUEST["newCode"]);
	$newCode=str_replace('    ',"\t",$newCode);//处理制表符
	$newCode=str_replace(' ',"&nbsp;",$newCode);//处理空格
	if($_REQUEST["page"]=="form"){
		$newCode='<div class="fForm" style="width:500px; margin:10px auto;">'."\n".$newCode."\n".'</div>';
	}
	$script=stripcslashes($_REQUEST["script"]);
	$all.=$script."\n".$newCode;
	$view=fopen("temp_details_setting.html","w");
	fwrite($view,'<meta charset="utf-8">'."\n");
	fwrite($view,'<link rel="stylesheet" href="css/h_reset.css" />'."\n");
	fwrite($view,'<script src="js/jquery-1.10.2.js"></script>'."\n");
	fwrite($view,$all);
	fclose($view);
}


//自定义设置
if($_REQUEST["act"]=="setting"){
	$page=$_GET["page"];
	$folder=$_GET["folder"];
	$ttl=$_REQUEST["ttl"];

	//获取依赖js文件
	$arr_info=code_arr2($page,$ttl,$folder);
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
	$smarty->assign("script",$script);

	//模板渲染代码
	$arr_code=code_arr($page,$folder,$ttl);//[0]:css \ [1]:spec \ [2]:html \ [3]:js
	$css='<style>'."\n".$arr_code[0];
	if($page=="form"){
		$html='</style>'."\n".'<div class="fForm" style="width:500px; margin:10px auto;">'."\n".$arr_code[2]."\n".'</div>';
	}else{
		$html='</style>'."\n".$arr_code[2];
	}
	if(!$arr_code[3]==""){ $js='<script>'."\n".'$(function(){'."\n".$arr_code[3]."\n".'});'."\n".'</script>';}
	$all=$str_script."\n".$css."\n".$html."\n".$js;
	$view=fopen("temp_details_setting.html","w");
	fwrite($view,'<meta charset="utf-8">'."\n");
	fwrite($view,'<link rel="stylesheet" href="css/h_reset.css" />'."\n");
	fwrite($view,'<script src="js/jquery-1.10.2.js"></script>'."\n");
	fwrite($view,$all);
	fclose($view);

	//固定和可编辑样式
	if(!$arr_code[1]==""){
		$arr_spec=explode("}",substr(trimall($arr_code[1]),0,-1));
		$arr2_spec=array();
		foreach($arr_spec as $k0=>$v0){
			
			if(substr($v0,0,1)=="!"){//排除可编辑的
				$arr2_spec[$k0]["key"]="!";
				$arr_temp=substr($v0,2);
			}else if(substr($v0,1)=="*"){//全部为固定
				$arr2_spec[$k0]["key"]="*";
				$arr_temp=array();
			}else{
				$arr_temp=substr($v0,1);
			}
			$temp=explode(",",$arr_temp);
			$arr2_spec[$k0]["css"]=$temp;
		};
	}
		
	//可编辑样式添加字体颜色
	$arr_unit=explode('}',substr($arr_code[0],0,-1));
	$str_unit='';
	//echo("<pre>");print_r($arr_spec);echo("</pre>");die;
	foreach($arr_unit as $k1=>$v1){
		$class=substr($v1,0,strpos($v1,"{"));
		$arr_style=explode(";",substr($v1,strpos($v1,"{")+1,-1));
		//此处可插入属性声明顺序的函数
		$css="";
		if($arr2_spec){
			if($arr2_spec[$k1]["key"]=="*"){
				foreach($arr_style as $k2=>$v2){
					$css.='<span style="color:#aaa;">'.$v2.'; </span>';
				}
			}else if($arr2_spec[$k1]["key"]=="!"){
				foreach($arr_style as $k2=>$v2){
					$arr=explode(":",$v2);
					$flag=0;
					foreach($arr2_spec[$k1]["css"] as $k3=>$v3){
						if($v3==trim($arr[0])){ $flag=1;}
					};
					if($flag===1){ $css.=$v2.'; ';
					}else{ $css.='<span style="color:#aaa;">'.$v2.'; </span>';}
				}
			}else{
				foreach($arr_style as $k2=>$v2){
					$arr=explode(":",$v2);
					$flag=0;
					if($arr2_spec[$k1]["css"]){
						foreach($arr2_spec[$k1]["css"] as $k3=>$v3){
							if($v3==trim($arr[0])){ $flag=1;}
						};
					}
					if($flag==0){ $css.=$v2.'; ';
					}else{ $css.='<span style="color:#aaa;">'.$v2.'; </span>';}
				}
			}
		}
		$css='&nbsp;&nbsp;&nbsp;&nbsp;'.$class.'{'.$css.'}<br />';
		$str_unit.=$css;
	};
	$html=str_replace("    ","\t",htmlspecialchars($arr_code[2]));
	$html=str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;",$html);
	$html=str_replace("\n","<br />",$html);
	$js=str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;",htmlspecialchars('<script>'."\n".$arr_code[3]."\n".'</script>'));
	$js=str_replace("\n","<br/>",$js);
	$str_unit='<p>&lt;style&gt;</p>'.$str_unit.'<p>&lt;/style&gt;</p>'.$html."<br />".$js;
	$smarty->assign("str",$str_unit);
	$smarty->display("details_setting.html");
}



//效果展示
if($_REQUEST["_temp"]){
	$page=$_GET["page"];
	$folder=$_GET["folder"];
	$ttl=$_GET["_temp"];

	//获取依赖js文件
	$arr_info=code_arr2($page,$ttl,$folder);
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

	//模板渲染代码
	$arr_code=code_arr($page,$folder,$_REQUEST["_temp"]);
	if($arr_code[0]!=""){ $style='<style>'."\n".$arr_code[0]."\n".'</style>';}
	else{$style="";}
	if(!$arr_code["3"]==""){ $js='<script>'."\n".'$(function(){'."\n".$arr_code[3]."\n".'});'."\n".'</script>';}
	$code_all=$str_script."\n".$style."\n".$arr_code[2]."\n".$js;
	$smarty->assign('content',$code_all);
	$smarty->display("list_1_view.html");
}





//获取dir所有文件名称列表
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

