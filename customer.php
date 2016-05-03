<?php
session_start();
require_once('common/EasyMySQLi.inc.php');

if(!isset($_SESSION['user'])){
    $_SESSION['message'] = "请先登录!";
    header('Location: index.php');
    exit;
}
$isAdmin = false;
if(isset($_SESSION['permission'])&&$_SESSION['permission']==1){
    $isAdmin = true;
}
//处理增改查
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sub'])){
    switch($_POST['Action']){
        case 'Add':
            $name = $_POST['name'];
            $gender = $_POST['gender'];
            $mobile = $_POST['mobile'];
            $idcard = $_POST['idcard'];
            if(strlen($name)<=0||strlen($idcard)<=0){
                $_SESSION['message'] = "姓名和证件不能为空!";
                header('Location: customer.php');
                exit;
            }
            $line = @$mysql->querySingleRow('SELECT * FROM t_customer WHERE idcard = ? ',$idcard);
            if($line != NULL){
                $_SESSION['message'] = "证件号重复!";
                break;
            }

            try{
                $result = $mysql->queryNoResult('INSERT INTO t_customer(`name`,`gender`,`idcard`,`mobile`,`is_delete`) VALUES (?, ?,?,?,0)',
                    $name,$gender,$idcard,$mobile);
            } catch (MySQLiQueryException $ex) {
                echo "Something went wrong: ".$ex->getMessage();
            }
            if(!$result){
                $_SESSION['message'] = "增加客户操作失败!";
            }else{
                $_SESSION['message'] = "增加客户操作成功!";
            }

            break;
        case 'Edit':
            $id = $_POST['cid'];
            $name = $_POST['name'];
            $gender = $_POST['gender'];
            $mobile = $_POST['mobile'];
            $idcard = $_POST['idcard'];
            if(strlen($name)<=0||strlen($idcard)<=0){
                $_SESSION['message'] = "姓名和证件不能为空!";
                header('Location: customer.php');
                exit;
            }
            $line = @$mysql->querySingleRow('SELECT * FROM t_customer WHERE idcard = ? ',$idcard);
            if($line == NULL){
                $_SESSION['message'] = "该客户不存在，不能编辑!";
                break;
            }
            try{
                $result = $mysql->queryNoResult('UPDATE t_customer SET name = ? , gender = ? , idcard = ? , mobile=? WHERE id=?',
                    $name,$gender,$idcard,$mobile,$id);
            } catch (MySQLiQueryException $ex) {
                echo "Something went wrong: ".$ex->getMessage();
            }
            if(!$result){
                $_SESSION['message'] = "修改客户操作失败!";
            }else{
                $_SESSION['message'] = "修改客户操作成功!";
            }
            break;
    }
}
//处理删除
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['Action'])) {
    switch($_GET['Action']) {
        case 'Del':
            $id = $_GET['id'];
            $result = $mysql->queryNoResult('UPDATE t_customer SET is_delete = 1 WHERE id=?',$id);
            if($result){
                $_SESSION['message'] = "删除客户操作成功!";
            }else{
                $_SESSION['message'] = "删除客户操作失败!";
            }
            break;
    }
}
//读取数据，显示界面
$custs = $mysql->queryAllRows('SELECT * FROM t_customer WHERE is_delete = 0 ORDER BY `id` ASC');

define('InternalAccess', true);
$contentFile = 'template/customer.php';
include('template/layout.php');



