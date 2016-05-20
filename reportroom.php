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
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['end_time']) && isset($_GET['start_time'])){
    $start = $_GET['start_time'];
    $end = strtotime($_GET['end_time']);
    $end = date("Y-m-d",$end+86400);
}
else{
    $start = date("Y-m-d");
    $end = date("Y-m-d",strtotime("+1 day"));
}
//读取数据，显示界面

$reports = @$mysql->queryAllRows('SELECT COUNT(t_room_type.room_type) AS times,t_room_type.quantity,t_room_type.room_type,SUM(room_price) AS money FROM t_check_in,t_room,t_room_type WHERE check_in_time>=?
AND check_in_time<=? AND t_check_in.room_id = t_room.id AND t_room.room_type = t_room_type.id GROUP BY t_room_type.room_type',$start,$end);
$end = isset($_GET['end_time'])?$_GET['end_time']:date("Y-m-d");
define('InternalAccess', true);
$contentFile = 'template/reportroom.php';
include('template/layout.php');

