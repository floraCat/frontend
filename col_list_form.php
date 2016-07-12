<?php
include_once("include.php");
$sdb=new db();



//列举/_temp/下文件夹内的文件名
if($_GET["list"]){
	$list=$_GET["list"];
	$page=$_REQUEST['page'];
	$url2="col_form/pc/_temp";
	$sort=$_GET["sort"];
	$files=my_scandir($url2);
	$index=0;
	foreach($files as $k0=>$v0){
		if(strstr($v0,$list)){
			$ttl=substr($v0,0,-5);
			$temp[$index]["ttl"]=$ttl;
			$arr_code=code_arr($page,$sort,$ttl);
			$style='<style>'."\n".$arr_code[0]."\n".'</style>';
			if(!$arr_code[3]==""){ $js='<script>'."\n".'$(function(){'."\n".$arr_code[3]."\n"."\n".'});'."\n".'</script>';}
			$code_all=$style."\n".$arr_code[2]."\n".$js;
			$temp[$index]["code"]=$code_all;
			$index++;
		}
	}
	$smarty->assign("temp",$temp);
	$smarty->display("list_form.html");
}




//效果展示
if($_GET["_temp"]){
	$page=$_GET["page"];
	$folder=$_GET["folder"];
	$arr_code=code_arr($page,$folder,$_REQUEST["_temp"]);
	$style='<style>'."\n".$arr_code[0]."\n".'</style>';
	$html='<div class="fForm">'."\n".$arr_code[2]."\n".'</div>';
	if(!$arr_code[3]==""){ $js='<script>'."\n".'$(function(){'."\n".$arr_code[3]."\n".'});'."\n".'</script>';}
	$code_all=$style."\n".$html."\n".$js;
	$smarty->assign('content',$code_all);
	$smarty->display("list_form_view.html");
}




//控件清单数据存储
if($_REQUEST["act"]=="formData"){
	$cookie_form=explode('#',substr($_COOKIE['form'],14));
	$cookie_code=substr($_COOKIE['form'],0,13);
	//遍历cookie新增的存数据库
	foreach($cookie_form as $k=>$v){
		$arr_save[$k]=array();
		$arr_save[$k]["cookie_code"]=$cookie_code;
		$unit[$k]=explode(',',$v);
		$arr_save[$k]["ttl"]=$unit[$k][0];
		$arr_save[$k]["onlyID"]=$unit[$k][0]."_".$cookie_code;
		$arr_save[$k]["img"]=$unit[$k][1];
		$arr_save[$k]["sort"]=$k+1;	
		$rs_get[$k]=$sdb->getTableRowResult("cookie_form"," onlyID='".$arr_save[$k]["onlyID"]."' ");
		if(!$rs_get[$k]){
			$rs_add=$sdb->addTableRecode("cookie_form",$arr_save[$k]);
		}
	};
	//遍历数据库把cookie中没有的删掉
	$rs_get2=$sdb->getTableAllResult("cookie_form","1=1 And cookie_code='".$cookie_code."' ");
	foreach($rs_get2 as $k2=>$v2){
		$flag=0;
		foreach($cookie_form as $k3=>$v3){
			$unit2[$k3]=explode(',',$v3);
			if($unit2[$k3][0]==$v2["ttl"]){ $flag=1;}
		}
		if($flag==0){//已删
			$rs_del=$sdb->deleteTableResult("cookie_form"," onlyID='".$v2["onlyID"]."' ");
		}
	};
	die;
}


//控件清单
if($_REQUEST["act"]=="formCart"){
	$smarty->display("list_form_cart.html");
}



//最前 __[控件清单]
if($_REQUEST["goto"]=="first"){
	$arr_mod=array();
	$onlyID=$_REQUEST["ttl"]."_".$_REQUEST["code"];
	$arr_mod["sort"]=0;
	$rs_mod=$sdb->updateTableCon($arr_mod,"cookie_form"," onlyID='".$onlyID."' ");
	$rs_get=$sdb->getTableAllResult("cookie_form","1=1 And cookie_code='".$_REQUEST["code"]."' Order By Sort ASC");
	if($rs_get){
		$sort_def=0;
		foreach($rs_get as $k=>$v){
			$arr_mod2=array();
			$arr_mod2["sort"]=$sort_def+1;
			$rs_arr_mod2=$sdb->updateTableCon($arr_mod2,"cookie_form","id='".$v["id"]."' "); 
			$sort_def++;
		};
	}
	$rs_get2=$sdb->getTableAllResult("cookie_form","1=1 And cookie_code='".$_REQUEST["code"]."' Order By Sort ASC");
	echo json_encode($rs_get2);
	exit;
}	


