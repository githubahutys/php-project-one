<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>酒店预订首页</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="alternate icon" type="image/png" href="assets/i/favicon.png">
    <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
    <style>

        .detail {
            background: #fff;
        }

        .detail-h2 {
            text-align: center;
            font-size: 150%;
            margin: 40px 0;
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
                <?php
                if(isset($_SESSION['user'])){
                    echo <<<TR
                    <button onclick = "window.location='login.handle.php?out=out'" class="am-btn am-btn-primary am-topbar-btn am-btn-sm" >
                    <span class="am-icon-user" ></span > 退出
                    </button >
TR;
                }else {
                    echo <<<TR
                    <button onclick = "window.location='login.php'" class="am-btn am-btn-primary am-topbar-btn am-btn-sm" >
                    <span class="am-icon-user" ></span > 登录
                    </button >
TR;
                }
                ?>
            </div>
        </div>
    </div>
</header>


<div class="detail">
    <div class="am-g am-container">
        <div class="am-u-lg-12">
            <h2 class="detail-h2">以下为可预订房型及余量</h2>

            <div class="am-g">

                <?php

                foreach($types as $row) {
                    if($row['is_delete'] == 1){continue;}
                    $remain = $row['remain']-3;
                    echo <<<TR
                <div class="am-u-sm-6" >
                    <div class="am-thumbnail" >
                        <img src = "{$row['img']}" alt = "" />
                        <div class="am-thumbnail-caption" >
                            <h3 > {$row['room_type']}/剩余<span style="color:blue;">{$remain}间</span>/价格：<span style="color:red;">{$row['price']}元</span></h3 >
                            <p >{$row['description']}</p >
                            <p >
                                <button class="am-btn am-btn-primary" onclick="changeType('{$row['id']}');" data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0, width: 500, height: 450}"> 预订</button >
                            </p >
                        </div >
                    </div >
                </div >
TR;
                }
                ?>


            </div>
        </div>
    </div>
</div>


<footer class="footer">
    <p>© 2014 酒店预订系统</p>
</footer>

<!--modal start-->
<div class="am-modal am-modal-no-btn" tabindex="-1" id="doc-modal-1">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">预订信息
            <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
        </div>
        <hr>
        <div class="am-modal-bd">
            <!--modal body-->
            <div class="am-g am-center">
                <div>
                    <form class="am-form am-form-horizontal am-center" onsubmit="return generatePrice();" action="index.php" method="post">

                        <div class="am-form-group">
                            <label  class="am-u-sm-3 am-form-label">预订时间:</label>
                            <div class="am-u-sm-8" style="float: left">
                                <div class="am-input-group am-datepicker-date" data-am-datepicker="{format: 'yyyy-mm-dd'}">
                                    <input type="text" name="check_in_time" id="check_in_time" class="am-form-field" placeholder="选择发表日期" readonly>
                                  <span class="am-input-group-btn am-datepicker-add-on">
                                    <button class="am-btn am-btn-default" type="button"><span class="am-icon-calendar"></span> </button>
                                  </span>
                                </div>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label  class="am-u-sm-3 am-form-label">退房时间:</label>
                            <div class="am-u-sm-8" style="float: left">
                                <div class="am-input-group am-datepicker-date" data-am-datepicker="{format: 'yyyy-mm-dd'}">
                                    <input type="text" name="check_out_time" id="check_out_time" class="am-form-field" placeholder="选择发表日期" readonly>
                                  <span class="am-input-group-btn am-datepicker-add-on">
                                    <button class="am-btn am-btn-default" type="button"><span class="am-icon-calendar"></span> </button>
                                  </span>
                                </div>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label  class="am-u-sm-3 am-form-label">房间类型:</label>
                            <div class="am-u-sm-8" style="float: left">
                                <select  id="roomSelect" name="room_id" data-am-selected="{maxHeight: 300}">

                                </select>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="room_price" class="am-u-sm-3 am-form-label">房间价格:</label>
                            <div class="am-u-sm-4" style="float: left">
                                <input type="text" name="room_price" id="room_price" placeholder="房间价格" readonly>
                                <input type="hidden" name="room_type" id="room_type">
                            </div>
                            <div class="am-u-sm-3" style="float: left">
                                <button class="am-btn am-btn-primary" type="button" onclick="generatePrice();">生成价格</button >
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label  class="am-u-sm-3 am-form-label">房间押金:</label>
                            <div class="am-u-sm-8" style="float: left">
                                <input type="text" name="guarantee_price"  placeholder="房间押金" value="100" readonly>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <div class="am-u-sm-1 am-u-sm-offset-8">
                                <input type="submit" name="sub" class="am-btn am-btn-default" value="确定"/>
                                <input type="hidden" name="Action" value="Add">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <!--modal end-->
        </div>
    </div>
</div>
<!--modal end-->

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="assets/js/amazeui.min.js"></script>


<script>
    function changeType(id){
        $('#room_type').val(id);
        $('#roomSelect').empty();
        $.post("index.php",
            {
                room_type:id,
                is_ajax:true
            },
            function(data,status){
                var data = eval(data);
                var i =0;
                $.each(data,function(idx,item){
                    i++;
                    if(i<=(data.length-3)){
                        $('#roomSelect').append("<option value = '"+item.id+"'>"+item.room_num+"</option>");
                    }
                })
            });
    }
    var prices = <?php echo json_encode($pricesMap);?>;

    function generatePrice(){
        var type = $('#room_type').val();
        var $checkInTimeStamp =$('#check_in_time');
        var $checkOutTimeStamp =$('#check_out_time');

        var strtime1 = $checkInTimeStamp.val();
        var strtime2 = $checkOutTimeStamp.val();
        var date1 = new Date(strtime1);
        var date2 = new Date(strtime2);
        alert(strtime2);
        var time1 = date1.getTime();
        var time2 = date2.getTime();
        var days = Math.abs((time2/1000-time1/1000)/86400);
        $('#room_price').val(days*prices[type]);
        return true;
    }

</script>
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
</script>
</body>
</html>
