{extends file='layout/main.tpl'}

{block title}广告管理{/block}

{block breadcrumb}
    <li>活动管理<span class="divider">&nbsp;</span></li>
    <li>广告管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetAdvertiseSpaceList')}">广告位列表</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">
            <!-- begin recent orders portlet-->
            <div class="widget">
                <div class="widget-body">
                    {*<div class="row-fluid">
                        <div class="span12">
                            <label>
                                <a href="{route('EditAdvertiseSpace')}" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加广告位</a>
                            </label>
                        </div>
                    </div>*}
                    <table class="table table-striped table-bordered dataTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>名称</th>
                            <th>标识符</th>
                            <th>尺寸</th>
                            <th>容量</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach $list as $item}
                            <tr>
                                <td>{$item.id}</td>
                                <td>{$item.name}</td>
                                <td>{$item.key_code}</td>
                                <td>{$item.width} x {$item.height}</td>
                                <td>{if empty($item.limit)}无限制{else}{$item.limit}{/if}</td>
                                <td>{$item.remark}</td>
                                <td>
                                    <a class="btn btn-sm btn-primary" href="{route('EditAdvertiseSpace',$item.id)}">编辑</a>
                                    <a class="btn btn-sm btn-info" href="{route('GetAdvertiseList', ['space_id' => $item.id])}">广告列表</a>
                                    {*<a class="btn btn-sm btn-danger remove-ad" data-id="{$item.id}">删除</a>*}
                                </td>
                            </tr>
                        {foreachelse}
                            <tr>
                                <td colspan="7" style="text-align: center">暂时没有相关广告位信息！</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                    {if $list}
                        <div class="row-fluid">
                            {if $list->getTotal() > 0}
                                <div class="span6" style="margin-top: 10px;">
                                    <div class="dataTables_info">显示 {$list->getFrom()} 到 {$list->getTo()} 项，共 {$list->getTotal()} 项。</div>
                                </div>
                            {/if}
                            <div class="span6">
                                <div class="dataTables_paginate">{$list->links()}</div>
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
    $(".remove-ad").click(function() {
        var id = $(this).attr('data-id');
        var obj = $(this);
        if (id) {
            iconfirm('确认要删除此广告位吗？', function() {
                $.post('{route("DeleteAdvertiseSpace")}', { advertise_space_id : id }, function(data) {
                   obj.closest('tr').remove();
                }, 'text');
            });
        }
    });
</script>
{/block}