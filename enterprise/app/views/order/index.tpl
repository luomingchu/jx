{extends file='layout/main.tpl'}

{block title}
{if $smarty.get.status eq Order::STATUS_PREPARING_FOR_SHIPMENT}
发货订单
{else}
订单列表
{/if}
{/block}

{block breadcrumb}
    <li>订单管理<span class="divider">&nbsp;</span></li>
    {if $smarty.get.status eq Order::STATUS_PREPARING_FOR_SHIPMENT}
    <li><a href="{route('WaitForShipmentOrderList',['status'=>Order::STATUS_PREPARING_FOR_SHIPMENT])}">待发货订单列表</a><span class="divider-last">&nbsp;</span></li>
    {else}
    <li><a href="{action('OrderController@index')}">订单列表</a><span class="divider-last">&nbsp;</span></li>
    {/if}
    
{/block}

{block main}
<div class="row-fluid">
    <div class="span12">
        <!-- begin recent orders portlet-->
        <div class="widget">
            <div class="widget-title">
                <h4>
                    <i class="icon-reorder"></i> 商品列表
                </h4>
                <span class="tools"> <a href="javascript:;" class="icon-chevron-down"></a> </span>
            </div>
            <div class="widget-body">
                <div class="row-fluid">
                    <div class="span12 booking-search" style="padding-bottom:5px;">
                        <FORM method="get" id="order_form">
                            <div class="pull-left margin-right-20" style="width: 100%">
                                <div class="controls" >
                                    <div>
                                        <span style="font-size: 14px;margin-left: 8px;">订单号：</span>
                                        <input placeholder="订单号精确搜索" class="input" name="id" value="{$smarty.get.id}" type="text" style="width: 130px;">
                                        <span style="font-size: 14px;margin-left: 8px;">宝贝名称：</span>
                                        <input placeholder="宝贝名称" class="input" name="goods_name" value="{$smarty.get.goods_name}" type="text" style="width: 130px;">
                                        <span style="font-size: 14px;margin-left: 8px;">收件人：</span>
                                        <input placeholder="收件人" class="input" name="username" value="{$smarty.get.username}" type="text" style="width: 100px;">
                                        <span style="font-size: 14px;margin-left: 8px;">成交时间：</span>
                                        <input type="text" class="input span1" name="start_datetime" value="{$smarty.get.start_datetime}" readonly="readonly"/> -
                                        <input type="text" class="input span1" name="end_datetime" value="{$smarty.get.end_datetime}" readonly="readonly"/>
                                    </div>
                                    <div>
                                        <span style="font-size: 14px;margin-left: 8px;">交易状态：</span>
                                        <select name="status">
                                            <option value="">全部</option>
                                            {foreach [
                                            Order::STATUS_PENDING_PAYMENT,
                                            Order::STATUS_CANCEL,
                                            Order::STATUS_PREPARING_FOR_SHIPMENT,
                                            Order::STATUS_SHIPPED,
                                            Order::STATUS_PROCESSING,
                                            Order::STATUS_READY_FOR_PICKUP,
                                            Order::STATUS_FINISH,
                                            'Uncomment'
                                            ] as $item}
                                                <option value="{$item}" {if $smarty.get.status eq $item}selected="selected"{/if}>{trans('order.status.'|cat:$item)}</option>
                                            {/foreach}
                                        </select>
                                        
                                        <span style="font-size: 14px;margin-left: 8px;">销售区域：</span>
                                    	<select name="group_id[]" class="sub_category" >
						                    <option value="">全部</option>
						                    {foreach $groups as $group}
						                        <option value="{$group.id}" {if $first_group_id eq $group.id}selected="selected"{/if}>{$group.name}</option>
						                    {/foreach}
					                	</select>
                                        
                                        
                                    </div>
                                    
                                    <div>
                                    	<span style="font-size: 14px;margin-left: 8px;">销售门店：</span>
                                        <select name="store" id="store">
                                            <option value="">全部</option>
                                            {foreach $store_list as $store}
                                                <option value="{$store.id}" {if $smarty.get.store eq $store.id}selected="selected" {/if}>{$store.name}</option>
                                            {/foreach}
                                        </select>
                                        <span style="font-size: 14px;margin-left: 8px;">销售指店：</span>
                                        <select name="vstore" id="vstore">
                                            <option value="">全部</option>
                                            {foreach $vstore_list as $vstore}
                                                <option value="{$vstore.id}" {if $vstore.id eq $smarty.get.vstore}selected="selected" {/if}>{$vstore.name}</option>
                                            {/foreach}
                                        </select>
                                        <input type="submit" class="btn btn-primary" value="查 询" id="searchOrder" style="position: relative;top: -5px;"/>
					                </div>
					                                                    
                                </div>
                            </div>
                        </FORM>
                    </div>
                </div>
                <table class="table table-bordered dataTable" id="order_item_list">
                    <thead>
                    <tr style="background: #E8E8E8;">
                        <th style="text-align: center;min-width: 500px;">宝贝</th>
                        <th style="width: 100px;min-width: 50px;">单价（元）</th>
                        <th style="width: 100px;min-width: 30px;">数量</th>
                        <th style="width: 120px;min-width: 40px;">实付款（元）</th>
                        <th style="width: 100px;min-width: 40px;">佣金（元）</th>
                        <th style="width: 150px;min-width: 50px;">交易状态</th>
                        <th style="width: 150px;min-width: 100px;">交易操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach $list as $order}
                        <tr>
                            <table class="table table-bordered order_item" id="order_{$order.id}" style="margin-top: 15px;">
                                <tr style="background: #E8E8E8;">
                                    <td colspan="7">
                                        {*$order.created_at*}
                                        <span style="margin-left: 15px;">订单号：{$order.id}</span>
                                        <span style="margin-left: 15px;">收货人：{$order.orderAddress.consignee}</span>
                                        <span style="margin-left: 15px;">电话：{$order.orderAddress.mobile}</span>
                                        <span style="margin-left: 15px;">销售指店：{$order.vstore.name}</span>
                                        <span class="badge badge-info">{trans("order.delivery."|cat:$order.delivery)}</span>
                                    </td>
                                </tr>
                                {$i=0}
                                {foreach $order.goods as $goods}
                                    <tr>
                                        <td style="min-width: 500px;">
                                            <img src="{$goods.goods.pictures[0].url}" class="img-rounded" style="display:inline-block;width: 80px; height: 80px;margin-right: 10px;"/>
                                            <div style="display:inline-block;width: 400px;">
                                                {$goods.goods_name}
                                                {if $goods.goods_name != $goods.goods.name}
                                                （{$goods.goods.name}）
                                                {/if}
                                                {if $goods.store_activity}
                                                <br/>
                                                <span class="badge badge-important">{trans("order.activity."|cat:$goods.store_activity.body_type)}</span> {$goods.store_activity.title}
                                                {/if}
                                                <br/>
                                                <span class="label label-warning label-mini" style="margin: 5px 0;font-weight: 100;">商品佣金：{$goods.brokerage_ratio|default:0}%</span>
                                                {if $goods.level_brokerage_ratio > 0}<span class="label label-warning label-mini" style="margin: 5px 0;font-weight: 100;">指店等级佣金：{$goods.level_brokerage_ratio|default:0}%</span>{/if}
                                                {if $order.pay_message}
                                                    <br/> 买家留言：{$order.pay_message}
                                                {/if}
                                                {if $goods.refund}
                                                <br/> <span class="label label-important label-mini">{trans("refund.status."|cat:$goods.refund.type|cat:"."|cat:$goods.refund.status)}<span>
                                                {/if}
                                            </div>
                                        </td>
                                        <td style="width: 100px;min-width: 50px;">{$goods.price}</td>
                                        <td style="width: 100px;min-width: 30px;">{$goods.quantity}</td>
                                        <td style="width: 120px;min-width: 40px;">{substr(round($goods.price*$goods.quantity, 2), 0, strpos(round($goods.price*$goods.quantity, 2), '.')+3)}</td>
                                        {if $goods@first}
                                            <td style="width: 100px;min-width:40px;text-align:center;vertical-align:middle;" rowspan="{count($order.goods)}">{if $order.status eq Order::STATUS_FINISH}{$order.brokerage}{else}0{/if} <span class="badge brokerage_help" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="佣金=订单商品单价 X 购买数量 X (商品佣金比率 X （1 + 指店等级佣金比率))">？</span></td>
                                            <td style="width:150px;min-width:50px;text-align:center;vertical-align:middle;" rowspan="{count($order.goods)}">
                                                <div style="margin-bottom: 5px;">{round_custom($order.amount-$order.use_coin/100, 2)}元{if !empty($order.use_coin)}<br/>（抵用指币{$order.use_coin}个）{/if}</div>
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
                                            	{/strip}">{trans('order.status.'|cat:$order.status)}</span>
                                                {if $order.status eq Order::STATUS_FINISH}
                                                    <br/>
                                                    {if $order.commented eq Order::COMMENTED_YES}
                                                        已评价
                                                    {else}
                                                        未评价
                                                    {/if}
                                                {/if}
                                            </td>
                                            <td style="width:150px;min-width:100px;text-align:center;vertical-align:middle;" rowspan="{count($order.goods)}" data-id="{$order.id}">
                                                <a href="{route('ViewOrderInfo', ['order_id' => $order.id])}" target="_blank" class="btn btn-info">订单详情</a>
                                            </td>
                                        {/if}
                                    </tr>
                                {/foreach}
                            </table>
                        </tr>
                        {foreachelse}
                        <tr>
                            <td colspan="7" style="text-align: center;">暂时没有相关订单信息</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>

                <div class="row-fluid">
                    {if !empty($list) && !$list->isEmpty()}
                        <div class="span6">
                            <div class="dataTables_paginate">{$list->links()}</div>
                        </div>
                    {/if}
                </div>
            </div>
        </div>
        <!-- end recent orders portlet-->
    </div>
