<?php 
//===============================================
// Includes
//===============================================
require('kissmvc.php');
//===============================================
// 全局变量
//===============================================
$GLOBALS['gSiteRootPath']='http://jfwf.erufa.com/yslt/newbs3en/';

//===============================================
// 数据库
//===============================================

	//=====================================================
	class tabActivity extends Model
	{
		function tabActivity()
		{
			parent::__construct('serial','activity_table','getdbh');
			$this->rs['serial']=0;
			$this->rs['title']='';
			$this->rs['desc']='';
			$this->rs['utime']=0;
			$this->rs['state']=0;
			$this->rs['image']='';
		}
	}
	//=====================================================
	class tabAdmin extends Model
	{
		function tabAdmin()
		{
			parent::__construct('serial','admin_table','getdbh');
			$this->rs['serial']=0;
			$this->rs['adminid']='';
			$this->rs['adminpass']='';
			$this->rs['adminname']='';
			$this->rs['photo']='';
		}
	}
	//=====================================================
	class tabComments extends Model
	{
		function tabComments()
		{
			parent::__construct('serial','comments_table','getdbh');
			$this->rs['serial']=0;
			$this->rs['bystuserial']=0;
			$this->rs['message']=''; //256 byte.
			$this->rs['utime']=0;
			$this->rs['replyserial']=0;//deprecated field.
		}
	}
	//=====================================================
	class tabC2 extends Model
	{
		function tabC2()
		{
			parent::__construct('serial','c2_table','getdbh');
			$this->rs['serial']=0;
			$this->rs['replyserial']=0;
			$this->rs['stuserial']=0;
			$this->rs['message']='';//256 byte.
			$this->rs['utime']=0;
		}
	}
	//=====================================================
	class tabLesorder extends Model
	{
		function tabLesorder()
		{
			parent::__construct('serial','lesorder_table','getdbh');
			$this->rs['serial']=0;
			$this->rs['lesserial']=0;
			$this->rs['stuserial']=0;
			$this->rs['utime']=0;
		}
	}
	//=====================================================
	class tabLesson extends Model
	{
		function tabLesson()
		{
			parent::__construct('serial','lesson_table','getdbh');
			$this->rs['serial']=0;
			$this->rs['actserial']=0;
			$this->rs['title']='';
			$this->rs['desc']='';
			$this->rs['utime']=0;
			$this->rs['state']=0;
			$this->rs['maxnum']=0;
			$this->rs['thumb']='';
			$this->rs['largeimage']='';
		}
		function currentNumber()
		{
			$ord=new tabLesorder();
			$cnt=$ord->select("count(serial) as cnt","lesserial=?",$this->get('serial'));
			return $cnt[0]['cnt'];
		}
	}
	//=====================================================
	class tabNews extends Model
	{
		function tabNews()
		{
			parent::__construct('serial','news_table','getdbh');
			$this->rs['serial']=0;
			$this->rs['byadminserial']=0;
			$this->rs['message']='';
			$this->rs['utime']=0;
			$this->rs['ontop']=0;
		}
	}
	//=====================================================
	class tabStudent extends Model
	{
		function tabStudent()
		{
			parent::__construct('serial','student_table','getdbh');
			$this->rs['serial']=0;
			$this->rs['stuid']='';
			$this->rs['stupass']='';
			$this->rs['stuname']='';
			$this->rs['year']=0;
			$this->rs['photo']='';
		}
	}
	//=====================================================
	class tabStufile extends Model
	{
		function tabStufile()
		{
			parent::__construct('serial','stufile_table','getdbh');
			$this->rs['serial']=0;
			$this->rs['stuserial']=0;
			$this->rs['url']='';
			$this->rs['utime']=0;
			$this->rs['lesserial']=0;
			$this->rs['title']='';
		}
	}
	




	//====================================
	//====================================	
	function getdbh()
	{	//To release the database connection simply do:
		//$GLOBALS['dbh']=null;
		if(!isset($GLOBALS['dbh']))
		{
			try
			{
				$GLOBALS['dbh']=new PDO('mysql:host=sql206.erufa.com;dbname=erufa_12096405_yangshuo','erufa_12096405','jf100001');
				$GLOBALS['dbh']->exec("set names utf8");
				//mysql_query("SET NAMES 'utf8'");
			}catch(PDOException $e)
			{
				die('Connection failed:'.$e->getMessage());
			}
		}
		return $GLOBALS['dbh'];
	}


//===============================================
// 全局PHP内部函数
//===============================================

