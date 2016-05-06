<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>
<!-- content start -->
<div class="admin-content">
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">管理员</strong> / <small>客房类型</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <button type="button" class="am-btn am-btn-default" data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0, width: 500, height: 400}"><span class="am-icon-plus"></span> 新增类型</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <table class="am-table am-table-bd am-table-striped admin-content-table">
                    <thead>
                    <tr>
                        <th>序号</th><th>房间类型</th><th>房间价格</th><th>房间总量</th><th>房间余量</th><th>管理</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i=0;
                    foreach ($types as $row) {
                        $i++;
                        echo <<<TR
                        <tr><td>{$i}</td><td>{$row['room_type']}</td><td>{$row['price']}</td><td>{$row['quantity']}</td><td>{$row['remain']}</td>
                        <td>
                            <div class="am-dropdown" data-am-dropdown>
                                <button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>
                                <ul class="am-dropdown-content">
                                    <li><a href="#" onclick="edit('{$row['room_type']}','{$row['price']}','{$row['quantity']}','{$row['remain']}','{$row['id']}')">1. 编辑</a></li>
                                    <li><a href="#" onclick=delOption('type.php','{$row['id']}')>2. 删除</a></li>
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
            <div class="am-modal-hd">客房类型
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <hr>
            <div class="am-modal-bd">
                <!--modal body-->
                <div class="am-g am-center">
                    <div>
                        <form class="am-form am-form-horizontal am-center" action="type.php" method="post">
                            <div class="am-form-group">
                                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">类型:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <input type="text" name="room_type" id="room_type" placeholder="房间类型">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">价格:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <input type="text" name="price" id="price" placeholder="房间价格">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">总数:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <input type="text" name="quantity" id="quantity" placeholder="房间总数">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">余量:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <input type="text" name="remain" id="remain" placeholder="房间余量">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-1 am-u-sm-offset-8">
                                    <input type="submit" name="sub" class="am-btn am-btn-default" value="确定"/>
                                    <input type="hidden" name="Action" id="Action" value="Add">
                                    <input type="hidden" name="tid" id="tid" value="">
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

    function edit(room_type,price,quantity,remain,tid){
        var $modal = $('#doc-modal-1');
        var $room_type = $('#room_type');
        var $price = $('#price');
        var $quantity = $('#quantity');
        var $remain = $('#remain');
        var $Action = $('#Action');
        var $tid = $('#tid');

        $price.val(price);
        $room_type.val(room_type);
        $quantity.val(quantity);
        $remain.val(remain);
        $Action.val('Edit');
        $tid.val(tid);
        $modal.modal();

    }
</script>