<?php
include_once("include.php");
include_once("global_function.php");
$sdb=new db();






//列表页
if($_GET["list"]){
	$list=$_GET["list"];
	$page=$_REQUEST['page'];
	$col=$_REQUEST['col'];
	$url2='col_'.$_REQUEST["page"].'/'.$_REQUEST["col"];
	$sort=$_GET["sort"];
	$folder=$_GET["folder"];
	$handle=scandir($url2);
	if($sort){//有指定筛选
		$temp=eachFile($list,$page,$url2,$sort);//指定筛选项模块源码数组
	}else if($folder){//网址有floder参数
		$temp=eachFile($list,$page,$url2,$folder);//指定文件夹模块源码数组
	}else{//全部
		$temp=array();
		$index=0;
		foreach($handle as $folder){
			if($folder!='.' && $folder!='..'){
				$temp_=eachFile($list,$page,$url2,$folder);//全部模块源码数组
				if($temp_){
					foreach($temp_ as $k=>$v){
						$temp[$index]=$v;
						$index++;
					};
				}
			}
		};
	}
	$smarty->assign("temp",$temp);

	//筛选项
	if($page=="module"){
		$sorts=array('base:基本结构模块','refer:参考样式模块');
	}
	if($page=="plus"){
		$sorts=array('self:自主封装插件','common:常用插件','recommend:推荐插件');
	}
	if($page=="plus" && $col=="unit"){
		$sorts=array('common:常用');
	}
	if($page=="form"){
		$sorts=array('base:基本结构控件');
	}
	if($_REQUEST["col"]=="bs"){
		$sorts=array('_set:组件','_plus:插件');
	}
	if($_REQUEST["col"]=="part"){
		$sorts=array('mark:符号');
	}
	foreach($sorts as $k=>$v){
		$arr_sort[$k]=array();
		$arr_sort[$k]=explode(":",$v);
	};
	$smarty->assign("arr_sort",$arr_sort);
	if($page=='form'){
		$smarty->display("list_col_form.html");
	}else if($_REQUEST["col"]=='part'){
		$smarty->display("list_col_part.html");
	}else if($_REQUEST["col"]=='bs'){
		$smarty->display("list_col_bs.html");
	}else{
		$smarty->display("list_col.html");
	}
}



//效果展示
if($_REQUEST["_temp"]){
	$page=$_GET["page"];
	$folder=$_GET["folder"];
	$ttl=$_GET["_temp"];
	$str_script=getRefer($page,$ttl,$folder,0,"");//依赖
	$arr_code=code_arr($page,$folder,$ttl);
	$code_all=$str_script."\n".code_str($arr_code);//模板渲染代码
	$smarty->assign('content',$code_all);
	$smarty->display("list_view.html");
}



//自定义设置
if($_REQUEST["act"]=="setting"){
	$page=$_GET["page"];
	$folder=$_GET["folder"];
	$ttl=$_REQUEST["ttl"];
	$str_script=getRefer($page,$ttl,$folder,0,"");//依赖
	$smarty->assign("script",$str_script);
	$arr_code=code_arr($page,$folder,$ttl);
	$code_all=$str_script."\n".code_str($arr_code);//模板渲染代码
	$view=fopen("temp_details_setting.html","w");
	fwrite($view,'<!DOCTYPE HTML>'."\n");
	fwrite($view,'<html>'."\n");
	fwrite($view,'<meta charset="utf-8">'."\n");
	fwrite($view,'<link rel="stylesheet" href="css/reset.css" />'."\n");
	fwrite($view,'<script src="js/jquery-1.10.2.js"></script>'."\n");
	fwrite($view,$code_all);
	fwrite($view,"\n".'</html>');
	fclose($view);

	//固定和可编辑样式
	$arr_code=code_arr($page,$folder,$ttl);
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
	foreach($arr_unit as $k1=>$v1){
		$css="";
		if($arr2_spec){//有spec数组
			$class=substr($v1,0,strpos($v1,"{"));
			$arr_style=explode(";",substr($v1,strpos($v1,"{")+1,-1));
			if($arr2_spec[$k1]["key"]=="*"){
				foreach($arr_style as $k2=>$v2){
					$css.='<span style="color:#a2aea2;">'.$v2.'; </span>';
				}
			}else if($arr2_spec[$k1]["key"]=="!"){
				foreach($arr_style as $k2=>$v2){
					$arr=explode(":",$v2);
					$flag=0;
					foreach($arr2_spec[$k1]["css"] as $k3=>$v3){
						if($v3==trim($arr[0])){ $flag=1;}
					};
					if($flag===1){ $css.=$v2.'; ';
					}else{ $css.='<span style="color:#a2aea2;">'.$v2.'; </span>';}
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
					}else{ $css.='<span style="color:#a2aea2;">'.$v2.'; </span>';}
				}
			}
			$css='&nbsp;&nbsp;&nbsp;&nbsp;'.trim($class).'{'.$css.'}<br />';
		}else{
			$css='&nbsp;&nbsp;&nbsp;&nbsp;'.trim($v1).'}<br />';
		}
		$str_unit.=$css;
	};
	if($page=="form"){ $html=htmlTabs('<div class="p-form" style="width:500px; margin:10px auto;">'."\n".$arr_code[2]."\n".'</div>');}
	else{ $html=htmlTabs($arr_code[2]);}
	$js=htmlTabs('<script>'."\n".$arr_code[4].'$(function(){'."\n".$arr_code[3].'});'."\n".'</script>');
	$str_unit='<p>&lt;style&gt;</p>'.$str_unit.'<p>&lt;/style&gt;</p>'.$html."<br />".$js;
	$smarty->assign("str",$str_unit);
	$smarty->display("details_setting.html");
}




