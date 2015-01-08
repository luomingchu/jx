{extends file='layout/main.tpl'}

{block title}门店管理员{/block}

{block breadcrumb}
<li>区域/门店管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('storeManagerList')}">门店管理员</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> 门店管理员列表
				</h4>
				<span class="tools"> <a href="javascript:;"
					class="icon-chevron-down"></a>
				</span>
			</div>
			
			<div class="widget-body">
				<div class="row-fluid">
					<div class="span12">
						<label>
							<a href="{route('storeManagerEdit')}" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加门店管理员</a>
						</label>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12 booking-search" style="padding-bottom:5px;">
						<FORM action="{Route('storeManagerList')}" method="get" id="form">
						
						<div class="pull-left margin-right-20">
							<div class="controls">
								<span style="font-size: 14px">用户名:</span>								
                                <input type="text" placeholder="用户名" name="username"  value="{$smarty.get.username}" >
							</div>							
						</div>
						<div class="pull-left margin-right-20">
							<div class="controls">
								<span style="font-size: 14px">门店名称:</span>								
                                <input type="text" placeholder="门店名称" name="store_name"  value="{$smarty.get.store_name}" >
							</div>							
						</div>
						<div class="pull-left margin-right-20">
							<label><button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i> 查询</button></label>
						</div>
						</FORM>
					</div>
				</div>
				<table class="table table-striped table-bordered dataTable">
					<thead>
						<tr>
							<th>用户名</th>										
							<th>所属组织</th>						
							<th>操作</th>
						</tr>
					</thead>
					<tbody id="tbodyres">
						{if $data}
							{foreach $data as $item}
								<tr class="odd gradeX">
									<td>{$item.username}</td>	
									<td>{$item.store.name}</td>
									<td>
									   <a href="{route('storeManagerEdit', ['id'=>$item.id] )}" class="btn mini purple"><i class="icon-edit"></i> 编辑</a>
									   <button class="btn mini black" onclick="deleteConfirm({$item.id}, '{$item.username}')"><i class="icon-trash"></i> 删除</button>
									</td>
								</tr>
							{/foreach}
						{/if}
					</tbody>
				</table>

				<div class="row-fluid">
					<div class="span6">
						<div class="dataTables_info">显示 {$data->getFrom()} 到 {$data->getTo()} 项，共 {$data->getTotal()} 项。</div>
					</div>
					<div class="span6">
						<div class="dataTables_paginate">
						{$data->appends([
							'username' => $smarty.get.username,
							'store_name' => $smarty.get.store_name
						])->links()}</div>
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
      	<form method="post" action="{route('storeManagerDelete')}">
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
<!-- /.modal -->


{/block}


{block script}
<script>
	function deleteConfirm(id, name){
		$('#DeleteConfirmModal').find('.modal-body strong').text(name).end().find('form [name="id"]').val(id).end().modal();
	}
</script>

{/block}
