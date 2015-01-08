{extends file='layout/main.tpl'}

{block title}活动管理{/block}

{block breadcrumb}
<li>活动管理<span class="divider">&nbsp;</span></li>
<li><a href="{route('ActivityList',['body_type'=>$smarty.get.body_type])}">{$activities[$smarty.get.body_type]}活动列表</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<!-- begin recent orders portlet-->
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> {$activities[$smarty.get.body_type]}活动列表
				</h4>
			</div>
			<div class="widget-body">
				<div class="row-fluid">
					<div class="span12">
						<label>
							<a href="{route('ActivityEdit',['body_type'=>$smarty.get.body_type])}" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加{$activities[$smarty.get.body_type]}活动</a>
						</label>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12 booking-search" style="padding-bottom:5px;">
						<FORM >
						<div class="pull-left margin-right-20">
							<div class="controls">
								<input placeholder="活动名称" class="input-large" name="title" value="{$smarty.get.title}" type="text">
                                时间周期：<input type="text" class="datepicker" name="start_date" value="{$smarty.get.start_date}" style="width: 120px;" readonly/>  到 <input type="text" class="datepicker" style="width: 120px" name="end_date" value="{$smarty.get.end_date}" readonly/>
							</div>
						</div>
						<div class="pull-left margin-right-20">
							<label>
							<input type="hidden" name="body_type" value="{$smarty.get.body_type}">
								<button type="submit" class="btn btn-primary" style="margin-left: 30px">查 询</button>
						    </label>
						</div>
						</FORM>
					</div>
				</div>
				<table class="table table-striped table-bordered dataTable" id="goods_item_list">
					<thead>
						<tr>
							<th>活动编号</th>
							<th>活动名称</th>
							<th>开始时间</th>
							<th>结束时间</th>
							<th>状态</th>
							<th>添加日期</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody id="tbodyres">
					  {foreach $data as $item}
						<tr class="odd gradeX">
							<td>{$item.id}</td>
							<td><img src="{$item.picture.url}" style="width: 80px;"/> {$item.title}</td>
							<td>{$item.start_datetime}</td>
							<td>{$item.end_datetime}</td>
							<td>
                                {if $item.status eq Activity::STATUS_OPEN}
                                    {if strtotime($item.end_datetime) < time()}
                                        已结束
                                    {elseif strtotime($item.start_datetime) > time()}
                                        未进行
                                    {else}
                                        进行中
                                    {/if}
                                {else}
                                    未开启
                                {/if}
                            </td>
							<td>{$item.created_at}</td>
							<td>
                                {if $item.status eq Activity::STATUS_CLOSE}
                                    <a href="javascript:;" data-id="{$item.id}" class="btn btn-primary openActivity">开启</a>
                                    <a class="btn btn-info" href="{route('ActivityEdit', ['body_type'=>$smarty.get.body_type, 'id' => $item.id])}">修改</a>
                                    <a class="btn btn-danger remove_activity" data-id="{$item.id}">删除</a>
                                {elseif $item.status eq Activity::STATUS_OPEN && strtotime($item.end_datetime) < time()}
                                    <a class="btn btn-danger remove_activity" data-id="{$item.id}">删除</a>
                                {else}
                                    <a class="btn btn-info" href="{route('ActivityEdit', ['body_type'=>$smarty.get.body_type, 'id' => $item.id])}">详情</a>
                                {/if}
							</td>
						</tr>
					   {foreachelse}
					     <tr>
                                <td colspan="12" style="text-align: center;">没有相关活动数据 ！</td>
                            </tr>
					   {/foreach}
					</tbody>
				</table>
				{if $data}
                        <div class="row-fluid">
                                <div class="span6" style="margin-top: 10px;">
                                    <div class="dataTables_info">显示 {$data->getFrom()} 到 {$data->getTo()} 项，共 {$data->getTotal()} 项。</div>
                                </div>
                            <div class="span6">
                                <div class="dataTables_paginate">{$data->appends(['title' => $smarty.get.title,'body_type' => $smarty.get.body_type])->links()}</div>
                            </div>
                        </div>
                    {/if}
			</div>
		</div>
		<!-- end recent orders portlet-->
	</div>
</div>
{/block}

{block script}
<script type="text/javascript">
    $('.datepicker').datepicker({
        format: "yyyy/mm/dd",
        language: "zh-CN"
    });

    $(".openActivity").click(function() {
        var activity_id = $(this).attr('data-id');
        iconfirm('开启后，活动的相关信息和活动商品将不能再进行修改，确认要开启此活动吗？', function() {
            $.post('{route("OpenActivity")}', { activity_id: activity_id }, function(data) {
                window.location.reload();
            });
        });
    });

    $(".remove_activity").click(function() {
        var activity_id = $(this).attr('data-id');
        var obj = $(this);
        iconfirm('确认要删除此活动吗？', function() {
            $.post('{route("ActivityDelete")}', { activity_id: activity_id }, function(data) {
                obj.closest('tr').remove();
            }, 'text');
        });
    });
</script>
{/block}