//timeStamp美国东部时间转上海时间
function edt2sh($timestamp) {

	$date = new DateTime('2000-01-01', new DateTimeZone('America/New_York'));
	$date->setTimestamp($timestamp);
    $date->setTimezone(new DateTimeZone('Asia/Shanghai'));
    return $date->format("Y年m月d日 G:i:s");
}

function template($iactive)
{
  echo "template";
}

?>


<?php 
//===============================================
// 全局HTML块函数
//===============================================
?>

<?php function sideNavigationBlock($subfolder) { 
	//侧边导航栏
	$pages = array(
		array("","首页"),
		array("myinfo","我的资料"),
		array("activity","课程"),
		array("news","通知"),
		array("comments","留言"),
		array("file","文件资源"),
		array("hr",""),
		array("help","帮助"),
		array("about","关于")
	);
	?>
    <ul class="nav bs-sidenav nav-pills nav-stacked">
		
		<?php 
			foreach ($pages as $page1){ ?>
		    <li <?php if(strcmp($subfolder,$page1[0])==0) echo "class='active'"; ?> >
				<?php if(strcmp($page1[0],"hr")==0) echo "<hr>"; 
					else { ?>
					<a href="<?php echo $GLOBALS['gSiteRootPath'].$page1[0];?>"><?php echo $page1[1];?></a>
				<?php } ?>
			</li>
		<?php }	?>

	</ul>
<?php } ?>


<?php function printOneLesson($lesobj,$displayMode=1) { 
	/*
	displayMode=1 only title, state and available num.
	displayMode=2 detail info without namelist.
	displayMode=3 detail info with namelist.
	*/
	$statestr="关闭";
	if( $lesobj->get('state')==1 )
		$statestr="开放";
	$order = new tabLesorder() ;
	$cnt=$order->select("count(serial) as cnt","lesserial=?",$lesobj->get('serial'));
	$ncnt=$cnt[0]['cnt'];
	$nlast=$lesobj->get('maxnum')-$ncnt;

	?>
	<!-- 课程批次 -->

	<?php 
	if($displayMode==1)
	{
		echo "<a href='".$GLOBALS['gSiteRootPath']."activity/index.php?les=".$lesobj->get('serial')."' class='list-group-item'>";
		echo "<strong>".$lesobj->get('title')."</strong>";
		if($lesobj->get('state')==1) echo "<span class='label label-info pull-right'>开放</span>";
		else echo "<span class='label label-warning pull-right'>关闭</span>";
		echo "<span class='label label-success pull-right'>剩余".$nlast."人</span>";
		echo "<p>".$lesobj->get('desc')."</p>";
		echo "</a>";
	}
	else if($displayMode>1) { 
	?>
		<div class="panel panel-default">
	      <div class="panel-heading">
	        <a href="<?php echo $GLOBALS['gSiteRootPath'].'activity/index.php?les='.$lesobj->get('serial');?>" style="color:black;display:block;text-decoration:none">
	        	<strong>
	        		<?php echo $lesobj->get('title');?>
	        	</strong>
	        	<span class="label label-<?php if($lesobj->get('state')==1) echo 'info';else echo 'warning';?> pull-right">
	        		<?php echo $statestr;?>
	        	</span>
	        </a>
	      </div>
	      <div class="panel-body">
	        <?php echo $lesobj->get('desc'); ?>
	        <p class="jfwfupdate"><?php echo edt2sh($lesobj->get('utime'));?></p>
	      </div>
	      <div class="panel-footer" style="position:relative">
	        <span class="label label-success">剩余<?php echo $nlast;?>人</span>
	        <span class="label label-default">最多<?php echo $lesobj->get('maxnum');?>人</span>
	        <a role="button" class="btn btn-primary btn-sm" style="position:absolute;right:10px;top:5px" <?php if($lesobj->get('state')!=1||isset($_SESSION['stuserial'])==false) echo "disabled='disabled'"; else echo "href='".$GLOBALS['gSiteRootPath']."activity/index.php?join=".$lesobj->get('serial')."'";?>>
	        	加入课程</a>
	      </div>
	      <?php if($displayMode>2){ 
	      	$order = new tabLesorder() ;
	      	$selstr="student_table.serial as serial1,student_table.stuname as name1,student_table.photo as photo1";
			$frmstr="student_table,lesorder_table";
			$whrstr="student_table.serial=lesorder_table.stuserial AND lesorder_table.lesserial=".$lesobj->get('serial')." GROUP BY student_table.serial ORDER BY lesorder_table.utime DESC " ;
			$array = $order->select_mt($selstr,$frmstr,$whrstr);

	      	?>
		      <!-- List group -->
		      <ul class="list-group">
		        <li class="list-group-item" style="background-color: rgb(217, 237, 247);font-weight:bold">已加入<?php echo $ncnt;?>人</li>

		        <?php foreach ($array as $stu1 ) { ?>
		        	<li class="list-group-item"><img class="jlesstuphoto" width="32" height="32" src="<?php echo $GLOBALS['gSiteRootPath'].'photos/'.$stu1['photo1'];?>">
		        		<?php echo $stu1['name1'];
		        			$file1=new tabStufile();
		        			$file1->retrieve_one("stuserial=? AND lesserial=?",array($stu1['serial1'],$lesobj->get('serial')));
		        			if( $file1->exists() )
		        			{
		        				$ext = strtolower(pathinfo($file1->get('url'), PATHINFO_EXTENSION));
								$typeicon="img/unknownicon.jpg";
								if( strcmp($ext,"pdf")==0 ) $typeicon="img/pdficon.jpg";
								else if( strcmp($ext,"ppt")==0 ) $typeicon="img/ppticon.jpg";
								else if( strcmp($ext,"pptx")==0) $typeicon="img/pptxicon.jpg";
								echo "<a target='_blank' href='".$file1->get('url')."' data-toggle='tooltip' data-placement='bottom' title='".$file1->get('title')."'>";
								echo "<img class='jlesfileicon' src='".$GLOBALS['gSiteRootPath'].$typeicon."'>";
		        				echo "</a>";
		        			}
		        		?>
		        	</li>
		        <?php } ?>

		      </ul>
		  <?php }/*endif $displayMode>2 */ ?>

	    </div>
    <?php }/* dm > 1*/ ?>
<?php } ?>


