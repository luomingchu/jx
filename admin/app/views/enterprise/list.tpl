{extends file='layout/main.tpl'}

{block title prepend}企业列表{/block}

{block breadcrumb}
<li>企业管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('GetEnterpriseList')}">企业列表</a> <span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> 企业列表
				</h4>
			</div>
			<div class="widget-body">
				<div class="row-fluid">
                        <div class="span12">
                            <label>
                                <a href="{route('EditEnterprise')}" id="addEnterprise" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加企业</a>
                            </label>
                        </div>
                </div>
				<table class="table table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>LOGO</th>
							<th>企业名称</th>
							<th>地址</th>
							<th>联系人</th>
							<th>联系人电话</th>							
							<th>添加时间</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						{foreach $data as $item}
						<tr>
							<td>{$item.id}</td>
							<td>{if $item.logo_id}<a href="{$item.logo.url}" target="_blank"><img src="{$item.logo.url}&width=25&height=25" width="25" height="25"></a>{else}<img src="{asset('img/avatar.png')}" width="25" height="25">{/if}</td>
							<td>{$item.name}</td>
							<td>{$item.detailAddress}</td>
							<td>{$item.contacts}</td>
							<td>{$item.phone}</td>
							<td>{$item.created_at|date_format:'Y-m-d'}</td>
							
							<td>
								<a class="btn btn-small" href="{route('EditEnterprise', ['id' => $item.id])}">编辑</a>
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
