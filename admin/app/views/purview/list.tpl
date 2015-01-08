{extends file='layout/main.tpl'}

{block breadcrumb}
    <li>权限管理 <span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetPurviewList')}">权限列表</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">
            <!-- begin recent orders portlet-->
            <div class="widget">
                <div class="widget-body">
                    {$html}
                </div>
            </div>
            <!-- end recent orders portlet-->
        </div>
    </div>

    <div id="nodeModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>权限编辑</h3>
        </div>
        <div class="modal-body">
            <form id="form" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">权限名称：</label>
                    <div class="controls">
                        <input type="text" id="name" name="name"/>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">权限标识符：</label>
                    <div class="controls">
                        <input type="text" id="purview_key" name="purview_key"/>
                        <span class="">路由中as关键字</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">上级权限：</label>
                    <div class="controls">
                        <select id="parent_id" name="parent_id">
                            <option value="">第一级</option>
                            {foreach $list as $item}
                                {if $item.name}
                                <option value="{$item.id}">{str_repeat('&nbsp;&nbsp;', count(explode(':', $item.path))-1)}{$item.name}</option>
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">所属控制器：</label>
                    <div class="controls">
                        <input type="text" name="controller" id="controller"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">所属方法：</label>
                    <div class="controls">
                        <input name="action" id="action" type="text"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">附加条件：</label>
                    <div class="controls">
                        <input type="text" id="condition" name="condition"/>
                        <span>如：a=1&b=2</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">排序号：</label>
                    <div class="controls">
                        <input type="text" id="sort_order" name="sort_order" value="100"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">类型：</label>
                    <div class="controls">
                        <label class="radio">
                            <input type="radio" name="type"  value="{Purview::TYPE_MENU}" />
                            菜单
                        </label>
                        <label class="radio">
                            <input type="radio" name="type" value="{Purview::TYPE_ACTION}" />
                            操作
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">状态：</label>
                    <div class="controls">
                        <label class="radio">
                            <input type="radio" name="status"  value="{Purview::STATUS_VALID}" />
                            开启
                        </label>
                        <label class="radio">
                            <input type="radio" name="status" value="{Purview::STATUS_INVALID}" />
                            关闭
                        </label>
                    </div>
                    <input type="hidden" id="purview_id" name="id"/>
                </div>
                <div class="control-group">
                    <label class="control-label">备注：</label>
                    <div class="controls">
                        <textarea name="remark" id="remark"></textarea>
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
<script type="text/javascript" src="{asset('assets/bootstrap/js/bootstrap-tooltip.js')}"></script>
<script type="text/javascript" src="{asset('assets/bootstrap/js/bootstrap-popover.js')}"></script>
<script type="text/javascript">
    $('.node').popover({
        html: true,
        title: '操作',
        container: 'body',
        content: '<div class="node_action"><a href="javascript:;" class="editNode">编辑</a> <a href="javascript:;" class="deleteNode">删除</a> <a href="javascript:;" class="addNode">添加</a></div>',
        trigger: 'click',
        delay: { "show": 100, "hide" : 300 }
    });

    $('.node').click(function() {
        $('.node_action').attr('data-id', $(this).attr('data-id'));
    });

    $(document).on('click', '.addNode', function() {
        $('.node').popover('hide');
        var id = $(this).parent().attr('data-id');
        $("#purview_id").val('');
        $("#parent_id option").removeAttr('selected');
        $("#parent_id option").each(function() {
            if ($(this).val() == id) {
                $(this).attr('selected', 'selected');
                return false;
            }
        });
        $("#name,#purview_key,#controller,#action,#condition").val('');
        $("#nodeModal").modal('show');
    });

    $(document).on('click', '.deleteNode', function() {
        $('.node').popover('hide');
        var id = $(this).parent().attr('data-id');
        iconfirm('确认要删除吗？', function() {
            $.post('{route("DeletePurview")}', { id : id }, function(data) {
                window.location.reload();
            }, 'text');
        });
    });

    $(document).on('click', '.editNode', function() {
        $('.node').popover('hide');
        var id = $(this).closest('.node_action').attr('data-id');
        if (id) {
            $.get('{route("GetPurviewInfo")}', { id : id } ,function(data) {
                $("#purview_id").val(id);
                $("#name").val(data.name);
                $("#purview_key").val(data.purview_key);
                $("#controller").val(data.controller);
                $("#action").val(data.action);
                $("#condition").val(data.condition);
                $("#sort_order").val(data.sort_order);
                var parent_id = data.parent_id;
                $("#parent_id option").each(function() {
                    if ($(this).val() == parent_id) {
                        $(this).attr('selected', 'selected');
                        return false;
                    }
                });
                $("[name='type']").filter("[value='"+data.type+"']").attr('checked', 'checked');
                $("[name='type']").filter("[value='"+data.type+"']").parent().addClass('checked');
                $("[name='status']").filter("[value='"+data.status+"']").attr('checked', 'checked');
                $("[name='status']").filter("[value='"+data.status+"']").parent().addClass('checked');
                $("#remark").val(data.remark);
                $("#nodeModal").modal('show');
            });
        }
    });

    $("#submitAction").click(function() {
        var data = $("#form").serialize();
        $.ajax({
            type: 'POST',
            url: '{route("SavePurviewInfo")}',
            data: $("#form").serialize(),
            success: function(data) {
                window.location.reload();
            }
        });
    });
</script>
{/block}