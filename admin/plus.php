<?php
//require_once("include.php");
	// header("Access-Control-Allow-Origin:*");
	// header("Content-Type:application/json;charset=UTF-8");

	// $conn=new mysqli("localhost:8000","root","123","fore-end");
	// $result=$conn->query("SELECT * FROM cookie_form");
	// $outp='';
	// while($rs=$result->fetch_array(MYSQLI_ASSOC)){
	// 	if($outp!=""){$outp.=",";}
	// 	$outp.='{"Id":"'.$rs["id"].'",';
	// 	$outp.='"Ttl":"'.$rs["ttl"].'",';
	// 	$outp.='"Cookie_code":"'.$rs["cookie_code"].'"}';
	// };
	// $outp='{"records":['.$outp.']}';
	// $conn->close();
	// echo($outp);




require_once("include.php");
$sdb=new db();
$rs=$sdb->getTableAllResult("cookie_form","1=1");
echo json_encode($rs);


?>