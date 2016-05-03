<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>酒店管理系统-登录</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="alternate icon" type="image/png" href="assets/i/favicon.png">
    <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
    <style>
        .header {
            text-align: center;
        }
        .header h1 {
            font-size: 200%;
            color: #333;
            margin-top: 30px;
        }
        .header p {
            font-size: 14px;
        }
    </style>
    <script>
        var message = "<?php
        session_start();
        if(isset($_SESSION['message'])){
           echo $_SESSION['message'];
           unset($_SESSION['message']);
        }
        ?>";
        if(message!=null&&message.length>0){
            alert(message);
        }
    </script>
</head>
<body>
<div class="header">
    <div class="am-g">
        <h1>酒店管理系统-登录</h1>
    </div>
    <hr />
</div>
<div class="am-g">
    <div class="am-u-lg-4 am-u-md-6 am-u-sm-centered">
         <br>
        <br>

        <form method="post" class="am-form" action="login.handle.php">
            <label for="user">账号:</label>
            <input type="text" name="user" id="user" value="">
            <br>
            <label for="password">密码:</label>
            <input type="password" name="pass" id="password" value="">
            <br>
            <br />
            <div class="am-cf">
                <input type="submit" name="sub" value="登 录" class="am-btn am-btn-primary am-btn-sm am-fr">
            </div>
        </form>
        <hr>
        <p>© 2016酒店管理系统.</p>
    </div>
</div>
</body>
</html>
