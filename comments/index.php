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
						<?php if(isset($_GET['view'])) { ?>
							<p><a href="<?php echo $GLOBALS['gSiteRootPath'].'comments/';?>">返回全部留言</a></p>
							<?php
								$selstr="comments_table.serial as cserial, comments_table.message as cmessage, comments_table.utime as cutime, student_table.stuname as sname, student_table.photo as sphoto";
								$frmstr="comments_table,student_table";
								$whrstr="comments_table.bystuserial=student_table.serial AND comments_table.serial=".$_GET['view'];

								$cmt = new tabComments() ;
								$cmt_array = $cmt->select_mt($selstr,$frmstr,$whrstr);
								$cmt=$cmt_array[0] ; ?>
									<div class="jcomment">
									  <div class="jcomment-photo">
									  	<img src="<?php echo $GLOBALS['gSiteRootPath'].'photos/'.$cmt['sphoto'];?>" width='50' height='50'>
									  </div>
									  <div class="jcomment-header">
									    <?php echo $cmt['sname'];?>
									  </div>
									  <div class="jcomment-body">
									    <?php echo $cmt['cmessage'];?>
									  </div>
									  <div class="jcomment-footer">
									  	<?php echo edt2sh($cmt['cutime']);?>
									  	<a href="#">评论(
									  		<?php 
									  		$c2=new tabC2() ;
									  		$arr=$c2->select("count(serial) as nreply","replyserial=?",$cmt['cserial']) ;
									  		echo $arr[0]['nreply'];?>
									  	)
									  	</a>
									  </div>
									</div>

						<?php }/*end if */ ?>
						<?php else { ?>
							<h4>全部留言</h4>
							<hr>
							<!-- comments -->
							<?php 
								$ipage=0;
								if(isset($_GET['icpage']))
									$ipage=intval($_GET['icpage']);
								commentsBlock(5,$ipage,1); ?>
						<?php }/* endelse */ ?>
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
