{extends file='layout/main.tpl'}

{block title}区域负责人{/block}

{block breadcrumb}
<li>区域/门店管理<span class="divider">&nbsp;</span></li>
<li><a href="{route('AreaStoreManagerList')}">区域负责人列表</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> 区域负责人列表
				</h4>
				<span class="tools"> <a href="javascript:;"
					class="icon-chevron-down"></a>
				</span>
			</div>
			
			<div class="widget-body">
				<div class="row-fluid">
					<div class="span12">
						<label>
							<a href="{route('AreaStoreManagerEdit')}" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加区域负责人</a>
						</label>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12 booking-search" style="padding-bottom:5px;">
						<FORM action="{Route('AreaStoreManagerList')}" method="get" id="form">
							<div class="pull-left margin-right-20">
								<input type="text" placeholder="用户名" name="username"  value="{$smarty.get.username}" >&nbsp;&nbsp;
	                            <span style="font-size: 14px">组织:</span>
	                            <select name="group_id[]" class="sub_group" data-placeholder="选择一级组织" style="width: 100px;">
	                                <option value="0">全部组织</option>
	                                {foreach $group as $item}
	                                    <option value="{$item.id}" {if $item.id eq $smarty.get.group_id.0}selected{/if}>{$item.name}</option>
	                                {/foreach}
	                            </select>&nbsp;&nbsp;
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
							<th>所管辖区域</th>						
							<th>操作</th>
						</tr>
					</thead>
					<tbody id="tbodyres">
						{if $data}
							{foreach $data as $item}
								<tr class="odd gradeX">
									<td>{$item.username}</td>	
									<td>{foreach $item.storeManageArea as $manager}
										{$manager.item.name}
									{/foreach}</td>
									<td>
									   <a href="{route('AreaStoreManagerEdit', ['id'=>$item.id] )}" class="btn mini purple"><i class="icon-edit"></i> 编辑</a>
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
      	<form method="post" action="{route('AreaStoreManagerDelete')}">
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
	//产生下级分类
    $(document).on('change', ".sub_group", function() {
        var parent_id = $(this).val();
        var obj = $(this);
        obj.nextAll().remove();
        $.getJSON("{route("GroupSub")}", { parent_id:parent_id }, function(data) {
            if (data.length > 0) {
                var select = '<select class="sub_group" name="group_id[]" style="width: 100px;"><option value="">请选择</option>';
                $(data).each(function(i, e) {
                    select += "<option value='"+ e.id+"'>"+ e.name+"</option> ";
                });
                select += "</select>";
                obj.parent().append(select);
            }
        });
    });
</script>

{/block}
