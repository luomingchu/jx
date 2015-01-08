{extends file='layout/main.tpl'}

{block title}消息管理{/block}

{block breadcrumb}
    <li><a href="{route('GetHistoryMessage')}">消息管理</a> <span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">

            <!-- begin recent orders portlet-->
            <div class="widget">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i>消息列表</h4>
                    <span class="tools"></span> </div>
                <div class="widget-body">
                    <div id="DataView"></div>
                    <table class="table table-striped table-bordered" id="DataViewTable">
                        <thead>
                        <tr>
                            <th>内容</th>
                            <th>时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach $list as $message}
                            <tr>
                                <td>{$message->description}</td>
                                <td>{$message->created_at}</td>
                                <td>
                                    {if $message->read eq Message::READ_YES}
                                        <span class="badge badge-success">已读</span>
                                    {else}
                                        <span class="badge badge-important">未读</span>
                                    {/if}
                                </td>
                                <td>
                                    <a href="{route('GetRefundInfo', ['refund_id' => $message->body_id])}" class="btn btn-info">查看</a>
                                    <a href="javascript:;" data-id="{$message->id}" class="btn btn-danger deleteMessage">删除</a>
                                </td>
                            </tr>
                        {foreachelse}
                        <tr>
                            <td colspan="4" style="text-align: center">暂时没有相关消息</td>
                        </tr>
                        {/foreach}
                        </tbody>
                    </table>
                    <div id="Pagination">{if $list}{$list->links()}{/if}</div>
                </div>
            </div>
            <!-- end recent orders portlet-->
        </div>
    </div>
{/block}

{block script}
<script type="text/javascript">
    $(".deleteMessage").click(function() {
        var id = $(this).attr('data-id');
        var obj = $(this);
        if (id) {
            iconfirm("确认要删除吗？", function() {
                $.post('{route("DeleteMessage")}', { id : id }, function(data) {
                    obj.closest('tr').slideUp('slow');
                }, 'text');
            });
        }
    });
</script>
{/block}
