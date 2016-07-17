<?php
include_once("include.php");
//include_once("_import.php");
$sdb=new db();
$g=$_GET;
$p=$_POST;


//border-radius
$rsList[0]["title"]="border-radius";
$rsList[0]["ttl"]="border-radius";
$rsList[0]["val"]='5px';
val($rsList[0]);

//opacity
$rsList[1]["title"]="opacity";
$rsList[1]["ttl"]="opacity";
$rsList[1]["val"]=0.6;
val($rsList[1]);

//box-shadow
$rsList[2]["title"]="box-shadow";
$rsList[2]["ttl"]="box-shadow";
$rsList[2]["val"]='0 0 2px #ccc';
val($rsList[2]);

//text-shadow
$rsList[3]["title"]="text-shadow";
$rsList[3]["ttl"]="text-shadow";
$rsList[3]["val"]='1px 1px 0 #ccc';
val($rsList[3]);

//transform: rotate(45deg)
$rsList[4]["title"]="transform:rotate";
$rsList[4]["ttl"]="transform";
$rsList[4]["val"]='rotate(45deg)';
val($rsList[4]);

//transform: translate(50px,100px)
$rsList[5]["title"]="transform:translate";
$rsList[5]["ttl"]="transform";
$rsList[5]["val"]='translate(50px,100px)';
val($rsList[5]);

//transform: scale(2,4);
$rsList[6]["title"]="transform:scale";
$rsList[6]["ttl"]="transform";
$rsList[6]["val"]='scale(2,4)';
val($rsList[6]);

//transform: skew(30deg,20deg);
$rsList[7]["title"]="transform:skew";
$rsList[7]["ttl"]="transform";
$rsList[7]["val"]='skew(30deg,20deg)';
val($rsList[7]);

//transform:matrix(0.866,0.5,-0.5,0.866,0,0);
$rsList[8]["title"]="transform:matrix";
$rsList[8]["ttl"]="transform";
$rsList[8]["val"]='matrix(0.866,0.5,-0.5,0.866,0,0)';
val($rsList[8]);

//transform: rotateX(120deg);
$rsList[9]["title"]="transform:rotateX";
$rsList[9]["ttl"]="transform";
$rsList[9]["val"]='rotateX(120deg)';
val($rsList[9]);

//transform: rotateY(130deg);
$rsList[10]["title"]="transform:rotateY";
$rsList[10]["ttl"]="transform";
$rsList[10]["val"]='rotateY(130deg)';
val($rsList[10]);



//transition:all .5s ease-in-out; 
$rsList[11]["title"]="transition";
$rsList[11]["ttl"]="transition";
$rsList[11]["val"]='all .5s ease-in-out';
val($rsList[11]);

//animation: myfirst 5s linear 2s infinite alternate;
$rsList[12]["title"]="animation";
$rsList[12]["ttl"]="animation";
$rsList[12]["val"]='myfirst 5s linear 2s infinite alternate';
val($rsList[12]);





//column-count:3;


//column-gap:40px;

//column-rule:3px outset #ff0000;






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


//if($_GET["col"]){
	$smarty->assign("rsList",$rsList);
	$smarty->display("col_others_css3.html");
//}



?>