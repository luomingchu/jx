{extends file='layout/main.tpl'}

{block title}指店统计{/block}

{block breadcrumb}
    <li>统计分析<span class="divider">&nbsp;</span></li>
    <li><a href="{route('ReportVstoreList')}">指店统计</a> <span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
                       
            <div class="widget">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i> 指店统计</h4>
                </div>
                <div class="widget-body">
                	<div class="row-fluid">
						<div class="span12 booking-search" style="padding-bottom:5px;">
						<FORM action="{Route('ReportVstoreList')}" method="get">
							<div class="pull-left margin-right-30">
								<div class="controls">
									
									<span style="font-size: 14px">日期:</span>
									<input type="text" class="input" name="start_date" value="{$smarty.get.start_date}" readonly="readonly"/> -
                                    <input type="text" class="input" name="end_date" value="{$smarty.get.end_date}" readonly="readonly"/>
								
									<select name="group_id[]" class="sub_category" >
					                    <option value="">所属组织区域</option>
					                    {foreach $groups as $group}
					                        <option value="{$group.id}">{$group.name}</option>
					                    {/foreach}
					                </select>
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
                            <th>新增指店</th>
                            <th>累计指店</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach $data as $k=>$item}
                            <tr class="odd gradeX" data-id="{$item.id}">
                                <td>{$item.date}</td>
                                <td>{$item.new_number}</td>
                                <td>{$item.total_number}</td>                 
                            </tr>
                        {foreachelse}
                            <tr>
                                <td colspan="5" style="text-align: center;">您暂时没有相关指店信息</td>
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
    
    
</script>
{/block}