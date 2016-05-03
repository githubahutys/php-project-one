<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>
<!-- content start -->
<div class="admin-content">
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">酒店管理</strong> / <small>客户信息</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <button type="button" class="am-btn am-btn-default" data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0, width: 500, height: 400}"><span class="am-icon-plus"></span> 新增客户</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <table class="am-table am-table-bd am-table-striped admin-content-table">
                    <thead>
                    <tr>
                        <th>ID</th><th>身份证</th><th>姓名</th><th>性别</th><th>手机号</th><th>管理</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($custs as $row) {
                        echo <<<TR
                        <tr><td>{$row['id']}</td><td>{$row['idcard']}</td><td>{$row['name']}</td><td>{$row['gender']}</td><td>{$row['mobile']}</td>
                        <td>
                            <div class="am-dropdown" data-am-dropdown>
                                <button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>
                                <ul class="am-dropdown-content">
                                    <li><a href="#" onclick="edit('{$row['name']}','{$row['gender']}','{$row['mobile']}','{$row['idcard']}','{$row['id']}')">1. 编辑</a></li>
                                    <li><a href="customer.php?Action=Del&id={$row['id']}">2. 删除</a></li>
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
            <div class="am-modal-hd">客户信息
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <hr>
            <div class="am-modal-bd">
                <!--modal body-->
                <div class="am-g am-center">
                    <div>
                        <form class="am-form am-form-horizontal am-center" action="customer.php" method="post">
                            <div class="am-form-group">
                                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">姓名:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <input type="text" name="name" id="name" placeholder="客户姓名">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">性别:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <select name="gender" id="gender">
                                        <option value="男">男</option>
                                        <option value="女">女</option>
                                    </select>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">手机:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <input type="text" name="mobile" id="mobile" placeholder="手机号码">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">证件:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <input type="text" name="idcard" id="idcard" placeholder="身份证号">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-1 am-u-sm-offset-8">
                                    <input type="submit" name="sub" class="am-btn am-btn-default" value="确定"/>
                                    <input type="hidden" name="Action" id="Action" value="Add">
                                    <input type="hidden" name="cid" id="cid" value="">

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

    function edit(name,gender,mobile,idcard,cid){
        var $modal = $('#doc-modal-1');
        var $name = $('#name');
        var $gender = $('#gender');
        var $mobile = $('#mobile');
        var $idcard = $('#idcard');
        var $Action = $('#Action');
        var $cid = $('#cid');

        $name.val(name);
        $gender.val(gender);
        $mobile.val(mobile);
        $idcard.val(idcard);
        $Action.val('Edit');
        $cid.val(cid);
        $modal.modal();

    }
</script>