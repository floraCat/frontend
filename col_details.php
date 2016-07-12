<?php
include_once("include.php");
$sdb=new db();



if($_REQUEST["details"]){

	//源代码
	$code_all=code_str($_REQUEST['page'],$_REQUEST['folder'],$_REQUEST['details']);
	$smarty->assign("code",$code_all);

	//模板相关信息
	$arr=array();
	$arr["image"]="images/"+$_REQUEST['page']+"/"+$_REQUEST['details']+".jpg";
	$arr["ttl"]=$_REQUEST["details"];
	$arr_info=code_arr2($_REQUEST["page"],$_REQUEST["details"],$_REQUEST["folder"]);
	$arr["hack"]=$arr_info[0];
	$arr["desc"]=$arr_info[1];
	$arr["refer"]=$arr_info[2];
	$arr["note"]=$arr_info[3];
	$smarty->assign("info",$arr);
	if($_REQUEST['page']=="form"){
		$smarty->display("details_form.html");
	}else{
		$smarty->display("details_all.html");
	}
}


//模板整源码
function code_str($page,$folder,$ttl){
	$arr_code=code_arr($page,$folder,$ttl);
		if($arr_code[0]!=""){$style='<style>'."\n".$arr_code[0]."\n".'</style>';}
		else{$style="";};
	$js=$arr_code[2];
	if(!$js==""){ $js='<script>'."\n".'$(function(){'."\n".$arr_code[2].'});'."\n".'</script>';}
	$code_all=$style."\n".$arr_code[1]."\n".$js;
	return $code_all;
}


//获取模板'css/html/js'的数组
function code_arr($page,$folder,$ttl){
	$str=file_get_contents("col_".$page."/pc/_temp/".$folder."/".$ttl.".html");

	$start_css=strpos($str,"/*_css");
	$end_css=strpos($str,"/*css_");
	$len_css=$end_css-$start_css;
	$css=substr($str,$start_css+10,$len_css-12);

	$start_html=strpos($str,"<!--_html");
	$end_html=strpos($str,"<!--html_");
	$len_html=$end_html-$start_html;
	$html=substr($str,$start_html+14,$len_html-16);

	$start_js=strpos($str,"/*_js");
	$end_js=strpos($str,"/*js_");
	$len_js=$end_js-$start_js;
	$js=substr($str,$start_js+9,$len_js-11);

	$arr_code=array();
	array_push($arr_code,$css,$html,$js);
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



?>

