<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>
<!-- content start -->
<div class="admin-content">
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">酒店管理</strong> / <small>退房结账</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <button type="button" class="am-btn am-btn-default" data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0, width: 500, height: 250}"><span class="am-icon-plus"></span> 新增退房</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="am-g">
            <div class="am-u-sm-12">
                <table class="am-table am-table-bd am-table-striped admin-content-table">
                    <thead>
                    <tr>
                        <th>序号</th><th>房间号</th><th>姓名</th><th>证件</th><th>手机</th><th>类型</th><th>价格</th><th>押金</th><th>入住时间</th><th>退房时间</th><th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i=0;
                    foreach ($checkins as $row) {
                        $i++;
                        $guarantee = $row['guarantee_price'] -$row['room_price'];
                        echo <<<TR
                        <tr><td>{$i}</td><td>{$roomNumsMap[$row['room_id']]['room_num']}</td><td>{$custsMap[$row['cust_id']]['name']}</td><td>{$custsMap[$row['cust_id']]['idcard']}</td><td>{$custsMap[$row['cust_id']]['mobile']}</td>
                        <td>{$typesMap[$roomNumsMap[$row['room_id']]['room_type']]}</td><td>{$row['room_price']}</td><td>{$guarantee}</td><td>{$row['check_in_time']}</td>
                        <td>{$row['check_out_time']}</td><td>{$adminsMap[$row['admin_id']]['name']}</td>
                    </tr>
TR;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!--modal start-->
    <div class="am-modal am-modal-no-btn" tabindex="-1" id="doc-modal-1">
        <div class="am-modal-dialog">
            <div class="am-modal-hd">退房结账
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <hr>
            <div class="am-modal-bd">
                <!--modal body-->
                <div class="am-g am-center">
                    <div>
                        <form class="am-form am-form-horizontal am-center" action="checkout.php" method="post">
                            <div class="am-form-group">
                                <label for="room_price" class="am-u-sm-3 am-form-label">房号:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <input type="text" name="room_num" id="room_price" placeholder="房间编号">
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
    <footer class="admin-content-footer">
        <hr>
        <p class="am-padding-left">© 2016 酒店管理工作台.</p>
    </footer>
</div>
<!-- content end -->