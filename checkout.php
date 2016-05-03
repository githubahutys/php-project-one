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
            $roomNum = trim($_POST['room_num']);
            $adminId = $_SESSION['admin_id'];
            date_default_timezone_set('Asia/Shanghai');
            $checkOutTime = date('Y-m-d h:i:s');
            //检查房间的使用状态，已用的不能check in
            $line = @$mysql->querySingleRow('SELECT * FROM t_room WHERE room_num= ? AND state=2 ',$roomNum);
            if($line == NULL){
                $_SESSION['message'] = "该房间不存在或空闲!";
                break;
            }

            try{
                $result = $mysql->queryNoResult('UPDATE t_room SET state =1 WHERE id = ? ',$line['id']);

                $result = $result && $mysql->queryNoResult('UPDATE t_check_in SET check_out=1 WHERE room_id= ? ',$line['id']);

            } catch (MySQLiQueryException $ex) {
                echo "Something went wrong: ".$ex->getMessage();
            }
            if(!$result){
                $_SESSION['message'] = "退房操作失败!";
            }else{
                $_SESSION['message'] = "退房操作成功!";
            }

            break;
    }
}
//读取数据，显示界面
$checkins = $mysql->queryAllRows('SELECT * FROM t_check_in WHERE check_out= 1 ORDER BY `id` ASC');
$custs = $mysql->queryAllRows('SELECT * FROM t_customer ORDER BY `id` ASC');
$rooms = $mysql->queryAllRows('SELECT * FROM t_room ORDER BY `id` ASC');
$types = $mysql->queryAllRows('SELECT * FROM t_room_type ORDER BY `id` ASC');
$admins = $mysql->queryAllRows('SELECT * FROM t_admin ORDER BY `id` ASC');
$typesMap = array();
foreach($types as $row){
    $typesMap[$row['id']] = $row['room_type'];
}
$pricesMap = array();
foreach($types as $row){
    $pricesMap[$row['id']] = $row['price'];
}
$roomsMap = array();
$roomNumsMap = array();
foreach($rooms as $row){
    $roomsMap[$row['id']] = $pricesMap[$row['room_type']];
    $roomNumsMap[$row['id']] =$row;
}
$custsMap = array();
foreach($custs as $row){
    $custsMap[$row['id']] = $row;
}
$adminsMap = array();
foreach($admins as $row){
    $adminsMap[$row['id']] = $row;
}
define('InternalAccess', true);
$contentFile = 'template/checkout.php';
include('template/layout.php');