//改后查看效果__[自定义设置]
if($_REQUEST["setting"]=="render"){
	$newCode=stripcslashes($_REQUEST["newCode"]);
	$newCode=str_replace(" "," ",$newCode);//处理特殊空格！！
	$newCode=str_replace('&nbsp;'," ",$newCode);//处理空格
	$newCode=str_replace('    ',"\t",$newCode);//处理制表符
	if($_REQUEST["page"]=="form"){
		$newCode='<div class="p-form" style="width:500px; margin:10px auto;">'."\n".$newCode."\n".'</div>';
	}
	$script=stripcslashes($_REQUEST["script"]);
	$all.=$script."\n".$newCode;
	$view=fopen("temp_details_setting.html","w");
	fwrite($view,'<meta charset="utf-8">'."\n");
	fwrite($view,'<link rel="stylesheet" href="css/reset.css" />'."\n");
	fwrite($view,'<script src="js/jquery-1.10.2.js"></script>'."\n");
	fwrite($view,$all);
	fclose($view);
}




//详情页
if($_REQUEST["details"]){

	//源代码
	$arr_code=code_arr($_REQUEST['page'],$_REQUEST['folder'],$_REQUEST['details']);
	if($_GET["page"]=="plus"){
		$way=$arr_code[2];
	}
	$code_all=code_str($arr_code);
	$smarty->assign("way",$way);
	$smarty->assign("code",$code_all);

	//模块相关信息
	$arr=array();
	$arr["image"]="images/"+$_REQUEST['page']+"/"+$_REQUEST['details']+".jpg";
	$arr["ttl"]=$_REQUEST["details"];
	if($_REQUEST['page']=="plus"){
		$arr["ttl_short"]=substr($_REQUEST["details"], 0,-6);
	}
	
	$arr_info=info_arr($_REQUEST["page"],$_REQUEST["details"],$_REQUEST["folder"]);
	$arr["hack"]=$arr_info[0];
	$arr["desc"]=$arr_info[1];
	$arr["refer"]=$arr_info[2];
	$arr["note"]=$arr_info[3];

	if($_GET["page"]=="plus"){
		$dir='col_'.$_REQUEST["page"].'/'.$_REQUEST["col"].'/'.$_REQUEST["folder"].'/'.substr($_REQUEST["details"],0,-6);
		$info_demo=plusDemos($dir,$_REQUEST["page"],$_REQUEST["folder"],substr($_REQUEST["details"], 0,-6));
		$arr["descs"]=$info_demo;
	}

	$smarty->assign("info",$arr);
	$smarty->display("details_all.html");
}


//切换demo_[详情页]
if($_REQUEST["act"]=="demos"){
	$page=$_REQUEST["page"];
	$folder=$_REQUEST["folder"];
	$col=$_REQUEST["col"];
	$ttl=$_REQUEST["demo"];
	$arr_code=code_arr($page,$folder,$ttl);//源代码数组
	$str_script=getRefer($page,$ttl,$folder,0,"");//依赖
	$code_all=$str_script."\n".code_str($arr_code);//模板渲染代码
	$demo=array();
	if(trimall($_REQUEST["way"])=="data-js"){
		$pos_data=newstripos($arr_code[2], "data-js", 1);
		$code_before=substr($arr_code[2], 0,$pos_data);
		$pos_data2=substr($arr_code[2],$pos_data);
		$pos_tab_end=newstripos($pos_data2, ">", 1);
		$pos_data3=substr($pos_data2,0,$pos_tab_end);		
		$pos_data_end=newstripos($pos_data3, "&nbsp;", 1);
		if(!$pos_data_end){
			$pos_data_end=newstripos($pos_data2, ">", 1);
			$code_data=substr($pos_data2, 0,$pos_data_end);
		}else{
			$code_data=substr($arr_code[2], 0,$pos_data_end);
		}
		$demo["script"]=$code_data;
	}else{
		$demo["script"]=$arr_code[3];
	}
	$demo["code"]=$code_all;
	echo json_encode($demo);
}



