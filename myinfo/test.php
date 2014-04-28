<?php session_start(); ?>
<?php require('../kiss/config.php'); ?>

<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>test我的信息</title>

    <!-- Bootstrap core CSS -->
	<link href="../css/jfwfdocs.min.css" rel="stylesheet">
    <link href="../css/bootstrap.css" rel="stylesheet">
	

    <!-- Custom styles for this template -->
	<link href="../css/jfwf.css" rel="stylesheet">

    
  </head>

  <body>

  	<?php
  		if($_GET['upload_ret'])
  		{
  			$str=base64_decode($_GET['upload_ret']);
  			$obj1=json_decode($str);
  			echo $obj1->rv1;
  			echo "<br>";
  			echo $obj1->rv2;
  			echo "<br>";

        $arr1=split(",",$obj1->rv1);

        $ord=new tabLesorder();
        $ord->retrieve($arr1[0]);
        if($ord->exists())
        {
          $sfile=new tabStufile();
          if( $sfile->retrieve_one("stuserial=? AND lesserial=?",array($ord->get('stuserial'),$ord->get('lesserial') ) ) )
          {//update the old.
            $sfile->set('utime',time());
            $sfile->set('title',$obj1->rv2);
            $sfile->set('url',"http://gradunion.qiniu.com/".$ord->get('lesserial')."/".$ord->get('stuserial').".".$arr1[1]);
            $sfile->update();
            echo '<h2>更新成功!</h2>';
          }else
          {//create new one.
            $sfile->set('stuserial',$ord->get('stuserial'));
            $sfile->set('lesserial',$ord->get('lesserial'));
            $sfile->set('url',"http://gradunion.qiniu.com/".$ord->get('lesserial')."/".$ord->get('stuserial').".".$arr1[1]);
            $sfile->set('utime',time());
            $sfile->set('title',$obj1->rv2);
            $sfile->create();
            echo '<h2>上传成功!</h2>';
          }

        }
  		}
  	?>

  	<hr>

  	<form id="form1" action="http://up.qiniu.com" enctype="multipart/form-data" method="post">
  		file:<input type="file" id="file" name="file" ><br>
  		key:<input type="text" id="key" name="key" value="201/333.ppt"><br>
  		token:<input type="text" id="token" name="token"><br>
  		<button type="button" id="submitppt" name="submitppt" >submit</button>
  	</form>

  	
					
	<div id="show1"></div>
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>


    <script type="text/javascript">
//提交PPT消息处理
	$( "#submitppt" ).click(function(event){
    var vord=20;
    var vles=12;
    var vstu=467;
    var rval1=""+vord+","+"ppt";
    var vtlt="前端js第三方SDK，用于构建网页七牛云存储应用，支持文件上传、进度查询、预览、文件处理等功能";
    var vkey=""+vles+"/"+vstu+".pdf";
		$.get( "../qiniu/uptoken.php", {bucket:"gradunion",key:vkey,rurl:"http://jfwf.erufa.com/yslt/newbs3en/myinfo/test.php",rv1:rval1,rv2:vtlt },"text").done(function(data){
		  	data.trim();
		  	$('#show1').text(data);
		  	var obj1=jQuery.parseJSON(data);
		  	if(obj1.uptoken)
		  	{
		  		$('#token').val(obj1.uptoken);
          $('#key').val(vkey);
		  		$('#form1').submit();
		  	}else
		  	{
		  		alert("错误:");
		  	}
		  });
	});

	    </script>
  </body>
</html>