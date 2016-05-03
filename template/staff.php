<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>
<!-- content start -->
<div class="admin-content">
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">管理员</strong> / <small>员工管理</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <button type="button" class="am-btn am-btn-default" data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0, width: 500, height: 500}"><span class="am-icon-plus"></span> 新增员工</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <table class="am-table am-table-bd am-table-striped admin-content-table">
                    <thead>
                    <tr>
                        <th>ID</th><th>用户名</th><th>姓名</th><th>职位</th><th>工号</th><th>权限</th><th>管理</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($staffs as $row) {
                        $permission = $row['permission']==1?"管理员":"普工";
                    echo <<<TR
                        <tr><td>{$row['id']}</td><td>{$row['user']}</td><td>{$row['name']}</td><td>{$row['job']}</td><td>{$row['jobid']}</td> <td>{$permission}</td>
                        <td>
                            <div class="am-dropdown" data-am-dropdown>
                                <button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>
                                <ul class="am-dropdown-content">
                                    <li><a href="#" onclick="edit('{$row['user']}','{$row['name']}','{$row['job']}','{$row['jobid']}','{$row['permission']}','{$row['id']}')">1. 编辑</a></li>
                                    <li><a href="staff.php?Action=Del&id={$row['id']}">2. 删除</a></li>
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
            <div class="am-modal-hd">员工信息
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <hr>
            <div class="am-modal-bd">
                <!--modal body-->
                <div class="am-g am-center">
                    <div>
                        <form class="am-form am-form-horizontal am-center" action="staff.php" method="post">
                            <div class="am-form-group">
                                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">账号:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <input type="text" name="user" id="user" placeholder="登录账号">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">姓名:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <input type="text" name="name" id="name" placeholder="员工姓名">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">职位:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <input type="text" name="job" id="job" placeholder="员工职位">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">工号:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <input type="text" name="jobid" id="jobid" placeholder="员工工号">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">权限:</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <select name="permission" id="permission">
                                        <option value="1">管理员</option>
                                        <option value="2">普通员工</option>
                                    </select>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="doc-ipt-pwd-2" class="am-u-sm-3 am-form-label">密码</label>
                                <div class="am-u-sm-8" style="float: left">
                                    <input type="password" name="password" id="password" placeholder="登录密码">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-1 am-u-sm-offset-8">
                                    <input type="submit" name="sub" class="am-btn am-btn-default" value="确定"/>
                                    <input type="hidden" name="Action" id="Action" value="Add">
                                    <input type="hidden" name="sid" id="sid" value="">
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
    function edit(user,name,job,jobid,permission,sid){
        var $modal = $('#doc-modal-1');
        var $user = $('#user');
        var $name = $('#name');
        var $job = $('#job');
        var $jobid = $('#jobid');
        var $permission = $('#permission');
        var $Action = $('#Action');
        var $sid = $('#sid');

        $user.val(user);
        $name.val(name);
        $job.val(job);
        $jobid.val(jobid);
        $permission.val(permission);
        $Action.val('Edit');
        $sid.val(sid);
        $modal.modal();

    }
</script>