</div>

{/block}

{block script}
<script type="text/javascript">
    $(function() {
        $('[name="start_datetime"],[name="end_datetime"]').datetimepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            minView: 2,
            language: 'zh-CN'
        });

        $("#store").change(function() {
            var store_id = $(this).val();
            $("#vstore option:not(:first)").remove();
            getVstoreList();
        });

        getVstoreList();
    });

    function getVstoreList() {
        var store_id = $("#store").val();
        if (store_id) {
            $.get("{route('GetVstoreList')}", { store_id : store_id }, function(data) {
                var html = "";
                var vstore = "{$smarty.get.vstore}";
                for (var i in data) {
                    var selected = "";
                    if (vstore == data[i]['id']) {
                        selected = "selected='selected'";
                    }
                    html += "<option value='"+data[i]['id']+"' "+selected+">"+data[i]['name']+"</option>";
                }
                $("#vstore").append(html);
            } );
        }
    }
    
    
    $(document).on('change', "[name='group_id[]']", function() {
        var group_id = $(this).val();
        var obj = $(this);
        obj.nextAll().remove();
        if (group_id != '') {
            $.getJSON("{route("GetSubGroups")}", { group_id: group_id }, function (data) {
                if (data.length > 0) {
                    var select = '<select class="sub_category" name="group_id[]"><option value="">--请选择--</option>';
                    $(data).each(function (i, e) {
                        select += "<option value='" + e.id + "'>" + e.name + "</option> ";
                    });
                    select += "</select>";
                    obj.parent().append(select);
                }
            });
        }
    });

    $('.brokerage_help').tooltip();
</script>
{/block}
