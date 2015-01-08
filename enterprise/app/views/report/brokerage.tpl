{extends file='layout/main.tpl'}

{block title}佣金报表{/block}

{block breadcrumb}
    <li>财务报表<span class="divider">&nbsp;</span></li>
    <li><a href="{route('ReportBrokerageList')}">佣金报表</a> <span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
                       
            <div class="widget">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i> 指店佣金报表</h4>
                </div>
                <div class="widget-body">
                	<div class="row-fluid">
						<div class="span12 booking-search" style="padding-bottom:5px;">
						<FORM action="{Route('ReportBrokerageList')}" method="get">
							<div class="pull-left margin-right-20">
								<div class="controls">
									<span style="font-size: 14px">月份:</span>
									<input type="text" class="input" name="end_month" value="{$smarty.get.end_month}" readonly="readonly"/>
									<span style="font-size: 14px;margin-left: 8px;">结算状态:</span>
									<select name="status">
                                        <option value="All">全部</option>
                                        <OPTION value="ed" {if $smarty.get.status eq 1}selected{/if}>已结算</OPTION>
                                        <OPTION value="un" {if $smarty.get.status eq 0}selected{/if}>未结算</OPTION>
									</select>
									<span style="font-size: 14px;margin-left: 8px;">每页数量:</span>
									<input type="text" class="input" name="limit" value="{$smarty.get.limit|default:15}" />
								</div>
							</div>
							<div class="pull-left margin-right-20">
                                <button class="btn btn-primary" type="submit"><i class="icon-search icon-white"></i> 查询</a></button>
                            </div>
						</FORM>
						</div>
					</div>
					<div class="row-fluid">
						<span>合计金额：￥{$total_brokerage}</span>
					</div>
                    <table class="table table-striped table-bordered dataTable">
                        <thead>
                        <tr>
                        	<th></th>
                            <th>序号</th>
                            <th>指店名称</th>
                            <th>店主名称</th>
                            <th>所属门店</th>
                            <th>开户户主姓名</th>
                            <th>开户行</th>
                            <th>银行帐号</th>
                            <th>佣金金额(￥)</th>
                            <th>是否已结算</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach $data as $k=>$item}
                        	{assign "vstore_id" $item.id}
                        	{foreach $item.member.bankcards as $bankcard}
                        		{if $bankcard.is_default eq Bankcard::ISDEFAULT}
                        			{assign "bankcard_real_name" $bankcard.real_name}
                        			{assign "bank_name" $bankcard.bank.name}
                        			{assign "bankcard_number" $bankcard.number}
								{/if}                    		
                        	{/foreach}
                        	{assign "yj" "0"}
                        	{assign "js" "0"}
                        	{foreach $item.orders as $order}
                        		{if $order->status eq Order::STATUS_FINISH && $order->finish_time|truncate:7:"" eq $end_month}
                        			{assign "yj" $yj+$order.brokerage}
                        			{if $order->brokerage_settlement_id gt 0}{assign "js" "1"}{/if}
                        		{/if}
                        	{/foreach}
                            <tr class="odd gradeX" data-id="{$item.id}">
                            	<td style="width: 20px;"><input type="checkbox" class="checkboxes" value="{$item.id}" /></td>
                                <td>{$k+1}</td>
                                <td>{$item.name}</td>
                                <td>{$item.member.real_name|default:$item.member.username}</td>                 
                                <td>{$item.store.name}</td>
                                <td>{$bankcard_real_name}</td>   
                                <td>{$bank_name}</td>    
                                <td>{$bankcard_number}</td>  
                                <td>{round_custom($yj)}</td>   
                                <td>{if $js eq "1"}已结算{else}未结算{/if}</td>   
                                <td><a href="{route('ReportBrokerageDetail', ['vstore_id' => $item.id,'end_month'=>$end_month])}" class="btn mini btn-primary">查看明细</a></td>   
                            </tr>
                        {foreachelse}
                            <tr>
                                <td colspan="11" style="text-align: center;">暂时没有相关指店佣金信息</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                    {if $data}
                    <div class="row-fluid">
                    	{if $data->getTotal() > 0}
                        <div class="span8" style="margin-top: 10px;">
                        	<input type="checkbox" id="checkAll"/> 全选
                            <a href="javascript:void(0)" id="multiOutExcel" class="btn mini btn-success" target="_blank">导出到Excel</a>
                            <a href="javascript:void(0)" id="multiOutExcelAll" class="btn mini btn-primary" target="_blank">全部导出到Excel</a>
                            <button class="btn btn-success" onclick="brokerageSettlement()"> 结算</button>
                            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#BrokerageSettlementModal" role="button"> 全部结算</a>
                            <a href="javascript:void(0)" id="multiOutBankExcel" class="btn mini btn-success" target="_blank">导出为银行报表</a>
                            <a href="javascript:void(0)" id="multiOutBankExcelAll" class="btn mini btn-primary" target="_blank">全部导出为银行报表[最多1000行记录]</a>
                            <div class="dataTables_info">显示 {$data->getFrom()} 到 {$data->getTo()} 项，共 {$data->getTotal()} 项。</div>
                        </div>
                        {/if}
                        <div class="span4">
                            <div class="dataTables_paginate">{$data->appends(['end_month'=>$end_month,'limit'=>$limit])->links()}</div>
                        </div>
                    </div>
                    {/if}
                </div>
            </div>      
            <!-- END EXAMPLE TABLE widget-->
        </div>
    </div>
    <!-- END ADVANCED TABLE widget-->
    