<?php function activityBlock($displayMode=1,$actserial=0,$lesserial=0) { 
	//课程分类及相关批次课程摘要显示
	//displayMode=1 for index.php; 
	//displayMode=2 for activity/index.php;
	//displayMode=3 for activity/index.php?act=xxx ;
	//displayMode=4 for activity/index.php?les=xxx ;
	?>
	<?php 
		if($displayMode==1) 
		{ 
			$act=new tabActivity();
			$array=$act->retrieve_many("serial>0 ORDER BY utime DESC");
			$nact=count($array);
			?>
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
			  	<?php 
			  		for($i=0;$i<$nact;$i++)
			  		{
			  			if($i==0)
			  				echo "<li data-target='#carousel-example-generic' data-slide-to='".$i."' class='active'></li>";
			  			else
			  				echo "<li data-target='#carousel-example-generic' data-slide-to='".$i."' ></li>";
			  		}
			  	?>
			  </ol>

			  <!-- Wrapper for slides -->
			  <div class="carousel-inner">
			  	<?php 
			  		for($i=0;$i<$nact;$i++)
			  		{
			  			$act1=$array[$i];
			  			if($i==0)
			  				echo "<div class='item active'>";
			  			else
			  				echo "<div class='item'>";
			  			$imgurl=$act1->get('image');
			  			if(strlen($imgurl)<2)
			  				$imgurl="img/act01.jpg";
			  			echo "<img src='".$imgurl."'>";
			  			echo "<div class='carousel-caption'>";
			  			echo "<h3>".$act1->get('title')."</h3>";
			        	
			        	echo "<p><a class='btn btn-primary btn-lg' role='button' href='".$GLOBALS['gSiteRootPath'].'activity/index.php?act='.$act1->get('serial')."'>查看详情</a></p>";
			  			echo "</div></div>";
			  		}
			  	?>
			  </div>

			  <!-- Controls -->
			  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
			    <span class="glyphicon glyphicon-chevron-left"></span>
			  </a>
			  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
			    <span class="glyphicon glyphicon-chevron-right"></span>
			  </a>
			</div>
			
		<?php 
		}/* endif displayMode==1 */ 
		else if($displayMode==2){
			$act=new tabActivity();
			$array=$act->retrieve_many("serial>0 ORDER BY utime DESC");
			/*horizonal activities link*/
			echo "<ol class='jh-breadcrumb'>";
			foreach ($array as $act) {
				echo "<li><a href='".$GLOBALS['gSiteRootPath']."activity/index.php?act=".$act->get('serial')."''>";
				echo $act->get('title')."</a></li>";		
			}
			echo "</ol>";

			foreach ($array as $act) { 
	?>
				<div class="panel panel-primary" style="border-width:2px">
				  <!-- Default panel contents -->
				  <div class="panel-heading">
				  	<a style="display:block;color:white" href="<?php echo $GLOBALS['gSiteRootPath'].'activity/index.php?act='.$act->get('serial'); ?>" >
				  		<strong><?php echo $act->get('title');?></strong>
				  	</a>
				  </div>
				  <div class="panel-body">
				  	<?php 
				  		echo "<p>".$act->get('desc')."</p>";
				  		echo "<p class='jfwfupdate'>".edt2sh($act->get('utime'))."</p>";
				  	?>
				  </div>
				  <div class="list-group">
				  	<?php 
				  		$les = new tabLesson();
						$array = $les->retrieve_many("actserial=? ORDER BY utime DESC",$act->get('serial'));
						if( count($array)==0 )
						{
							echo "<a class='list-group-item'><p class='list-group-item-text'>课程批次列表为空。</p></a>";
						}else
						{
							foreach ($array as $les ) {
								printOneLesson($les,1);
							}
						}
				  	?>
				  </div>
				</div>
			<?php } /* end foreach $array as $act */ ?>
	<?php } /*end elseif displayMode==2 */ 
	else if($displayMode==3) { ?>
		<?php 
			
			/*horizonal navi link*/
			$act=new tabActivity();
			$act->retrieve($actserial);
			if($act->exists())
			{
				echo "<ol class='breadcrumb'>";
				echo "<li><a href='".$GLOBALS['gSiteRootPath']."activity/'>".全部课程."</a></li>";
				echo "<li>".$act->get('title')."</li>";
				echo "</ol>";
			}
			
			$les=new tabLesson();
			$array = $les->retrieve_many("actserial=? ORDER BY utime DESC",$actserial);
			foreach ($array as $les){
				printOneLesson($les,2) ;
			}
		?>
	<?php } /*end elseif displayMode==3 */  
	else if($displayMode==4) { ?>
		<?php 
			/*horizonal navi link*/
			$les0=new tabLesson();
			$whrstr="lesson_table.serial=".$lesserial." AND lesson_table.actserial=activity_table.serial";
			$selarray=$les0->select_mt("activity_table.serial as actserial, activity_table.title as acttitle, lesson_table.title as ltitle","activity_table,lesson_table",$whrstr);
			if($selarray)
			{
				echo "<ol class='breadcrumb'>";
				echo "<li><a href='".$GLOBALS['gSiteRootPath']."activity/'>".全部课程."</a></li>";
				echo "<li><a href='".$GLOBALS['gSiteRootPath']."activity/index.php?act=".$selarray[0]['actserial']."''>".$selarray[0]['acttitle']."</a></li>";
				echo "<li>".$selarray[0]['ltitle']."</li>";
				echo "</ol>";
			}

			$les=new tabLesson();
			$les->retrieve($lesserial);
			if($les->exists())
			{
				printOneLesson($les,3) ;
			}
		?>
	<?php } /*end elseif displayMode==4 */  ?>
<?php } ?>


