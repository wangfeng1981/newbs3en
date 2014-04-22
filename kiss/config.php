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
			$this->rs['message']='';
			$this->rs['utime']=0;
			$this->rs['replyserial']=0;
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
		array("myinfo","我的信息"),
		array("activity","课程"),
		array("news","通知"),
		array("comments","评论"),
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
								echo "<img class='jlesfileicon' src='".$GLOBALS['gSiteRootPath'].$typeicon."'>";
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
			$les=new tabLesson();
			$array = $les->retrieve_many("serial>0 ORDER BY utime DESC LIMIT 0,6");
			foreach ($array as $les){
				printOneLesson($les,2) ;
			}
			if(count($array)>5) echo "<p><a href='".$GLOBALS['gSiteRootPath']+"activity/'>更多课程...</a></p>";
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
				<div class="panel panel-default" style="border-width:2px">
				  <!-- Default panel contents -->
				  <div class="panel-heading">
				  	<a style="display:block;text-decoration:none" href="<?php echo $GLOBALS['gSiteRootPath'].'activity/index.php?act='.$act->get('serial'); ?>" >
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



<?php function newsBlock($nshow=5,$ipage=0) { 
	//最新通知显示 $ipage is zero based.
	/*
	SELECT news_table.message AS msg, admin_table.adminname AS name
		FROM news_table, admin_table
		WHERE news_table.byadminserial = admin_table.serial
		GROUP BY admin_table.serial
		ORDER BY news_table.utime DESC 
		LIMIT 0 , 30

		<div class="jcomment">
		  <div class="jcomment-photo">
		  	<img src="photos/1-1.jpg">
		  </div>
		  <div class="jcomment-header">
		    孙俪
		  </div>
		  <div class="jcomment-body">
		    我选择了2014年第一期开题，欢迎大家参加.
		  </div>
		  <div class="jcomment-footer">
		  	2014年1月1日 23:53 <a href="#">评论(2)</a>
		  </div>
		</div>
	*/

	?>

		<?php 
			$news=new tabNews();
			$ncnt=$news->select("count(serial) as cnt","serial>0");
			$totalNumNews=0+$ncnt[0]['cnt'];
			$startindex=$ipage*$nshow;
			$npage=ceil($totalNumNews/$nshow);
			if( $totalNumNews == 0 ) {
				echo "<div class='jcomment-admin'>通知列表为空。</div>";
			}

			$selstr="news_table.serial as nserial, news_table.message as nmessage, news_table.utime as nutime, news_table.ontop as nontop, admin_table.adminname as aname, admin_table.photo as aphoto";
			$frmstr="news_table,admin_table";
			$whrstr="news_table.byadminserial=admin_table.serial GROUP BY news_table.serial ORDER BY news_table.ontop DESC, news_table.utime DESC LIMIT ".$startindex.",".$nshow ;

			$news = new tabNews() ;
			$news_array = $news->select_mt($selstr,$frmstr,$whrstr);

			foreach ($news_array as $news) { ?>

				<div class="jcomment-admin<?php if($news['nontop']==1) echo '-top';?>">
				  <div class="jcomment-photo">
				  	<img src="<?php echo $GLOBALS['gSiteRootPath'].'photos/'.$news['aphoto'];?>" width='50' height='50'>
				  </div>
				  <div class="jcomment-header-admin<?php if($news['nontop']==1) echo '-top';?>">
				    <?php echo $news['aname'];?>
				  </div>
				  <div class="jcomment-body">
				    <?php echo $news['nmessage'];?>
				  </div>
				  <div class="jcomment-footer">
				  	<?php echo edt2sh($news['nutime']);?>
				  </div>
				</div>

		<?php }	?>

		<?php if( $ipage==0 && $totalNumNews>$nshow ) { ?>
			<div class="jcomment-admin"><a href="<?php echo $GLOBALS['gSiteRootPath'].'news/';?>">更多... ...</a></div>
		<?php } /*if( $ipage==0 && $totalNumNews>$nshow )*/ ?>


<?php } ?>


