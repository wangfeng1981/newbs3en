<?php session_start(); ?>
<?php require('kiss/config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
 
<?php 
foreach($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
 
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
 
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
 
<style type='text/css'>
body
{
    font-family: Arial;
    font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
    text-decoration: underline;
}
</style>
</head>
<body>
<!-- Beginning header -->
    <div>
        <a href='<?php echo site_url('teacher/student_management')?>'>学生管理</a> | 
        <a href='<?php echo site_url('teacher/activity_management')?>'>活动管理</a> |
        <a href='<?php echo site_url('teacher/lesson_management')?>'>活动期次管理</a> |
        <a href='<?php echo site_url('teacher/news_management')?>'>管理员通知管理</a> |
        <a href='<?php echo site_url('teacher/comments_management')?>'>学生留言管理</a> | 
        <a href='<?php echo site_url('teacher/c2_management')?>'>学生评论留言管理</a> |
        <a href='<?php echo site_url('teacher/lesorder_management')?>'>学生选课管理</a> | 
        <a href='<?php echo site_url('teacher/admin_management')?>'>管理员管理</a>|
        <a href='<?php echo site_url('teacher/stufile_management')?>'>学生文件管理</a>|
        <a target='_blank' href='/adminpage/gcrud/studentyear.php'>学生信息汇总</a>|
        <a href='/adminpage/gcrud/adminquit.php'>退出</a>
    </div>
<!-- End of header-->
    <div style='height:20px;'></div>  

    <div>
        <?php

            if( isset($_POST['adminid']) && isset($_POST['adminpass']) )
            {
                $admin=new tabAdmin() ;
                if(false!=$admin->retrieve_one('adminid=? AND adminpass=?',array($_POST['adminid'],$_POST['adminpass'])))
                {
                    $_SESSION['adminserial']=$admin->get('serial');
                }else
                {
                    echo "<p style='color:red;font-weight:bold'><h3>管理员账号或密码错误，请重试.</h3></p>";
                }
            }

            if(isset($_SESSION['adminserial']))
                echo $output;
            else
            {
                echo "<p><h3>请登录后执行管理操作</h3></p>";
                echo "<form action='' method='post'>";
                echo "<p>管理员账号:<input type='text' name='adminid' id='adminid' value='administrator'></p>";
                echo "<p>管理员密码:<input type='password' name='adminpass' id='adminpass'></p>";
                echo "<p><input type='submit' name='submit' id='submit'></p>";
                echo "</form>";
            }
          ?>
     </div>
<!-- Beginning footer -->
<div><p>by jfwf@yeah.net</p></div>
<!-- End of Footer -->
</body>
</html>