<?php
/* 单条通知输出 */
function oneNewsBlock($n) 
{
	$admin=new tabAdmin() ;
	$admin->retrieve($n->get('byadminserial'));

	if($n->get('ontop')==1)
		echo "<div class='jcomment-admin-top'>";
	else 
		echo "<div class='jcomment-admin'>";
	echo "<div class='jcomment-photo'>";
	echo "<img src='".$GLOBALS['gSiteRootPath'].'photos/'.$admin->get('photo')."' width='50' height='50'>";
	echo "</div>";
	if($n->get('ontop')==1)
		echo "<div class='jcomment-header-admin-top'>";
	else
		echo "<div class='jcomment-header-admin'>";
	echo $admin->get('adminname');
	echo "</div>";
	echo "<div class='jcomment-body'>";
	echo $n->get('message');
	echo "</div>";
	echo "<div class='jcomment-footer'>";
	echo edt2sh($n->get('utime'));
	echo "</div>";
	echo "</div>";
}

?>


<?php function newsBlock($nshow=5,$ipage=0,$showpager=0) 
{ 
	//最新通知显示 $ipage is zero based.
	$news=new tabNews();
	$ncnt=$news->select("count(serial) as cnt","serial>0");
	$totalNumNews=0+$ncnt[0]['cnt'];
	$startindex=$ipage*$nshow;
	$npage=ceil($totalNumNews/$nshow);
	if( $totalNumNews == 0 ) {
		echo "<div class='jcomment-admin'>通知列表为空。</div>";
	}

	$news = new tabNews() ;
	$news_array = $news->retrieve_many("serial>0 ORDER BY ontop DESC, utime DESC LIMIT ".$startindex.",".$nshow);

	foreach ($news_array as $news) { 
		oneNewsBlock($news);
	}
	if( $ipage==0 && $totalNumNews>$nshow && $showpager==0 ) { 
		echo "<div class='jcomment-admin'><a href='".$GLOBALS['gSiteRootPath'].'news/'."'>更多...</a></div>";
	}else
	{
		echo "<p>";
		$url0=$GLOBALS['gSiteRootPath'].'news/index.php?ipage=';
		for($i=1;$i<=$npage;$i++)
		{
			echo "<a href='".$url0.($i-1)."'>&nbsp;".$i."&nbsp;</a>";
		}
		echo "</p>";
	}
} 
?>

