{extends file='layout/main.tpl'}

{block title}商品类目{/block}

{block breadcrumb}
    <li>商品管理 <span class="divider">&nbsp;</span></li>
    <li>商品设置<span class="divider">&nbsp;</span></li>
    <li><a href="">商品类目列表</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">
            <!-- begin recent orders portlet-->
            <div class="widget">
                <div class="widget-body">
                    <table class="table table-striped table-bordered dataTable" id="goods_item_list">
                        <thead>
                        <tr>
                            <th>商品类目名称</th>
                            <th>属性列表</th>
                            <th>属性数</th>
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
                                <td><a href="javascript;" class="toggle-status badge {if $item.enterpriseGoodsTypes}badge-info{else}badge-important{/if}" data-id="{$item.id}">{if $item.enterpriseGoodsTypes}取消使用{else}我要使用{/if}</a> </td>
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
    $(".toggle-status").click(function(e) {
        e.preventDefault();
        var goods_type_id = $(this).attr('data-id');
        var obj = $(this);
        $.post("{route('ToggleGoodsType')}", { goods_type_id: goods_type_id}, function(data) {
            if (data == "save-success") {
                obj.text('取消使用');
                obj.removeClass('badge-important').addClass('badge-info');
            } else {
                obj.text('我要使用');
                obj.removeClass('badge-info').addClass('badge-important');
            }
        }, 'text');
    });
</script>
{/block}