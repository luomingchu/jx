<table class="table table-bordered dataTable" id="order_item_list">
    <thead>
    <tr style="background: #E8E8E8;">
        <th><input type="checkbox" class="checkbox" id="checkAll"> 商品</th>
        <th style="width: 200px;">商品价格（元）</th>
        <th style="width: 120px;">实付款（元）</th>
        <th style="width: 100px;">佣金比</th>
        <th style="width: 120px;">佣金（元）</th>
        <th style="width: 120px;">结账状态</th>
        <th style="width: 120px;">操作</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        {foreach $list as $item}
    {if $item.order.id}
    <tr>
        <table class="table table-bordered order_item" id="order_{$item.order.id}" style="margin-top: 15px;">
            <tr style="background: #E8E8E8;">
                <td colspan="7">
                    <span><input type="checkbox" class="checkbox items" value="{$item.id}" {if $item.status eq Brokerage::STATUS_SETTLED}disabled="disabled" {/if}/>  销售指店：{$item.order.vstore.name}</span>
                    <span style="margin-left: 15px;">订单号：{$item.order.id}</span>
                    <span style="margin-left: 15px;">买家：{$item.order.member.username}</span>
                    <span style="margin-left: 15px;">电话：{$item.order.member.mobile}</span>
                    <span style="margin-left: 15px;">销售时间：{$item.order.created_at}</span>
                </td>
            </tr>
            {$i=0}
            {foreach $item.order.goods as $goods}
                <tr>
                    <td>
                        <img src="{$goods.goods.pictures[0].url}" class="img-rounded" style="float:left;width: 80px; height: 80px;margin-right: 10px;"/>
                        <div style="float: left;">
                            {$goods.goods.name} [{$goods.goods_sku}]
                            {if $order.pay_message}
                                <br/> 买家留言：{$order.pay_message}
                            {/if}
                        </div>
                    </td>
                    <td style="width: 200px;">{$goods.price} * {$goods.quantity} = {round($goods.price*$goods.quantity,2)}</td>
                    {if $i eq 0}
                        <td style="width: 120px;" rowspan="{count($item.order.goods)}">{$item.order.amount}</td>
                        <td style="width: 100px;" rowspan="{count($item.order.goods)}">{$item.ratio}%</td>
                        <td style="width: 120px;" rowspan="{count($item.order.goods)}">{round($item.order_amount * $item.ratio / 100, 2)}</td>
                        {if $item.status eq Brokerage::STATUS_UNSETTLED}
                        <td style="width: 120px;"  rowspan="{count($item.order.goods)}">
                            <span class="badge badge-important">未结算</span>
                        </td>
                        <td style="width: 120px;"  rowspan="{count($item.order.goods)}">
                            <a href="javascript:;" class="btn btn-primary settlement" data-id="{$item.id}">结算</a>
                        </td>
                        {else}
                            <td style="width: 120px;"  rowspan="{count($item.order.goods)}"><span class="badge badge-success">已结算</span><br/>{$item.settled_at}</td>
                            <td style="width: 120px;"  rowspan="{count($item.order.goods)}"></td>
                        {/if}
                    {/if}
                </tr>
                {$i=$i+1}
            {/foreach}
        </table>
    </tr>
    {/if}
        {foreachelse}
        <td colspan="8" style="text-align: center;">暂时没有相关佣金信息</td>
        {/foreach}
    </tr>
    </tbody>
</table>

<div style="margin-top: 8px;" id="paginate">
    <div>
        <span style="float: left;">
            <input type="checkbox" class="checkbox" id="checkAll2"/> 全选
            <button class="btn btn-primary" id="multiSettle">批量结算</button>
        </span>
        <span style="float: right;margin-right: 20px;"> 每页：<input type="text" style="width: 25px;" id="limit" value="{$smarty.get.limit|default:10}"/> 去第：<input type="text" style="width: 25px;" id="page" value="{$smarty.get.page|default:1}"/> 页 <input type="button" class="btn btn-primary btn-mini" id="jumpPage" value="GO"/></span>
    </div>
    <div style="text-align: right;margin-right: 10px;">
        {$list->appends(['status' => $smarty.get.status, 'vstore_id' => $smarty.get.vstore_id, 'store_id' => $smarty.get.store_id, 'start_time' => $smarty.get.start_time, 'end_time' => $smarty.get.end_time, 'limit' => $smarty.get.limit])->links()}
    </div>
</div>
<div style="clear: both;"></div>