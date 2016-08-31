<?php
require_once("include.php");
	header("Access-Control-Allow-Origin:*");
	header("Content-Type:application/json;charset=UTF-8");

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



$con=mysql_connect('localhost:8000','root','123');
mysql_select_db("fore-end", $con);
mysql_query("set names 'utf8'");//避免中文都变问号

$sql="SELECT * FROM cookie_form ";
$result_ = mysql_query($sql);
while( $row2 = mysql_fetch_array($result_,MYSQL_ASSOC) ){
    $result8[] = $row2;
}

print_r($result8);


?>