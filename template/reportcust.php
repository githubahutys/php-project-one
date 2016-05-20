<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>
<!-- content start -->
<div class="admin-content">
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">酒店管理</strong> /
                <small>客户报表</small>
            </div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-3">

                <div class="am-input-group am-datepicker-date" data-am-datepicker="{format: 'yyyy-mm-dd'}">
                    <input type="text" name="start_time" id="start_time" class="am-form-field" placeholder="选择起始日期"
                           value="<?php echo $start; ?>" readonly>
                       <span class="am-input-group-btn am-datepicker-add-on">
                          <button class="am-btn am-btn-default" type="button"><span class="am-icon-calendar"></span>
                          </button>
                       </span>
                </div>
            </div>
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-input-group am-datepicker-date" data-am-datepicker="{format: 'yyyy-mm-dd'}">
                    <input type="text" name="end_time" id="end_time" class="am-form-field" placeholder="选择结束日期"
                           value="<?php echo $end; ?>" readonly>
                       <span class="am-input-group-btn am-datepicker-add-on">
                          <button class="am-btn am-btn-default" type="button"><span class="am-icon-calendar"></span>
                          </button>
                       </span>
                </div>
            </div>
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-input-group am-input-group-sm">
                    <input type="text" class="am-form-field" id="search_txt" placeholder="按姓名查询"
                           value="<?php if (isset($content)) echo $content; ?>">

          <span class="am-input-group-btn">
            <button class="am-btn am-btn-default" type="button" onclick="doSearch();">查询报表</button>
          </span>
                </div>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <table class="am-table am-table-bd am-table-striped admin-content-table">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>姓名</th>
                        <th>性别</th>
                        <th>证件</th>
                        <th>手机</th>
                        <th>累计消费</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    foreach ($reports as $row) {
                        $i++;
                        echo <<<TR
                        <tr><td>{$i}</td><td>{$row['name']}</td><td>{$row['gender']}</td><td>{$row['idcard']}</td><td>{$row['mobile']}</td><td>{$row['money']}</td>
                        </tr>
TR;
                    }
                    ?>
                    </tbody>
                </table>
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
        var search_txt = $.trim($("#search_txt").val());
        if (start_time == "" || end_time == "") {
            return;
        }
        var url = "reportcust.php?start_time=" + start_time + "&end_time=" + end_time+"&search_txt="+search_txt;
        window.location.href = url;
    }
</script>