//最后 __[控件清单]
if($_REQUEST["goto"]=="last"){
	$arr_mod=array();
	$onlyID=$_REQUEST["ttl"]."_".$_REQUEST["code"];
	$arr_mod["sort"]=10000;
	$rs_mod=$sdb->updateTableCon($arr_mod,"cookie_form"," onlyID='".$onlyID."' ");
	$rs_get=$sdb->getTableAllResult("cookie_form","1=1 And cookie_code='".$_REQUEST["code"]."' Order By Sort ASC");
	if($rs_get){
		$sort_def=0;
		foreach($rs_get as $k=>$v){
			$arr_mod2=array();
			$arr_mod2["sort"]=$sort_def+1;
			$rs_arr_mod2=$sdb->updateTableCon($arr_mod2,"cookie_form","id='".$v["id"]."' "); 
			$sort_def++;
		};
	}
	$rs_get2=$sdb->getTableAllResult("cookie_form","1=1 And cookie_code='".$_REQUEST["code"]."' Order By Sort ASC");
	echo json_encode($rs_get2);
	exit;
}	


//向上一级 __[控件清单]
if($_REQUEST["goto"]=="up"){
	$arr_mod_prev=array();
	$onlyID_prev=$_REQUEST["ttl_prev"]."_".$_REQUEST["code"];
	$arr_mod_prev["sort"]=$_REQUEST["sort"];
	$rs_mod_prev=$sdb->updateTableCon($arr_mod_prev,"cookie_form","onlyID='".$onlyID_prev."' ");
	$arr_mod=array();
	$onlyID=$_REQUEST["ttl"]."_".$_REQUEST["code"];
	$arr_mod["sort"]=$_REQUEST["sort"]-1;
	$rs_mod=$sdb->updateTableCon($arr_mod,"cookie_form","onlyID='".$onlyID."' ");

	$rs_get2=$sdb->getTableAllResult("cookie_form","1=1 And cookie_code='".$_REQUEST["code"]."' Order By Sort ASC");
	echo json_encode($rs_get2);
	exit;
}	


//删除 __[控件清单]
if($_REQUEST["goto"]=="del"){
	$onlyID=$_REQUEST["ttl"]."_".$_REQUEST["code"];
	$rs_del=$sdb->deleteTableResult("cookie_form","onlyID='".$onlyID."' ");
	$rs_get=$sdb->getTableAllResult("cookie_form","1=1 And cookie_code='".$_REQUEST["code"]."' Order By Sort ASC");
	if($rs_get){
		$sort_def=0;
		foreach($rs_get as $k=>$v){
			$arr_mod2=array();
			$arr_mod2["sort"]=$sort_def+1;
			$rs_arr_mod2=$sdb->updateTableCon($arr_mod2,"cookie_form","id='".$v["id"]."' "); 
			$sort_def++;
		};
	}
	$rs_get2=$sdb->getTableAllResult("cookie_form","1=1 And cookie_code='".$_REQUEST["code"]."' Order By Sort ASC");
	echo json_encode($rs_get2);
	exit;
}	



//查看效果
if($_REQUEST["act"]=="viewForm"){
	$page=$_REQUEST['page'];
	$folder=$_REQUEST["folder"];
	$arr_all=code_all($page,$folder,$_REQUEST["form"]);
	$smarty->assign("sCode",$arr_all);
	$formWarp='.fForm{width:500px; margin-left:auto; margin-right:auto;}';
	$smarty->assign("formWarp",$formWarp);
	$smarty->display("list_form_viewAll.html");
}



//合成表单(详情页)
if($_REQUEST["act"]=="createForm"){
	$page=$_REQUEST["page"];
	$folder=$_REQUEST["folder"];
	$arr_all=code_all($page,$folder,$_REQUEST["form"]);
	$style='<style>'."\n".$arr_all[0]."\n".'</style>';
	$js=$arr_all[2];
	if(!$js==""){ $js='<script>'."\n".'$(function(){'."\n".$arr_all[2]."\n".'});'."\n".'</script>';}
	$code_all=$style."\n".$arr_all[1]."\n".$js;
	$smarty->assign("code",$code_all);
	$smarty->display("details_formAll.html");
}



