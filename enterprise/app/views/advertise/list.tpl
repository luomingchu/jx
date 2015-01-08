{extends file='layout/main.tpl'}

{block title}广告管理{/block}

{block breadcrumb}
    <li>活动管理<span class="divider">&nbsp;</span></li>
    <li>广告管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetAdvertiseSpaceList')}">广告位</a><span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetAdvertiseList', ['space_id' => $smarty.get.space_id])}">广告列表</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">
            <!-- begin recent orders portlet-->
            <div class="widget">
                <div class="widget-body">
                    <div class="row-fluid">
                        <div class="span12">
                            <form>
                                <span><input type="text" class="form-control" name="keyword" value="{Input::get('keyword')}" placeholder="广告名称搜索"></span>
                                <span>
                                    <select name="space_id" class="form-control" id="space_id" style="font-weight:300">
                                        <option value="">请选择广告位</option>
                                        {foreach $space as $item}
                                            <OPTION value="{$item.id}" {if $smarty.get.space_id eq $item.id}selected="selected"{/if}>{$item.name}</OPTION>
                                        {/foreach}
                                    </select>
                                </span>
                                <span style="position: relative;top: -5px;left: -20px;">
                                    <button type="submit" class="btn btn-primary" style="margin-left: 30px">查 询</button>
                                    <a href="{route('EditAdvertise', ['space_id' => $smarty.get.space_id])}" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加广告</a>
                                </span>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered dataTable">
                        <thead>
                        <tr>
                            <th><input type="checkbox" class="group-checkable" data-set=".checkboxes" id="checkAll" /></th>
                            <th>标题</th>
                            <th>广告位</th>
                            <th>图片</th>
                            <th>排序</th>
                            <th>状态</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach $list as $item}
                            <tr>
                                <td><input type="checkbox" class="checkboxes" value="{$item.id}" /></td>
                                <td>{$item.title}</td>
                                <td>{$item.space.name}</td>
                                <td><a href="{$item.picture.url}" target="_blank" class="thumbnail pull-left"><img src="{$item.picture.url}" style="height: 50px;"></a></td>
                                <td>{$item.sort}</td>
                                <td><span class="badge {if $item.status eq Advertise::STATUS_OPEN}badge-info{else}badge-important{/if} toggle-status" data-id="{$item.id}" data-status="{$item.status}" style="cursor: pointer;">{trans('notice.status.'|cat:$item.status)}</span></td>
                                <td>{$item.remark}</td>
                                <td>
                                    <a class="btn btn-sm btn-primary" href="{route('EditAdvertise',['id' => $item.id, 'space_id' => $smarty.get.space_id])}">编辑</a>
                                    <a class="btn btn-sm btn-danger remove-ad" data-id="{$item.id}">删除</a>
                                </td>
                            </tr>
                        {foreachelse}
                            <tr>
                                <td colspan="8" style="text-align: center;">暂时没有相关广告信息</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                    {if $list}
                        <div class="row-fluid">
                            {if $list->getTotal() > 0}
                                <div class="span6" style="margin-top: 10px;">
                                    <input type="checkbox" id="checkAll2"/> 全选
                                    <input type="button" id="multiRemove" class="btn btn-danger" value="批量删除"/>
                                    <div class="dataTables_info">显示 {$list->getFrom()} 到 {$list->getTo()} 项，共 {$list->getTotal()} 项。</div>
                                </div>
                            {/if}
                            <div class="span6">
                                <div class="dataTables_paginate">{$list->appends(['space_id' => $smarty.get.space_id])->links()}</div>
                            </div>
                        </div>
                    {/if}
                </div>
            </div>
            <!-- end recent orders portlet-->
        </div>
    </div>

{/block}



{block script}
<script type="text/javascript">
    //批量选中
    $("#checkAll,#checkAll2").click(function()
    {
        if ($(this).parent().hasClass('checked')) {
            $(".checkboxes").parent().removeClass('checked');
        } else {
            $(".checkboxes").parent().addClass('checked');
        }
    });


    $("#multiRemove").click(function() {
        var ad_id = new Array();
        $(".checkboxes").each(function() {
            if ($(this).parent().hasClass('checked')) {
                ad_id.push($(this).val());
            }
        });
        if (ad_id.length < 1) {
            return;
        }
        iconfirm('确认要删除这'+ad_id.length+'个广告吗？', function() {
            $.ajax({
                type:'POST',
                data: { advertise_id : ad_id },
                url: '{route("DeleteAdvertise")}',
                dataType: 'text',
                success:function(data) {
                    window.location.reload();
                }
            });
        });
    });

    $('.remove-ad').click(function() {
        var ad_id = $(this).attr('data-id');
        var obj = $(this);
        if (ad_id) {
            iconfirm('确认要删除此广告吗？', function() {
                $.ajax({
                    type:'POST',
                    data: { advertise_id: ad_id },
                    url: '{route("DeleteAdvertise")}',
                    dataType: 'text',
                    success:function(data) {
                        obj.closest('tr').remove();
                    }
                });
            });
        }
    });

    $(".toggle-status").click(function() {
        var ad_id = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        if (ad_id) {
            var title = '开启';
            if (status == '{Advertise::STATUS_OPEN}') {
                title = '关闭';
            }
            iconfirm('确认要'+title+'此广告吗？', function() {
                $.post('{route('ToggleAdvertiseStatus')}', { advertise_id : ad_id, status: status }, function(data) {
                    window.location.reload();
                }, 'text');
            });
        }
    });
</script>
{/block}