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

    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/jfwfdocs.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
	<link href="../css/jfwf.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
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
						  <ul class="nav bs-sidenav nav-pills nav-stacked">
							<!-- side navigation -->
							<li class="active">
								<a href="<?php echo $GLOBALS['gSiteRootPath'];?>"><strong>首页</strong></a>
							</li>
							<li>
								<a href="<?php echo $GLOBALS['gSiteRootPath'].'myinfo/';?>">我的信息</a>
							</li>
							<li>
								<a href="<?php echo $GLOBALS['gSiteRootPath'].'news/';?>">查看通知</a>
							</li>
							<li>
								<a href="<?php echo $GLOBALS['gSiteRootPath'].'comments/';?>">查看评论</a>
							</li>
							<hr>
							<li>
								<a href="<?php echo $GLOBALS['gSiteRootPath'].'activity/';?>"><span class="label label-primary">课程</span></a>
							</li>
							<hr>
							<li>
								<a href="<?php echo $GLOBALS['gSiteRootPath'].'ppt/';?>">查看PPT</a>
							</li>
						</ul>
					  </div>
					</div>
					<div class="col-md-6 column">
						<div class="list-group">
							<div class="list-group-item-first">
								<h3>博士学术论坛</h3>
							</div>
							<a href="#" class="list-group-item" >
								<h4 class="list-group-item-heading">
									2014年第一期
								</h4>
								<p class="list-group-item-text">
									2014年5月1日 奥运园区A501.
								</p>
								<span class="label label-success">剩余14</span>
								<p class="jfwfupdate">2014.4.25</p>
							</a>
						</div>
						<div class="list-group">
							<div class="list-group-item-first">
								<h3>开题</h3>
							</div>
							<a href="#" class="list-group-item" >
								<h4 class="list-group-item-heading">
									2014年第一期
								</h4>
								<p class="list-group-item-text">
									2014年春季开题的同学请加入该批次.
								</p>
								<span class="label label-success">剩余14</span>
								<p class="jfwfupdate">2014.5.25</p>
							</a>
						</div>
						
						
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
						<h3>最新通知(5)</h3>
						<hr>
						<div class="bs-callout bs-callout-warning">
							<h4>Teacher Yang</h4>
							<p>这是置顶通知，请详细阅读。。。。。。</p>
							<p class="jfwfupdate">2014.4.1</p>
						</div>
						<div class="bs-callout bs-callout-info">
							<h4>Teacher Yang</h4>
							<p>这是普通通知，请详细阅读。。。。。。</p>
							<p class="jfwfupdate">2014.5.1</p>
						</div>
						<div class="bs-callout bs-callout-info">
							<h4>Teacher Wang</h4>
							<p>通知2... ... ... ...。</p>
							<p class="jfwfupdate">2014.4.20</p>
						</div>
						<div class="bs-callout bs-callout-info">
							<h4>Teacher Yang</h4>
							<p>通知3... ... ... ...。</p>
							<p class="jfwfupdate">2014.4.15</p>
						</div>
						<div class="bs-callout bs-callout-info">
							<h4>Teacher Yang</h4>
							<p>通知4... ... ... ...。</p>
							<p class="jfwfupdate">2014.4.10</p>
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
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
