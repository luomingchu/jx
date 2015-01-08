{extends file='layout/main.tpl'}

{block title}商品类目{/block}

{block breadcrumb}
    <li>商品管理 <span class="divider">&nbsp;</span></li>
    <li><a href="">商品类目列表</a><span class="divider-last">&nbsp;</span></li>
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
                                <a href="javascript:;" id="addGoodsType" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加商品类目</a>
                            </label>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered dataTable" id="goods_item_list">
                        <thead>
                        <tr>
                            <th>商品类目名称</th>
                            <th>属性列表</th>
                            <th>属性数</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyres">
                        {foreach $list as $item}
                            <tr>
                                <td>{$item.name}</td>
                                <td>
                                    {foreach $item.GoodsTypeAttributes as $attr}
                                        {$attr->name}{if !$attr@last}，{/if}
                                    {/foreach}
                                </td>
                                <td>{$item.attr_count}</td>
                                <td><a href="javascript;" class="toggle-status badge {if $item->status eq GoodsType::STATUS_OPEN}badge-info{else}badge-important{/if}" data-id="{$item.id}" data-status="{$item->status}">{if $item->status eq GoodsType::STATUS_OPEN}开启{else}关闭{/if}</a> </td>
                                <td data-id="{$item.id}">
                                    <a href="{route('GetGoodsTypeAttributes', ['goods_type_id' => $item.id])}" class="btn btn-info">属性列表</a>
                                    <a href="javascript:;" class="btn btn-info editGoodsType">修改</a>
                                    <a href="javascript:;" class="btn btn-warning deleteGoodsType">删除</a>
                                </td>
                            </tr>
                        {foreachelse}
                            <tr><td colspan="5" style="text-align: center;">系统暂时没有相关商品类目信息</td></tr>
                        {/foreach}
                        </tbody>
                    </table>

                    <div class="span6">
                        <div class="dataTables_paginate">{$list->links()}</div>
                    </div>
                </div>
            </div>
            <!-- end recent orders portlet-->
        </div>
    </div>
{/block}

{block script}
<script type="text/javascript">
    $("#addGoodsType").click(function() {
        var html = '<form id="goods_type_form"><div class="control-group">' +
                '<label class="control-label">商品类型名称:</label>' +
                '<div class="controls">' +
                '<input type="text" placeholder="商品类型名称" name="name" class="text"/>' +
                '</div></div>' +
                '<div class="control-group"><label class="control-label">类目属性:</label>' +
                '<div class="controls"><textarea name="attributes" style="height: 120px;width: 450px;"></textarea><span class="help-inline">每行一个商品属性组。排序也将按照自然顺序排序。</span>' +
                '</div></div></form>';
        iconfirm(html, function() {
            if ($("#goods_type_form [name='name']").val() == '') {
                ialert('商品类目名称不能为空');
                return false;
            }
            if ($("#goods_type_form [name='attributes']").val() == '') {
                ialert('商品类目属性不能为空');
                return false;
            }
            $.post("{route('SaveGoodsType')}", $("#goods_type_form").serialize(), function(data) {
                window.location.reload();
            }, 'text');
        });
    });

    $(".deleteGoodsType").click(function() {
        var goods_type_id = $(this).parent().attr('data-id');
        var obj = $(this);
        if (goods_type_id) {
            iconfirm("您确认要删除此商品类目吗？", function() {
                $.post("{route('DeleteGoodsType')}", { goods_type_id : goods_type_id }, function(data) {
                    obj.closest('tr').remove();
                }, 'text');
            });
        }
    });

    $(".editGoodsType").click(function() {
        var goods_type_id = $(this).parent().attr('data-id');
        var name = $(this).closest('tr').find("td:first").text();
        var html = '<form id="edit_goods_type_form"><div class="control-group">' +
                '<label class="control-label">商品类型名称:</label>' +
                '<div class="controls">' +
                '<input type="text" placeholder="商品类型名称" name="name" class="text" value="'+name+'"/>' +
                '<input type="hidden" name="goods_type_id" value="'+goods_type_id+'"/> </div></div></form>';
        iconfirm(html, function() {
            if ($("#edit_goods_type_form [name='name']").val() == '') {
                ialert('商品类目名称不能为空');
                return false;
            }
            $.post("{route('SaveGoodsType')}", $("#edit_goods_type_form").serialize(), function(data) {
                window.location.reload();
            }, 'text');
        });
    });

    $(".toggle-status").click(function(e) {
        e.preventDefault();
        var goods_type_id = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        var obj = $(this);
        $.post("{route('ToggleGoodsType')}", { goods_type_id: goods_type_id, status: status }, function(data) {
            if (status == "{GoodsType::STATUS_OPEN}") {
                obj.text('关闭');
                obj.attr('data-status', "{GoodsType::STATUS_CLOSE}");
                obj.removeClass('badge-info').addClass('badge-important');
            } else {
                obj.text('开启');
                obj.attr('data-status', "{GoodsType::STATUS_OPEN}");
                obj.removeClass('badge-important').addClass('badge-info');
            }
        }, 'text');
    });
</script>
{/block}