<?php
session_start();
require_once('common/EasyMySQLi.inc.php');

if(!isset($_SESSION['user'])){
    $_SESSION['message'] = "请先登录!";
    header('Location: login.php');
    exit;
}
$isAdmin = false;
if(isset($_SESSION['permission'])&&$_SESSION['permission']==1){
    $isAdmin = true;
}
//处理增删改查
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sub'])){
    switch($_POST['Action']){
        case 'Add':
            $user = $_POST['user'];
            $name = $_POST['name'];
            $job = $_POST['job'];
            $jobid = $_POST['jobid'];
            $permission = $_POST['permission'];
            $pass = $_POST['password'];
            if(strlen($user)<=0||strlen($pass)<=0){
                $_SESSION['message'] = "账号和密码必填!";
                header('Location: staff.php');
                exit;
            }
            $line = @$mysql->querySingleRow('SELECT * FROM t_admin WHERE user= ? or jobid= ?',$user,$jobid);
            if($line != null){
                $_SESSION['message'] = "账号或工号重复!";
                break;
            }

            try{
            $result = $mysql->queryNoResult('INSERT INTO t_admin(`user`,`password`,`name`,`job`,`jobid`,`permission`) VALUES (?, ?,?,?,?,?)', $user,SHA1($pass),
                $name,$job,$jobid,$permission);
            } catch (MySQLiQueryException $ex) {
                echo "Something went wrong: ".$ex->getMessage();
            }
            if(!$result){
                $_SESSION['message'] = "增加员工操作失败!";
            }else{
                $_SESSION['message'] = "增加员工操作成功!";
            }

            break;
        case 'Edit':
            $id = $_POST['sid'];
            $user = $_POST['user'];
            $name = $_POST['name'];
            $job = $_POST['job'];
            $jobid = $_POST['jobid'];
            $permission = $_POST['permission'];
            $pass = $_POST['password'];
            if(strlen($user)<=0||strlen($pass)<=0){
                $_SESSION['message'] = "账号和密码必填!";
                header('Location: staff.php');
                exit;
            }
            $line = @$mysql->querySingleRow('SELECT * FROM t_admin WHERE user= ? or jobid= ?',$user,$jobid);
            if($line == null){
                $_SESSION['message'] = "员工不存在，不能编辑!";
                break;
            }

            try{
                $result = $mysql->queryNoResult('UPDATE t_admin SET user = ? , password = ? , name = ? , job=?,jobid=?,permission=? WHERE id=?',
                    $user,sha1($pass),$name,$job,$jobid,$permission,$id);
            } catch (MySQLiQueryException $ex) {
                echo "Something went wrong: ".$ex->getMessage();
            }
            if(!$result){
                $_SESSION['message'] = "修改员工操作失败!";
            }else{
                $_SESSION['message'] = "修改员工操作成功!";
            }
            break;
    }
}
//处理删除
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['Action'])) {
    switch($_GET['Action']) {
        case 'Del':
            $id = $_GET['id'];
            $result = $mysql->queryNoResult('DELETE FROM t_admin WHERE id=?',$id);
            if($result){
                $_SESSION['message'] = "删除员工操作成功!";
            }else{
                $_SESSION['message'] = "删除员工操作失败!";
            }
            break;
    }
}
//读取数据，显示界面
$staffs = $mysql->queryAllRows('SELECT * FROM t_admin ORDER BY `id` ASC');

define('InternalAccess', true);
$contentFile = 'template/staff.php';
include('template/layout.php');



