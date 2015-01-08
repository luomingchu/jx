{extends file='layout/main.tpl'}

{block title}会员列表{/block}

{block breadcrumb}
<li>会员管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('MemberList')}">会员列表</a> <span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> 会员列表
				</h4>
			</div>
			<div class="widget-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>头像</th>
							<th>用户名</th>
							<th>手机号</th>
							<th>邮箱</th>
							<th>性别</th>
							<th>现金余额</th>
							<th>实名认证</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						{foreach $data as $item}
						<tr>
							<td>{$item.id}</td>
							<td>{if $item.avatar}<a href="{$item.avatar.storage.url}" target="_blank"><img src="{$item.avatar.url}&width=25&height=25" width="25" height="25"></a>{else}<img src="{asset('img/avatar.png')}" width="25" height="25">{/if}</td>
							<td>{$item.username}</td>
							<td>{$item.mobile}</td>
							<td>{$item.email}</td>
							<td>{trans('member.gender.'|cat:$item.gender)}</td>
							<td>&#xFFE5;{$item.cash}</td>
							<td>
								<span class="label {strip}
								{if $item.real_name_status eq Member::REANNAME_STATUS_NOTAPPLY}
									label-danger
								{elseif $item.real_name_status eq Member::REANNAME_STATUS_PENDING}
									label-info
								{elseif $item.real_name_status eq Member::REANNAME_STATUS_APPROVED}
									label-success
								{elseif $item.real_name_status eq Member::REANNAME_STATUS_UNAPPROVED}
									label-warning
								{/if}
									{/strip}" >
									{trans('member.real_name_status.'|cat:$item.real_name_status)}
								</span>
							</td>
							<td>
								{if $item.real_name_status eq Member::REANNAME_STATUS_APPROVED}<a class="btn btn-small" href="{route('RealNameInfo', ['id' => $item.id])}">实名信息</a>{/if}
							</td>
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
