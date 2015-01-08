{extends file='layout/main.tpl'}

{block title}角色管理{/block}

{block breadcrumb}
    <li>权限管理 <span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetRoleList')}">角色管理</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-body">
                    <div class="row-fluid">
                        <div class="span12">
                            <label>
                                <a href="javascript:;" id="addRole" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加角色</a>
                            </label>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered dataTable">
                        <thead>
                        <tr>
                            <th>编号</th>
                            <th>角色名称</th>
                            <th>角色描述</th>
                            <th>添加时间</th>
                            <th>修改时间</th>
                            <th>成员</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyres">
                        {foreach $list as $item}
                            <tr class="odd gradeX" data-id="{$item.id}">
                                <td>{$item.id}</td>
                                <td>{$item.name}</td>
                                <td>{$item.remark|default:'-'}</td>
                                <td>{$item.created_at}</td>
                                <td>{$item.updated_at}</td>
                                <td>
                                    {foreach $item.managers as $manager}
                                        <span>{$manager.username}{if !$manager@last}、{/if}</span>
                                    {/foreach}
                                </td>
                                <td><span class="toggle-status badge {if $item.status eq Role::STATUS_VALID}badge-info{else}badge-important{/if} toggle-status" data-id="{$item.id}" data-status="{$item.status}" style="cursor: pointer;">{trans('role.status.'|cat:$item.status)}</span></td>
                                <td>
                                    <a href="{route('GetRolePurview', ['role_id' => $item.id])}" class="btn btn-primary assignPurview"><i class="icon-lock"></i> 角色授权</a>
                                    <a href="javascript:;" class="btn btn-success assignManager"><i class="icon-group"></i> 分配成员</a>
                                    <a href="javascript:;" class="btn btn-info editRole"><i class="icon-pencil"></i> 编辑</a>
                                    <a href="javascript:;" class="btn btn-danger deleteRole"><i class="icon-remove"></i> 删除</a>
                                </td>
                            </tr>
                            {foreachelse}
                            <tr class="odd gradeX">
                                <td colspan="10" style="text-align: center">还没有相关角色信息！</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="roleModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>角色编辑</h3>
        </div>
        <div class="modal-body">
            <form id="form" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">角色名称：</label>
                    <div class="controls">
                        <input type="text" id="name" name="name"/>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">备注：</label>
                    <div class="controls">
                        <textarea name="remark" id="remark" style="height: 80px;"></textarea>
                    </div>
                    <input type="hidden" id="role_id" name="id"/>
                </div>
                <div class="control-group">
                    <label class="control-label">状态：</label>
                    <div class="controls">
                        <label class="radio">
                            <input type="radio" name="status"  value="{Role::STATUS_VALID}" />
                            开启
                        </label>
                        <label class="radio">
                            <input type="radio" name="status" value="{Role::STATUS_INVALID}" />
                            关闭
                        </label>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal" id="submitAction">确定</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        </div>
    </div>
{/block}

{block script}
<script type="text/javascript">

    $("#addRole").click(function() {
        $("#roleModal").modal('show');
        $("#name,#remark,#role_id").val('');
    });

    $(".editRole").click(function() {
        var id = $(this).closest('tr').attr('data-id');
        var td = $(this).closest('tr').children();
        var status = td.eq(6).find('span').attr('data-status');
        if (id) {
            $("#name").val(td.eq(1).text());
            $("#remark").val(td.eq(2).text());
            $("#role_id").val(id);
            $("[name='status']").removeAttr('checked');
            $("[name='status']").parent().removeClass('checked');
            $("[name='status']").each(function() {
                if ($(this).val() == status) {
                    $(this).attr('checked', 'checked').parent().addClass('checked');
                }
            });
        }
        $("#roleModal").modal('show');
    });

    $("#submitAction").click(function() {
        if ($("#name").val() == '') {
            ialert('角色名称不能为空');
            return false;
        }
        $.post('{route("SaveRole")}', $("#form").serialize(), function(data) {
            window.location.reload();
        }, 'text');
    });

    $(".toggle-status").click(function() {
        var id = $(this).closest('tr').attr('data-id');
        var status = $(this).attr('data-status');
        var status_title = '禁用';
        if (status != '{Role::STATUS_VALID}') {
            status_title = '启用';
        }
        iconfirm('确认要'+status_title+'此角色吗？', function() {
            $.post('{route("ToggleRoleStatus")}', { role_id: id, status: status }, function(data) {
                window.location.reload();
            });
        });
    });

    $(".deleteRole").click(function() {
        var id = $(this).closest('tr').attr('data-id');
        var obj = $(this);
        if (id) {
            iconfirm('确认要删除此角色吗？', function() {
                $.post('{route("DeleteRole")}', { role_id: id }, function() {
                    obj.closest('tr').slideUp('slow');
                }, 'text');
            });
        }
    });

    $(".assignManager").click(function() {
        var id = $(this).closest('tr').attr('data-id');
        if (id) {
            $.get('{route('GetRoleManager')}', { role_id : id }, function(html) {
                iconfirm(html, function() {
                    $.post('{route("AssignRoleManager")}', $("#manager_form").serialize(), function() {
                        ialert('修改角色成员成功！');
                    }, 'text');
                }, null, '角色成员');
            }, 'html');
        }
    });


</script>
{/block}