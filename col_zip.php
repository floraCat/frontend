<?php
include_once("global_function.php");

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
		//模板渲染代码
		$doc_top='<html>'."\n".'<head>'."\n\t".'<meta charset="utf-8">'."\n\t".'<link rel="stylesheet" href="h_reset.css" />'."\n\t".'<script src="jquery-1.10.2.js"></script>'."\n".'</head>'."\n".'<body>'."\n";
		$doc_btm="\n".'</body>'."\n".'</html>';
		$code_all=$doc_top."\n".code_str_all($arr_all)."\n".$doc_btm;
		$f=fopen($url."/form_".date("YmdHis", time()).".html","w+");
		fwrite($f,$code_all);
		fclose($f);

		$style=$arr_all[0];
		getImgs($url,$style);//获取背景图片
		$html=$arr_all[2];
		getImages($url,$html);//获取html图片

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
		$str_script=getRefer($page,$ttl,$folder,1);//依赖
		//模板渲染代码
		$doc_top='<html>'."\n".'<head>'."\n\t".'<meta charset="utf-8">'."\n\t".'<link rel="stylesheet" href="h_reset.css" />'."\n\t".'<script src="jquery-1.10.2.js"></script>'."\n\t".$str_script."\n".'</head>'."\n".'<body>'."\n";
		$doc_btm="\n".'</body>'."\n".'</html>';
		$arr_code=code_arr($page,$folder,$ttl);
		$code_all=$doc_top."\n".code_str($arr_code)."\n".$doc_btm;

		$f=fopen($url."/".$ttl.".html","w+");
		fwrite($f,$code_all);
		fclose($f);

		$style=$arr_code[0];
		getImgs($url,$style);//获取背景图片
		$html=$arr_code[2];
		getImages($url,$html);//获取html图片

		$files=array();
		$arr_info=info_arr($page,$ttl,$folder);
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



//获取背景图片
function getImgs($url,$style){
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
}


//获取html图片
function getImages($url,$html){
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


?>

