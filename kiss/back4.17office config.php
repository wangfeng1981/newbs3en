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

<<<<<<< HEAD
function template($iactive)
=======
function template($iactive=1)
>>>>>>> 7455de9ec1e5e4f1cf7cd47e77a2c665c097a6d3
{
  echo "template";
}

?>


<<<<<<< HEAD
=======

>>>>>>> 7455de9ec1e5e4f1cf7cd47e77a2c665c097a6d3
<?php 
//===============================================
// 全局HTML块函数
//===============================================
?>
<<<<<<< HEAD
=======

>>>>>>> 7455de9ec1e5e4f1cf7cd47e77a2c665c097a6d3
<?php function sideNavigationBlock($subfolder) { 
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

<?php function activityBlock($nshow=1) { ?>
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
<<<<<<< HEAD
<?php } ?>
=======
<?php } ?>


>>>>>>> 7455de9ec1e5e4f1cf7cd47e77a2c665c097a6d3
