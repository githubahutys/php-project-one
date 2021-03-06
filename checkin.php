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
            $custId = $_POST['cust_id'];
            $roomId = $_POST['room_id'];
            $roomPrice = $_POST['room_price'];
            $guatanteePrice = $_POST['guarantee_price'];
            $adminId = $_SESSION['admin_id'];
            date_default_timezone_set('Asia/Shanghai');
            $checkInTime = $_POST['check_in_time'];
            $checkOutTime = $_POST['check_out_time'];
            $extra = time()-strtotime($checkInTime);
            $checkInTime = date('Y-m-d H:i:s');
            $checkOutStamp = strtotime($checkOutTime)+$extra;
            $checkOutTime = date("Y-m-d H:i:s",$checkOutStamp);

            if(!is_numeric($roomPrice)||!is_numeric($guatanteePrice)){
                $_SESSION['message'] = "价格必须为数字!";
                break;
            }
            //检查房间的使用状态，已用的不能check in
            $line = @$mysql->querySingleRow('SELECT * FROM t_room WHERE id= ? AND state=2 ',$roomId);
            if($line != NULL){
                $_SESSION['message'] = "该房间已被使用!";
                break;
            }
            //检查入住房间、时间是否已被其他人预订

            $check = @$mysql->querySingleRow('SELECT * FROM t_reserve WHERE room_id= ? AND check_in=0 AND check_in_time<=? AND check_out_time>=?',$roomId,$checkInTime,$checkInTime);
            if($check==NULL){
                $check = @$mysql->querySingleRow('SELECT * FROM t_reserve WHERE room_id= ? AND check_in=0 AND check_in_time<=? AND check_out_time>=?',$roomId,$checkOutTime,$checkOutTime);
            }
            if($check!=NULL){
                $_SESSION['message'] = "该房间已被预订!";
                break;
            }



            try{
                $result = $mysql->queryNoResult('UPDATE t_room SET state =2 WHERE id = ? ',$roomId);

                $result = $result && $mysql->queryNoResult('INSERT INTO t_check_in(`admin_id`,`cust_id`,`room_id`,`check_in_time`,`guarantee_price`,`room_price`,`check_out`,`check_out_time`) VALUES (?,?,?,?,?,?,0,?)',
                    $adminId,$custId,$roomId,$checkInTime,$guatanteePrice,$roomPrice,$checkOutTime);
                $result = $result&&$mysql->queryNoResult('UPDATE t_room_type SET remain= remain-1 WHERE id=(SELECT room_type FROM t_room WHERE id=?)',
                        $roomId);
            } catch (MySQLiQueryException $ex) {
                echo "Something went wrong: ".$ex->getMessage();
            }
            if(!$result){
                $_SESSION['message'] = "增加入住操作失败!";
            }else{
                $_SESSION['message'] = "增加入住操作成功!";
            }

            break;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search_txt'])){
    $content = $_GET['search_txt'];
    $checkins = @$mysql->queryAllRows('SELECT * FROM t_check_in WHERE check_out= 0 AND cust_id IN (SELECT id FROM t_customer WHERE name=? OR idcard=?) ORDER BY id ASC',$content,$content);
}
else{
    $checkins = $mysql->queryAllRows('SELECT * FROM t_check_in WHERE check_out= 0 ORDER BY `id` ASC');
}
//读取数据，显示界面

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
$contentFile = 'template/checkin.php';
include('template/layout.php');



