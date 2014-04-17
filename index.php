<?php session_start(); ?>
<?php /*require('kiss/config.php');*/ ?>

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
						  <?php /*sideNavigationBlock("");*/  ?>
					  	</div>
					</div>
					<div class="col-md-6 column">
						<!-- 课程分类列表 -->
						<?php /*activityBlock(1);*/ template(); ?>
						
						
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
						<div class="bs-callout bs-callout-warning">
							<div class="media">
							  <a class="pull-left" href="#">
								<img class="media-object" src="photos/teacher.jpg" width="32" height="32">
							  </a>
							  <div class="media-body">
								<h5>王老师</h5>
								<p>这是置顶通知，请详细阅读。。。。。。</p>
								<p class="jfwfupdate">2014.5.2</p>
							  </div>
							</div>
						</div>



						<div class="bs-callout bs-callout-info">
							<div class="jfwfcmtYellow">
								<div>
									<img class="media-object" src="photos/teacher.jpg" alt="pdf"  width="32" height="32">
								</div>
								<div>
									<h4>Teacher Yang</h4>
									<p>这是普通通知，请详细阅读。。。。。。</p>
									<p class="jfwfupdate">2014.5.1</p>
								</div>
							</div>
						</div>
						<div class="bs-callout bs-callout-info">
							<div style="display:inline-block;vertical-align:top">
								<img src="photos/teacher.jpg" alt="pdf"  width="32" height="32">
							</div>
							<div style="display:inline-block;margin=2px 2px 2px 2px">
								<h4>Teacher Wang</h4>
								<p>通知2... ... ... ...。</p>
								<p class="jfwfupdate text-right">2014.4.20</p>
							</div>
						</div>
						<div class="bs-callout bs-callout-info" style="padding:2px 2px 2px 5px;margin:2px 2px 2px 2px">
							<a class="pull-left" href="#">
								<img src="photos/teacher.jpg" alt="pdf"  width="32" height="32">
							</a>
							<h5>Teacher Yang</h5>
							<p>通知3... h5 and padding 2px margin 2px.. ...。</p>
							<p class="jfwfupdate">2014.4.15</p>
						</div>
						<div class="media">
						  <img class="media-object" src="img/pdficon.jpg" alt="pdf"  width="32" height="32">
						  <div class="media-body">
							<h5 class="media-heading">Student Zhao</h5>
							IGARSS会议报告及行程
							<p class="jfwfupdate">2014.5.2</p>
						  </div>
						  <hr>
						</div>
						<hr>
						<h3>最新留言(5)</h3>
						<hr>
						<div class="bs-callout bs-callout-student">
							<h4>Student ABC</h4>
							<p>这是我的留言。</p>
							<p class="jfwfupdate">2014.5.2</p>
						</div>
						<div class="bs-callout bs-callout-student">
							<h4>Student ABC</h4>
							<p>这是我的留言。</p>
							<p class="jfwfupdate">2014.5.2</p>
						</div>
						<div class="bs-callout bs-callout-student">
							<h4>Student ABC</h4>
							<p>这是我的留言。</p>
							<p class="jfwfupdate">2014.5.2</p>
						</div>
						<div class="bs-callout bs-callout-student">
							<h4>Student ABC</h4>
							<p>这是我的留言。</p>
							<p class="jfwfupdate">2014.5.2</p>
						</div>
						<div class="bs-callout bs-callout-student">
							<h4>Student ABC</h4>
							<p>这是我的留言。</p>
							<p class="jfwfupdate">2014.5.2</p>
						</div>
						
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
