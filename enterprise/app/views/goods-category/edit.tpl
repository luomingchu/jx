{extends file='layout/main.tpl'}

{block title}商品分类管理{/block}

{block breadcrumb}
<li>商品管理 <span class="divider">&nbsp;</span></li>
<li>商品设置<span class="divider">&nbsp;</span></li>
<li><a href="{route('GoodsCategoryList')}">商品分类列表</a><span class="divider">&nbsp;</span></li>
<li>{if $data.id gt 0}修改{else}添加{/if}商品分类<span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<!-- begin recent orders portlet-->
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> {if $data.id gt 0}修改{else}添加{/if}商品分类
				</h4>
			</div>
			<div class="widget-body">
				<form method="post" action="{route('GoodsCategorySave')}" class="form-horizontal">
					<div class="control-group">
						<label class="control-label">分类名称:</label>
						<div class="controls">
							<input type="text" placeholder="请输入分类名称" class="input-large" name="name" value="{Input::old('name')|default:$data.name}" required />
							<span class="help-inline"></span>
						</div>
					</div>
					{if $data.id gt 0}
					<div class="form-group">
				        <label  class="col-sm-2 col-md-1 control-label">上级分类</label>
				        <div class="col-sm-10">
				            <p class="form-control-static">{if $parent_node}{$parent_node->name}{else}全部分类{/if} [<a href="javascript:;" id="editBelongCategory" data-id="{$data->id}">修改</a>]</p>
				        </div>
				    </div>
				    {/if}
					<div class="control-group" {if $data.id gt 0}style="display: none;"{/if} id="selCategory">
						<label class="control-label">{if !$data}上级分类:{/if}</label>
						<div class="controls">
							<select class="input-large m-wrap sub_category" tabindex="1" name="path[]">
								<option value="0" selected>--做为第一级分类--</option>
								{foreach $category as $item}
				                	<option value="{$item->id}">{$item->name}</option>
				                {/foreach}
							</select>
						</div>
					</div>
					<div class="form-actions">
						<input type="hidden" value="{$data.id}" name="id" />
						<button type="submit" class="btn blue"><i class="icon-ok"></i> 保存</button>
						<a href="{route('GoodsCategoryList')}"><button type="button" class="btn"><i class=" icon-remove"></i> 取消</button></a>
					</div>
				</form>
			</div>
		</div>
		<!-- end recent orders portlet-->
	</div>
</div>
{/block}

{block script}
<script>
	$(document).on('change', ".sub_category", function() {
        var parent_id = $(this).val();
        var obj = $(this);
        obj.nextAll().remove();
        $.getJSON("{route("GoodsCategorySub")}", { parent_id:parent_id }, function(data) {
            if (data.length > 0) {
                var select = '<select class="input-large m-wrap sub_category" name="path[]" tabindex="1" style="margin-top: 5px;"><option value="">--请选择--</option>';
                $(data).each(function(i, e) {
                    select += "<option value='"+ e.id+"'>"+ e.name+"</option> ";
                });
                select += "</select>";
                obj.parent().append(select);
            }
        });
    });
	
	$(document).ready(function(){
	    $("#editBelongCategory").click(function() {
	        $("#selCategory").toggle();
	        if ($("#selCategory").is(":hidden")) {
	            $(this).text('修改');
	        } else {
	            $(this).text('取消修改');
	        }
	    });
	});
</script>
{/block}