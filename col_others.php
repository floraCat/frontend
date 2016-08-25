<?php
include_once("include.php");
include_once("global_function.php");
$sdb=new db();



//小部件
if($_REQUEST["act"]=="catTop" && $_REQUEST["col"]=="part"){
	$smarty->display("top_others_part.html");
}

//Bootstrap模块
if($_REQUEST["act"]=="catTop" && $_REQUEST["col"]=="bs"){
	$smarty->display("top_others_bs.html");
}

//网址
if($_REQUEST["col"]=="website"){
	$smarty->display("top_others_website.html");
}

//常用样式
if($_REQUEST["col"]=="style"){
	$smarty->display("top_others_style.html");
}

//常用脚本
if($_REQUEST["col"]=="js"){
	$smarty->display("top_others_js.html");
}

//常用正则
if($_REQUEST["col"]=="reg"){
	$smarty->display("top_others_reg.html");
}

//列表
if($_REQUEST["act"]=="listAll"){
	$url2='col_others/'.$_REQUEST["col"].'/'.$_REQUEST["folder"];
	$files=my_scandir($url2,$_REQUEST["page"]);
	foreach($files as $k0=>$v0){
		$temp[$k0]=substr($v0,0,strpos($v0,"_"));
				$cats[0]=$temp[0];
		if($k0>0){
			if($temp[$k0]==$temp[$k0-1]){
			}else{
				array_push($cats, $temp[$k0]);
			}
		}
	}
	$smarty->assign("temp",$cats);
	$smarty->display("top_others_list.html");
}
	

