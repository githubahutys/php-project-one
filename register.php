<?php
session_start();
require_once('common/EasyMySQLi.inc.php');
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sub'])){

            $name = $_POST['user'];
            $gender = $_POST['gender'];
            $mobile = $_POST['mobile'];
            $idcard = $_POST['idcard'];
            $pass = $_POST['pass1'];

            $line = @$mysql->querySingleRow('SELECT * FROM t_customer WHERE idcard = ? OR mobile = ? ',$idcard,$mobile);
            if($line != NULL){
                $_SESSION['message'] = "证件号或手机号已存在!";
            }
            else {
                try {
                    $result = $mysql->queryNoResult('INSERT INTO t_customer(`name`,`gender`,`idcard`,`mobile`,`is_delete`,`pass`,`permission`) VALUES (?, ?,?,?,0,?,0)',
                        $name, $gender, $idcard, $mobile, SHA1($pass));

                } catch (MySQLiQueryException $ex) {
                    echo "Something went wrong: " . $ex->getMessage();
                }
                if (!$result) {
                    $_SESSION['message'] = "注册失败!";
                } else {
                    $_SESSION['message'] = "注册成功，请登录!";
                    header('Location: login.php');
                    exit;
                }
            }
}

include('template/register.php');