//运行demo_[详情页]
if($_REQUEST["act"]=="running"){
	$page=$_REQUEST["page"];
	$folder=$_REQUEST["folder"];
	$col=$_REQUEST["col"];
	$ttl=$_REQUEST["demo"];
	$dataRefer=$_REQUEST["dataRefer"];
	$code_config=stripcslashes($_REQUEST["code_config"]);
	$arr_code=code_arr($page,$folder,$ttl);//源代码数组
	if(trimall($_REQUEST["way"])=="data-js"){
		//截取data-js两边的代码
		$pos_data=newstripos($arr_code[2], "data-js", 1);
		$code_before=substr($arr_code[2], 0,$pos_data);
		$pos_data2=substr($arr_code[2],$pos_data);
		$pos_tab_end=newstripos($pos_data2, ">", 1);
		$pos_data3=substr($pos_data2,0,$pos_tab_end);		
		$pos_data_end=newstripos($pos_data3, "&nbsp;", 1);
		if(!$pos_data_end){
			$pos_data_end=newstripos($pos_data2, ">", 1);
			$code_after=substr($pos_data2, $pos_data_end);
		}else{
			$code_after=substr($arr_code[2], $pos_data_end);
		}
		$code_all["html"]=$code_before.$code_config.$code_after;
		$code_all["script"]="<script>"."\n"."$(function(){"."\n".$arr_code[3]."});"."\n"."</script>";
	}else{
		$code_all["html"]=$arr_code[2];
		$code_all["script"]="<script>"."\n"."$(function(){"."\n".$code_config."});"."\n"."</script>";
	}
	$str_script=getRefer($page,$ttl,$folder,0,$dataRefer);//依赖
	$code_all=$str_script."\n"."<style>".$arr_code[0]."</style>"."\n".$code_all["html"]."\n".$code_all["script"];//模板渲染代码
	$view=fopen("temp_details_setting.html","w");
	fwrite($view,'<!DOCTYPE HTML>'."\n");
	fwrite($view,'<html>'."\n");
	fwrite($view,'<meta charset="utf-8">'."\n");
	fwrite($view,'<link rel="stylesheet" href="css/reset.css" />'."\n");
	fwrite($view,'<script src="js/jquery-1.10.2.js"></script>'."\n");
	fwrite($view,'<body style="min-height:1500px;">'."\n");
	fwrite($view,$code_all);
	fwrite($view,'</body>'."\n".'</html>');
	fclose($view);
	echo json_encode("seccess");
}



//遍历文件夹全部模块返回源码
function eachFile($list,$page,$url2,$folder){
	$index=0;
	$files=@my_scandir($url2."/".$folder,$page);
	foreach($files as $k0=>$v0){
		if(strstr($v0,$list)){
			$ttl=substr($v0,0,-5);
			$temp[$index]["ttl"]=$ttl;
			if($page=="plus"){$temp[$index]["ttl_short"]=substr($ttl,0,-6);}
			$arr_code=code_arr($page,$folder,$ttl);
			$code_all=code_str($arr_code);
			$temp[$index]["code"]=$code_all;
			$temp[$index]["folder"]=$folder;
			$info_arr=info_arr($page,$ttl,$folder);
			$temp[$index]["ttl_zh"]=$info_arr[1];
			$index++;
		}
	}
	return $temp;
}


//获取插件demo文件名和描述
function plusDemos($dir,$page,$folder,$ttl){
	$files=my_scandir($dir,$page);
	$index=0;
	foreach($files as $k=>$v){
		if(substr($v,0,-5)!="index"){
			$info_demo[$index]["name"]=substr($v,0,-5);
			$infos=info_arr($page,$ttl.'/'.substr($v,0,-5),$folder);
			$info_demo[$index]["desc"]=$infos[1];
			$index++;
		}
	};
	return $info_demo;
}



?>

