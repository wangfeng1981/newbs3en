﻿<?php session_start(); ?>
<?php require('kiss/config.php'); ?>

<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>研究生课程小助手-首页</title>

    <!-- Bootstrap core CSS -->
	<link href="css/jfwfdocs.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
	

    <!-- Custom styles for this template -->
	<link href="css/jfwf.css" rel="stylesheet">

    
  </head>

  <body>

	<div class="container">
		<div class="row clearfix">
			<div class="col-md-12 column">
				<nav class="navbar navbar-default" role="navigation">
					<div class="navbar-header">
						 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="#">研究生选课小助手</a>
					</div>
					
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<form class="navbar-form navbar-right" role="form">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="请输入学号">
								<input type="password" class="form-control" placeholder="请输入密码">
								<div class="checkbox">
									<label>
									  <input type="checkbox">记住我
									</label>
								</div>
							</div> <button type="submit" class="btn btn-primary">登录</button>
						</form>
						<ul class="nav navbar-nav navbar-right">
							<li>
								<a href="#">退出</a>
							</li>
						</ul>
					</div>
					
				</nav>
				<div class="row clearfix">
					<div class="col-md-2 column ">
						<div class="bs-sidebar hidden-print affix" role="complementary">
						  <!-- side navigation -->
						  <?php sideNavigationBlock(""); ?>
					  	</div>
					</div>
					<div class="col-md-6 column">
						<!-- 课程分类列表 -->
						<?php activityBlock(1); ?>
						
						
						<hr>
						<h3>最新PPT(5)</h3>
						<hr>
						<div class="media">
						  <a class="pull-left" href="#">
							<img class="media-object" src="img/ppticon.jpg" alt="ppt" width="32" height="32">
						  </a>
						  <div class="media-body">
							<h4 class="media-heading">Student Mi</h4>
							遥感XXX研究进展
							<p class="jfwfupdate">2014.5.2</p>
						  </div>
						  <hr>
						</div>
						<div class="media">
						  <a class="pull-left" href="#">
							<img class="media-object" src="img/pptxicon.jpg" alt="pptx"  width="32" height="32">
						  </a>
						  <div class="media-body">
							<h4 class="media-heading">Student Li</h4>
							IGARSS会议报告及行程
							<p class="jfwfupdate">2014.5.2</p>
						  </div>
						  <hr>
						</div>		
						<div class="media">
						  <a class="pull-left" href="#">
							<img class="media-object" src="img/pdficon.jpg" alt="pdf"  width="32" height="32">
						  </a>
						  <div class="media-body">
							<h4 class="media-heading">Student Zhao</h4>
							IGARSS会议报告及行程
							<p class="jfwfupdate">2014.5.2</p>
						  </div>
						  <hr>
						</div>
						
					</div>

					<div class="col-md-4 column">
						<h4><strong>最新通知</strong></h4>
						<hr>
						<!-- news -->
						<?php newsBlock(); ?>

						<hr>
						<h4>最新留言</h4>
						<hr>
						<!-- comments -->
						<?php commentsBlock(); ?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	  
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