//css3
if($_REQUEST["col"]=="css3"){

	$rsList=array();

	//border-radius
	$borderRadius["title"]="border-radius:";
	$borderRadius["ttl"]="border-radius";
	$borderRadius["val"]='5px';
	$borderRadius["funName"]='borderRadius';
	function borderRadius($val){
		return $rs='border-radius:'.$val.';';
	}

	//opacity
	$opacity["title"]="opacity:";
	$opacity["ttl"]="opacity";
	$opacity["val"]=0.6;
	$opacity["funName"]='opacity';
	function opacity($val){
		return $rs='opacity:'.$val.';';
	}

	//box-shadow
	$boxShadow["title"]="box-shadow:";
	$boxShadow["ttl"]="box-shadow";
	$boxShadow["val"]='0 0 2px #ccc';
	$boxShadow["funName"]='boxShadow';
	function boxShadow($val){
		return $rs='box-shadow:'.$val.';';
	}

	//text-shadow
	$textShadow["title"]="text-shadow:";
	$textShadow["ttl"]="text-shadow";
	$textShadow["val"]='1px 1px 0 #ccc';
	$textShadow["funName"]='textShadow';
	function textShadow($val){
		return $rs='text-shadow:'.$val.';';
	}

	//transform: rotate(45deg)
	$rotate["title"]="transform:rotate(...)";
	$rotate["ttl"]="rotate";
	$rotate["val"]='45deg';
	$rotate["funName"]='rotate';
	function rotate($val){
		return $rs='-webkit-transform: rotate('.$val.'); -ms-transform: rotate('.$val.'); transform: rotate('.$val.');';
	}

	//transform: translate(50px,100px)
	$translate["title"]="transform:translate(...)";
	$translate["ttl"]="translate";
	$translate["val"]='50px,50px';
	$translate["funName"]='translate';
	function translate($val){
		return $rs='-webkit-transform: translate('.$val.'); -ms-transform: translate('.$val.'); transform: translate('.$val.');';
	}

	//transform: scale(2,4);
	$scale["title"]="transform:scale(...)";
	$scale["ttl"]="scale";
	$scale["val"]='2,1';
	$scale["funName"]='scale';
	function scale($val){
		return $rs='-webkit-transform: scale('.$val.'); -ms-transform: scale('.$val.'); transform: scale('.$val.');';
	}

	//transform: skew(30deg,20deg);
	$skew["title"]="transform:skew(...)";
	$skew["ttl"]="skew";
	$skew["val"]='-30deg,0deg';
	$skew["funName"]='skew';
	function skew($val){
		return $rs='-webkit-transform: skew('.$val.'); -ms-transform: skew('.$val.'); transform: skew('.$val.');';
	}

	//transform:matrix(0.866,0.5,-0.5,0.866,0,0);
	$matrix["title"]="transform:matrix(...)";
	$matrix["ttl"]="matrix";
	$matrix["val"]='0.866,0.5,-0.5,0.866,0,0';
	$matrix["funName"]='matrix';
	function matrix($val){
		return $rs='-webkit-transform: matrix('.$val.'); -ms-transform: matrix('.$val.'); transform: matrix('.$val.');';
	}

	//transform: rotateX(120deg);
	$rotateX["title"]="transform:rotateX(...)";
	$rotateX["ttl"]="rotateX";
	$rotateX["val"]='30deg';
	$rotateX["funName"]='rotateX';
	function rotateX($val){
		return $rs='-webkit-transform: rotateX('.$val.'); transform: rotateX('.$val.');';
	}

	//transform: rotateY(130deg);
	$rotateY["title"]="transform:rotateY(...)";
	$rotateY["ttl"]="rotateY";
	$rotateY["val"]='30deg';
	$rotateY["funName"]='rotateY';
	function rotateY($val){
		return $rs='-webkit-transform: rotateY('.$val.'); transform: rotateY('.$val.');';
	}

	//transition:all .5s ease-in-out; 
	$transition["title"]="transition(...)";
	$transition["ttl"]="transition";
	$transition["val"]='all .5s ease-in-out';
	$transition["funName"]='transition';
	function transition($val){
		return $rs='-webkit-transition: '.$val.'; transition: '.$val.';';
	}

	//animation: myfirst 5s linear 2s infinite alternate;
	$animation["title"]="animation(...)";
	$animation["ttl"]="animation";
	$animation["val"]='myfirst 5s linear 2s infinite alternate';
	$animation["funName"]='animation';
	function animation($val){
		return $rs='-webkit-animation: '.$val.'; animation: '.$val.';';
	}

	array_push($rsList, 
		$borderRadius,
		$opacity,
		$boxShadow,
		$textShadow,
		$rotate,
		$translate,
		$scale,
		$skew,
		$matrix,
		$rotateX,
		$rotateY,
		$transition,
		$animation);

	//column-count:3;
	//column-gap:40px;
	//column-rule:3px outset #ff0000;

	if($_POST["data_title"]){//复制操作时
		foreach($rsList as $k=>$v){

			if($v["title"]==$_POST["data_title"]){
				$v1=$_POST["data_val"];
				$code=$v["funName"]($v1);
				echo json_encode($code);
			}
		};
	}else{//展示列表
		foreach($rsList as $k2=>$v2){
			$rsList[$k2]['ttl_img']=$v2["ttl"];
			$rsList[$k2]["code"]=$v2["funName"]($v2["val"]);
		};
		$smarty->assign("rsList",$rsList);
		$smarty->display("top_others_css3.html");
	}

}


//兼容处理后返回
function val($ttl,$val){
	if($title=="opacity"){ $code1='';}
	else if($title=="transform"){ $code1="-webkit-".$ttl.":".$val."; -moz-".$ttl.":".$val."; -ms-".$ttl.":".$val.";";
	}else{ $code1="-webkit-".$ttl.":".$val."; -moz-".$ttl.":".$val.";";}
	$code=$ttl.":".$val."; ".$code1;
	return $code;		
}



/*


border-radius:
	moz  webkit  o
	不兼容6~8

opacity:
	不用前缀
	不兼容6~8

box-shadow:
	moz  webkit
	不兼容6~8

transform:
	moz  webkit  ms
	不兼容6~8

transition:
	moz  webkit
	不兼容6~9

animation:
	moz  webkit
	不兼容6~9









*/



?>




