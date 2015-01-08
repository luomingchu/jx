{extends file='layout/main.tpl'}

{block title}实名信息{/block}

{block breadcrumb}
<li>会员管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('SuggestionList')}">会员反馈列表</a> <span class="divider">&nbsp;</span></li>
<li>添加备注<span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> 添加备注
				</h4>
			</div>
			<div class="widget-body">
				<form class="form-horizontal" method="post" action="{route('SuggestionRemark')}">
					<div class="control-group">
						<div class="control-label">建议者姓名</div>
						<div class="controls">{$data.member.username}</div>
					</div>
					<div class="control-group">
						<div class="control-label">建议内容</div>
						<div class="controls"><textarea class="input-xxlarge" name="content" rows="4" disabled>{$data.content}</textarea></div>
					</div>
					<div class="control-group">
						<div class="control-label">您的备注</div>
						<div class="controls">
							<textarea class="input-xxlarge" name="remark" rows="4"></textarea>
						</div>
					</div>
					<div class="form-actions">
						<input type="hidden" name="id" value="{$data.id}">
						<button type="submit" class="btn btn-success"><i class="icon-ok"></i> 保存</button>
                        <a href="javascript:window.history.go(-1);"><button type="button" class="btn"><i class=" icon-remove"></i> 取消</button></a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
{/block}
