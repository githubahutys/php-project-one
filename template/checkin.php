<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>
<!-- content start -->
<div class="admin-content">
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">酒店管理</strong> / <small>入住登记</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <button type="button" class="am-btn am-btn-default" data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0, width: 500, height: 500}"><span class="am-icon-plus"></span> 新增入住</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <table class="am-table am-table-bd am-table-striped admin-content-table">
                    <thead>
                    <tr>
                        <th>ID</th><th>房间号</th><th>姓名</th><th>证件</th><th>手机</th><th>类型</th><th>价格</th><th>押金</th><th>入住时间</th><th>退房时间</th><th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($checkins as $row) {
                        $guarantee = $row['guarantee_price'];
                        echo <<<TR
                        <tr><td>{$row['id']}</td><td>{$roomNumsMap[$row['room_id']]['room_num']}</td><td>{$custsMap[$row['cust_id']]['name']}</td><td>{$custsMap[$row['cust_id']]['idcard']}</td><td>{$custsMap[$row['cust_id']]['mobile']}</td>
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
            <div class="am-modal-hd">入住信息
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <hr>
            <div class="am-modal-bd">
                <!--modal body-->
                <div class="am-g am-center">
                    <div>
                        <form class="am-form am-form-horizontal am-center" action="checkin.php" method="post">
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">客户信息:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <select name="cust_id" data-am-selected="{searchBox: 1}">
                                        <option value = ''></option>
                                        <?php
                                        foreach($custs as $row) {
                                            if($row['is_delete'] == 1){continue;}

                                            echo "<option value = '{$row[id]}' > {$row['name']}-{$row['idcard']}</option >";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label  class="am-u-sm-3 am-form-label">入住时间:</label>
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
                                        <option value = ''></option>
                                        <?php
                                        foreach ($types as $row) {
                                            if($row['is_delete'] == 1){continue;}
                                            echo "<optgroup label='{$row['room_type']}'>";
                                            foreach ($rooms as $rowr) {
                                                if($rowr['room_type']!=$row['id'] ||$rowr['is_delete'] == 1){
                                                    continue;
                                                }
                                                echo "<option value = '{$rowr['id']}' >{$rowr['room_num']}</option >";
                                            }
                                            echo "</optgroup>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="room_price" class="am-u-sm-3 am-form-label">价格:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <input type="text" name="room_price" id="room_price" placeholder="房间价格">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label  class="am-u-sm-3 am-form-label">押金:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <input type="text" name="guarantee_price"  placeholder="房间押金">
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
<script>
    var prices = <?php echo json_encode($roomsMap);?>;
    $(function(){
        var $selected = $('#roomSelect');
        var $checkInTimeStamp =$('#check_in_time');
        var $checkOutTimeStamp =$('#check_out_time');

        $selected.on('change', function() {
            var roomId = $(this).val();
            var strtime1 = $checkInTimeStamp.val();
            var strtime2 = $checkOutTimeStamp.val();
            var date1 = new Date(strtime1);
            var date2 = new Date(strtime2);
            var time1 = date1.getTime();
            var time2 = date2.getTime();
            var days = (time2/1000-time1/1000)/86400;
            $('#room_price').val(days*prices[roomId]);
        });
    });
</script>