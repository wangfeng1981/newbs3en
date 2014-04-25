<?php session_start(); ?>
<?php 
require_once('phplib/rs.php');

if(isset($_GET['bucket']) && isset($_GET['key']) && isset($_GET['les']) && isset($_GET['rurl']) && isset($_SESSION['stuserial']))
{
	$bucket=$_GET['bucket'];
	$key1=$_GET['key'];
	$scope=$bucket.":".$key1 ;

	$accessKey = 'Dlg_hYbpSA5VGIYIYu2pm7q5Gx1HJlh014YTUJF2';
	$secretKey = 'oKm1Pr65k_oIMOw5ZHc0pisQbai_dYodi_NoQqDl';
	Qiniu_setKeys($accessKey, $secretKey);

	$putPolicy = new Qiniu_RS_PutPolicy($scope);
	if(isset($_GET['rurl']))
	{
		$putPolicy->ReturnUrl=urldecode($_GET['rurl']);
		$putPolicy->ReturnBody=json_encode(array('les' =>$_GET['les'],'stu'=>$_SESSION['stuserial'] ));
	}	
	$upToken = $putPolicy->Token(null);

	echo json_encode(array("uptoken"=>$upToken)); 
}else
{
	echo json_encode(array("uptoken"=>"")); 
}


?>