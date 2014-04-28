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
							}else if(isset($_GET['upload_ret']))
							{
								$str=base64_decode($_GET['upload_ret']);
  								$obj1=json_decode($str);
  								$arr1=split(",",$obj1->rv1);
  								$ordserial=$arr1[0];
  								$extname=$arr1[1];
  								$ord=new tabLesorder();
						        $ord->retrieve($ordserial);
						        if($ord->exists())
						        {
						          $sfile=new tabStufile();
						          if( $sfile->retrieve_one("stuserial=? AND lesserial=?",array($ord->get('stuserial'),$ord->get('lesserial') ) ) )
						          {//update the old.
						            $sfile->set('utime',time());
						            $sfile->set('title',$obj1->rv2);
						            $sfile->set('url',"http://gradunion.qiniu.com/".$ord->get('lesserial')."/".$ord->get('stuserial').".".$extname);
						            $sfile->update();
						          }else
						          {//create new one.
						            $sfile->set('stuserial',$ord->get('stuserial'));
						            $sfile->set('lesserial',$ord->get('lesserial'));
						            $sfile->set('url',"http://gradunion.qiniu.com/".$ord->get('lesserial')."/".$ord->get('stuserial').".".$extname);
						            $sfile->set('utime',time());
						            $sfile->set('title',$obj1->rv2);
						            $sfile->create();
						          }
						          jAlertBlock($atype="alert-success",$atitle="OK!",$amsg="上传/更新PPT文件成功.");
						      }
							}else if(isset($_GET['quitles']) && isset($_SESSION['stuserial']))
							{
								$ord=new tabLesorder();
						        $ord->retrieve($_GET['quitles']);
						        if($ord->exists())
						        {
						        	$les2=new tabLesson() ;
						        	$les2->retrieve($ord->get('lesserial')) ;
						        	if($les2->exists())
						        	{
						        		if($les2->get('state')==1)
						        		{
						        			$ord->delete();
						        			jAlertBlock($atype="alert-success",$atitle="OK!",$amsg="已退出 ".$les2->get('title') );
						        		}else
						        		{
						        			jAlertBlock($atype="alert-danger",$atitle="错误!",$amsg="无法退出 ".$les2->get('title').",可能因为课程已关闭或者锁定,如果确实想退出请联系管理员." );
						        		}
						        	}else
						        	{
						        		$ord->delete();
						        		jAlertBlock($atype="alert-warning",$atitle="注意!",$amsg="课程已失效,已退出本次课程.");
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
														    <input id="pass0" name="pass0" type="password" placeholder="" class="form-control input-md" required="" maxlength="16">
														    
														  </div>
														</div>

														<!-- Password input-->
														<div class="form-group">
														  <label class="col-md-4 control-label" for="pass1">新密码</label>
														  <div class="col-md-4">
														    <input id="pass1" name="pass1" type="password" placeholder="" class="form-control input-md" required="" maxlength="16">
														    
														  </div>
														</div>

														<!-- Password input-->
														<div class="form-group">
														  <label class="col-md-4 control-label" for="pass2">确认新密码</label>
														  <div class="col-md-4">
														    <input id="pass2" name="pass2" type="password" placeholder="" class="form-control input-md" required="" maxlength="16">
														    
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
										<td><a href="" onclick="showPptDialog(<?php echo $obj1['ls'].','.$obj1['os'].',\''.$obj1['lt'].'\'';?>);return false;" ><?php if(strlen($obj1['fu'])>1) echo "更新文件";else echo "上传文件";?></a> | 
											<a href="index.php?quitles=<?php echo $obj1['os'];?>">退出课程</a>
										</td><!-- add file or update file, quit lesson.-->
									</tr>
									<?php $numActivateTooltip=$i; ?>
								<?php } ?>
							</tbody>
						</table>
						<hr>

						<!-- my messages -->
						<h4><strong>我的留言</strong></h4>
						<?php commentsBlock(10,0,0); ?>
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
	        <form class="form-horizontal" method="post" action="http://up.qiniu.com/" enctype="multipart/form-data" id="formppt">

			  <!-- Text input-->
			  <div class="form-group">
			    <label class="col-md-4 control-label" for="lestitle">课程</label>  
			    <div class="col-md-4">
			    <input id="lestitle" name="lestitle" type="text" placeholder="" class="form-control input-md" disabled='disabled'>
			      
			    </div>
			  </div>

			  <!-- Text input-->
			  <div class="form-group">
			    <label class="col-md-4 control-label" for="filetitle">PPT标题</label>  
			    <div class="col-md-4">
			    <input id="filetitle" name="filetitle" type="text" placeholder="" class="form-control input-md" required="" maxlength="60">
			      
			    </div>
			  </div>

			  <!-- File Button --> 
			  <div class="form-group">
			    <label class="col-md-4 control-label" for="fileppt">PPT文件</label>
			    <div class="col-md-4">
			      <input id="file" name="file" class="input-file" type="file" required=""><!-- debug onChange='onPptFileChanged()' -->
			    </div>
			  </div>

			  <input name="key" id="key" type="hidden" value="<resource_key>">
			  <input name="token" id="token" type="hidden" value="<upload_token>">

			  <!-- Button (Double) -->
			  <div class="form-group">
			    <label class="col-md-4 control-label" for="submit"></label>
			    <div class="col-md-8">
			      <button type="button" name="submitppt" id="submitppt" class="btn btn-primary">提交</button>
			      <button id="" name="" class="btn btn-warning" data-dismiss="modal">取消</button>
			    </div>
			  </div>
			  <div class="progress progress-striped active" id="progressppt" >
				<div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
				    <span class="sr-only">上传中...</span>
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
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>


    <script type="text/javascript">
    <!-- 激活Tooltip -->
    <?php
    	for ($i=1; $i<=$numActivateTooltip; $i++)
		{
  			echo "$('#a_id_".$i."').tooltip('hide');";
		}
    ?>

    var vlesserial=0;
    var vorderserial=0;

	function showPptDialog(les1,ord1,ltitle)
	{
		vlesserial=les1;
		vorderserial=ord1;
		$('#file').val("");
		$('#filetitle').val("");
		$('#key').val("");
		$('#token').val("");
		$('#progressppt').hide();
		$('#lestitle').val(ltitle);

		$('#modalUploadPpt').modal('show');
	}

	//提交PPT消息处理
	$( "#submitppt" ).click(function( event ) {
		if($('#file').val()=="")
		{
			alert('请输入文件.');
			return ;
		}else if($('#filetitle').val()=="")
		{
			alert('请输入文件标题.');
			return ;
		}

		$('#progressppt').show("slow");
		var exts = ['ppt','pptx','pdf'];
		var fullfilepath=$('#file').val();
		var get_ext = fullfilepath.split('.');
		get_ext = get_ext.reverse();
		get_ext=get_ext[0].toLowerCase();
		if ( $.inArray ( get_ext, exts ) > -1 )
		{
			var key1=""+vlesserial+"/<?php echo $_SESSION['stuserial'];?>."+get_ext;
			var rurl="<?php echo urlencode($GLOBALS['gSiteRootPath'].'myinfo/index.php');?>";
			var rval1=vorderserial+","+get_ext;
			var rval2=$('#filetitle').val();
			$('#key').val(key1);
			$.get( "../qiniu/uptoken.php", { bucket: "gradunion",key: key1, rurl:"<?php echo urlencode($GLOBALS['gSiteRootPath'].'myinfo/index.php');?>",rv1:rval1,rv2:rval2 } )
			  .done(function( data ) {
			  	data.trim();
			  	var obj = jQuery.parseJSON( data );
			  	if(obj.uptoken)
			  	{
			  		$('#token').val(obj.uptoken);
			  		$('#key').val(key1);
			  		$('#formppt').submit();
			  	}else
			  	{
			  		alert("错误:"+obj.error);
			  		$('#progressppt').hide();
			  	}
			  });
		}else
		{
			alert('不支持的文件格式.');
			$('#progressppt').hide();
		}
		
	});

    </script>
  </body>
</html>
