<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>
<!doctype html>
<html class="no-js fixed-layout">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>酒店管理系统-工作台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" type="image/png" href="assets/i/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">
    <meta name="apple-mobile-web-app-title" content="Amaze UI" />
    <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="assets/css/admin.css">
    <script src="assets/js/jquery.min.js"></script>


</head>
<body>

<header class="am-topbar am-topbar-inverse admin-header">
    <div class="am-topbar-brand">
        <strong>酒店管理工作台</strong>
    </div>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
            <li class="am-dropdown" data-am-dropdown>
                <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
                    <span class="am-icon-users"></span> 退出系统 <span class="am-icon-caret-down"></span>
                </a>
                <ul class="am-dropdown-content">
                    <li><a href="login.handle.php?out=out"><span class="am-icon-power-off"></span> 退出</a></li>
                </ul>
            </li>
            <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
        </ul>
    </div>
</header>

<div class="am-cf admin-main">
    <!-- sidebar start -->
    <div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
        <div class="am-offcanvas-bar admin-offcanvas-bar">
            <ul class="am-list admin-sidebar-list">
                <li><a href="admin.php"><span class="am-icon-home"></span> 首页</a></li>
                <li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#collapse-nav'}"><span class="am-icon-file"></span> 酒店管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                    <ul class="am-list  admin-sidebar-sub" id="collapse-nav">
                        <li><a href="customer.php"><span class="am-icon-file-o"></span> 客户信息</a></li>
                        <li><a href="checkin.php" class="am-cf"><span class="am-icon-check"></span> 入住登记</a></li>
                        <li><a href="checkout.php"><span class="am-icon-puzzle-piece"></span> 退房结账</a></li>
                        <li><a href="reserve.php"><span class="am-icon-th"></span> 客房预订</a></li>
                    </ul>
                </li>
                <?php
                if($isAdmin){
                    $string =
                        <<<ADMIN
                                  <li class="admin-parent">
                                <a class="am-cf" data-am-collapse="{target: '#collapse-nav-admin'}"><span class="am-icon-file"></span> 管理员功能 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                                <ul class="am-list admin-sidebar-sub" id="collapse-nav-admin">
                                    <li><a href="room.php"><span class="am-icon-file-o"></span> 客房管理</a></li>
                                    <li><a href="type.php"><span class="am-icon-file-o"></span> 客房类型</a></li>
                                    <li><a href="staff.php"><span class="am-icon-file-text"></span> 员工管理</a></li>
                                </ul>
                            </li>
ADMIN;
                    echo $string;
                }
                ?>
            </ul>


        </div>
    </div>
    <!-- sidebar end -->

    <!-- content start -->
    <?php
    include($contentFile);//布局文件和内容文件分开成两个模板，减少代码量
    ?>
    <!-- content end -->

</div>
<!--删除提示modal-->
<div class="am-modal am-modal-confirm" tabindex="-1" id="delete-confirm">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">删除分类</div>
        <div class="am-modal-bd">
            确定要删除这条记录吗？操作不可恢复！
        </div>
        <div class="am-modal-footer">
            <span class="am-modal-btn" data-am-modal-cancel>取消</span>
            <span class="am-modal-btn" data-am-modal-confirm>确定</span>
        </div>
    </div>
</div>
<script>
    var message = "<?php
        if(isset($_SESSION['message'])){
           echo $_SESSION['message'];
           unset($_SESSION['message']);
        }
        ?>";
    if(message!=null&&message.length>0){
        alert(message);
    }

    function delOption(page,id){
        $('#delete-confirm').modal({
            relatedTarget: this,
            onConfirm: function(options) {
                var url = page+"?Action=Del&id="+id;
                window.location.href = url;
            },
            // closeOnConfirm: false,
            onCancel: function() {
            }
        });
    }
</script>
<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="assets/js/amazeui.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
