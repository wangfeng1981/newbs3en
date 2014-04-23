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
						<!-- Warning informations -->
						<?php
						
							if(isset($_FILES["file"]["name"]) && isset($_SESSION['stuserial']))
							{
								if( jSaveStudentPhotoFile($_SESSION['stuserial']) )
								{
									jAlertBlock($atype="alert-success",$atitle="OK!",$amsg="修改头像成功.");
								}else
								{
									jAlertBlock($atype="alert-warning",$atitle="警告!",$amsg="修改头像失败,可能因为文件尺寸大于10k或者格式错误,请修改后再试.");
								}
							}else if(isset($_POST['pass0']) && isset($_POST['pass0']) && isset($_POST['pass0']) && isset($_SESSION['stuserial']))
							{
								$stu=new tabStudent();
								$stu->retrieve($_SESSION['stuserial']);
								if($stu->exists())
								{
									if(strcmp($_POST['pass0'],$stu->get('stupass'))==0)
									{
										if(strcmp($_POST['pass1'],$_POST['pass2'])==0)
										{
											$stu->set('stupass',$_POST['pass1']);
											$stu->update();
											jAlertBlock($atype="alert-success",$atitle="OK!",$amsg="修改密码成功.");
										}else
										{
											jAlertBlock($atype="alert-warning",$atitle="警告!",$amsg="两次输入的新密码不同,请重新输入.");
										}
									}else
									{
										jAlertBlock($atype="alert-warning",$atitle="警告!",$amsg="旧密码错误,请重新输入.");
									}
								}
							}

						?>


						<!-- my info -->
						<h4><strong>个人资料</strong></h4>
						<?php
							$stu=new tabStudent();
							if(isset($_SESSION['stuserial']))
							{
								$stu->retrieve($_SESSION['stuserial']);
								if($stu->exists())
								{ ?>
									<div class="media">
										<a class="pull-left">
											<img style="margin:10px" width="50" height="50" src="<?php echo $GLOBALS['gSiteRootPath'].'photos/'.$stu->get('photo');?>">
										</a>
										<div class="media-body" style="margin:10px">
											<strong>姓名:<?php echo $stu->get('stuname');?></strong>
											<br><strong>学号:</strong><?php echo $stu->get('stuid');?>
										</div>
									</div>
									<div class="panel-group" id="panel-1">
										<div class="panel panel-default">
											<div class="panel-heading">
												 <a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-1" href="#panel-changephoto">修改头像</a>
											</div>
											<div id="panel-changephoto" class="panel-collapse collapse">
												<div class="panel-body">
													<form class="form-horizontal" id="formcphoto" action="" method="post" enctype="multipart/form-data">
														<fieldset>
														<!-- File Button --> 
														<div class="form-group">
														  <label class="col-md-4 control-label" for="photo">新头像文件</label>
														  <div class="col-md-4">
														    <input id="file" name="file" class="input-file" type="file">
														    <span class="help-block">请上传50x50 小于10k的jpg,png,gif文件.</span>  
														  </div>
														</div>

														<!-- Button -->
														<div class="form-group">
														  <label class="col-md-4 control-label" for="submit"></label>
														  <div class="col-md-4">
														    <button id="submit" name="submit" class="btn btn-success">确认上传</button>
														  </div>
														</div>
														</fieldset>
													</form>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading">
												 <a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-1" href="#panel-changepwd">修改密码</a>
											</div>
											<div id="panel-changepwd" class="panel-collapse collapse">
												<div class="panel-body">
													<form class="form-horizontal" id="formcpwd" action="" method="post">
														<fieldset>
														<!-- Password input-->
														<div class="form-group">
														  <label class="col-md-4 control-label" for="pass0">旧密码</label>
														  <div class="col-md-4">
														    <input id="pass0" name="pass0" type="password" placeholder="" class="form-control input-md" required="">
														    
														  </div>
														</div>

														<!-- Password input-->
														<div class="form-group">
														  <label class="col-md-4 control-label" for="pass1">新密码</label>
														  <div class="col-md-4">
														    <input id="pass1" name="pass1" type="password" placeholder="" class="form-control input-md" required="">
														    
														  </div>
														</div>

														<!-- Password input-->
														<div class="form-group">
														  <label class="col-md-4 control-label" for="pass2">确认新密码</label>
														  <div class="col-md-4">
														    <input id="pass2" name="pass2" type="password" placeholder="" class="form-control input-md" required="">
														    
														  </div>
														</div>

														<!-- Button -->
														<div class="form-group">
														  <label class="col-md-4 control-label" for="submit"></label>
														  <div class="col-md-4">
														    <button id="submit" name="submit" class="btn btn-success">确认修改</button>
														  </div>
														</div>

														</fieldset>
													</form>

												</div>
											</div>
										</div>
									</div>
								<?php 
								}else
								{
									jAlertBlock("alert-danger","错误!","学号无效,请稍后重新登录再试.");
								}
							}else {
								jAlertBlock("alert-warning","警告!","请先登录,然后查看个人信息.");
							} 
						?>
						<hr>

						<!-- my lesson orders -->
						<h4><strong>我的课程</strong></h4>
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
						<h4><strong>我的留言</strong></h4>
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
