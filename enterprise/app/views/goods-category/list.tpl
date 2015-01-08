{extends file='layout/main.tpl'}

{block title}商品分类管理{/block}

{block breadcrumb}
<li>商品管理<span class="divider">&nbsp;</span></li>
<li>商品设置<span class="divider">&nbsp;</span></li>
<li><a href="{route('GoodsCategoryList')}">商品分类</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<!-- begin recent orders portlet-->
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> 商品分类列表
				</h4>
				<span class="tools"> <a href="javascript:;"
					class="icon-chevron-down"></a>
				</span>
			</div>
			<div class="widget-body">
				<div class="row-fluid">
					<div class="span12">
						<label>
							<a href="{route('GoodsCategoryEdit')}" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加商品分类</a>
						</label>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12 booking-search" style="padding-bottom:5px;">
						<FORM action="{Route('GoodsCategoryList')}" method="get" id="category_form">
						<div class="pull-left margin-right-20">
							<div class="controls">
								<span style="font-size: 14px">分类:</span>
                                 <select name="category_id[]" class="sub_category" data-placeholder="选择一级分类" tabindex="1">
                                    <option value="">全部分类</option>
                                    {foreach $category as $item}
                                   		<option value="{$item.id}" {if $item.id eq $smarty.get.category_id.0}selected{/if}>{$item.name}</option>
									{/foreach}
                                 </select>
							</div>
						</div>
						<div class="pull-left margin-right-20">
							<label><a href="javascript:void(0)" onclick="select()" class="btn btn-primary"><i class="icon-search icon-white"></i> 查询</a></label>
						</div>
						</FORM>
					</div>
				</div>
				<table class="table table-striped table-bordered dataTable">
					<thead>
						<tr>
							<th>#</th>
							<th>分类名称</th>
							<th>上级分类名称</th>
							<th>创建日期</th>
							<th>修改日期</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody id="tbodyres">
						{if $data}
							{foreach $data as $item}
							<tr class="odd gradeX">
								<td>{$item.id}</td>
								<td>{$item.name}</td>
								<td>{$item->parentNode()->first()->name}</td>
								<td>{$item.created_at|date_format:"%Y-%m-%d"}</td>
								<td>{$item.updated_at|date_format:"%Y-%m-%d"}</td>
								<td>
									<a class="btn btn-sm btn-default" href="{route('GoodsCategoryEdit', $item.id)}"><i class="icon-edit"></i>编辑</a>
									<button class="btn mini black" onclick="deleteConfirm({$item.id}, '{$item.name}')"><i class="icon-trash"></i> 删除</button>
								</td>
							</tr>
							{/foreach}
						{/if}
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
        <p>您确定要删除分类“<strong></strong>”吗？</p>
      </div>
      <div class="modal-footer">
      	<form method="post" action="{route('GoodsCategoryDelete')}">
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
function select(){
	$("#category_form").submit();
}

//产生下级分类
$(document).on('change', ".sub_category", function() {
    var parent_id = $(this).val();
    var obj = $(this);
    obj.nextAll().remove();
    $.getJSON("{route("GoodsCategorySub")}", { parent_id:parent_id }, function(data) {
        if (data.length > 0) {
            var select = '<select class="sub_category" name="category_id[]" tabindex="1"><option value="">--请选择--</option>';
            $(data).each(function(i, e) {
                select += "<option value='"+ e.id+"'>"+ e.name+"</option> ";
            });
            select += "</select>";
            obj.parent().append(select);
        }
    });
});

</script>

<script>
	function deleteConfirm(id, name){
		$('#DeleteConfirmModal').find('.modal-body strong').text(name).end().find('form [name="id"]').val(id).end().modal();
	}
</script>
{/block}
