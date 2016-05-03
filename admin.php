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

$todayStart = time();
$todayEnd = $todayStart+86400;
$start = date("Y-m-d H:i:s",$todayStart);
$end = date("Y-m-d H:i:s",$todayEnd);

$peoples = $mysql->querySingleField('SELECT count(`id`) FROM t_customer');
$reserves = $mysql->querySingleField('SELECT count(`id`) FROM t_reserve');
$checkins = $mysql->querySingleField('SELECT count(`id`) FROM t_check_in');
$checkouts = $mysql->querySingleField('SELECT count(`id`) FROM t_check_in WHERE check_out = 1');
define('InternalAccess', true);
$contentFile = 'template/admin.php';
include('template/layout.php');



