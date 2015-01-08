{extends file='layout/main.tpl'}

{block title}系统参数{/block}

{block breadcrumb}
    <li>系统管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('ConfigsList')}">系统参数</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> 系统参数列表
				</h4>
				<span class="tools"> <a href="javascript:;"
					class="icon-chevron-down"></a>
				</span>
			</div>
			
			<div class="widget-body">				
				<table class="table table-striped table-bordered dataTable">
					<thead>
						<tr>							
							<th>参数名</th>
							<th>键值</th>
							<th>备注</th>							
							<th>操作</th>
						</tr>
					</thead>
					<tbody id="tbodyres">
						{foreach $data as $item}
							<tr class="odd gradeX">
								<td>{$item.name}</td>
								<td>{$item.keyvalue}</td>
								<td>{$item.remark}</td>
								<td>
								   <a href="{route('ConfigsEdit', $item.key)}" class="btn mini purple"><i class="icon-edit"></i> 编辑</a>
								</td>
							</tr>
						{foreachelse}
                            <tr>
                                <td colspan="4" style="text-align: center;">没有相关数据 ！</td>
                            </tr>
						{/foreach}
					</tbody>
				</table>
				{if $data}
				<div class="row-fluid">
					<div class="span6">
						<div class="dataTables_info">显示 {$data->getFrom()} 到 {$data->getTo()} 项，共 {$data->getTotal()} 项。</div>
					</div>
					<div class="span6">
						<div class="dataTables_paginate">{$data->links()}</div>
					</div>
				</div>
				{/if}
			</div>
		</div>
	</div>
</div>
{/block}
