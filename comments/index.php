<?php session_start(); ?>
<?php require('../kiss/config.php'); ?>
<?php
	
	if( isset($_SESSION['stuserial']) && $_POST['comment'])
	{
		$cmt = new tabComments();
		$cmt->set('bystuserial',$_SESSION['stuserial']);
		$cmt->set('message',$_POST['comment']);
		$cmt->set('utime',time());
		$cmt->create();
	}
?>

<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>查看留言</title>

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
						  <?php sideNavigationBlock("comments");?>
					  </div>
					</div>
					<div class="col-md-8 column">
						<h4>全部留言</h4>
						<hr>
						<!-- comments -->
						<?php 
							$ipage=0;
							if(isset($_GET['icpage']))
								$ipage=intval($_GET['icpage']);
							commentsBlock(5,$ipage,1); ?>

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
