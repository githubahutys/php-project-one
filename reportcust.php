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
$content="";
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['end_time']) && isset($_GET['start_time'])){
    $content = $_GET['search_txt'];
    $start = $_GET['start_time'];
    $end = strtotime($_GET['end_time']);
    $end = date("Y-m-d",$end+86400);
}
else{
    $start = date("Y-m-d");
    $end = date("Y-m-d",strtotime("+1 day"));
}
//读取数据，显示界面
if($content==""){
    $reports = @$mysql->queryAllRows('SELECT name,gender,idcard,mobile,SUM(room_price) AS money FROM t_check_in,t_customer WHERE check_in_time>=?
AND check_in_time<=? AND t_check_in.cust_id = t_customer.id GROUP BY cust_id ORDER BY money DESC LIMIT 10',$start,$end);
}else{
    $reports = @$mysql->queryAllRows('SELECT name,gender,idcard,mobile,SUM(room_price) AS money FROM t_check_in,t_customer WHERE check_in_time>=?
AND check_in_time<=? AND t_customer.name=? AND t_check_in.cust_id = t_customer.id GROUP BY cust_id ORDER BY money DESC LIMIT 10',$start,$end,$content);

}

$end = isset($_GET['end_time'])?$_GET['end_time']:date("Y-m-d");
define('InternalAccess', true);
$contentFile = 'template/reportcust.php';
include('template/layout.php');

