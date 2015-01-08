{extends file='layout/main.tpl'}

{block title}企业列表{/block}

{block breadcrumb}
<li>银行管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('GetBankList')}">银行列表</a> <span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> 银行列表
				</h4>
			</div>
			<div class="widget-body">
				<div class="row-fluid">
                        <div class="span12">
                            <label>
                                <a href="{route('EditBank')}" id="addEnterprise" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加银行</a>
                            </label>
                        </div>
                </div>
				<table class="table table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>名称</th>
							<th>logo</th>
							<th>服务热线</th>
							<th>排序</th>
							<th>备注</th>							
							<th>添加时间</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						{foreach $data as $item}
						<tr>
							<td>{$item.id}</td>
							<td>{$item.name}</td>
							<td>{if $item.logo_hash}<a href="{route('FilePull', ['hash' => $item.logo_hash])}" target="_blank">
							<img src="{route('FilePull', ['hash' => $item.logo_hash])}&width=25&height=25" width="25" height="25"></a>{else}<img src="{asset('img/avatar.png')}" width="25" height="25">{/if}</td>
							<td>{$item.hotline}</td>
							<td>{$item.sort}</td>
							<td>{$item.remark|truncate:25}</td>
							<td>{$item.created_at|date_format:'Y-m-d'}</td>
							<td>
								<a class="btn btn-small" href="{route('EditBank', ['id' => $item.id])}"><i class="icon-edit"></i> 编辑</a>
								<a class="btn btn-small" href="javascript:void(0)" onclick="deleteConfirm({$item.id}, '{$item.name}')"><i class="icon-trash"></i> 删除</button>
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

<div class="modal fade" id="DeleteConfirmModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">删除确认</h4>
      </div>
      <div class="modal-body">
        <p>您确定要删除“<strong></strong>”吗？</p>
      </div>
      <div class="modal-footer">
      	<form method="post" action="{route('DeleteBank')}">
      		<input type="hidden" name="id" value="{$item.id}" >
        	<button class="btn" type="button" data-dismiss="modal" aria-hidden="true">取消</button>
    		<button class="btn btn-danger" type="submit">删除</button>
    	</form>
      </div>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
{/block}

{block script}
<script>
	function deleteConfirm(id, name){
		$('#DeleteConfirmModal').find('.modal-body strong').text(name).end().find('form [name="id"]').val(id).end().modal();
	}
</script>
{/block}