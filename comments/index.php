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
						<?php
						
							if( isset($_SESSION['stuserial']) && isset($_POST['comment']) && isset($_POST['icmt']) && isset($_POST['ireply']) )
							{
								if($_POST['icmt']==0 && $_POST['ireply']==0 )
								{
									$cmt = new tabComments();
									$cmt->set('bystuserial',$_SESSION['stuserial']);
									$cmt->set('message',$_POST['comment']);
									$cmt->set('utime',time());
									$cmt->create();
									jAlertBlock($atype="alert-success",$atitle="OK!",$amsg="留言成功.");
								}else if( $_POST['icmt'] > 0 )
								{
									$c2=new tabC2() ;
									$c2->set('stuserial',$_SESSION['stuserial']);
									$c2->set('replyserial',$_POST['icmt']);
									$c2->set('message',$_POST['comment']);
									$c2->set('utime',time());
									$c2->create();
									jAlertBlock($atype="alert-success",$atitle="OK!",$amsg="评论成功.");
								}else
								{
									$c2=new tabC2() ;
									$c2->retrieve($_POST['ireply']);

									$r1=new tabC2() ;
									$r1->set('stuserial',$_SESSION['stuserial']);
									$r1->set('replyserial',$c2->get('replyserial'));
									$r1->set('message',$_POST['comment']);
									$r1->set('utime',time());
									$r1->create();
									jAlertBlock($atype="alert-success",$atitle="OK!",$amsg="回复成功.");
								}
								
							}
						?>

						<?php if(isset($_GET['view'])) { 
							echo "<p><a href='".$GLOBALS['gSiteRootPath'].'comments/'."'>返回全部留言</a></p><hr>";
							$cmt=new tabComments() ;
							$cmt->retrieve($_GET['view']) ;
							if($cmt->exists())
								oneCommentBlock($cmt,1) ;
							if(isset($_GET['reply']))
							{
								//leave reply.
								leaveACommentBlock(0,$_GET['reply']);
							}else
							{
								//leave comment.
								leaveACommentBlock($_GET['view'],0);
							}

						 }/*end if */else
						 {
						 	echo "<h4><strong>全部留言</strong></h4>";
						 	echo "<hr>";
						 	$ipage=0;
						 	if(isset($_GET['icpage']))
						 		$ipage=intval($_GET['icpage']);
						 	commentsBlock(10,$ipage,1);
						 	echo "<hr>";
						 	leaveACommentBlock(0,0);
						 } 

						 ?>
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