<?php

function oneFileBlock($f) 
{
	$ext = strtolower(pathinfo($f->get('url'), PATHINFO_EXTENSION));
	$typeicon="img/unknownicon.jpg";
	if( strcmp($ext,"pdf")==0 ) $typeicon="img/pdficon.jpg";
	else if( strcmp($ext,"ppt")==0 ) $typeicon="img/ppticon.jpg";
	else if( strcmp($ext,"pptx")==0) $typeicon="img/pptxicon.jpg";

	$stu=new tabStudent() ;
	$stu->retrieve($f->get('stuserial'));

	echo "<div class='media' style='margin-top:5px'>";
	echo "<a class='pull-left' target='_blank' href='".$f->get('url')."'>";
	echo "<img class='media-object' src='".$GLOBALS['gSiteRootPath'].$typeicon."' width='32' height='32'>";
	echo "</a>";
	echo "<div class='media-body'>";
	echo "<h5 class='media-heading'>".$stu->get('stuname')."</h5>";
	echo $f->get('title');
	echo "<p class='jfwfupdate'>".edt2sh($f->get('utime'))."</p>";
	echo "</div>";
	echo "<hr style='margin-top:0px;margin-bottom:5px'>";
	echo "</div>";
}
?>


<?php 

function filesBlock($nshow=5,$ipage=0,$showpager=0) { 
	//最新文件显示 $ipage is zero based.

		$file=new tabStufile();
		$ncnt=$file->select("count(serial) as cnt","serial>0");
		$total=0+$ncnt[0]['cnt'];
		$startindex=$ipage*$nshow;
		$npage=ceil($total/$nshow);

		if( $total==0 ) {
			echo "<div class='media' style='margin-top:5px'>文件列表为空。</div>";
		}

		$file = new tabStufile() ;
		$file_array = $file->retrieve_many("serial>0 ORDER BY utime DESC LIMIT ".$startindex.",".$nshow);

		foreach ($file_array as $file) { 
			oneFileBlock($file);
		} 

		if( $ipage==0 && $total>$nshow && $showpager==0 ) { 
			echo "<div class='media'><a href='".$GLOBALS['gSiteRootPath'].'file/'."'>更多...</a></div>";
		}else
		{
			echo "<p>";
			$url0=$GLOBALS['gSiteRootPath'].'file/index.php?ipage=';
			for($i=1;$i<=$npage;$i++)
			{
				echo "<a href='".$url0.($i-1)."'>&nbsp;".$i."&nbsp;</a>";
			}
			echo "</p>";
		}
} ?>




