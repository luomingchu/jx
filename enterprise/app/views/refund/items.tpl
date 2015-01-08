<table class="table table-bordered table-hover" id="refund_items">
    <thead>
    <tr>
        <th>退款编号</th>
        <th>订单编号</th>
        <th>宝贝名称</th>
        <th>买家名称</th>
        <th>收款账户类型</th>
        <th>收款账户</th>
        <th>退款金额</th>
        <th>申请时间</th>
        <th>退款状态</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    {foreach $list as $item}
    <tr>
        <td>{$item.id}</td>
        <td>{$item.order_id}</td>
        <td  style="min-width: 500px;">
            <img src="{$item.goods.pictures[0].url}&width=50&height=50" class="img-rounded" style="display:inline-block;width: 50px; height: 50px;margin-right: 10px;"/>
            <div style="display:inline-block;width: 400px;">
                {$item.goods_name}
                {if $item.goods_name != $item.goods.name}
                    （{$item.goods.name}）
                {/if}
                {if $item.store_activity}
                    <br/>
                    <span class="badge badge-important">{trans("order.activity."|cat:$item.store_activity.body_type)}</span> {$item.store_activity.title}
                {/if}
                <br/>
            </div>
        </td>
        <td>{$item.member.username}</td>
        {if $item.account_type eq 'Bankcard'}
            <td>银行卡</td>
            <td>{$item.account.number}</td>
        {else}
            <td>支付宝</td>
            <td>{$item.account.alipay_account}</td>
        {/if}
        <td>{$item.refund_amount}</td>
        <td>{$item.created_at}</td>
        <td>
            <span class="label {if $item.status eq Refund::STATUS_SUCCESS}label-success{else}label-important{/if}">{trans("refund.status."|cat:$item.status)}</span>
        </td>
        <td>
            <a href="{route('GetRefundInfo', ['refund_id' => $item.id])}" class="btn btn-info">查看</a>
            {if $item.status neq Refund::STATUS_SUCCESS}
                <a href="javascript:;" class="refund btn btn-primary agree_payment" {if $item.account_type eq 'Bankcard'} data-account_type="{$item.account.open_account_bank}" data-account_number="{$item.account.number}" {else} data-account_type="支付宝" data-account_number="{$item.account.alipay_account}" {/if} data-id="{$item.id}">退款</a>
            {/if}
        </td>
    </tr>
    {foreachelse}
    <tr>
        <td colspan="10" style="text-align: center;">
            <span id="message">暂时没有相关退款申请信息！</span>
        </td>
    </tr>
    {/foreach}
    </tbody>
</table>
<div style="text-align: right;" id="paginate">
    {if !empty($list)}
        {$list->links()}
    {/if}
</div>