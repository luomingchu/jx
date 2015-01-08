<table class="table table-bordered table-advance table-hover">
    <thead>
    <tr>
        <th>商品名称</th>
        <th>货号</th>
        <th>市场价</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody id="goods_item_list">
    {foreach $goods_list as $item}
        <tr class="odd gradeX goods_item" data-id="{$item.id}" id="goods_item_{$item.id}" data-price="{$item.market_price}">
            <td>
                <img src="{$item.pictures[0].url}&width=30&height=30" style="width: 25px;float: left;margin-right: 10px;"/>
                {$item.name}
            </td>
            <td>{$item.number}</td>
            <td>{$item.market_price}</td>
            <td>
                <a href="javascript:;" class="btn choose btn-info" data-id="{$item.id}" >选择</a>
            </td>
        </tr>
        {foreachelse}
        <tr class="odd gradeX">
            <td colspan="4" style="text-align: center;" id="loading">没有相关商品！</td>
        </tr>
    {/foreach}
    </tbody>
</table>
<div style="padding-left: 8px;">
    <div style="float:right;">{$goods_list->links()}</div>
    <div style="clear: both"></div>
</div>