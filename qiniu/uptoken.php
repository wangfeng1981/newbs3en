<?php session_start(); ?>
<?php 
require_once('phplib/rs.php');

if(isset($_GET['bucket']) && isset($_GET['key']) && isset($_GET['rurl']) && isset($_GET['rv1']) && isset($_GET['rv2']) )
{
	// build token string.
	$bucket=$_GET['bucket'];
	$key1=$_GET['key'];
	$scope=$bucket.":".$key1 ;

	$accessKey = 'Dlg_hYbpSA5VGIYIYu2pm7q5Gx1HJlh014YTUJF2';
	$secretKey = 'oKm1Pr65k_oIMOw5ZHc0pisQbai_dYodi_NoQqDl';
	Qiniu_setKeys($accessKey, $secretKey);

	$putPolicy = new Qiniu_RS_PutPolicy($scope);
	$putPolicy->ReturnUrl=urldecode($_GET['rurl']);
	$putPolicy->ReturnBody=json_encode( array('rv1'=>$_GET['rv1'],'rv2'=>$_GET['rv2']));
	$upToken = $putPolicy->Token(null);
	echo json_encode(array("uptoken"=>$upToken)); 
}else
{
	echo json_encode(array("error"=>"error: less inparams.")); 
}


?>