<?php function topNaviBlock() 
{ //顶端导航栏
	$state=0; //0 no session , no post; 1 login bad; 2 login ok or has session.
	if( isset($_GET['quit']))
	{
		unset($_SESSION['stuserial']);
		unset($_SESSION['stuid']);
		unset($_SESSION['stuname']);
		session_destroy();
	}else
	{
		if( isset($_POST['stuid']))
		{
			$stu = new tabStudent();
			if($stu->retrieve_one("stuid=? AND stupass=?",array($_POST['stuid'],$_POST['stupass'])))
			{
				$_SESSION['stuserial']=$stu->get('serial');
				$_SESSION['stuid']=$stu->get('stuid');
				$_SESSION['stuname']=$stu->get('stuname');
				$state=2 ;
			}else
			{
				$state=1;
			}
		}else if( isset($_SESSION['stuserial']))
		{
			$state=2;
		}
	}
	
?>
	<nav class="navbar navbar-default" role="navigation">
		<div class="navbar-header">
			 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> 
			 	<span class="sr-only">Toggle navigation</span>
			 	<span class="icon-bar"></span>
			 	<span class="icon-bar"></span>
			 	<span class="icon-bar"></span>
			 </button> 
			 <a class="navbar-brand" href="<?php echo $GLOBALS['gSiteRootPath'];?>">研究生选课小助手</a>
		</div>
		
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<?php if($state==2) { ?> 
				<ul class="nav navbar-nav navbar-right">
					<li><a><?php echo $_SESSION['stuname'];?>,您好!</a></li>
					<li>
						<a href="<?php echo $GLOBALS['gSiteRootPath']."index.php?quit=1"; ?>">退出</a>
					</li>
				</ul>
			<?php } else { /* endif $state==2 */ ?>
				<form class="navbar-form navbar-right" role="form" action="<?php echo $GLOBALS['gSiteRootPath']."index.php"; ?>" method="post" id="formlogin" name="formlogin" >
					<div class="form-group">
						<?php if($state==1) echo "<span class='label label-warning'>学号或密码错误,请重新输入.</span>"; ?>
						<input type="text" name="stuid" id="stuid" class="form-control" placeholder="请输入学号" <?php if(isset($_COOKIE["rememberme"])) echo "value='".$_COOKIE["rememberme"]."'";?>>
						<input type="password" name="stupass" id="studpass" class="form-control" placeholder="请输入密码">
						<div class="checkbox">
							<label>
							  <input type="checkbox" name="rememberme" id="rememberme" value="yes">记住我
							</label>
						</div>
					</div> <button type="submit" name="submit" id="submit" class="btn btn-primary" value="submit">登录</button>
				</form>
			<?php } /* endelse $state==2 */ ?>
			
		</div>
	</nav>
<?php } ?>


<?php function footerBlock() { ?>
	<!-- footer: copyright , date , develope team , etc  -->
	<footer class="bs-docs-footer" role="contentinfo">
	  <div class="container">
	    <p>Designed and built by <a href="mailto:#">wangfeng@irsa.ac.cn</a>. Copyright © 2014 gradunion.cn</p>
	  </div>
	</footer>
<?php } ?>


<?php function leaveACommentBlock($icmt=0,$ireply=0){ 	
	$acturl=$GLOBALS['gSiteRootPath'].'comments/index.php';
	if($icmt>0)
		$acturl=$acturl."?view=".$icmt;
	else if( $ireply> 0 )
	{
		$c2=new tabC2() ;
		$c2->retrieve($ireply);
		if($c2->exists())
		{
			$acturl=$acturl."?view=".$c2->get('replyserial');
		}
	}

	?>
	<!-- icmt=0 and ireply=0 leave a comment; else $icmt>0 reply a comment; else $ireply>0 reply a reply.-->
	<!-- 页面底端留言 -->
	<form role="form" id="formcomment" name="formcomment" action="<?php echo $acturl;?>" method="post">
		<div class="form-group">
			<input type="hidden" id="icmt" name="icmt" value="<?php echo $icmt;?>">
			<input type="hidden" id="ireply" name="ireply" value="<?php echo $ireply;?>">
			<?php 
				$msg0="";
				if($icmt==0 && $ireply>0 )
				{
					$c2=new tabC2() ;
					$c2->retrieve($ireply) ;
					if($c2->exists())
					{
						$stu=new tabStudent() ;
						$stu->retrieve($c2->get('stuserial'));
						$msg0="回复 ".$stu->get('stuname').": ";
					}
				}
			?>
	  		<textarea maxlength='100' class="form-control" rows="3" id="comment" name="comment" placeholder="请输入留言或评论,最多100字"><?php echo $msg0;?></textarea>
		</div>
		<p><?php if(isset($_SESSION['stuserial'])==false) echo "<span class='label label-warning'>请登录后进行留言或评论.</span>" ?></p>
		<button type="submit" class="btn btn-info" <?php if(isset($_SESSION['stuserial'])==false) echo "disabled";?> >
			<?php
				if($icmt==0&&$ireply==0)
					echo "提交留言";
				else if($icmt>0)
					echo "提交评论";
				else echo "提交回复";
			?>	
		</button>
	</form>
	<script type="text/javascript">
		$(function() {        
		    // Get all textareas that have a "maxlength" property.
		    $('textarea[maxlength]').each(function() {

		        // Store the jQuery object to be more efficient...
		        var $textarea = $(this);

		        // Store the maxlength and value of the field.
		        var maxlength = $textarea.attr('maxlength');
		        var val = $textarea.val();

		        // Trim the field if it has content over the maxlength.
		        $textarea.val(val.slice(0, maxlength));

		        // Bind the trimming behavior to the "keyup" event.
		        $textarea.bind('keyup', function() {
		            $textarea.val($textarea.val.slice(0, maxlength));
		        });

		    });
		});
	</script>

<?php } ?>


