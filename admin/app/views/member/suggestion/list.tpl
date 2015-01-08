{extends file='layout/main.tpl'}

{block title}会员列表{/block}

{block breadcrumb}
<li>会员管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('SuggestionList')}">会员反馈列表</a> <span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> 会员反馈列表
				</h4>
			</div>
			<div class="widget-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
                            <th>提建议者</th>
                            <th>建议内容</th>
                            <th>建议日期</th>
                            <th>备注</th>
                            <th>备注日期</th>
                            <th></th>
						</tr>
					</thead>
					<tbody>
						{foreach $data as $item}
						<tr>
							<td>{$item.id}</td>
							<td>{if $item.member.avatar}<a href="{$item.member.avatar.storage.url}" target="_blank"><img src="{$item.member.avatar.url}&width=25&height=25" width="25" height="25"></a>{else}<img src="{asset('img/avatar.png')}" width="25" height="25">{/if}
							{$item.member.username}</td>
							<td>{$item.content|truncate:120}</td>
                            <td>{$item.created_at|date_format:"%Y-%m-%d"}</td>
                            <td>{$item.remark|truncate:120}</td>
                            <td>{$item.remark_time|date_format:"%Y-%m-%d"}</td>
							<td>
								<a class="btn btn-default" href="{route('SuggestionEdit', ['id' => $item.id])}"><i class="icon-plus"></i> 备注</a>
							</td>
						</tr>
						{foreachelse}
                            <tr>
                                <td colspan="7" style="text-align: center;">没有相关建议信息 ！</td>
                            </tr>
						{/foreach}
					</tbody>
				</table>
				<div class="row-fluid">
					<div class="span6">
						<div class="dataTables_info">显示 {$data->getTotal()} 项中的 {$data->getFrom()} 到 {$data->getTo()} 项。</div>
					</div>
					<div class="span6">
						<div class="dataTables_paginate">{$data->links()}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{/block}
