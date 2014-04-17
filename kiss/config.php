

<?php 
	
//===============================================
// Includes
//===============================================
require('kissmvc.php');
	//GLOBAL VARIBALES
	$GLOBALS['gSiteRootPath']='http://jfwf.erufa.com/yslt/newbs3en/';
	
	
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

?>