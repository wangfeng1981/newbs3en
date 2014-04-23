<?php 
require_once('phplib/rs.php');

if(isset($_GET['bucket'])==false || isset($_GET['key'])==false )
{
	echo "";
}else
{
	$bucket = $_GET['bucket'];
	$key1 = $_GET['key'];
	$scope=$bucket.":".$key1;

	$accessKey = 'Dlg_hYbpSA5VGIYIYu2pm7q5Gx1HJlh014YTUJF2';
	$secretKey = 'oKm1Pr65k_oIMOw5ZHc0pisQbai_dYodi_NoQqDl';
	Qiniu_setKeys($accessKey, $secretKey);

	$putPolicy = new Qiniu_RS_PutPolicy($scope);
	$upToken = $putPolicy->Token(null);

	echo $bucket."<br>";
	echo $key1."<br>";
	echo $upToken;
}

?>