{extends file='layout/main.tpl'}

{block title}佣金报表{/block}

{block breadcrumb}
    <li>财务报表<span class="divider">&nbsp;</span></li>
    <li><a href="{route('ReportBrokerageList')}">佣金报表</a> <span class="divider">&nbsp;</span></li>
    <li>佣金明细<span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
                       
            <div class="widget">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i> 指店佣金明细</h4>
                </div>
                <div class="widget-body">
                    <table class="table table-striped table-bordered dataTable">
                        <thead>
                        <tr>
                            <th>交易号</th>
                            <th>订单号</th>
                            <th>下单时间</th>
                            <th>付款时间</th>
                            <th>宝贝名称</th>
                            <th>佣金(￥)</th>
                            <th>交易来源</th>
                            <th>交易对方</th>
                            <th>支付类型</th>
                            <th>备注</th>
                        </tr>
                        </thead>                        
                        <tbody>
                        {foreach $data as $item}
                            <tr class="odd gradeX" data-id="{$item.id}">
                                <td>{$item.order.out_trade_no}</td>
                                <td>{$item.order.id}</td>
                                <td>{$item.order.created_at|date_format:"%Y-%m-%d %H:%M:%S"}</td>
                                <td>{$item.order.payment_time|date_format:"%Y-%m-%d %H:%M:%S"}</td>
                                <td>{$item.goods_name|truncate:50}</td>                 
                                <td>{round_custom($item.price*$item.quantity*$item.brokerage_ratio/100)}</td>
                                <td>指帮连锁</td>   
                                <td>{$item.order.member.username}</td>    
                                <td>支付宝担保交易</td>  
                                <td>{$item.goods_sku}</td>   
                            </tr>
                        {foreachelse}
                            <tr>
                                <td colspan="11" style="text-align: center;">您暂时没有相关货款信息</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                    {if $data}
                    <div class="row-fluid">
                        <div class="span6" style="margin-top: 10px;">
                            <a href="javascript:void(0)" id="multiOutExcelAll" class="btn mini btn-primary" target="_blank">全部导出到Excel</a>
                            <div class="dataTables_info">显示 {$data->getFrom()} 到 {$data->getTo()} 项，共 {$data->getTotal()} 项。</div>
                        </div>
                        <div class="span6">
                            <div class="dataTables_paginate">{$data->appends(['end_month'=>$end_month,'vstore_id'=>$vstore_id])->links()}</div>
                        </div>
                    </div>
                    {/if}
                </div>
            </div>      
            <!-- END EXAMPLE TABLE widget-->
        </div>
    </div>
    <!-- END ADVANCED TABLE widget-->
{/block}

{block script}
<script type="text/javascript">
    $(function() {
        $('[name="end_month"]').datetimepicker({
            format: 'yyyy-mm',
            autoclose: true,
            startView:3,
            minView: 3,
            language: 'zh-CN',
    		endDate : "{$end_month}"
        });
    });
    //导出全部数据到Excel
    $("#multiOutExcelAll").click(function(){
    	var end_month="{$end_month}";
    	var vstore_id="{$vstore_id}";
    	$("#multiOutExcelAll").prop("href","{route('ReportVstoreBrokerageExcel')}?vstore_id="+vstore_id+"&end_month="+end_month);
    });
</script>
{/block}