{extends file='layout/main.tpl'}

{block title}公告列表{/block}

{block breadcrumb}
    <li>公告管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetNoticeList')}">公告列表</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">
            <!-- begin recent orders portlet-->
            <div class="widget">
                <div class="widget-body">
                    <div class="row-fluid">
                        <div class="span12">
                            <label>
                                <a href="{route('EditNotice')}" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加公告</a>
                            </label>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12 booking-search" style="padding-bottom:5px;">
                            <FORM action="{Route('GetNoticeList')}" method="get" id="category_form">
                                <div class="pull-left margin-right-20">
                                    <div class="controls">
                                        <input placeholder="关键字" class="input-large" name="title" value="{$smarty.get.title}" type="text">&nbsp;&nbsp;
                                        <span style="font-size: 14px">状态:</span>
                                        <select name="status"  style="width: 100px;">
                                            <option value="">全部</option>
                                            <option value="{Notice::STATUS_OPEN}" {if $smarty.get.status eq Notice::STATUS_OPEN}selected="selected" {/if}>开启</option>
                                            <option value="{Notice::STATUS_CLOSE}" {if $smarty.get.status eq Notice::STATUS_CLOSE}selected="selected" {/if}>关闭</option>
                                        </select>&nbsp;&nbsp;
                                    </div>
                                </div>
                                <div class="pull-left margin-right-20">
                                    <button class="btn btn-primary" type="submit"><i class="icon-search icon-white"></i> 查询</a></button>
                                </div>
                            </FORM>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered dataTable" id="notices_item_list">
                        <thead>
                        <tr>
                            <th><input type="checkbox" class="group-checkable" data-set="#notices_item_list .checkboxes" id="checkAll" /></th>
                            <th>公告标题</th>
                            <th>公告类型</th>
                            <th>状态</th>
                            <th>排序号</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyres">
                        {foreach $list as $item}
                            <tr class="odd gradeX">
                                <td><input type="checkbox" class="checkboxes" value="{$item.id}" /></td>
                                <td>{$item.title|truncate:60}</td>
                                <td>{trans('notice.kind.'|cat:$item.kind)}</td>
                                <td><span class="badge {if $item.status eq Notice::STATUS_OPEN}badge-info{else}badge-important{/if} toggle-status" data-id="{$item.id}" data-status="{$item.status}" style="cursor: pointer;">{trans('notice.status.'|cat:$item.status)}</span></td>
                                <td>{$item.sort_order}</td>
                                <td>
                                    <a class="btn btn-default" href="{route('EditNotice', ['notice_id' => $item.id])}"><i class="icon-edit"></i>编辑</a>
                                    <a class="btn btn-danger remove-notice" href="javascript:;" data-id="{$item.id}"><i class="icon-trash"></i>删除</a>
                                </td>
                            </tr>
                            {foreachelse}
                            <tr>
                                <td colspan="12" style="text-align: center;">暂时没有相关公告信息 ！</td>
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
                                <div class="dataTables_paginate">{$list->appends(['title' => $smarty.get.title, 'kind' => $smarty.get.kind,'status' => $smarty.get.status])->links()}</div>
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
    <script>
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
            var notice_id = new Array();
            $(".checkboxes").each(function() {
                if ($(this).parent().hasClass('checked')) {
                    notice_id.push($(this).val());
                }
            });
            if (notice_id.length < 1) {
                return;
            }
            iconfirm('确认要删除这'+notice_id.length+'个公告吗？', function() {
                $.ajax({
                    type:'POST',
                    data: { notice_id : notice_id },
                    url: '{action("NoticeController@postDeleteNotice")}',
                    dataType: 'text',
                    success:function(data) {
                        window.location.reload();
                    }
                });
            });
        });

        $('.remove-notice').click(function() {
            var notice_id = $(this).attr('data-id');
            var obj = $(this);
            if (notice_id) {
                iconfirm('确认要删除此公告吗？', function() {
                    $.ajax({
                        type:'POST',
                        data: { notice_id: notice_id },
                        url: '{action("NoticeController@postDeleteNotice")}',
                        dataType: 'text',
                        success:function(data) {
                            obj.closest('tr').remove();
                        }
                    });
                });
            }
        });

        $(".toggle-status").click(function() {
            var notice_id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            if (notice_id) {
                var title = '开启';
                if (status == '{Notice::STATUS_OPEN}') {
                    title = '关闭';
                }
                iconfirm('确认要'+title+'此公告吗？', function() {
                    $.post('{route('ToggleNoticeStatus')}', { notice_id : notice_id, status: status }, function(data) {
                        window.location.reload();
                    }, 'text');
                });
            }
        });

    </script>
{/block}