<?php function commentsBlock($nshow=5,$ipage=0,$showpager=0) { 
	//最新评论显示 $ipage is zero based.
	/*
	SELECT news_table.message AS msg, admin_table.adminname AS name
		FROM news_table, admin_table
		WHERE news_table.byadminserial = admin_table.serial
		GROUP BY admin_table.serial
		ORDER BY news_table.utime DESC 
		LIMIT 0 , 30

		<div class="jcomment">
		  <div class="jcomment-photo">
		  	<img src="photos/1-1.jpg">
		  </div>
		  <div class="jcomment-header">
		    孙俪
		  </div>
		  <div class="jcomment-body">
		    我选择了2014年第一期开题，欢迎大家参加.
		  </div>
		  <div class="jcomment-footer">
		  	2014年1月1日 23:53 <a href="#">评论(2)</a>
		  </div>
		</div>
	*/

	?>

		<?php 
			$cmt=new tabComments();
			$ncnt=$cmt->select("count(serial) as cnt","serial>0");
			$totalNumComments=0+$ncnt[0]['cnt'];
			$startindex=$ipage*$nshow;
			$npage=ceil($totalNumComments/$nshow);
			if( $totalNumComments == 0 ) {
				echo "<div class='jcomment'>评论列表为空。</div>";
			}

			$selstr="comments_table.serial as cserial, comments_table.message as cmessage, comments_table.utime as cutime, comments_table.replyserial as creply, student_table.stuname as sname, student_table.photo as sphoto";
			$frmstr="comments_table,student_table";
			$whrstr="comments_table.bystuserial=student_table.serial GROUP BY comments_table.serial ORDER BY comments_table.utime DESC LIMIT ".$startindex.",".$nshow ;

			$cmt = new tabComments() ;
			$cmt_array = $cmt->select_mt($selstr,$frmstr,$whrstr);

			foreach ($cmt_array as $cmt) { ?>

				<div class="jcomment<?php if($cmt['creply']>0) echo '-reply';?>">
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
				  </div>
				</div>

		<?php } ?>
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


<?php function filesBlock($nshow=5,$ipage=0) { 
	//最新文件显示 $ipage is zero based.
	/*
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
	*/
		$file=new tabStufile();
		$ncnt=$file->select("count(serial) as cnt","serial>0");
		$total=0+$ncnt[0]['cnt'];
		$startindex=$ipage*$nshow;
		$npage=ceil($total/$nshow);

		if( $total==0 ) {
			echo "<div class='media' style='margin-top:5px'>文件列表为空。</div>";
		}

		$selstr="stufile_table.serial as fserial, stufile_table.url as furl, stufile_table.utime as futime, stufile_table.lesserial as flserial, stufile_table.title as ftitle, student_table.stuname as sname";
		$frmstr="stufile_table,student_table";
		$whrstr="stufile_table.stuserial=student_table.serial GROUP BY stufile_table.serial ORDER BY stufile_table.utime DESC LIMIT ".$startindex.",".$nshow ;

			$file = new tabStufile() ;
			$file_array = $file->select_mt($selstr,$frmstr,$whrstr);

			foreach ($file_array as $file) { 
				$ext = strtolower(pathinfo($file['furl'], PATHINFO_EXTENSION));
				$typeicon="img/unknownicon.jpg";
				if( strcmp($ext,"pdf")==0 ) $typeicon="img/pdficon.jpg";
				else if( strcmp($ext,"ppt")==0 ) $typeicon="img/ppticon.jpg";
				else if( strcmp($ext,"pptx")==0) $typeicon="img/pptxicon.jpg";

				?>

				<div class="media" style="margin-top:5px">
				  <a class="pull-left" href="#">
					<img class="media-object" src="<?php echo $GLOBALS['gSiteRootPath'].$typeicon;?>" alt="pdf"  width="32" height="32">
				  </a>
				  <div class="media-body">
					<h5 class="media-heading"><?php echo $file['sname'];?></h5>
					<?php echo $file['ftitle'];?>
					<p class="jfwfupdate"><?php echo edt2sh($file['futime']);?></p>
				  </div>
				  <hr style="margin-top:0px;margin-bottom:5px">
				</div>

		<?php } ?>
		<?php if( $ipage==0 && $total>$nshow ) { ?>
			<div class="media"><a href="<?php echo $GLOBALS['gSiteRootPath'].'file/';?>">更多... ...</a></div>
		<?php } /* endif( $ipage==0 && $total>$nshow )*/ ?>


<?php } ?>


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
	    <p>Designed and built by <a href="http://weibo.com/wangfengirsa" target="_blank">@wangfengirsa</a>. Copyright © 2014 jfwf@yeah.net</p>
	  </div>
	</footer>
<?php } ?>


<?php function leaveACommentBlock(){ ?>
	<!-- 页面底端留言 -->
	<form role="form" id="formcomment" name="formcomment" action="<?php echo $GLOBALS['gSiteRootPath'].'comments/index.php';?>" method="post">
		<div class="form-group">
	  		<textarea class="form-control" rows="3" id="comment" name="comment" placeholder="请输入留言"></textarea>
		</div>
		<p><?php if(isset($_SESSION['stuserial'])==false) echo "<span class='label label-warning'>请登录后进行留言.</span>" ?></p>
		<button type="submit" class="btn btn-info" <?php if(isset($_SESSION['stuserial'])==false) echo "disabled";?> >提交留言</button>
	</form>

<?php } ?>








