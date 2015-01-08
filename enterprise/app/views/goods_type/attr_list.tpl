{extends file='layout/main.tpl'}

{block title}商品类目{/block}

{block breadcrumb}
<li>商品管理 <span class="divider">&nbsp;</span></li>
<li>商品设置<span class="divider">&nbsp;</span></li>
<li><a href="{route('GetGoodsTypeList')}">商品类目列表</a><span class="divider">&nbsp;</span></li>
<li><a href="{route('GetGoodsTypeAttributes', ['goods_type_id' => $smarty.get.goods_type_id])}">类目属性列表</a><span class="divider-last">&nbsp;</span></li>
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
                            商品类目：
                            <select id="goods_type">
                                {foreach $types as $type}
                                    <option value="{$type.id}" {if $type.id eq $smarty.get.goods_type_id}selected="selected" {/if}>{$type.name}</option>
                                {/foreach}
                            </select>
                            <a href="javascript:;" id="addAttr" style="position: relative;top: -5px;" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加属性</a>
                        </label>
                    </div>
                </div>
                <table class="table table-striped table-bordered dataTable" id="goods_item_list">
                    <thead>
                    <tr>
                        <th>属性名称</th>
                        <th>所属类目</th>
                        <th>排序号</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody id="tbodyres">
                        {foreach $list as $item}
                            <tr>
                                <td>{$item.name}</td>
                                <td>{$types->get($item.goods_type_id)->name}</td>
                                <td>{$item.sort_order}</td>
                                <td data-id="{$item.id}">
                                    <a href="javascript:;" class="btn btn-info btn-mini edit_attr">修改</a>
                                    <a href="javascript:;" class="btn btn-danger btn-mini delete_attr">删除</a>
                                </td>
                            </tr>
                            {foreachelse}
                            <tr>
                                <td colspan="4" style="text-align: ">没有相关类目属性信息</td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
        <!-- end recent orders portlet-->
    </div>
</div>
{/block}

{block script}
<script type="text/javascript">
    $("#goods_type").change(function() {
        window.location.href = "{route('GetGoodsTypeAttributes')}?goods_type_id="+$(this).val();
    });

    $("#addAttr").click(function() {
        var goods_type_id = $("#goods_type").val();
        var html = '<form id="attr_form"><div class="control-group">' +
                '<label class="control-label">属性名称:</label>' +
                '<div class="controls">' +
                '<input type="text" name="name" class="text"/>' +
                '</div></div>' +
                '<div class="control-group"><label class="control-label">排序号:</label>' +
                '<div class="controls"><input type="text" name="sort_order"/> ' +
                '<input type="hidden" name="goods_type_id" value="'+goods_type_id+'"/> </div></div></form>';
        iconfirm(html, function() {
            if ($("#attr_form [name='name']").val() == '') {
                ialert('商品类目属性名称不能为空');
                return false;
            }
            $.post("{route('SaveGoodsTypeAttribute')}", $("#attr_form").serialize(), function(data) {
                window.location.reload();
            }, 'text');
        });
    });

    $(".edit_attr").click(function() {
        var goods_type_id = $("#goods_type").val();
        var id = $(this).parent().attr('data-id');
        var name = $(this).closest('tr').find('td:nth-child(1)').text();
        var sort = $(this).closest('tr').find('td:nth-child(3)').text();
        var html = '<form id="attr_form"><div class="control-group">' +
                '<label class="control-label">属性名称:</label>' +
                '<div class="controls">' +
                '<input type="text" name="name" class="text" value="'+name+'"/>' +
                '</div></div>' +
                '<div class="control-group"><label class="control-label">排序号:</label>' +
                '<div class="controls"><input type="text" name="sort_order" value="'+sort+'"/> ' +
                '<input type="hidden" name="goods_type_id" value="'+goods_type_id+'"/><input type="hidden" name="goods_type_attribute_id" value="'+id+'"/> </div></div></form>';
        iconfirm(html, function() {
            if ($("#attr_form [name='name']").val() == '') {
                ialert('商品类目属性名称不能为空');
                return false;
            }
            $.post("{route('SaveGoodsTypeAttribute')}", $("#attr_form").serialize(), function(data) {
                window.location.reload();
            }, 'text');
        });
    });

    $(".delete_attr").click(function() {
        var id = $(this).parent().attr('data-id');
        var obj = $(this);
        if (id) {
            iconfirm('删除后，需重新配置对应类型下的商品库存！确认要删除此属性吗？', function() {
                $.post("{route('DeleteGoodsTypeAttribute')}", { goods_type_attribute_id: id }, function(data) {
                    obj.closest('tr').remove();
                }, 'text');
            });
        }
    });
</script>
{/block}