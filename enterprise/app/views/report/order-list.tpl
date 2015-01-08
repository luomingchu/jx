{extends file='layout/main.tpl'}

{block title}销售概况{/block}

{block breadcrumb}
    <li>统计分析<span class="divider">&nbsp;</span></li>
    <li><a href="{route('ReportOrderList')}">销售概况</a> <span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i> 订单统计概览</h4>
                </div>
                <div class="widget-body">
                	<table class="table table-striped table-bordered dataTable">
                        <thead>
                        <tr>
                            <th>日期</th>
                            <th>成交额</th>
                            <th>成交量</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr class="odd gradeX">
                                <td>今天</td>
                                <td>{round_custom($today_amount)}</td>
                                <td>{$today_count}</td>
                            </tr>
                            <tr class="odd gradeX">
                                <td>昨天</td>
                                <td>{round_custom($yesterday_amount)}</td>
                                <td>{$yesterday_count}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="widget">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i> 订单排行榜</h4>
                </div>
                <div class="widget-body">
	                <div class="span12">
	                	<div class="tabbable tabbable-custom">
                        	<ul class="nav nav-tabs">
                               <li class="active"><a href="#tab_1_1" data-toggle="tab">门店排行</a></li>
                               <li><a href="#tab_1_2" data-toggle="tab">指店排行</a></li>
                            </ul>
                            <div class="tab-content">
                            	<div class="tab-pane active" id="tab_1_1">
                            		<div class="row-fluid">
										<div class="span12 booking-search" style="padding-bottom:5px;">
										<FORM action="{Route('ReportOrderList')}" method="get">
											<div class="pull-left margin-right-20">
												<div class="controls">
													<span style="font-size: 14px">门店名称:</span>
				                                    <select name="store_id" data-placeholder="选择门店名称" style="width: 150px;">
				                                        <option value="">--所有门店--</option>
				                                        {foreach $stores as $store}
				                                            <option value="{$store.id}" {if $store.id eq $smarty.get.store_id}selected{/if}>{$store.name}</option>
				                                        {/foreach}
				                                    </select>&nbsp;&nbsp;
													<span style="font-size: 14px">下单日期:</span>
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
									<table class="table table-striped table-bordered dataTable">
				                        <thead>
				                        <tr>
				                            <th>排名</th>
				                            <th>门店名称</th>
				                            <th>成交量</th>
				                            <th>成交总金额</th>
				                            <th>操作</th>
				                        </tr>
				                        </thead>
				                        <tbody>
				                        {foreach $order as $k=>$item}
				                            <tr class="odd gradeX" data-id="{$item.id}">
				                                <td>{$k+1}</td>
				                                <td>{$item.store.name}</td>
				                                <td>{$item.sum_goods_count}</td>
				                                <td>{round_custom($item.sum_amount)}</td>
				                                <td>
				                                    <a href="{route('ReportOrderDetatil', ['store_id' => $item.store_id,'start_date'=>$start_date,'end_date'=>$end_date])}" class="btn mini btn-primary">查看明细</a>
				                                </td>
				                            </tr>
				                        {foreachelse}
				                            <tr>
				                                <td colspan="5" style="text-align: center;">您暂时没有相关订单统计信息</td>
				                            </tr>
				                        {/foreach}
				                        </tbody>
				                    </table>
				                    <div class="row-fluid">
				                        <div class="span6">
				                            <div class="dataTables_paginate">{$order->appends(['store_id'=>$smarty.get.store_id,'start_date'=>$smarty.get.start_date,'end_date'=>$smarty.get.end_date])->links()}</div>
				                        </div>
				                    </div>
                            	</div>
                            	<div class="tab-pane" id="tab_1_2">
                    				<div class="row-fluid">
										<div class="span12 booking-search" style="padding-bottom:5px;">
											<FORM action="{Route('ReportOrderList')}" method="get">
												<div class="pull-left margin-right-20">
													<div class="controls">
														<span style="font-size: 14px">下单日期:</span>
														<input type="text" class="input" name="start_date2" value="{$smarty.get.start_date2}" readonly="readonly"/> -
					                                    <input type="text" class="input" name="end_date2" value="{$smarty.get.end_date2}" readonly="readonly"/>
													</div>
												</div>
												<div class="pull-left margin-right-20">
					                                <button class="btn btn-primary" type="submit"><i class="icon-search icon-white"></i> 查询</a></button>
					                            </div>
											</FORM>
										</div>
									</div>
									<table class="table table-striped table-bordered dataTable">
				                        <thead>
				                        <tr>
				                            <th>排名</th>
				                            <th>指店名称</th>
				                            <th>成交量</th>
				                            <th>成交总金额</th>
				                            <th>操作</th>
				                        </tr>
				                        </thead>
				                        <tbody>
				                        {foreach $order2 as $k=>$item}
				                            <tr class="odd gradeX" data-id="{$item.id}">
				                                <td>{$k+1}</td>
				                                <td>{$item.vstore.name}</td>
				                                <td>{$item.sum_goods_count}</td>
				                                <td>{round_custom($item.sum_amount)}</td>
				                                <td>
				                                    <a href="{route('ReportOrderDetatil2', ['vstore_id' => $item.vstore_id,'start_date'=>$start_date2,'end_date'=>$end_date2])}" class="btn mini btn-primary">查看明细</a>
				                                </td>
				                            </tr>
				                        {foreachelse}
				                            <tr>
				                                <td colspan="5" style="text-align: center;">您暂时没有相关订单统计信息</td>
				                            </tr>
				                        {/foreach}
				                        </tbody>
				                    </table>
				                    <div class="row-fluid">
				                        <div class="span6">
				                            <div class="dataTables_paginate">{$order2->appends(['start_date2'=>$smarty.get.start_date2,'end_date2'=>$smarty.get.end_date2])->links()}</div>
				                        </div>
				                    </div>	
                   				</div>
                            </div>
                        </div>
	                </div><div style="clear:both"></div>
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
        $('[name="start_date"],[name="end_date"],[name="start_date2"],[name="end_date2"]').datetimepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            minView: 2,
            language: 'zh-CN'
        });
    });
</script>
{/block}