//样式设置[全部控件]
if($_REQUEST["act"]=="settingAll"){
	$page=$_REQUEST["page"];
	$folder=$_REQUEST["folder"];
	$form=$_REQUEST["form"];

	//获取依赖js文件
	// $arr_info=code_arr2($page,$ttl,$folder);
	// $refer=trimall($arr_info[2]);
	// if($refer!=""){
	// 	$arr_refer=explode(',', $refer);
	// 	$str_script="";
	// 	foreach($arr_refer as $k=>$v){
	// 		$temp=explode(":", $v);
	// 		$script='<script src="'.$temp[0].'"></script>';
	// 		$str_script.=$script."\n";
	// 	}
	// }
	// $test=refer_all($page,$folder,$form);
	// print_r($test);die;
	//$smarty->assign("script",$script);

	//模板渲染代码
	$arr_all=code_all($page,$folder,$_REQUEST["form"]);
	$style='<style>'."\n".$arr_all[0]."\n".'</style>';
	$html='<div class="fForm" style="width:500px; margin:10px auto;">'."\n".$arr_all[1]."\n".'</div>';
	$js=$arr_all[2];
	if(!$js==""){ $js='<script>'."\n".'$(function(){'."\n".$arr_all[2].'});'."\n".'</script>';}
	$code_all=$style."\n".$html."\n".$js;
	$view=fopen("temp_details_setting.html","w");
	fwrite($view,'<meta charset="utf-8">');
	fwrite($view,'<link rel="stylesheet" href="css/h_reset.css" />');
	fwrite($view,'<script src="js/jquery-1.10.2.js"></script>');
	fwrite($view,$code_all);
	fclose($view);

	$html=str_replace("    ","\t",htmlspecialchars($arr_all[1]));
	$html=str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;",$html);
	$html=str_replace("\n","<br />",$html);
	$js=str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;",htmlspecialchars('<script>'."\n".$arr_all[2]."\n".'</script>'));
	$js=str_replace("\n","<br/>",$js);
	$css=str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;",htmlspecialchars('<style>'."\n".$arr_all[0]."\n".'</style>'));
	$css=str_replace("\n","<br/>",$css);
	$str_unit=$css."<br />".$html."<br />".$js;
	$smarty->assign("str",$str_unit);

	$smarty->display("details_setting.html");
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


//表单全部控件(html/css/js)arr数组
function code_all($page,$folder,$form){
	$cookie_arr=explode("#",substr($form,14));
	$arr_all=array();
	foreach($cookie_arr as $k=>$v){
		$arr[$k]=explode(",",$v);
		$sCode=code_arr($page,$folder,$arr[$k][0]);
		$arr_css=$arr_css.$sCode[0]."\n";
		$arr_html=$arr_html.$sCode[2];
		$arr_js=$arr_js.$sCode[3];
	};
	//样式去重
	$class=array();
	$len_cls=substr_count($arr_css,"}",0);
	for($x=1;$x<=$len_cls;$x++){
		$cls_1[$x]=newstripos($arr_css,"}",$x);			
		if($x>1){
			$start_pos=newstripos($arr_css,"}",$x-1);
		}else{
			$start_pos=0;
		}
		$cls_2=stripos($arr_css,".",$start_pos);		
		$len=$cls_1[$x]-$cls_2+1;
		$class[$x]=substr($arr_css,$cls_2,$len);
		$css[1]=$class[1];
		if($x>1){
			$flag=true;
			for($y=1;$y<$x;$y++){
				if($class[$x]==$class[$y]){
					$flag=flase;
				}
			}
			if($flag===true){
				$css[$x]=$class[$x];
			}
		}
	}
	$arr_css=implode("\n\t",$css);
	array_push($arr_all,"\t".$arr_css,$arr_html,$arr_js);
	return($arr_all);
}


//表单全部依赖
// function refer_all($page,$folder,$form){
// 	$cookie_arr=explode("#",substr($form,14));
// 	$arr_all=array();
// 	foreach($cookie_arr as $k=>$v){
// 		$arr[$k]=explode(",",$v);
// 		$sCode=code_arr2($page,$arr[$k][0],$folder);
// 		$str_refer=$arr_refer.$sCode[2]."\n";
// 		echo($sCode[2]);die;
// 	}
// 	return $str_refer;
// }


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


//第几次出现的位置
function newstripos($str, $find, $count, $offset=0){
	$pos = stripos($str, $find, $offset);
	$count--;
	if ($count > 0 && $pos !== FALSE){
		$pos = newstripos($str, $find ,$count, $pos+1);
	}
	return $pos;
}


?>