<?php function jAlertBlock($atype="alert-warning",$atitle="title",$amsg="This is alert!"){ ?>
	<!-- 警告提示 -->
	<div class="alert <?php echo $atype;?> alert-dismissable">
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	  <strong><?php echo $atitle;?></strong> <?php echo $amsg;?>
	</div>
<?php } ?>




<?php function jSaveStudentPhotoFile($stuserial) {
	/* 保存上传的头像文件到 ../photos/photo-201300000000001.ext 文件
	 * 并负责写入student_table中对应的学生记录photo字段  
	*/
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);

	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/jpg")
	|| ($_FILES["file"]["type"] == "image/pjpeg")
	|| ($_FILES["file"]["type"] == "image/x-png")
	|| ($_FILES["file"]["type"] == "image/png"))
	&& ($_FILES["file"]["size"] < 11000 )
	&& in_array($extension, $allowedExts)) {
	  if ($_FILES["file"]["error"] > 0) {
	    return false ;
	  } 
	  else {
	  	$destfilename="photo-".$stuserial.".".$extension;
   	    if (file_exists("../photos/".$destfilename)) 
    	      unlink("../photos/".$destfilename);
	    if( move_uploaded_file($_FILES["file"]["tmp_name"],
	      "../photos/".$destfilename) )
	    {
	    	$stu=new tabStudent();
	    	$stu->retrieve($stuserial) ;
	    	if($stu->exists())
	    	{
	    		$stu->set('photo',$destfilename);
	    		$stu->update();
	    	}else return false ;
	    }else
	        return false ;
	  }
	} else {
	  return false;
	}
	return true;
}
?>

<?php function fileIconImgTagBlock($fileurl,$filetitle="",$atagid=""){
	$ext = strtolower(pathinfo($fileurl, PATHINFO_EXTENSION));
	$typeicon="img/unknownicon.jpg";
	if( strcmp($ext,"pdf")==0 ) $typeicon="img/pdficon.jpg";
	else if( strcmp($ext,"ppt")==0 ) $typeicon="img/ppticon.jpg";
	else if( strcmp($ext,"pptx")==0) $typeicon="img/pptxicon.jpg";
	echo "<a id='".$atagid."' target='_blank' href='".$fileurl."' data-toggle='tooltip' data-placement='bottom' title='".$filetitle."' >";
	echo "<img class='jlesfileicon2' src='".$GLOBALS['gSiteRootPath'].$typeicon."'>";
	echo "</a>";
}
?>

<?php
/* 输出单个留言评论 */
function oneReplyBlock($cmt,$reply,$candelete=0)
{
	$stu=new tabStudent();
	$stu->retrieve($reply->get('stuserial')) ;
	$imgurl=$GLOBALS['gSiteRootPath']."photos/student.jpg";
	$stuname="无效姓名";
	if($stu->exists())
	{
		$imgurl=$GLOBALS['gSiteRootPath']."photos/".$stu->get('photo');
		$stuname=$stu->get('stuname');
	}
	echo "<div class='jcomment-reply'>";
	echo "  <div class='jcomment-photo'>";
	echo "    <img src='".$imgurl."' width='50' height='50'>";
	echo "  </div>";
	echo "  <div class='jcomment-header'>";
	echo $stuname;
	echo "  </div>";
	echo "  <div class='jcomment-body'>";
	echo $reply->get('message');
	echo "  </div>";
	echo "  <div class='jcomment-footer'>";
	echo edt2sh($reply->get('utime'));
	if($candelete==1)
	{
		echo "<a href='".$GLOBALS['gSiteRootPath']."myinfo/index.php?delrpl=".$reply->get('serial')."'>";
		echo "|&nbsp;删除&nbsp;" ;
		echo "</a>" ;
	}
	echo "    <a href='".$GLOBALS['gSiteRootPath']."comments/index.php?view=".$cmt->get('serial')."&reply=".$reply->get('serial')."'>";
	echo "&nbsp;回复&nbsp;";
	echo "    </a>";
	echo "  </div>";
	echo "</div>";//end jcomment-reply

}
?>


