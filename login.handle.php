<?php
session_start();
require_once('common/EasyMySQLi.inc.php');

//退出
if(isset($_GET['out']))
{
    unset($_SESSION['user']);
    unset($_SESSION['pass']);
    //重定向
    header('Location: index.php');
    exit();
}
//登录

if(isset($_POST['sub']))
{
   //验证账号、密码
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    if(strlen($user)<=0||strlen($pass)<=0){
        $_SESSION['message'] = "用户名、密码不能为空！";
        header('Location: index.php');
        exit();
    }
   //查询数据库中是否匹配
    $line = @$mysql->querySingleRow('SELECT * FROM t_admin WHERE user = ? AND password= ?',$user,SHA1($pass));
    if($line==NULL){
        //账号密码不匹配
        $_SESSION['message'] = "账号或者密码不正确！";
        header('Location: index.php');
        exit();
    }
    //登录成功保存session
    $_SESSION['user']=$_POST['user'];
    $_SESSION['admin_id']=$line['id'];
    $_SESSION['pass']=$_POST['pass'];
    $_SESSION['permission']=$line['permission'];
    header('Location: admin.php');
    exit();
}
else{
    $_SESSION['message'] = "请先登录！";
    header('Location: index.php');
    exit();
}

