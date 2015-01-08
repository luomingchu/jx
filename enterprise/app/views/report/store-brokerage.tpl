{extends file='layout/main.tpl'}

{block title}货款报表{/block}

{block breadcrumb}
    <li>财务报表<span class="divider">&nbsp;</span></li>
    <li><a href="{route('ReportStoreBrokerageList')}">货款报表</a> <span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
                       
            <div class="widget">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i> 门店货款统计</h4>
                </div>
                <div class="widget-body">
                	<div class="row-fluid">
						<div class="span12 booking-search" style="padding-bottom:5px;">
						<FORM action="{Route('ReportStoreBrokerageList')}" method="get">
							<div class="pull-left margin-right-20">
								<div class="controls">
									<span style="font-size: 14px">完单日期:</span>
									<input type="text" class="input" name="start_date" value="{$smarty.get.start_date}" readonly="readonly"/> -
                                    <input type="text" class="input" name="end_date" value="{$smarty.get.end_date}" readonly="readonly"/>
								</div>
							</div>
							<div class="pull-left margin-right-20">
                                <button class="btn btn-primary" type="submit"><i class="icon-search icon-white"></i> 查询</a></button>
                            </div>
						</FORM>
						</div>
					</div>
					<div class="row-fluid">
						<span>合计货款/销售金额：￥{$total_last_amount}/{$total_amount}</span>
					</div>
                    <table class="table table-striped table-bordered dataTable">
                        <thead>
                        <tr>
                        	<th></th>
                            <th>序号</th>
                            <th>门店名称</th>
                            <th>联系人</th>
                            <th>所属区域</th>
                            <th>开户户主姓名</th>
                            <th>开户行</th>
                            <th>银行帐号</th>
                            <th>货款/销售金额</th>
                            <th>查看明细</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach $order as $k=>$item}
                            <tr class="odd gradeX" data-id="{$item.id}">
                            	<td style="width: 20px;"><input type="checkbox" class="checkboxes" value="{$item.store.id}" /></td>
                                <td>{$k+1}</td>
                                <td>{$item.store.name}</td>
                                <td>{$item.store.contacts}</td>                 
                                <td>{$item.store.group.name}</td>
                                <td>{$item.store.bankcard.name}</td>   
                                <td>{$item.store.bankcard.bank.name}</td>    
                                <td>{$item.store.bankcard.number}</td>  
                                <td>{$item.last_amount}/{$item.sum_amount}</td>   
                                <td><a href="{route('ReportStoreBrokerageDetail', ['store_id' => $item.store_id,'start_date'=>$start_date,'end_date'=>$end_date])}" class="btn mini btn-primary">查看明细</a></td>          
                            </tr>
                        {foreachelse}
                            <tr>
                                <td colspan="10" style="text-align: center;">您暂时没有相关货款信息</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                    {if $order}
                    <div class="row-fluid">
                    	{if $order->getTotal() > 0}
                        <div class="span8" style="margin-top: 10px;">
                        	<input type="checkbox" id="checkAll"/> 全选
                            <a href="javascript:void(0)" id="multiOutBankExcel" class="btn mini btn-success" target="_blank">导出为银行报表</a>
                            <a href="javascript:void(0)" id="multiOutBankExcelAll" class="btn mini btn-primary" target="_blank">全部导出为银行报表[最多1000行记录]</a>
                            <div class="dataTables_info">显示 {$order->getFrom()} 到 {$order->getTo()} 项，共 {$order->getTotal()} 项。</div>
                        </div>
                        {/if}
                        <div class="span4">
                            <div class="dataTables_paginate">{$order->appends(['start_date'=>$start_date,'end_date'=>$end_date])->links()}</div>
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
    $('[name="start_date"],[name="end_date"]').datetimepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        minView: 2,
        language: 'zh-CN'
    });
});
 
//导出选中的行数到银行报表
$("#multiOutBankExcel").click(function() {
	var store_ids = new Array();
	var start_date="{$start_date}";
	var end_date="{$end_date}";
	$(".checkboxes").each(function() {
        if ($(this).parent().hasClass('checked')) {
        	store_ids.push($(this).val());
        }
    });
	if (store_ids.length < 1) {
		$("#multiOutBankExcel").prop("target","_self");
        return;
    }
	$("#multiOutBankExcel").prop("href","{route('ReportStoreBrokerageToBankSome')}?store_ids="+store_ids+"&start_date="+start_date+"&end_date="+end_date);
});

//导出全部数据为银行报表
$("#multiOutBankExcelAll").click(function(){
	var start_date="{$start_date}";
	var end_date="{$end_date}";
	$("#multiOutBankExcelAll").prop("href","{route('ReportStoreBrokerageToBankAll')}?start_date="+start_date+"&end_date="+end_date);
});
</script>
{/block}