<div class="modal fade" id="BrokerageSettlementModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">结算确认</h4>
      </div>
      <FORM method="post" action="{route('BrokerageSettlement')}">
		<div class="modal-body">
      		<input type="hidden" name="vstore_ids" id="vstore_ids" value="" />
   			<input type="hidden" name="end_month" value="{$end_month}" />
        	<h3>结算备注<small></small></h3>
	        <div>
	        	<textarea name="remark" style="width:90%" rows="3" placeholder="在此可填写银行结算佣金的流水号等"></textarea>
	        </div>
      	</div>
      	<div class="modal-footer">
      		<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	        <button type="submit" class="btn btn-primary">保存</button>
      	</div>
      </form>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<!-- /.modal -->
{/block}

{block script}
<script type="text/javascript">
//月份选择
$(function() {
    $('[name="end_month"]').datetimepicker({
        format: 'yyyy-mm',
        autoclose: true,
        startView:3,
        minView: 3,
        language: 'zh-CN',
		endDate : "{$max_month}"
    });
});

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
	var vstore_ids = new Array();
	var end_month="{$end_month}";
	var status="{$status}";
	$(".checkboxes").each(function() {
        if ($(this).parent().hasClass('checked')) {
        	vstore_ids.push($(this).val());
        }
    });
	if (vstore_ids.length < 1) {
		$("#multiOutExcel").prop("target","_self");
        return;
    }
	$("#multiOutExcel").prop("href","{route('OutExcelForVstoreBrokerageSome')}?vstore_ids="+vstore_ids+"&end_month="+end_month+"&status="+status);
});

//导出全部数据到Excel
$("#multiOutExcelAll").click(function(){
	var end_month="{$end_month}";
	var status="{$status}";
	$("#multiOutExcelAll").prop("href","{route('OutExcelForVstoreBrokerageAll')}?end_month="+end_month+"&status="+status);
});

//导出选中的行数到银行报表
$("#multiOutBankExcel").click(function() {
	var vstore_ids = new Array();
	var end_month="{$end_month}";
	var status="{$status}";
	$(".checkboxes").each(function() {
        if ($(this).parent().hasClass('checked')) {
        	vstore_ids.push($(this).val());
        }
    });
	if (vstore_ids.length < 1) {
		$("#multiOutBankExcel").prop("target","_self");
        return;
    }
	$("#multiOutBankExcel").prop("href","{route('OutExcelToBankSome')}?vstore_ids="+vstore_ids+"&end_month="+end_month+"&status="+status);
});

//导出全部数据为银行报表
$("#multiOutBankExcelAll").click(function(){
	var end_month="{$end_month}";
	var status="{$status}";
	$("#multiOutBankExcelAll").prop("href","{route('OutExcelToBankAll')}?end_month="+end_month+"&status="+status);
});

function brokerageSettlement(){
	var vstore_ids = new Array();
	$(".checkboxes").each(function() {
        if ($(this).parent().hasClass('checked')) {
        	vstore_ids.push($(this).val());
        }
    });
	if (vstore_ids.length < 1) {
        return;
    }
	$("#vstore_ids").val(vstore_ids);
	$('#BrokerageSettlementModal').modal();
}
</script>
{/block}