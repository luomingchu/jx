{extends file='layout/main.tpl'}

{block title}基本信息{/block}

{block breadcrumb}
<li>系统管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('EnterpriseInfo')}">企业信息</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<!-- begin recent orders portlet-->
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> 企业信息
				</h4>
			</div>
			<div class="widget-body">
                <div class="span12">
                	<div style="border:none;border-radius: 0px; width:100%; height:220px;">
                		<div style="padding:0 20px 0 30px;font-size:25px; height:70px; line-height:70px;">
                			<SPAN style="font-size:14px;">欢迎你</SPAN>&nbsp;&nbsp;&nbsp;&nbsp;
                			<span style="color:#2b2b2b">{$data.name}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                			<SPAN style="font-size:14px;color:#2b2b2b">角色：{if Auth::user()->is_super eq Manager::SUPER_VALID}超级管理员{else}普通管理员{/if}</SPAN>
                		</div>
                		<div style="padding:20px 30px 0 30px;font-size:16px;">
                			<img src="{asset('img/icon_01.jpg')}" width="25" height="25" style="width:25px; height:25px;" alt=""><span style="color:#263147">指帮连锁企业版</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                			<img src="{asset('img/icon_02.jpg')}" width="25" height="25" style="width:25px; height:25px;" alt=""><span style="color:#d2d3d6">指帮连锁商圈版</span>
                		</div>
                		<div style="padding:0 30px 0 30px;height:50px; line-height:50px;">上次登录时间：{if Auth::user()->prev_login_time}{Auth::user()->prev_login_time}{else}首次登录{/if}</div>
                		<div style="padding:0 30px 0 30px;height:45px; line-height:45px;">
                			<a href="{route('ReportOrderList')}">销售概况报表</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                			<a href="{route('ReportMemberList')}">用户统计报表</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                			<a href="{route('ReportVstoreList')}">指店统计报表</a>
                			<!-- <a href="javascript:ialert('您的权限不够，请联系超级管理员！');">销售概况报表</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                			<a href="javascript:ialert('您的权限不够，请联系超级管理员！');">用户统计报表</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                			<a href="javascript:ialert('您的权限不够，请联系超级管理员！');">指店统计报表</a> -->
                		</div>
                	</div>
                </div>
				<!-- <div class="margin10">
					<blockquote>
						<p>企业名称：{$data.name}</p>
						<p><img src="{route('FilePull',['id'=>$data.logo_id,'width'=>150])}" /></p>
					</blockquote>
				</div> -->

				<!-- begin form-->
				<form action="#" class="form-horizontal">
					<table class="table table-hover">
						<thead>
							<tr></tr>
						</thead>
						<tbody style="border:none">
							
							<tr>
								<td class="span5">总计成交总额<span style="color:#ff0000;font-size:18px;"> {$amount} </span>元</td>
								<td class="span5"></td>
								<td></td>
							</tr>
							<tr>
								<td class="span5">总计成交订单<span style="color:#ff0000;font-size:18px;"> {$order_count} </span>笔</td>
								<td class="span5"></td>
								<td></td>
							</tr>
							
							<tr>
								<td class="span3">您有<span style="color:#ff0000;font-size:18px;"> {$vstore_count} </span>个指店申请未处理</td>
								<td class="span5"><a href="{route('WaitAuditVstoreList',['status'=>Vstore::STATUS_ENTERPRISE_AUDITING])}"><button class="btn" type="button">指店管理</button></a></td>
								<td></td>
							</tr>
							<tr>
								<td class="span3">您有<span style="color:#ff0000;font-size:18px;"> {$activity_count} </span>个活动正在进行</td>
								<td class="span5"><a href="{route('ActivityList',['body_type'=>'InnerPurchase'])}"><button class="btn" type="button">活动管理</button></a></td>
								<td></td>
							</tr>					
							<tr>
								<td class="span3">您有<span style="color:#ff0000;font-size:18px;"> {$task_count} </span>个任务正在进行</td>
								<td class="span12" ><a href="{route('TaskList')}"><button class="btn" type="button">任务管理</button></a></td>
								<td></td>
							</tr>
							<!-- <tr>
								<td class="span3">企业法人</td>
								<td class="span5">{$data.legal}</td>
								<td></td>
							</tr>
							<tr>
								<td class="span3">联系人</td>
								<td class="span5">{$data.contacts}</td>
								<td></td>
							</tr>
							<tr>
								<td class="span3">联系电话</td>
								<td class="span5">{$data.phone}</td>
								<td></td>
							</tr>
							<tr>
								<td class="span3">地址</td>
								<td class="span5">{$data.detail_address}</td>
								<td></td>
							</tr>					
							<tr>
								<td class="span3">简介</td>
								<td class="span12" >{$data.description}</td>
								<td></td>
							</tr>
							
							<tr>
								<td class="span3"><a href="{route('EditEnterpriseInfo')}" role="button" class="btn btn-success ys">编辑</a></td>
								<td class="span5" ></td>
								<td></td>
							</tr> -->
							
						</tbody>
						
					</table>

					
				</form>
				<!-- end form-->
			</div>
		</div>
		<!-- end recent orders portlet-->
	</div>
</div>

{/block}


