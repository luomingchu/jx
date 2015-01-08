{extends file='layout/main.tpl'}

{block title}用户统计{/block}

{block breadcrumb}
    <li>统计分析<span class="divider">&nbsp;</span></li>
    <li><a href="{route('ReportMemberList')}">用户统计</a> <span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
                       
            <div class="widget">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i> 用户统计</h4>
                </div>
                <div class="widget-body">
                	<div class="row-fluid">
						<div class="span12 booking-search" style="padding-bottom:5px;">
						<FORM action="{Route('ReportMemberList')}" method="get">
							<div class="pull-left margin-right-20">
								<div class="controls">
									
									<span style="font-size: 14px">日期:</span>
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
                            <th>日期</th>
                            <th>新增用户</th>
                            <th>累计用户</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach $data as $k=>$item}
                            <tr class="odd gradeX" data-id="{$item.id}">
                                <td>{$item.date}</td>
                                <td>{$item.add_members}</td>
                                <td>{$item.total_members}</td>                 
                            </tr>
                        {foreachelse}
                            <tr>
                                <td colspan="5" style="text-align: center;">您暂时没有相关用户信息</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                    <div class="row-fluid">
                        <div class="span6">
                          </div>
                    </div>
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
</script>
{/block}