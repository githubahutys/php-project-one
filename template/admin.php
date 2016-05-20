<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>
<!-- content start -->
<div class="admin-content">
    <div class="admin-content-body">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">首页</strong> / <small>信息简报</small></div>
        </div>

        <ul class="am-avg-sm-1 am-avg-md-4 am-margin am-padding am-text-center admin-content-list ">
            <li><a href="#" class="am-text-success"><span class="am-icon-btn am-icon-file-text"></span><br/>历史预订<br/><?php echo $reserves;?>间</a></li>
            <li><a href="#" class="am-text-warning"><span class="am-icon-btn am-icon-briefcase"></span><br/>历史入住<br/><?php echo $checkins;?>间</a></li>
            <li><a href="#" class="am-text-danger"><span class="am-icon-btn am-icon-recycle"></span><br/>历史退房<br/><?php echo $checkouts;?>间</a></li>
            <li><a href="#" class="am-text-secondary"><span class="am-icon-btn am-icon-user-md"></span><br/>注册客户<br/><?php echo $peoples;?>人</a></li>
        </ul>
        <div class="am-g">
            <div class="am-u-sm-12">
                <table class="am-table am-table-bd am-table-striped admin-content-table">
                    <thead>
                    <tr>
                        <th>序号</th><th>房型</th><th>总量</th><th>余量</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i=0;
                    foreach($types as $row){
                        $i++;
                        echo <<<TR
                        <tr><td>{$i}</td><td>{$row['room_type']}</td><td><span class="am-badge am-badge-success">{$row['quantity']}</span></td><td><span class="am-badge am-badge-danger">{$row['remain']}</span></td>
                        </tr>
TR;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="admin-content-footer">
        <hr>
        <p class="am-padding-left">© 2016 酒店管理工作台.</p>
    </footer>
</div>
<!-- content end -->
