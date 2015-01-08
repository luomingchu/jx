{extends file='layout/main.tpl'}

{block title}订单管理{/block}

{block breadcrumb}
    <li>订单管理<span class="divider">&nbsp;</span></li>
    <li><a href="{action('OrderController@index')}">订单列表</a><span class="divider">&nbsp;</span></li>
    <li><a href="{route('ViewOrderInfo', ['order_id' => $info.id])}">订单详情</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">
            <!-- begin recent orders portlet-->
            <div class="widget">
                <div class="widget-title">
                    <h4>
                        <i class="icon-reorder"></i> 订单信息
                    </h4>
                    <span class="tools"> <a href="javascript:;" class="icon-chevron-down"></a> </span>
                </div>
                <div class="widget-body">
                    <div class="row-fluid">
                        <div style="margin-bottom: 20px;color: #000;">
                            <span style="margin-right: 15px;">订单编号：{$info.id}</span>
                            <span style="margin-right: 15px;">下单时间：{$info.created_at}</span>
                            <span style="margin-right: 15px;">支付宝交易号：{$info.out_trade_no|default:"-"}</span>
                            <span style="margin-right: 15px;">支付时间：{$info.payment_time|default:"-"}</span>
                        </div>
                        {if !empty($order.delivery_time)}
                        <div style="margin-bottom: 20px;color: #000;">
                            <span style="margin-right: 15px;">物流公司：{$info.order_address.express_name}</span>
                            <span style="margin-right: 15px;">物流单号：{$info.order_address.express_number}</span>
                            <span style="margin-right: 15px;">发货时间：{$info.delivery_time}</span>
                        </div>
                        {/if}
                        <div>
                            <table class="table table-bordered dataTable" id="order_item_list">
                                <thead>
                                <tr style="background: #E8E8E8;">
                                    <th><span style="margin-left: 15px;">商品</span></th>
                                    <th style="width: 100px;">单价（元）</th>
                                    <th style="width: 100px;">数量</th>
                                    <th style="width: 120px;">实付款（元）</th>
                                    <th style="width: 150px;">交易状态</th>
                                    <th style="width: 200px;">评价</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <table class="table table-bordered order_item" id="order_{$order.id}" style="margin-top: 15px;">
                                        {foreach $info.goods as $goods}
                                            <tr>
                                                <td>
                                                    <img src="{$goods.goods.pictures[0].url}" class="img-rounded" style="float:left;width: 80px; height: 80px;margin-right: 10px;"/>
                                                    <div style="float: left;">
                                                        {$goods.goods_name}
                                                        {if $goods.goods_name != $goods.goods.name}
                                                            （{$goods.goods.name}）
                                                        {/if}
                                                        {if $goods.store_activity}
                                                            <br/>
                                                            <span class="badge badge-important">{trans("order.activity."|cat:$goods.store_activity.body_type)}</span> {$goods.store_activity.title}
                                                        {/if}
                                                        {if $order.pay_message}
                                                            <br/> 买家留言：{$order.pay_message}
                                                        {/if}
                                                    </div>
                                                </td>
                                                <td style="width: 100px;">{$goods.price}</td>
                                                <td style="width: 100px;">{$goods.quantity}</td>
                                                <td style="width: 120px;">{substr(round($goods.price*$goods.quantity, 2), 0, strpos(round($goods.price*$goods.quantity, 2), '.')+3)}</td>
                                                {if $goods@first}
                                                    <td style="width:150px;text-align:center;vertical-align:middle;" rowspan="{count($info.goods)}">
                                                        <div style="margin-bottom: 5px;">{$info.amount}元{if !empty($info.use_coin)}<br/>（抵用指币{$info.use_coin}个）{/if}</div>
                                                            <span class="label {strip}
                                                        {if $order.status eq Order::STATUS_PENDING_PAYMENT}
                                                            label-info
                                                        {elseif $order.status eq Order::STATUS_PREPARING_FOR_SHIPMENT or $order.status eq Order::STATUS_PROCESSING}
                                                            label-warning
                                                        {elseif $order.status eq Order::STATUS_SHIPPED or $order.status eq Order::STATUS_READY_FOR_PICKUP}
                                                            label-success
                                                        {else}
                                                            label-danger
                                                        {/if}
                                                            {/strip}">{trans('order.status.'|cat:$info.status)}</span>
                                                                {if $order.status eq Order::STATUS_FINISH}
                                                                    <br/>
                                                                    {if $order.commented eq Order::COMMENTED_YES}
                                                                        已评价
                                                                    {else}
                                                                        未评价
                                                                    {/if}
                                                                {/if}
                                                    </td>
                                                {/if}
                                                <td style="width:200px;">
                                                    {if $goods.comment}
                                                    <span class="comment">买家：{foreach range(1, $goods.comment.evaluation) as $evaluation}<i class="icon-star" style="color: red;"></i>{/foreach} {if $goods.comment.content}{$goods.comment.content}{/if}</span>
                                                        {if count($goods.comment.reply) > 0}
                                                        <div style="margin-top: 5px;">回复：
                                                            {foreach $goods.comment.reply as $reply}
                                                                <div style="border-bottom: 1px dashed #ccc;margin-bottom: 5px;padding-bottom: 2px;">{$reply.content} {$reply.created_at}</div>
                                                            {/foreach}
                                                        </div>
                                                        {/if}
                                                    {else}
                                                        买家暂无评价
                                                    {/if}
                                                </td>
                                            </tr>
                                        {/foreach}
                                    </table>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget">
                <div class="widget-title">
                    <h4>
                        <i class="icon-reorder"></i> 买家信息
                    </h4>
                    <span class="tools"> <a href="javascript:;" class="icon-chevron-down"></a> </span>
                </div>
                <div class="widget-body">
                    <div class="row-fluid" style="color: #000;">
                        <div style="margin-bottom: 8px;">买家：{$info.member.username}{if $info.member.real_name}（{$info.member.real_name}）{/if}</div>
                        <div style="margin-bottom: 8px;">收货地址：{$info.order_address.consignee} ，{$info.order_address.mobile}，{$info.order_address.region_name} {$info.order_address.address}，{$info.order_address.zipcode}</div>
                        <div style="margin-bottom: 8px;">买家留言：{$info.remark_buyer}</div>
                    </div>
                </div>
            </div>
            <div class="widget">
                <div class="widget-title">
                    <h4>
                        <i class="icon-reorder"></i> 卖家信息
                    </h4>
                    <span class="tools"> <a href="javascript:;" class="icon-chevron-down"></a> </span>
                </div>
                <div class="widget-body">
                    <div class="row-fluid" style="color: #000;">
                        <div style="margin-bottom: 8px;">发货门店：{$info.store.name} 联系电话：{$info.store.phone}</div>
                        <div style="margin-bottom: 8px;">销售指店：{$info.vstore.name}</div>
                    </div>
                </div>
            </div>
            <!-- end recent orders portlet-->
        </div>
    </div>
{/block}