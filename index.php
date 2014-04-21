<?php session_start(); ?>
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
				<!-- top navigation bar -->
				<?php topNaviBlock(); ?>

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
						<h4>最新文件资源</h4>
						<hr>
						<!-- 文件列表 -->
						<?php filesBlock(5); ?>
						
					</div>

					<div class="col-md-4 column">
						<h4><strong>最新通知</strong></h4>
						<hr>
						<!-- news -->
						<?php newsBlock(); ?>

						<hr>
						<h4><strong>最新评论</strong></h4>
						<hr>
						<!-- comments -->
						<?php commentsBlock(); ?>
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
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
