<?php session_start(); ?>
<?php require('kiss/config.php'); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <style type="text/css">
    	table a:link {
			color: #666;
			font-weight: bold;
			text-decoration:none;
		}
		table a:visited {
			color: #999999;
			font-weight:bold;
			text-decoration:none;
		}
		table a:active,
		table a:hover {
			color: #bd5a35;
			text-decoration:underline;
		}
		table {
			font-family:Arial, Helvetica, sans-serif;
			color:#666;
			font-size:12px;
			text-shadow: 1px 1px 0px #fff;
			background:#eaebec;
			margin:20px;
			border:#ccc 1px solid;

			-moz-border-radius:3px;
			-webkit-border-radius:3px;
			border-radius:3px;

			-moz-box-shadow: 0 1px 2px #d1d1d1;
			-webkit-box-shadow: 0 1px 2px #d1d1d1;
			box-shadow: 0 1px 2px #d1d1d1;
		}
		table th {
			padding:21px 25px 22px 25px;
			border-top:1px solid #fafafa;
			border-bottom:1px solid #e0e0e0;

			background: #ededed;
			background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#ebebeb));
			background: -moz-linear-gradient(top,  #ededed,  #ebebeb);
		}
		table th:first-child {
			text-align: left;
			padding-left:20px;
		}
		table tr:first-child th:first-child {
			-moz-border-radius-topleft:3px;
			-webkit-border-top-left-radius:3px;
			border-top-left-radius:3px;
		}
		table tr:first-child th:last-child {
			-moz-border-radius-topright:3px;
			-webkit-border-top-right-radius:3px;
			border-top-right-radius:3px;
		}
		table tr {
			text-align: center;
			padding-left:20px;
		}
		table td:first-child {
			text-align: left;
			padding-left:20px;
			border-left: 0;
		}
		table td {
			padding:18px;
			border-top: 1px solid #ffffff;
			border-bottom:1px solid #e0e0e0;
			border-left: 1px solid #e0e0e0;

			background: #fafafa;
			background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
			background: -moz-linear-gradient(top,  #fbfbfb,  #fafafa);
		}
		table tr.even td {
			background: #f6f6f6;
			background: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#f6f6f6));
			background: -moz-linear-gradient(top,  #f8f8f8,  #f6f6f6);
		}
		table tr:last-child td {
			border-bottom:0;
		}
		table tr:last-child td:first-child {
			-moz-border-radius-bottomleft:3px;
			-webkit-border-bottom-left-radius:3px;
			border-bottom-left-radius:3px;
		}
		table tr:last-child td:last-child {
			-moz-border-radius-bottomright:3px;
			-webkit-border-bottom-right-radius:3px;
			border-bottom-right-radius:3px;
		}
		table tr:hover td {
			background: #f2f2f2;
			background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
			background: -moz-linear-gradient(top,  #f2f2f2,  #f0f0f0);	
		}
    </style>
 </head>
<body>

	<?php if(isset($_SESSION['adminserial'])) { ?>

	<div>
		<p><h3>年级列表</h3></p>
		<p><small>请点击需要查看的年级</small>
		<?php 
			$stu=new tabStudent() ;
			$yearArr = $stu->select('DISTINCT(year)','serial>0');
			$i=0;
			foreach ($yearArr as $y1) {
				if($i>0) echo "|";
				echo "<a href='?year=".$y1['year']."'>".$y1['year']."</a>";
				$i=$i+1;
			}
		?>
		</p>
		<hr>
		<?php
			if(isset($_GET['year']))
			{
				echo "<p><h3>当前年级: ".$_GET['year']."</h3></p>";
				echo "<hr>";

				$act=new tabActivity() ;
				$actArr=$act->retrieve_many('serial>0') ;
				foreach ($actArr as $act ) {
					$whereInStr="lesserial IN(";
					$les=new tabLesson() ;
					$lesArray=$les->retrieve_many('actserial=?',$act->get('serial'));
					$i=0;
					foreach ($lesArray as $les) {
						if($i>0) $whereInStr=$whereInStr.",";
						$whereInStr=$whereInStr.$les->get('serial');
						$i=$i+1;
					}
					$whereInStr=$whereInStr.")";

					echo "<p><strong><h4>".$act->get('title')."</h4></strong></p>";
					echo "<table>";
					echo "<tr><th>#</th><th>学号</th><th>姓名</th><th>年级</th><th>加入活动期次</th></tr>";
					$stu=new tabStudent() ;
					$array=$stu->retrieve_many('year=?',$_GET['year']) ;
					$i=1;
					foreach ($array as $stu) {
						echo "<tr>";
						echo "<td>".$i."</td>";
						echo "<td>".$stu->get('stuid')."</td>";
						echo "<td>".$stu->get('stuname')."</td>";
						echo "<td>".$stu->get('year')."</td>";
						echo "<td>";
						$order=new tabLesorder() ;
						$orderArray=$order->retrieve_many('stuserial=? AND '.$whereInStr,$stu->get('serial'));
						foreach ($orderArray as $order ) {
							$lesson = new tabLesson() ;
							$lesson->retrieve($order->get('lesserial')) ;
							if($lesson->exists())
							{
								echo $lesson->get('title');
								$file1=new tabStufile() ;
								if($file1->retrieve_one('stuserial=? AND lesserial=?',array($stu->get('serial'),$lesson->get('serial'))))
								{
									echo "<a target='_blank' href='".$file1->get('url')."'>(已上传文件)</a>";
								}
								echo "<br>";
							}
						}
						echo "</td>";
						echo "</tr>";
						$i=$i+1;
					}
					echo "</table>";
					echo "<hr>";
				}

			}
		?>

	<?php } else {
			echo "<p><a href='http://www.gradunion.cn/adminpage/gcrud/index.php/teacher/stufile_management'>请先使用管理员账号密码登陆.</a></p>";
		}
	?>
</div>
</body>
</html>