{extends file='layout/main.tpl'}

{block title}订单统计{/block}

{block breadcrumb}
    <li>统计分析<span class="divider">&nbsp;</span></li>
    <li><a href="{route('ReportOrderList')}">订单统计</a> <span class="divider">&nbsp;</span></li>
    <li>订单列表<span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i> 订单列表</h4>
                </div>
                <div class="widget-body">
                	<table class="table table-striped table-bordered dataTable">
                        <thead>
                        <tr>
                            <th>订单号</th>
                            <th>成交时间</th>
                            <th>宝贝名称</th>
                            <th>成交数量</th>
                            <th>单价</th>
                            <th>实付款</th>
                            <th>收藏数</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        	{foreach $data as $goods}
                            <tr class="odd gradeX">
                                <td>{$goods.order.id}</td>
                                <td>{$goods.order.created_at|date_format:"%Y-%m-%d %H:%M:%S"}</td>
                                <td>{$goods.goods.name}</td>
                                <td>{$goods.quantity}</td>
                                <td>{$goods.goods.market_price}</td>
                                <td>{$goods.price}</td>
                                <td>{$goods.goods.favorite_count|default:0}</td>
                                {*<td><a href="{route('EnterpriseGoodsEdit', ['id' => $goods.goods.enterpriseGoods.id])}" class="btn mini btn-primary">查看商品</a></td>*}
                                <td><a href="{route('ViewOrderInfo',$goods.order.id)}" class="btn mini btn-primary">查看订单</a></td>
                            </tr>
                            {foreachelse}
                            <tr>
                                <td colspan="8" style="text-align: center;">没有相关订单详情信息</td>
                            </tr>
                            {/foreach}
                        </tbody>
                    </table>
                    {if $data}
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="dataTables_paginate">{$data->appends(['store_id'=>$store_id,'vstore_id'=>$vstore_id,'start_date'=>$start_date,'end_date'=>$end_date])->links()}</div>
                        </div>
                    </div>
                    {/if}
                </div>
            </div>
        </div>
    </div>
    <!-- END ADVANCED TABLE widget-->
{/block}