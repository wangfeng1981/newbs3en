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

    <title>文件资源</title>

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
						  <?php sideNavigationBlock("file");?>
					  </div>
					</div>
					<div class="col-md-8 column">
						<h4><strong>全部文件资源</strong></h4>
						<hr>
						<?php 
							$ipage=0;
							if(isset($_GET['ipage']))
								$ipage=$_GET['ipage']+0;
							filesBlock(20,$ipage,1);
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
