{extends file='layout/main.tpl'}

{block title}管理员列表{/block}

{block breadcrumb}
    <li>权限管理 <span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetManagerList')}">管理员列表</a><span class="divider-last">&nbsp;</span></li>
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
                                <a href="{route('EditManagerInfo')}" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加管理员</a>
                            </label>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered dataTable">
                        <thead>
                        <tr>
                            <th>登录用户名</th>
                            <th>真实姓名</th>
                            <th>手机号</th>
                            <th>邮箱</th>
                            <th>性别</th>
                            <th>超级管理员</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyres">

                        {foreach $list as $item}
                            <tr class="odd gradeX">
                                <td>{$item.username}</td>
                                <td>{$item.real_name|default:'-'}</td>
                                <td>{$item.mobile|default:'-'}</td>
                                <td>{$item.email|default:'-'}</td>
                                <td>{if $item.gender eq Member::GENDER_MAN }男{else}女{/if}</td>
                                <td>{if $item.is_super eq Manager::SUPER_INVALID}<span class="badge badge-important" >否</span>{else}<span class="badge badge-info">是</span>{/if}</td>    
                                <td>{if $item.status eq Manager::STATUS_INVALID}<span data-id="{$item.id}" data-status="{$item.status}" class="badge badge-important toggle-status" style="cursor: pointer;">禁用</span>{else}<span data-id="{$item.id}" data-status="{$item.status}" style="cursor: pointer;" class="badge badge-info toggle-status">启用</span>{/if}</td>
                                <td>
                                    <a href="{route('EditManagerInfo', ['id'=>$item.id] )}" class="btn mini btn-primary"><i class="icon-edit"></i> 编辑</a>
                                    {if $item.is_super eq Manager::SUPER_INVALID }
                                    <button class="btn mini btn-danger delete_manager" data-id="{$item.id}"><i class="icon-trash"></i> 删除</button>
                                	{/if}
                                </td>
                            </tr>
	                        {foreachelse}
	                            <tr class="odd gradeX">
	                                <td colspan="7" style="text-align: center">还没有相关管理员信息！</td>
	                            </tr>
	                        {/foreach}
                        
                        </tbody>
                    </table>

                    <div class="row-fluid" style="text-align: right;">
                        {$list->links()}
                    </div>

                </div>
            </div>
        </div>
    </div>
{/block}

{block script}
<script type="text/javascript">
    $(".toggle-status").click(function() {
        var id = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        var status_title = '禁用';
        if (status != '{Manager::STATUS_VALID}') {
            status_title = '启用';
        }
        iconfirm('确认要'+status_title+'此管理员吗？', function() {
            $.post('{route("ToggleManagerStatus")}', { manager_id: id, status: status }, function(data) {
                window.location.reload();
            });
        });
    });

    $(".delete_manager").click(function() {
        var id = $(this).attr('data-id');
        var obj = $(this);
        if (id) {
            iconfirm('确认要删除此管理员吗？', function() {
                $.post('{route("DeleteManager")}', { manager_id: id }, function() {
                    obj.closest('tr').slideUp('slow');
                }, 'text');
            });
        }
    });
</script>
{/block}