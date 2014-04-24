<?php 
require_once('phplib/rs.php');

$bucket="gradunion";
$key1="";

if(isset($_GET['bucket']))
	$bucket=$_GET['bucket'];
if(isset($_GET['key']))
	$key1=$_GET['key'];

$scope=$bucket;
if(strcmp($key1,"")!=0)
	$scope=$scope.":".$key1 ;

$accessKey = 'Dlg_hYbpSA5VGIYIYu2pm7q5Gx1HJlh014YTUJF2';
$secretKey = 'oKm1Pr65k_oIMOw5ZHc0pisQbai_dYodi_NoQqDl';
Qiniu_setKeys($accessKey, $secretKey);

$putPolicy = new Qiniu_RS_PutPolicy($scope);
$upToken = $putPolicy->Token(null);

echo json_encode(array("uptoken"=>$upToken)); 


?>