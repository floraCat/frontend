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
	$smarty->display("list_form_viewAll.html");
}



//合成表单__[控件清单]
if($_REQUEST["act"]=="createForm"){
	$page=$_REQUEST["page"];
	$folder=$_REQUEST["folder"];
	$form=$_REQUEST["form"];
	$arr_all=code_all($page,$folder,$form);
	$code_all=code_str_all($arr_all);
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
	$code_all=code_str_all($arr_all);
	$view=fopen("temp_details_setting.html","w");
	fwrite($view,'<meta charset="utf-8">');
	fwrite($view,'<link rel="stylesheet" href="css/h_reset.css" />');
	fwrite($view,'<script src="js/jquery-1.10.2.js"></script>');
	fwrite($view,$code_all);
	fclose($view);

	$html=htmlTabs('<div class="fForm" style="width:500px; margin:10px auto;">'."\n".$arr_all[2].'</div>');
	$js=htmlTabs('<script>'."\n".$arr_all[4].'$(function(){'."\n".$arr_all[3].'});'."\n".'</script>');
	$css=htmlTabs('<style>'."\n".$arr_all[0]."\n".'</style>');
	$str_unit=$css."<br />".$html."<br />".$js;
	$smarty->assign("str",$str_unit);
	$smarty->display("details_setting.html");
}








?>

