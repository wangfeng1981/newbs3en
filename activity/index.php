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

    <title>课程列表</title>

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
						  <?php sideNavigationBlock("activity"); ?>
					  	</div>
					</div>
					<div class="col-md-8 column">
						<?php
							if(isset($_GET['join']))
							{//want to join the lesson.
								$les=new tabLesson();
								$les->retrieve($_GET['join']) ;
								if($les->exists())
								{
									if($les->currentNumber()>=$les->get('maxnum'))
									{//lesson reach maxnum, can't join.
										jAlertBlock("alert-warning","警告!","本次课程已达最大人数,您无法加入.");
									}else
									{
										if(isset($_SESSION['stuserial']))
										{//do logined.
											$ord=new tabLesorder();
											$ord->retrieve_one("lesserial=? AND stuserial=?",array($_GET['join'],$_SESSION['stuserial']));
											if($ord->get('serial')>0)
											{//has joint the same lesson yet.
												jAlertBlock("alert-warning","警告!","您已加入本次课程,请不要重复加入.");
											}else
											{//hasn't joint this lesson.
												$ord=new tabLesorder();
												$ord->set('lesserial',$_GET['join']);
												$ord->set('stuserial',$_SESSION['stuserial']);
												$ord->set('utime',time());
												$ord->create();
												$newserial=$ord->get('serial');
												if($newserial>0)
												{// join successfully.
													jAlertBlock("alert-success","OK!","您已成功加入到本次课程.");
												}else
												{// something wrong with lesserial or stuserial or bugs.
													jAlertBlock("alert-danger","错误!","选课过程中出现错误,可能是学号或课程编号无效.请重新登录后再试,或给联系管理员帮忙解决.");
												}
											}
										}else
										{// not logined.
											jAlertBlock("alert-danger","错误!","请登录后再进行相关操作.");
										}
									}
								}
							}
						?>
						<?php 
							if(isset($_GET['les']))
							{
								activityBlock(4,0,$_GET['les']);
							}else if(isset($_GET['join'])) 
							{
								activityBlock(4,0,$_GET['join']);
							}else if(isset($_GET['act']))
							{
								activityBlock(3,$_GET['act'],0);
							}else
							{
								activityBlock(2,0,0);
							}
						?>
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
