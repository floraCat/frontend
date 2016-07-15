<?php
include_once("include.php");
include_once("global_function.php");
$sdb=new db();



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



//查看效果__[控件清单]
if($_REQUEST["act"]=="viewForm"){
	$page=$_REQUEST['page'];
	$folder=$_REQUEST["folder"];
	$arr_all=code_all($page,$folder,$_REQUEST["form"]);
	$smarty->assign("sCode",$arr_all);
	$formWarp='.fForm{width:500px; margin-left:auto; margin-right:auto;}';
	$smarty->assign("formWarp",$formWarp);
	$smarty->display("list_form_viewAll.html");
}



//合成表单__[控件清单]
if($_REQUEST["act"]=="createForm"){
	$page=$_REQUEST["page"];
	$folder=$_REQUEST["folder"];
	$form=$_REQUEST["form"];
	$arr_all=code_all($page,$folder,$form);
	$style='<style>'."\n".$arr_all[0]."\n".'</style>';
	$js=$arr_all[2];
	$fun=str_replace("\n",'',$arr_all[3]);
	if(!$js==""){ $js='<script>'."\n".$fun."\n".'$(function(){'."\n".$arr_all[2]."\n".'});'."\n".'</script>';}
	$code_all=$style."\n".$arr_all[1]."\n".$js;
	$smarty->assign("code",$code_all);
	$smarty->display("details_formAll.html");
}



//自定义设置__[合成表单]
if($_REQUEST["act"]=="settingAll"){
	$page=$_REQUEST["page"];
	$folder=$_REQUEST["folder"];
	$form=$_REQUEST["form"];

	//模板渲染代码
	$arr_all=code_all($page,$folder,$_REQUEST["form"]);
	$style='<style>'."\n".$arr_all[0]."\n".'</style>';
	$html='<div class="fForm" style="width:500px; margin:10px auto;">'."\n".$arr_all[1]."\n".'</div>';
	$js=$arr_all[2];
	$fun=str_replace("\n",'',$arr_all[3]);
	if(!$js==""){ $js='<script>'."\n".$fun.'$(function(){'."\n".$arr_all[2].'});'."\n".'</script>';}
	$code_all=$style."\n".$html."\n".$js;
	$view=fopen("temp_details_setting.html","w");
	fwrite($view,'<meta charset="utf-8">');
	fwrite($view,'<link rel="stylesheet" href="css/h_reset.css" />');
	fwrite($view,'<script src="js/jquery-1.10.2.js"></script>');
	fwrite($view,$code_all);
	fclose($view);

	$html=htmlTabs('<div class="fForm">'."\n".$arr_all[1].'</div>');
	$js=htmlTabs('<script>'."\n".$arr_all[3].'$(function(){'."\n".$arr_all[2].'});'."\n".'</script>');
	$css=htmlTabs('<style>'."\n".$arr_all[0]."\n".'</style>');
	$str_unit=$css."<br />".$html."<br />".$js;
	$smarty->assign("str",$str_unit);
	$smarty->display("details_setting.html");
}





//表单全部控件(html/css/js)arr数组
function code_all($page,$folder,$form){
	$cookie_arr=explode("#",substr($form,14));
	$arr_all=array();
	foreach($cookie_arr as $k=>$v){
		$arr[$k]=explode(",",$v);
		$sCode=code_arr($page,$folder,$arr[$k][0]);
		$arr_css=$arr_css.$sCode[0]."\n";
		$arr_html=$arr_html.$sCode[2]."\n";
		$arr_js=$arr_js.$sCode[3]."\n";
		if($sCode[4]){$arr_fun=$arr_fun.$sCode[4];}
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
		$str_fun=str_replace("\n","",trim($arr_fun));
		$size_fun=substr_count($str_fun,"function ",0);
		for($x=1;$x<=$size_fun;$x++){
			$start_pos=newstripos($str_fun,"function ",$x);
			$end_pos=strpos($str_fun,"}function",$start_pos+9);
			if(!$end_pos){ $end_pos=strlen($str_fun);}
			$len=$end_pos-$start_pos+1;
			$fun=substr($str_fun,$start_pos,$len);
			preg_match('/function\s+([^\(]+)/',$fun,$result);
				$rs[$x]=$result[1];
			if($x>1){
				if($rs[$x]==$rs[$x-1]){
					$str_fun=substr_replace($str_fun,'',$start_pos,$len);
				}
			}
		}
		$str_fun=str_replace("{","{"."\n",$str_fun);
		$str_fun=str_replace(";",";"."\n",$str_fun);
		$str_fun=str_replace('}',"}"."\n",$str_fun);
		$str_fun=str_replace("\n".');',');',$str_fun);
		$str_fun=str_replace("\n".'else{','else{',$str_fun);
	}

	array_push($arr_all,"\t".$arr_css,$arr_html,$str_js,$str_fun);
	return($arr_all);
}




?>

