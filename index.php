<?php
session_start();
require_once('common/EasyMySQLi.inc.php');
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['is_ajax'])){
    $rooms = $mysql->queryAllRows('SELECT * FROM t_room WHERE room_type=? AND is_delete=0 AND state=1 ORDER BY `id` ASC',$_POST['room_type']);
    echo json_encode($rooms);
    return;
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sub'])){
    if(!isset($_SESSION['cust'])){
        $_SESSION['message'] = "请先登录!";
        header('Location: login.php');
        exit;
    }
    switch($_POST['Action']){
        case 'Add':
            $custId = $_SESSION['cust_id'];
            $roomId = $_POST['room_id'];
            $roomPrice = $_POST['room_price'];
            $guatanteePrice = $_POST['guarantee_price'];
            $adminId = 0;
            date_default_timezone_set('Asia/Shanghai');
            $checkInTime = $_POST['check_in_time'];
            $checkOutTime = $_POST['check_out_time'];

            /*$extra = time()-strtotime($checkInTime);
            $checkInTime = date('Y-m-d H:i:s');
            $checkOutStamp = strtotime($checkOutTime)+$extra;
            $checkOutTime = date("Y-m-d H:i:s",$checkOutStamp);*/

            if(!is_numeric($roomPrice)||!is_numeric($guatanteePrice)){
                $_SESSION['message'] = "价格必须为数字!";
                break;
            }

            //检查预订数量
            $lines = @$mysql->querySingleRow('SELECT * FROM t_reserve WHERE cust_id= ? AND check_in=0',$custId);
            if($lines != NULL){
                if($_SESSION['permission']==0){
                    if(count($lines)>=2){
                        $_SESSION['message'] = "非VIP用户只能预订2间,超出请到柜台预订!";
                        break;
                    }
                }
                if($_SESSION['permission']==1){
                    if(count($lines)>=20){
                        $_SESSION['message'] = "VIP用户只能预订20间，超出请到柜台预订!";
                        break;
                    }
                }
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
                var_dump($check);
                var_dump($checkInTime);
                var_dump($checkOutTime);
                exit;
                $_SESSION['message'] = "该房间在此时间段已被预订!";
                break;
            }

            try{
                $result = $mysql->queryNoResult('INSERT INTO t_reserve (`admin_id`,`cust_id`,`room_id`,`check_in_time`,`guarantee_price`,`room_price`,`check_out_time`,`check_in`) VALUES (?,?,?,?,?,?,?,?)',
                    $adminId,$custId,$roomId,$checkInTime,$guatanteePrice,$roomPrice,$checkOutTime,0);
                $result = $result&&$mysql->queryNoResult('UPDATE t_room_type SET remain= remain-1 WHERE id=(SELECT room_type FROM t_room WHERE id=?)',
                        $roomId);
            } catch (MySQLiQueryException $ex) {
                echo "Something went wrong: ".$ex->getMessage();
            }
            if(!$result){
                $_SESSION['message'] = "预订失败!";
            }else{
                $_SESSION['message'] = "预订成功!";
            }

            break;
    }
}


$types = $mysql->queryAllRows('SELECT * FROM t_room_type ORDER BY `id` ASC');
$rooms = $mysql->queryAllRows('SELECT * FROM t_room ORDER BY `id` ASC');
$pricesMap = array();
foreach($types as $row){
    $pricesMap[$row['id']] = $row['price'];
}
$roomsMap = array();

foreach($rooms as $row){
    $roomsMap[$row['id']] = $pricesMap[$row['room_type']];
}

include('template/index.php');