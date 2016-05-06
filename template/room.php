<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>
<!-- content start -->
<div class="admin-content">
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">管理员</strong> / <small>客房管理</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <button type="button" class="am-btn am-btn-default" data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0, width: 500, height: 400}"><span class="am-icon-plus"></span> 新增客房</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <table class="am-table am-table-bd am-table-striped admin-content-table">
                    <thead>
                    <tr>
                        <th>序号</th><th>房间号</th><th>房间类型</th><th>房间电话</th><th>房间状态</th><th>管理</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i=0;
                    foreach ($rooms as $row) {
                        $i++;
                        $state = $row['state']==1?"空闲":"已用";
                        echo <<<TR
                        <tr><td>{$i}</td><td>{$row['room_num']}</td><td>{$typesMap[$row['room_type']]}</td><td>{$row['phone']}</td><td>{$state}</td>
                        <td>
                            <div class="am-dropdown" data-am-dropdown>
                                <button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>
                                <ul class="am-dropdown-content">
                                    <li><a href="#" onclick="edit('{$row['room_num']}','{$row['room_type']}','{$row['phone']}','{$row['state']}','{$row['id']}')">1. 编辑</a></li>
                                    <li><a href="#" onclick=delOption('room.php','{$row['id']}')>2. 删除</a></li>
                                </ul>
                            </div>
                        </td>
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
            <div class="am-modal-hd">客房信息
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <hr>
            <div class="am-modal-bd">
                <!--modal body-->
                <div class="am-g am-center">
                    <div>
                        <form class="am-form am-form-horizontal am-center" action="room.php" method="post">
                            <div class="am-form-group">
                                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">编号:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <input type="text" name="room_num" id="room_num" placeholder="房间编号">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">类型:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <select name="room_type" id="room_type">
                                        <?php
                                        foreach ($types as $row) {
                                            if($row['is_delete'] == 1){continue;}
                                            echo "<option value = '{$row['id']}' >{$row['room_type']}</option >";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">电话:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <input type="text" name="phone" id="phone" placeholder="房间电话">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">状态:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <select name="state" id="state">
                                        <option value="1">空闲</option>
                                        <option value="2">已用</option>
                                    </select>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-1 am-u-sm-offset-8">
                                    <input type="submit" name="sub" class="am-btn am-btn-default" value="确定"/>
                                    <input type="hidden" name="Action" id="Action" value="Add">
                                    <input type="hidden" name="rid" id="rid" value="">
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

    function edit(room_num,room_type,phone,state,rid){
        var $modal = $('#doc-modal-1');
        var $room_num = $('#room_num');
        var $room_type = $('#room_type');
        var $phone = $('#phone');
        var $state = $('#state');
        var $Action = $('#Action');
        var $rid = $('#rid');

        $room_num.val(room_num);
        $room_type.val(room_type);
        $phone.val(phone);
        $state.val(state);
        $Action.val('Edit');
        $rid.val(rid);
        $modal.modal();

    }
</script>