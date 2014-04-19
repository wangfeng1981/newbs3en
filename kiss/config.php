﻿

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
			$this->rs['type']='';
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
		array("file","文件资源")
	);
	?>
    <ul class="nav bs-sidenav nav-pills nav-stacked">
		
		<?php 
			foreach ($pages as $page1){ ?>
		    <li <?php if(strcmp($subfolder,$page1[0])==0) echo "class='active'"; ?> >
				<a href="<?php echo $GLOBALS['gSiteRootPath'].$page1[0];?>"><?php echo $page1[1];?></a>
			</li>
		<?php }	?>

	</ul>
<?php } ?>

<?php function activityBlock($nshow=1) { 
	//课程分类及相关批次课程摘要显示
	?>
    <div class="list-group">
		<?php 
			$act = new tabActivity();
			$act_array = $act->retrieve_many("serial>0 ORDER BY utime DESC");
			foreach ($act_array as $act) { ?>

			<a class="list-group-item active2" href="<?php echo $GLOBALS['gSiteRootPath'].'activity/index.php?actserial='.$act->get('serial'); ?>" >
				<h4 class="list-group-item-heading"><strong><?php echo $act->get('title');?></strong></h4>
			</a>

			<?php 
				$les = new tabLesson();
				$les_array = $les->retrieve_many("actserial=? ORDER BY utime DESC",$act->get('serial'));
				$i=0;
				$nles=count($les_array);
				foreach( $les_array as $les ) { ?>

				<a class="list-group-item" href="<?php echo $GLOBALS['gSiteRootPath'].'activity/index.php?lesserial='.$les->get('serial'); ?>" >
					<h5 class="list-group-item-heading">
						<?php echo $les->get('title');?>
						<span class="label label-success text-right">剩余<?php 
							$order = new tabLesorder();
							$nsel = $order->select("count(stuserial) as nsel","lesserial=?",$les->get('serial'));
							echo $les->get('maxnum')-$nsel['nsel'];
						?></span>
					</h5>
				    <p class="list-group-item-text"><small><?php echo $les->get('desc');?></small></p>

				</a>
				<?php $i=$i+1 ; if($i>=$nshow) break ; ?>

			<?php }	?>
			<?php if( $nshow<$nles ) { ?>
				<a class="list-group-item" href="<?php echo $GLOBALS['gSiteRootPath'].'activity/index.php?actserial='.$act->get('serial'); ?>" >
					<p class="list-group-item-text"><small>更多...</small></p>
				</a>
			<?php } ?>
			<hr>

		<?php }	?>

	</div>
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
			$ncnt=$news->select("count(serial) as cnt");
			$totalNumNews=0+$ncnt['cnt'];
			$startindex=$ipage*$nshow;
			$npage=ceil($totalNumNews/$nshow);

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


<?php function commentsBlock($nshow=5,$ipage=0) { 
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
			$ncnt=$cmt->select("count(serial) as cnt");
			$totalNumNews=0+$ncnt['cnt'];
			$startindex=$ipage*$nshow;
			$npage=ceil($totalNumNews/$nshow);


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

		<?php }	?>
		<?php if( $ipage==0 && $totalNumNews>$nshow ) { ?>
			<div class="jcomment"><a href="<?php echo $GLOBALS['gSiteRootPath'].'comments/';?>">更多... ...</a></div>
		<?php } /*if( $ipage==0 && $totalNumNews>$nshow )*/ ?>

<?php } ?>