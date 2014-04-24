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
														    <input name="file" class="input-file" type="file">
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
								<tr><th>#</th><th>课程</th><th>文件</th><th>操作</th></tr>
							</thead>
							<tbody>
								<?php 
									if(isset($_SESSION['stuserial']))
									$ord=new tabLesorder();
									$array=$ord->select_clause("select lesorder_table.serial as os,lesorder_table.lesserial as ls, lesorder_table.stuserial as ss, lesson_table.title as lt, stufile_table.title as ft, stufile_table.url as fu FROM lesorder_table LEFT JOIN lesson_table ON lesorder_table.lesserial = lesson_table.serial LEFT JOIN stufile_table ON lesorder_table.lesserial = stufile_table.lesserial AND lesorder_table.stuserial = stufile_table.stuserial WHERE lesorder_table.stuserial =".$_SESSION['stuserial']);
									$i=0;
									foreach ($array as $obj1) { ?>
									<tr>
										<td><?php $i=$i+1;echo $i;?></td>
										<td><?php echo $obj1['lt'];?></td>
										<td><?php if($obj1['fu']) echo fileIconImgTagBlock($obj1['fu'],$obj1['ft'],"a_id_".$i);?></td><!-- file icon-->
										<td><?php if($obj1['fu']) echo "<a onclick='showPptDialog(".$obj1['ls'].','.$obj1['ss'].")' >更新文件</a>";else echo "<a onclick='showPptDialog(".$obj1['ls'].','.$obj1['ss'].")'>上传文件</a>";echo " | <a href='index.php?quitles=".$obj1['os']."'>退出课程</a>"; ?></td><!-- add file or update file, quit lesson.-->
									</tr>
									<?php $numActivateTooltip=$i; ?>
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


	<!-- Upload file modal dialog -->
	<div class="modal fade" id="modalUploadPpt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">上传PPT文件</h4>
	      </div>
	      <div class="modal-body">
	        <form class="form-horizontal" method="post" action="http://up.qiniu.com/" enctype="multipart/form-data">

			  <!-- Text input-->
			  <div class="form-group">
			    <label class="col-md-4 control-label" for="lestitle">课程</label>  
			    <div class="col-md-4">
			    <input id="lestitle" name="lestitle" type="text" placeholder="" class="form-control input-md">
			      
			    </div>
			  </div>

			  <!-- Text input-->
			  <div class="form-group">
			    <label class="col-md-4 control-label" for="filetitle">PPT标题</label>  
			    <div class="col-md-4">
			    <input id="filetitle" name="filetitle" type="text" placeholder="" class="form-control input-md" required="">
			      
			    </div>
			  </div>

			  <!-- File Button --> 
			  <div class="form-group">
			    <label class="col-md-4 control-label" for="fileppt">PPT文件</label>
			    <div class="col-md-4">
			      <input id="file" name="file" class="input-file" type="file" onChange='onPptFileChanged()'>
			    </div>
			  </div>

			  <input name="key" id="key" type="text" value="<resource_key>">
			  <input name="token" id="token" type="text" value="<upload_token>">

			  <!-- Button (Double) -->
			  <div class="form-group">
			    <label class="col-md-4 control-label" for="submit"></label>
			    <div class="col-md-8">
			      <button type="submit" name="submitppt" id="submitppt" class="btn btn-success" disabled='disabled' >提交</button>
			      <button id="" name="" class="btn btn-warning" data-dismiss="modal">取消</button>
			    </div>
			  </div>

			</form>
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

<script type="text/javascript">
	
</script>
    <script type="text/javascript">
    <!-- 激活Tooltip -->
    <?php
    	for ($i=1; $i<=$numActivateTooltip; $i++)
		{
  			echo "$('#a_id_".$i."').tooltip('hide');";
		}
    ?>

    var les=0;
    var stu=0;

    function onPptFileChanged()
	{
		var exts = ['ppt','pptx','pdf'];
		var fullfilepath=$('#file').val();
		var get_ext = fullfilepath.split('.');
		get_ext = get_ext.reverse();
		get_ext=get_ext[0].toLowerCase();
		if ( $.inArray ( get_ext, exts ) > -1 )
		{
			var destfilename=""+les+"/"+stu+"."+get_ext;
			$('#key').val(destfilename);
			$.get( "../qiniu/uptoken.php", { bucket: "gradunion", key: destfilename } )
			  .done(function( data ) {
			  	var obj = jQuery.parseJSON( data );
			    $('#token').val(obj.uptoken);
			    $('#submitppt').removeAttr('disabled');
			  });
		}else
		{
			alert('不支持的文件格式.');
		}

	}

	function showPptDialog(les1,stu1)
	{
		les=les1;
		stu=stu1;
		$('#modalUploadPpt').modal('show');
	}

    </script>
  </body>
</html>
