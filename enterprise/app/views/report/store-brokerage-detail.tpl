{extends file='layout/main.tpl'}

{block title}货款报表{/block}

{block breadcrumb}
	<li>财务报表<span class="divider">&nbsp;</span></li>
    <li><a href="{route('ReportStoreBrokerageList')}">货款报表</a> <span class="divider">&nbsp;</span></li>
    <li>货款明细<span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i> 门店货款明细</h4>
                </div>
                <div class="widget-body">
                	<table class="table table-striped table-bordered dataTable">
                        <thead>
                        <tr>
                            <th></th>
                            <th>交易号</th>
                            <th>订单号</th>
                            <th>下单时间</th>
                            <th>付款时间</th>
                            <th>宝贝名称</th>
                            <th>实付款</th>
                            <th>交易来源</th>
                            <th>交易对方</th>
                            <th>支付类型</th>
                            <th>备注</th>
                        </tr>
                        </thead>
                        <tbody>
                        	{foreach $data as $goods}
                            <tr class="odd gradeX">
                            	<td style="width: 20px;"><input type="checkbox" class="checkboxes" value="{$goods.id}" /></td>
                                <td>{$goods.order.out_trade_no}</td>
                                <td>{$goods.order.id}</td>
                                <td>{$goods.order.created_at|date_format:"%Y-%m-%d %H:%M:%S"}</td>
                                <td>{$goods.order.payment_time|date_format:"%Y-%m-%d %H:%M:%S"}</td>
                                <td>{$goods.goods_name}</td>
                                <td>{round_custom($goods.price*$goods.quantity)}</td>
                                <td>{$platform_name}</td>
                                <td>{$goods.order.member.username}</td>
                                <td>{$trade_source}</td>
                                <td>{$goods.goods_sku}</td>
                            </tr>
                            {foreachelse}
                            <tr>
                                <td colspan="9" style="text-align: center;">没有相关订单详情信息</td>
                            </tr>
                            {/foreach}
                        </tbody>
                    </table>
                    {if $data}
                    <div class="row-fluid">
                    	{if $data->getTotal() > 0}
                        <div class="span6" style="margin-top: 10px;">
                        	<input type="checkbox" id="checkAll"/> 全选
                            <a href="javascript:void(0)" id="multiOutExcel" class="btn mini btn-success" target="_blank">导出到Excel</a>
                            <a href="javascript:void(0)" id="multiOutExcelAll" class="btn mini btn-primary" target="_blank">全部导出到Excel</a>
                            <div class="dataTables_info">显示 {$data->getFrom()} 到 {$data->getTo()} 项，共 {$data->getTotal()} 项。</div>
                        </div>
                        {/if}
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

{block script}
<script>
//批量选中
$("#checkAll").click(function()
{
    if ($(this).parent().hasClass('checked')) {
        $(".checkboxes").parent().removeClass('checked');
    } else {
        $(".checkboxes").parent().addClass('checked');
    }
});

//导出选中的行数到excel
$("#multiOutExcel").click(function() {
	var order_goods_id = new Array();
	var start_date="{$start_date}";
	var end_date="{$end_date}";
	var store_id="{$store_id}";
	$(".checkboxes").each(function() {
        if ($(this).parent().hasClass('checked')) {
        	order_goods_id.push($(this).val());
        }
    });
	if (order_goods_id.length < 1) {
        return;
    }
	$("#multiOutExcel").prop("href","{route('ReportStoreBrokerageExcel2')}?order_goods_id="+order_goods_id+"&start_date="+start_date+"&end_date="+end_date+"&store_id="+store_id);
});

//导出全部数据到Excel
$("#multiOutExcelAll").click(function(){
	var start_date="{$start_date}";
	var end_date="{$end_date}";
	var store_id="{$store_id}";
	$("#multiOutExcelAll").prop("href","{route('ReportStoreBrokerageExcel')}?store_id="+store_id+"&start_date="+start_date+"&end_date="+end_date);
});
</script>
{/block}