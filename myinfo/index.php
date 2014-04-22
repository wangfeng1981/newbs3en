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

    <title>我的信息</title>

    <!-- Bootstrap core CSS -->
	<link href="../css/jfwfdocs.min.css" rel="stylesheet">
    <link href="../css/bootstrap.css" rel="stylesheet">
	

    <!-- Custom styles for this template -->
	<link href="../css/jfwf.css" rel="stylesheet">

    
  </head>

  <body>

	<div class="container">
		<div class="row clearfix">
			<div class="col-md-12 column">
				<!-- top navigation bar -->
				<?php topNaviBlock(); ?>

				<div class="row clearfix">
					<div class="col-md-2 column ">
						<div class="bs-sidebar hidden-print affix" role="complementary">
						  <!-- side navigation -->
						  <?php sideNavigationBlock("myinfo"); ?>
					  	</div>
					</div>
					<div class="col-md-8 column">
						<!-- my info -->
						<h4>我的个人信息</h4>
						<?php
							$stu=new tabStudent();
							if(isset($_SESSION['stuserial']))
							{
								$stu->retrieve($_SESSION['stuserial']);
								if($stu->exists())
								{

								}else
								{
									jAlertBlock("alert-danger","错误!","学号无效,请稍后重新登录再试.");
								}
							}else {
								jAlertBlock("alert-warning","警告!","请先登录,然后查看个人信息.");
							} 
						?>
						<table class="table table-striped table-hover">
							<thead>
								<tr><th>#</th><th>字段</th><th>值</th><th>操作</th></tr>
							</thead>
							<tbody>
								<tr><td>1</td><td>学号</td><td><?php echo $stu->get('stuid');?></td><td>修改</td></tr>
								<tr><td>2</td><td>密码</td><td>*********</td><td>修改</td></tr>
								<tr><td>3</td><td>姓名</td><td><?php echo $stu->get('stuname');?></td><td>修改</td></tr>
								<tr><td>4</td><td>头像</td><td><img width="50" height="50" src="<?php echo $GLOBALS['gSiteRootPath'].'photos/'.$stu->get('photo');?>"></td><td>修改</td></tr>
							</tbody>
						</table>
						<hr>

						<!-- my lesson orders -->
						<h4>我的课程</h4>
						<table class="table table-striped table-hover">
						  <thead>
								<tr><th>#</th><th>课程</th><th>期次</th><th>加入时间</th><th>文件(冒泡提示文件标题)</th><th>操作</th></tr>
							</thead>
							<tbody>
								<?php 
									$ord=new tabLesorder();
									$array=$ord->retrieve_many("stuserial=? ORDER BY utime DESC",$_SESSION['stuserial']);
									$i=1;
									foreach ($array as $ord) { ?>
									<tr><td><?php echo $i;$i=$i+1;?></td><td>?</td><td><?php echo $ord->get('lesserial');?></td><td><?php echo edt2sh($ord->get('utime'));?></td><td>?</td><td>退出</td></tr>
								<?php } ?>
								
							</tbody>
						</table>
						<hr>

						<!-- my messages -->
						<h4>我的留言</h4>
						<table class="table table-striped table-hover">
						  <thead>
								<tr><th>#</th><th>留言</th><th>时间</th><th width="50">操作</th></tr>
							</thead>
							<tbody>
								<?php 
									$cmt=new tabComments();
									$array=$cmt->retrieve_many("bystuserial=? ORDER BY utime DESC",$_SESSION['stuserial']);
									$i=1;
									foreach ($array as $cmt) { ?>
									<tr><td><?php echo $i;$i=$i+1;?></td><td><?php echo $cmt->get('message');?></td><td><?php echo edt2sh($cmt->get('utime'));?></td><td>删除</td></tr>
								<?php } ?>
								
							</tbody>
						</table>
						<hr>
						<!-- leave a comment block -->
						<?php leaveACommentBlock(); ?>
						
					</div>

				</div>
			</div>
		</div>
		
	</div>

	<!-- Footer block  -->
	<?php footerBlock(); ?>
	  
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../js/jquery-1.10.2.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