<?php 
/* 输出单个留言 */
function oneCommentBlock($cmt,$showreply=0,$candelete=0)
{
	$stu=new tabStudent();
	$stu->retrieve($cmt->get('bystuserial')) ;
	$imgurl=$GLOBALS['gSiteRootPath']."photos/student.jpg";
	$stuname="无效姓名";
	if($stu->exists())
	{
		$imgurl=$GLOBALS['gSiteRootPath']."photos/".$stu->get('photo');
		$stuname=$stu->get('stuname');
	}
	echo "<div class='jcomment'>";
	echo "  <div class='jcomment-photo'>";
	echo "    <img src='".$imgurl."' width='50' height='50'>";
	echo "  </div>";
	echo "  <div class='jcomment-header'>";
	echo $stuname;
	echo "  </div>";
	echo "  <div class='jcomment-body'>";
	echo $cmt->get('message');
	echo "  </div>";
	echo "  <div class='jcomment-footer'>";
	echo edt2sh($cmt->get('utime'));
	if($candelete==1)
	{
		echo "<a href='".$GLOBALS['gSiteRootPath']."myinfo/index.php?delcmt=".$cmt->get('serial')."'>";
		echo "|&nbsp;删除&nbsp;" ;
		echo "</a>" ;
	}
	echo "    <a href='".$GLOBALS['gSiteRootPath']."comments/index.php?view=".$cmt->get('serial')."'>";
	$c2=new tabC2() ;
	$cnt=$c2->select("count(serial) as nr","replyserial=?",$cmt->get('serial'));
	echo "&nbsp;评论(".$cnt[0]['nr'].")&nbsp;";
	echo "    </a>";
	echo "  </div>";
	echo "</div>";//end jcomment-reply
	if($showreply==1)
	{
		$c2=new tabC2() ;
		$arr=$c2->retrieve_many("replyserial=? ORDER BY utime DESC",$cmt->get('serial'));
		foreach ($arr as $r1 ) {
			oneReplyBlock($cmt,$r1) ;
		}
	}
}

?>


<?php function commentsBlock($nshow=5,$ipage=0,$showpager=0) { 
	//最新留言显示 $ipage is zero based.
	
	?>

		<?php 
			$cmt=new tabComments();
			$ncnt=$cmt->select("count(serial) as cnt","serial>0");
			$totalNumComments=0+$ncnt[0]['cnt'];
			$startindex=$ipage*$nshow;
			$npage=ceil($totalNumComments/$nshow);
			if( $totalNumComments == 0 ) {
				echo "<div class='jcomment'>留言列表为空。</div>";
			}

			/*
			$selstr="comments_table.serial as cserial, comments_table.message as cmessage, comments_table.utime as cutime, student_table.stuname as sname, student_table.photo as sphoto";
			$frmstr="comments_table,student_table";
			$whrstr="comments_table.bystuserial=student_table.serial GROUP BY comments_table.serial ORDER BY comments_table.utime DESC LIMIT ".$startindex.",".$nshow ;

			$cmt = new tabComments() ;
			$cmt_array = $cmt->select_mt($selstr,$frmstr,$whrstr);
			*/

			$cmt=new tabComments() ;
			$cmt_array=$cmt->retrieve_many("serial>0 ORDER BY utime DESC LIMIT ".$startindex.",".$nshow);
			foreach ($cmt_array as $cmt) { 
				oneCommentBlock($cmt,0);
			} ?>
		<?php if( $showpager==0 && $totalNumComments>$nshow ) { ?>
			<div class="jcomment"><a href="<?php echo $GLOBALS['gSiteRootPath'].'comments/';?>">更多... ...</a></div>
		<?php }else if($showpager==1){ ?>
			<ul class="pagination">
				<li <?php if($ipage<=0) echo "class='disabled'";?>>
					<a href="<?php if($ipage<=0) echo '#'; else echo $GLOBALS['gSiteRootPath'].'comments/index.php?icpage='.($ipage-1);?>">&laquo;</a>
				</li>
				<?php 
					$ivalid=0;
					for ($i = $ipage-2; $i < 5+2 ; $i++) {
						if( $i<0 ) continue ;
						if( $i==$npage ) break;
						$ivalid=$ivalid+1;
						$str1="";
						if($i==$ipage) $str1="class='active'";
    					echo "<li ".$str1."><a href='".$GLOBALS['gSiteRootPath'].'comments/index.php?icpage='.$i."'>".($i+1)."</a></li>";
						if($ivalid==5) break;
					}
				?>
				<li <?php if($ipage>=$npage-1) echo "class='disabled'";?>>
					<a href="<?php if($ipage>=$npage-1) echo '#';else echo $GLOBALS['gSiteRootPath'].'comments/index.php?icpage='.($ipage+1);?>">&raquo;</a>
				</li>
			</ul>
		<?php } ?>
<?php } ?>







