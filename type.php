<?php
session_start();
require_once('common/EasyMySQLi.inc.php');

if (!isset($_SESSION['user'])) {
    $_SESSION['message'] = "请先登录!";
    header('Location: login.php');
    exit;
}
$isAdmin = false;
if (isset($_SESSION['permission']) && $_SESSION['permission'] == 1) {
    $isAdmin = true;
}
//处理增删改查
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sub'])) {
    switch ($_POST['Action']) {
        case 'Add':
            $type = $_POST['room_type'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $remain = $_POST['remain'];
            $desc = $_POST['desc'];
            if (!is_numeric($quantity) || !is_numeric($remain) || !is_numeric($price)) {
                $_SESSION['message'] = "价格、总量、余量必须为数字!";
                header('Location: type.php');
                exit;
            }
            $line = @$mysql->querySingleRow('SELECT * FROM t_room_type WHERE room_type= ? ', $type);
            if ($line != NULL) {
                $_SESSION['message'] = "房间类型重复!";
                break;
            }

            //检查是否上传文件
            if (isset($_FILES['pic'])) {
                //验证上传文件的MIME类型，是否在允许的范围内
                $allowd = array('image/jpeg', 'image/JPG', 'image/png', 'image/gif');
                if (!in_array($_FILES['pic']['type'], $allowd)) {
                    $_SESSION['message'] = "禁止上传非图片文件!";
                    break;
                }
                if (!file_exists('upload')) {
                    mkdir('upload');
                }
                $filename = "upload/" . time();
                switch ($_FILES['pic']['type']) {
                    case 'image/jpeg':
                        $filename .= ".jpeg";
                        break;
                    case 'image/JPG':
                        $filename .= ".JPG";
                        break;
                    case 'image/png':
                        $filename .= ".png";
                        break;
                    case 'image/gif':
                        $filename .= ".gif";
                        break;
                }
                move_uploaded_file($_FILES['pic']['tmp_name'], $filename);
            }
            try {
                $result = $mysql->queryNoResult('INSERT INTO t_room_type(`room_type`,`price`,`quantity`,`remain`,`is_delete`,`description`,`img`) VALUES (?, ?,?,?,0,?,?)', $type, $price,
                    $quantity, $remain, $desc, $filename);
            } catch (MySQLiQueryException $ex) {
                echo "Something went wrong: " . $ex->getMessage();
            }
            if (!$result) {
                $_SESSION['message'] = "增加类型操作失败!";
            } else {
                $_SESSION['message'] = "增加类型操作成功!";
            }

            break;
        case
            'Edit':
            $id = $_POST['tid'];
            $type = $_POST['room_type'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $remain = $_POST['remain'];
            $desc = $_POST['desc'];

            if (!is_numeric($quantity) || !is_numeric($remain) || !is_numeric($price)) {
                $_SESSION['message'] = "价格、总量、余量必须为数字!";
                header('Location: type.php');
                exit;
            }
            $line = @$mysql->querySingleRow('SELECT * FROM t_room_type WHERE room_type= ? ', $type);
            if ($line == NULL) {
                $_SESSION['message'] = "类型不存在，不能修改!";
                break;
            }
            //检查是否上传文件
            if (isset($_FILES['pic'])) {
                //验证上传文件的MIME类型，是否在允许的范围内
                if($_FILES['pic']['size']==0){
                    try {
                        $result = $mysql->queryNoResult('UPDATE t_room_type SET room_type = ? , price = ? , quantity = ? , remain=? ,description=? WHERE id=?',
                            $type, $price, $quantity, $remain, $desc, $id);
                    } catch (MySQLiQueryException $ex) {
                        echo "Something went wrong: " . $ex->getMessage();
                    }
                    if (!$result) {
                        $_SESSION['message'] = "修改类型操作失败!";
                    } else {
                        $_SESSION['message'] = "修改类型操作成功!";
                    }
                    break;
                }
                $allowd = array('image/jpeg', 'image/JPG', 'image/png', 'image/gif');
                if (!in_array($_FILES['pic']['type'], $allowd)) {
                    $_SESSION['message'] = "禁止上传非图片文件!";
                    break;
                }
                if (!file_exists('upload')) {
                    mkdir('upload');
                }
                $filename = "upload/" . time();
                switch ($_FILES['pic']['type']) {
                    case 'image/jpeg':
                        $filename .= ".jpeg";
                        break;
                    case 'image/JPG':
                        $filename .= ".JPG";
                        break;
                    case 'image/png':
                        $filename .= ".png";
                        break;
                    case 'image/gif':
                        $filename .= ".gif";
                        break;
                }
                move_uploaded_file($_FILES['pic']['tmp_name'], $filename);
            }
            try {
                $result = $mysql->queryNoResult('UPDATE t_room_type SET room_type = ? , price = ? , quantity = ? , remain=? ,description=? ,img=? WHERE id=?',
                    $type, $price, $quantity, $remain, $desc, $filename, $id);
            } catch (MySQLiQueryException $ex) {
                echo "Something went wrong: " . $ex->getMessage();
            }
            if (!$result) {
                $_SESSION['message'] = "修改类型操作失败!";
            } else {
                $_SESSION['message'] = "修改类型操作成功!";
            }
            break;
    }
}
//处理删除
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['Action'])) {
    switch ($_GET['Action']) {
        case 'Del':
            $id = $_GET['id'];
            $result = $mysql->queryNoResult('UPDATE t_room_type SET is_delete = 1 WHERE id=?', $id);
            if ($result) {
                $_SESSION['message'] = "删除类型操作成功!";
            } else {
                $_SESSION['message'] = "删除类型操作失败!";
            }
            break;
    }
}
//读取数据，显示界面
$types = $mysql->queryAllRows('SELECT * FROM t_room_type WHERE is_delete = 0 ORDER BY `id` ASC');

define('InternalAccess', true);
$contentFile = 'template/type.php';
include('template/layout.php');



