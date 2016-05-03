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
//处理增删改查
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sub'])){
    switch($_POST['Action']){
        case 'Add':
            $roomNum = $_POST['room_num'];
            $roomType = $_POST['room_type'];
            $phone = $_POST['phone'];
            $state = $_POST['state'];

            if(strlen($roomNum)<=0){
                $_SESSION['message'] = "房间编号不能为空!";
                header('Location: room.php');
                exit;
            }
            $line = @$mysql->querySingleRow('SELECT * FROM t_room WHERE room_num = ?',$roomNum);
            if($line != null){
                $_SESSION['message'] = "房间编号重复!";
                break;
            }

            try{
                $result = $mysql->queryNoResult('INSERT INTO t_room(`room_num`,`room_type`,`phone`,`state`,`is_delete`) VALUES (?, ?,?,?,0)', $roomNum,$roomType,
                    $phone,$state);
            } catch (MySQLiQueryException $ex) {
                echo "Something went wrong: ".$ex->getMessage();
            }
            if(!$result){
                $_SESSION['message'] = "增加房间操作失败!";
            }else{
                $_SESSION['message'] = "增加房间操作成功!";
            }

            break;
        case 'Edit':
            $id = $_POST['rid'];
            $roomNum = $_POST['room_num'];
            $roomType = $_POST['room_type'];
            $phone = $_POST['phone'];
            $state = $_POST['state'];
            if(strlen($roomNum)<=0){
                $_SESSION['message'] = "房间编号不能为空!";
                header('Location: room.php');
                exit;
            }
            $line = @$mysql->querySingleRow('SELECT * FROM t_room WHERE room_num = ?',$roomNum);
            if($line == null){
                $_SESSION['message'] = "房间不存在，不能编辑!";
                break;
            }

            try{
                $result = $mysql->queryNoResult('UPDATE t_room SET room_num = ? , room_type = ? , phone = ? , state=? WHERE id=?',
                    $roomNum,$roomType,$phone,$state,$id);
            } catch (MySQLiQueryException $ex) {
                echo "Something went wrong: ".$ex->getMessage();
            }
            if(!$result){
                $_SESSION['message'] = "修改客房操作失败!";
            }else{
                $_SESSION['message'] = "修改客房操作成功!";
            }
            break;
    }
}
//处理删除
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['Action'])) {
    switch($_GET['Action']) {
        case 'Del':
            $id = $_GET['id'];
            $result = $mysql->queryNoResult('UPDATE t_room SET is_delete = 1 WHERE id=?',$id);
            if($result){
                $_SESSION['message'] = "删除客房操作成功!";
            }else{
                $_SESSION['message'] = "删除客房操作失败!";
            }
            break;
    }
}
//读取数据，显示界面
$rooms = $mysql->queryAllRows('SELECT * FROM t_room WHERE is_delete = 0 ORDER BY `id` ASC');
$types = $mysql->queryAllRows('SELECT * FROM t_room_type ORDER BY `id` ASC');
$typesMap = array();
foreach($types as $row){
    $typesMap[$row['id']] = $row['room_type'];
}

define('InternalAccess', true);
$contentFile = 'template/room.php';
include('template/layout.php');



