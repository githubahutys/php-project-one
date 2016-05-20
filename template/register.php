<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>酒店前台注册账户</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
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

        .footer p {
            color: #7f8c8d;
            margin: 0;
            padding: 15px 0;
            text-align: center;
            background: #2d3e50;
        }
    </style>
</head>
<body>
<header class="am-topbar am-topbar-fixed-top">
    <div class="am-container">
        <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-secondary am-show-sm-only"
                data-am-collapse="{target: '#collapse-head'}"><span class="am-sr-only">导航切换</span> <span
                class="am-icon-bars"></span></button>

        <div class="am-collapse am-topbar-collapse" id="collapse-head">
            <ul class="am-nav am-nav-pills am-topbar-nav">
                <li class="am-active"><a href="index.php">首页</a></li>
            </ul>
            <div class="am-topbar-right">
                <button onclick="window.location='register.php'"
                        class="am-btn am-btn-secondary am-topbar-btn am-btn-sm"><span class="am-icon-pencil"></span> 注册
                </button>
            </div>
            <div class="am-topbar-right">
                <button onclick="window.location='login.php'" class="am-btn am-btn-primary am-topbar-btn am-btn-sm">
                    <span class="am-icon-user"></span> 登录
                </button>
            </div>
        </div>
    </div>
</header>
<div class="header">
    <div class="am-g" style="padding-top:10px">
        <h2>会员注册新账号</h2>
        <hr>
    </div>
</div>
<div class="am-g" id="content">
    <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
        <form method="post" onsubmit="return checkEmpty();" class="am-form am-form-horizontal" action="register.php">

            <div class="am-form-group">
                <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">姓名</label>
                <div class="am-u-sm-10">
                    <input type="text" name="user" id="user" placeholder="输入姓名" value="">
                </div>
            </div>

            <div class="am-form-group">
                <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">手机</label>

                <div class="am-u-sm-10">
                    <input type="text" name="mobile" id="mobile" placeholder="输入手机号码" value="">
                </div>
            </div>

            <div class="am-form-group">
                <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">身份证</label>

                <div class="am-u-sm-10">
                    <input type="text" name="idcard" id="idcard" placeholder="输入你的身份证" value="">
                </div>
            </div>

            <div class="am-form-group">
                <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">性别</label>

                <div class="am-u-sm-10">
                    <label class="am-radio-inline">
                        <input type="radio" value="男" name="gender" checked="true"> 男
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio"value="女" name="gender"> 女
                    </label>
                </div>
            </div>

            <div class="am-form-group">
                <label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">密码</label>

                <div class="am-u-sm-10">
                    <input type="password" name="pass1" id="pass1" placeholder="设置一个密码">
                </div>
            </div>
            <div class="am-form-group">
                <label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">确认密码</label>

                <div class="am-u-sm-10">
                    <input type="password" name="pass2" id="pass2" placeholder="请再次输入密码">
                    <input type="hidden" name="sub">
                </div>
            </div>
            <br/>

            <div class="am-form-group">
                <div class="am-u-sm-3 am-u-sm-offset-9">
                    <button type="submit"  class="am-btn am-btn-secondary">提交注册</button>
                </div>
            </div>
        </form>
        <hr>
    </div>
</div>
<script>
    function checkEmpty(){
        var name = $('#user').val();
        var mobile = $('#mobile').val();
        var idcard = $('#idcard').val();
        var pass1 = $('#pass1').val();
        var pass2 = $('#pass2').val();

        if(pass1!==pass2){
            alert('两次输入的密码不一致');
            return false;
        }
        if($.trim(name)==""||$.trim(mobile)==""||$.trim(idcard)==""||$.trim(pass1)==""||$.trim(pass2)==""){
            alert('请完整填写注册信息');
            return false;
        }
        return true;
    }

    var message = "<?php
        if(isset($_SESSION['message'])){
           echo $_SESSION['message'];
           unset($_SESSION['message']);
        }
        ?>";
    if(message!=null&&message.length>0){
        alert(message);
    }
</script>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="assets/js/amazeui.min.js"></script>
</body>
</html>
