<?php

/*
--压缩下载模块执行前面不能有header信息，否则无法设置压缩需要的header信息，所以跟其他功能区分开来
--且保证<?php ?>之前不要有空行
*/


//下载zip[单个]
if($_REQUEST["act"]=="zipOne"){
	$url="./files/download_file";
	$file=$_GET["file"];
	deldir($url,$url);
	file2dir($file, $url);
	require_once 'zip.php'; 
	$zip = new PHPZip();
	$zip->ZipAndDownload($url);
}


//下载zip[整套]
if($_REQUEST["act"]=="zipAll"){
	$url="./files/download_file";
	if($_REQUEST["attr"]=="formAll"){//多个控件合并
		deldir($url,$url);
		$page=$_REQUEST["page"];
		$folder=$_REQUEST["folder"];
		$arr_all=code_all($page,$folder,$_REQUEST["form"]);
		$style='<style>'."\n".$arr_all[0]."\n".'</style>';
		$html='<div class="fForm" style="width:500px; margin:10px auto;">'."\n".$arr_all[1]."\n".'</div>';
		$js=$arr_all[2];
		if(!$js==""){ $js='<script>'."\n".$arr_all[3]."\n".'$(function(){'."\n".$arr_all[2]."\n".'});'."\n".'</script>';}
		$doc_top='<html>'."\n".'<head>'."\n\t".'<meta charset="utf-8">'."\n\t".'<link rel="stylesheet" href="h_reset.css" />'."\n\t".'<script src="jquery-1.10.2.js"></script>'."\n".'</head>'."\n".'<body>'."\n";
		$doc_btm="\n".'</body>'."\n".'</html>';
		$code_all=$doc_top."\n".$style."\n".$html."\n".$js."\n".$doc_btm;
		$f=fopen($url."/form_".date("YmdHis", time()).".html","w+");
		fwrite($f,$code_all);
		fclose($f);
		//获取背景图片
		$len_imgs=substr_count($style,'url(',0);
		if($len_imgs>0){
			for($i=1;$i<=$len_imgs;$i++){
				$start_pos=newstripos($style, 'url(', $i)+4;
				$end_pos=strpos($style,')',$start_pos);	
				$len=$end_pos-$start_pos;
				$str_img=substr($style,$start_pos,$len);
				$url_img=pathinfo($str_img);
				file2dir($str_img, $url.'/'.$url_img["dirname"]);
			};
		}
		//获取html图片
		preg_match_all('/<img.*?src="(.*?)".*?>/is',$html,$arr_pics);
		$len_pics=count($arr_pics[1]);
		for($j=0;$j<$len_pics;$j++){
			if($j>0){
				if($arr_pics[1][$j]!=$arr_pics[1][$j-1]){
					$url_pic=pathinfo($arr_pics[1][$j]);
					file2dir($arr_pics[1][$j], $url.'/'.$url_pic["dirname"]);
				}
			}else{
				$url_pic=pathinfo($arr_pics[1][$j]);
				file2dir($arr_pics[1][$j], $url.'/'.$url_pic["dirname"]);
			}
		}
		$files=array();
		array_push($files,'./css/h_reset.css');
		array_push($files,'./js/jquery-1.10.2.js');
		foreach($files as $k=>$v){
			file2dir($v, $url);
		};
	}else{//单个模块
		deldir($url,$url);
		$page=$_GET["page"];
		$folder=$_GET["folder"];
		$ttl=$_GET["ttl"];
		$arr_code=code_arr($page,$folder,$ttl);
		$style='<style>'."\n".$arr_code[0]."\n".'</style>';
		if($page=="form"){
			$html='<div class="fForm" style="width:500px; margin:10px auto;">'."\n".$arr_code[1]."\n".'</div>';
		}else{$html=$arr_code[1];}
		$js=$arr_code[2];
		if(!$js==""){ $js='<script>'."\n".$arr_code[3]."\n".'$(function(){'."\n".$arr_code[2]."\n".'});'."\n".'</script>';}
		//获取依赖js文件
		$arr_info=code_arr2($page,$ttl,$folder);
		$refer=trimall($arr_info[2]);
		if($refer!=""){
			$arr_refer=explode(',', $refer);
			$str_script="";
			foreach($arr_refer as $k=>$v){
				$temp=explode(":", $v);
				$script='<script src="'.basename($temp[0]).'"></script>';
				$str_script.=$script;
			}
		}
		$doc_top='<html>'."\n".'<head>'."\n\t".'<meta charset="utf-8">'."\n\t".'<link rel="stylesheet" href="h_reset.css" />'."\n\t".'<script src="jquery-1.10.2.js"></script>'."\n\t".$str_script."\n".'</head>'."\n".'<body>'."\n";
		$doc_btm="\n".'</body>'."\n".'</html>';
		$code_all=$doc_top."\n".$style."\n".$html."\n".$js."\n".$doc_btm;
		$f=fopen($url."/".$ttl.".html","w+");
		fwrite($f,$code_all);
		fclose($f);
		//获取背景图片
		$len_imgs=substr_count($style,'url(',0);
		if($len_imgs>0){
			for($i=1;$i<=$len_imgs;$i++){
				$start_pos=newstripos($style, 'url(', $i)+4;
				$end_pos=strpos($style,')',$start_pos);	
				$len=$end_pos-$start_pos;
				$str_img=substr($style,$start_pos,$len);
				$url_img=pathinfo($str_img);
				file2dir($str_img, $url.'/'.$url_img["dirname"]);
			};
		}
		//获取html图片
		preg_match_all('/<img.*?src="(.*?)".*?>/is',$html,$arr_pics);
		$len_pics=count($arr_pics[1]);
		for($j=0;$j<$len_pics;$j++){
			if($j>0){
				if($arr_pics[1][$j]!=$arr_pics[1][$j-1]){
					$url_pic=pathinfo($arr_pics[1][$j]);
					file2dir($arr_pics[1][$j], $url.'/'.$url_pic["dirname"]);
				}
			}else{
				$url_pic=pathinfo($arr_pics[1][$j]);
				file2dir($arr_pics[1][$j], $url.'/'.$url_pic["dirname"]);
			}
		}
		$files=array();
		$arr_info=code_arr2($page,$ttl,$folder);
		if(strpos($arr_info[2],",")===false){//依赖[单个]
			$refer=$arr_info[2];
			$arr_temp=explode(':',$refer);
			array_push($files,$arr_temp[0]);
		}else{//依赖[多个]
			$refer=explode($arr_info[2],",");
			foreach($refer as $k1=>$v1){
				$arr_temp=explode(':',$v1);
				array_push($files,$arr_temp[0]);
			};
		}
		array_push($files,'./css/h_reset.css');
		array_push($files,'./js/jquery-1.10.2.js');
		foreach($files as $k=>$v){
			file2dir($v, $url);
		};
	}
		
	require_once 'zip.php'; 
	$zip = new PHPZip();
	$zip->ZipAndDownload($url);
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

	$start_fun=strpos($str,"/*_fun");
	$end_fun=strpos($str,"/*fun_");
	$len_fun=$end_fun-$start_fun;
	if($start_fun){ $fun=substr($str,$start_fun+10,$len_fun-12)."\n";}
	else{$fun="";}

	$arr_code=array();
	array_push($arr_code,$css,$html,$js,$fun);
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


//表单全部控件(html/css/js)arr数组
function code_all($page,$folder,$form){
	$cookie_arr=explode("#",substr($form,14));
	$arr_all=array();
	foreach($cookie_arr as $k=>$v){
		$arr[$k]=explode(",",$v);
		$sCode=code_arr($page,$folder,$arr[$k][0]);
		$arr_css=$arr_css.$sCode[0]."\n";
		$arr_html=$arr_html.$sCode[1]."\n";
		$arr_js=$arr_js.$sCode[2]."\n";
		if($sCode[3]){$arr_fun=$arr_fun.$sCode[3];}
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
	$arr_css=implode("\n",$css);

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
					foreach($arr_exFun2 as $k2=>$v2){
						if(trim($v)==trim($v2)){}else{
							$arr_exFun2[$k]=$v;
							$arr_js2[$k]=$v;
						}
					};
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

	array_push($arr_all,$arr_css,$arr_html,$str_js,$str_fun);
	return($arr_all);
}


//转移文件
function file2dir($sourcefile, $dir){
     if( is_dir($sourcefile) || ! file_exists($sourcefile) ){
         return false;
     }
     if(!file_exists($dir)){
     	mkdir($dir,0700,true);
     }
     $filename = basename($sourcefile);
     return copy($sourcefile, $dir .'/'. $filename);
}


//删除目录下的文件
function deldir($dir,$leave) {
  $dh=opendir($dir);
  while ($file=readdir($dh)) {
    if($file!="." && $file!="..") {
      $fullpath=$dir."/".$file;
      if(!is_dir($fullpath)) {
          unlink($fullpath);
      } else {
          deldir($fullpath,$leave);
      }
    }
  }
  closedir($dh);
  if($dir!=$leave){
	if(rmdir($dir)){ return true;}
	else{ return false;}  	
  }
	  
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


?>

