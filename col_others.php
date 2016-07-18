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

//列表
if($_REQUEST["act"]=="listAll"){
	$url2='col_others/'.$_REQUEST["col"].'/'.$_REQUEST["folder"];
	$files=my_scandir($url2);
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
	$borderRadius["title"]="border-radius";
	$borderRadius["ttl"]="border-radius";
	$borderRadius["val"]='5px';

	//opacity
	$opacity["title"]="opacity";
	$opacity["ttl"]="opacity";
	$opacity["val"]=0.6;

	//box-shadow
	$boxShadow["title"]="box-shadow";
	$boxShadow["ttl"]="box-shadow";
	$boxShadow["val"]='0 0 2px #ccc';

	//text-shadow
	$textShadow["title"]="text-shadow";
	$textShadow["ttl"]="text-shadow";
	$textShadow["val"]='1px 1px 0 #ccc';

	//transform: rotate(45deg)
	$rotate["title"]="transform:rotate";
	$rotate["ttl"]="transform";
	$rotate["val"]='rotate(45deg)';

	//transform: translate(50px,100px)
	$translate["title"]="transform:translate";
	$translate["ttl"]="transform";
	$translate["val"]='translate(50px,100px)';

	//transform: scale(2,4);
	$scale["title"]="transform:scale";
	$scale["ttl"]="transform";
	$scale["val"]='scale(2,4)';

	//transform: skew(30deg,20deg);
	$skew["title"]="transform:skew";
	$skew["ttl"]="transform";
	$skew["val"]='skew(30deg,20deg)';

	//transform:matrix(0.866,0.5,-0.5,0.866,0,0);
	$matrix["title"]="transform:matrix";
	$matrix["ttl"]="transform";
	$matrix["val"]='matrix(0.866,0.5,-0.5,0.866,0,0)';

	//transform: rotateX(120deg);
	$rotateX["title"]="transform:rotateX";
	$rotateX["ttl"]="transform";
	$rotateX["val"]='rotateX(120deg)';

	//transform: rotateY(130deg);
	$rotateY["title"]="transform:rotateY";
	$rotateY["ttl"]="transform";
	$rotateY["val"]='rotateY(130deg)';

	//transition:all .5s ease-in-out; 
	$transition["title"]="transition";
	$transition["ttl"]="transition";
	$transition["val"]='all .5s ease-in-out';

	//animation: myfirst 5s linear 2s infinite alternate;
	$animation["title"]="animation";
	$animation["ttl"]="animation";
	$animation["val"]='myfirst 5s linear 2s infinite alternate';

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
			val($v);
		};
	}else{//展示列表
		$smarty->assign("rsList",$rsList);
		$smarty->display("top_others_css3.html");
	}

}


//兼容处理后返回
function val($title){
	if($_POST["data_title"]==$title["title"]){
		if(!$_POST["data_val"]==""){
			$val=$_POST["data_val"];
		}else{
			$val=$title["val"];
		}
		$code=$title["ttl"].":".$val."; -webkit-".$title["ttl"].":".$val.";";
		echo json_encode($code);
	}
}


?>

