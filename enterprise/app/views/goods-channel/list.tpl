{extends file='layout/main.tpl'}

{block title}频道管理{/block}

{block breadcrumb}
<li>商品管理<span class="divider">&nbsp;</span></li>
<li><a href="{route('GoodsChannelList')}">频道管理</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<!-- begin recent orders portlet-->
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> 商品频道列表
				</h4>
				<span class="tools"> <a href="javascript:;"
					class="icon-chevron-down"></a>
				</span>
			</div>
			<div class="widget-body">
				<!-- <div class="row-fluid">
					<div class="span12">
						<label>
							<a href="{route('GoodsChannelEdit')}" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加商品频道</a>
						</label>
					</div>
				</div> -->
				<table class="table table-striped table-bordered dataTable">
					<thead>
						<tr>
							<th>#</th>
							<th>频道名称</th>
							<th>创建日期</th>
							<th>修改日期</th>
							<!-- <th>操作</th> -->
						</tr>
					</thead>
					<tbody id="tbodyres">
						{foreach $data as $item}
						<tr class="odd gradeX">
							<td>{$item.id}</td>
							<td>{$item.name}</td>
							<td>{$item.created_at|date_format:"%Y-%m-%d"}</td>
							<td>{$item.updated_at|date_format:"%Y-%m-%d"}</td>
							<!-- <td>
								<a class="btn btn-sm btn-default" href="{route('GoodsChannelEdit', $item.id)}"><i class="icon-edit"></i>编辑</a>
								<button class="btn mini black" onclick="deleteConfirm({$item.id}, '{$item.name}')"><i class="icon-trash"></i> 删除</button>
							</td> -->
						</tr>
						{foreachelse}
						<tr colspan="5"></tr>
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
		<!-- end recent orders portlet-->
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
        <p>您确定要删除频道“<strong></strong>”吗？</p>
      </div>
      <div class="modal-footer">
      	<form method="post" action="{route('GoodsChannelDelete')}">
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
