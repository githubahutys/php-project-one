<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>
<!-- content start -->
<div class="admin-content">
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">酒店管理</strong> /
                <small>客房报表</small>
            </div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-3">

                <div class="am-input-group am-datepicker-date" data-am-datepicker="{format: 'yyyy-mm-dd'}">
                    <input type="text" name="start_time" id="start_time" class="am-form-field" placeholder="选择起始日期"
                           value="<?php echo $start;?>" readonly>
                       <span class="am-input-group-btn am-datepicker-add-on">
                          <button class="am-btn am-btn-default" type="button"><span class="am-icon-calendar"></span>
                          </button>
                       </span>
                </div>
            </div>
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-input-group am-datepicker-date" data-am-datepicker="{format: 'yyyy-mm-dd'}">
                    <input type="text" name="end_time" id="end_time" class="am-form-field" placeholder="选择结束日期"
                           value="<?php echo $end;?>" readonly>
                       <span class="am-input-group-btn am-datepicker-add-on">
                          <button class="am-btn am-btn-default" type="button"><span class="am-icon-calendar"></span>
                          </button>
                       </span>
                </div>
            </div>
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-input-group am-input-group-sm">
          <span class="am-input-group-btn">
            <button class="am-btn am-btn-default" type="button" onclick="doSearch();">查询报表</button>
          </span>
                </div>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>房间类型</th>
                        <th>房间总数</th>
                        <th>累计入住次数</th>
                        <th>累计销售金额</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    $money=0;
                    $times=0;
                    foreach ($reports as $row) {
                        $i++;
                        $money+=$row['money'];
                        $times+=$row['times'];
                        echo <<<TR
                        <tr><td>{$i}</td><td>{$row['room_type']}</td><td>{$row['quantity']}</td><td>{$row['times']}</td><td>{$row['money']}</td>
                        </tr>
TR;
                    }
                    ?>
                    <tr><td>合计金额：</td><td><?php echo $money;?></td><td>累计入住：</td><td><?php echo $times;?></td><td></td></tr>

                    </tbody>
                </table>
                <hr>
                <div>累计入住：<?php echo $times;?>次&nbsp;&nbsp;&nbsp;合计金额：<?php echo $money;?>元</div>
            </div>
        </div>
    </div>
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
    function doSearch() {
        var start_time = $.trim($("#start_time").val());
        var end_time = $.trim($("#end_time").val());
        if (start_time == ""||end_time == "") {
            return;
        }
        var url = "reportroom.php?start_time=" + start_time+"&end_time="+end_time;
        window.location.href = url;
    }
</script>