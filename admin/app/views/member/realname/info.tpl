{extends file='layout/main.tpl'}

{block title}实名信息{/block}

{block breadcrumb}
<li>会员管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('RealNameList')}">实名审核</a> <span class="divider">&nbsp;</span></li>
<li><a href="{route('RealNameInfo')}">实名信息</a> <span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> 实名信息
				</h4>
			</div>
			<div class="widget-body">
				<form class="form-horizontal" method="post" action="{route('RealNameVerify')}">
					<div class="control-group">
						<div class="control-label">姓名</div>
						<div class="controls">{$data.realname.name}</div>
					</div>
					<div class="control-group">
						<div class="control-label">身份证号码</div>
						<div class="controls">{$data.realname.id_number}</div>
					</div>
					<div class="control-group">
						<div class="control-label">认证图片</div>
						<div class="controls">
							{foreach $data.realname.pictures as $picture}
							<a href="{route('FilePull', ['hash' => $picture.hash])}" target="_blank">
								<img src="{route('FilePull', ['hash' => $picture.hash])}&width=300&height=300" style="width:300px;height:300px" />
							</a>
							{/foreach}
						</div>
					</div>

					{if $data.real_name_status eq Member::REANNAME_STATUS_PENDING}
					<div class="form-actions">
						<input type="hidden" name="id" value="{$data.id}">
						<button type="submit" class="btn btn-success" name="real_name_status" value="{Member::REANNAME_STATUS_APPROVED}">
							<i class="icon-ok"></i> 通过
						</button>
						<button type="submit" class="btn btn-warning" name="real_name_status" value="{Member::REANNAME_STATUS_UNAPPROVED}">
							<i class="icon-remove"></i> 驳回
						</button>
					</div>
					{/if}
				</form>
			</div>
		</div>
	</div>
</div>
{/block}
