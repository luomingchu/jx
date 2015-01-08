{extends file='layout/main.tpl'}

{block title}频道管理{/block}

{block breadcrumb}
<li>商品管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('GoodsChannelList')}">频道管理</a><span class="divider">&nbsp;</span></li>
<li>{if $data.id gt 0}修改{else}添加{/if}商品频道<span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<!-- begin recent orders portlet-->
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> {if $data.id gt 0}修改{else}添加{/if}商品频道
				</h4>
			</div>
			<div class="widget-body">
				<form method="post" action="{route('GoodsChannelSave')}" class="form-horizontal">
					<div class="control-group">
						<label class="control-label">频道名称:</label>
						<div class="controls">
							<input type="text" placeholder="请输入分类名称" class="input-large" name="name" value="{Input::old('name')|default:$data.name}" required />
							<span class="help-inline"></span>
						</div>
					</div>
					<div class="form-actions">
						<input type="hidden" value="{$data.id}" name="id" />
						<button type="submit" class="btn blue"><i class="icon-ok"></i> 保存</button>
						<a href="{route('GoodsChannelList')}"><button type="button" class="btn"><i class=" icon-remove"></i> 取消</button></a>
					</div>
				</form>
			</div>
		</div>
		<!-- end recent orders portlet-->
	</div>
</div>
{/block}