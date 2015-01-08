{extends file='layout/main.tpl'}

{block title}指店管理{/block}

{block breadcrumb}
<li>指店管理 <span class="divider">&nbsp;</span></li>

{if $smarty.get.status eq Vstore::STATUS_ENTERPRISE_AUDITING}
<li><a href="{route('WaitAuditVstoreList',['status'=>Vstore::STATUS_ENTERPRISE_AUDITING])}">待审核指店</a><span class="divider-last">&nbsp;</span></li>
{else}
<li><a href="{route('VstoreList')}">指店列表</a><span class="divider-last">&nbsp;</span></li>
{/if}
    
    
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> 指店列表
				</h4>
				<span class="tools"> <a href="javascript:;" class="icon-chevron-down"></a></span>
			</div>
			
			<div class="widget-body">
				<div class="row-fluid">
					  <div class="span12 booking-search" style="padding-bottom:5px;">
						<form action="{Route('VstoreList')}" method="get" id="form">
						<div class="pull-left margin-right-20">
							<div class="controls">
							    <div>
									<span style="font-size: 14px">指店名称:</span>								
	                                <input type="text" placeholder="指店名称" name="name"  value="{$smarty.get.name}" >
								
									<span style="font-size: 14px;margin-left: 8px;">状态：</span>
			                       	<select class="input-large m-wrap" id="status" tabindex="1" name="status">
										<option value="">--请选择状态--</option>
                                        {foreach array(
                                            Vstore::STATUS_OPEN,
                                            Vstore::STATUS_CLOSE,
                                            Vstore::STATUS_ENTERPRISE_AUDITING,
                                            Vstore::STATUS_ENTERPRISE_AUDITERROR,
                                            Vstore::STATUS_ENTERPRISE_AUDITED,
                                            Vstore::STATUS_MEMBER_GETED
                                        ) as $status}
                                        <option value="{$status}" {if $smarty.get.status eq $status}selected="selected" {/if}>{trans('vstore.status.'|cat:$status)}</option>
                                        {/foreach}
	                                </select>	
	                                <input type="submit" class="btn btn-primary" value="查 询" id="searchOrder" style="position: relative;top: -5px;"/>
								</div>
							</div>					
						</div>
					</form>
				<table class="table table-striped table-bordered dataTable">
					<thead>
						<tr>
							<th>指店名称</th>
							<th>所属门店</th>
							<th>所属人性质</th>
							<th>指店联系人</th>
							<th>联系电话</th>			
							<th>等级</th>
							<th>创建时间</th>	
							<th>状态</th>							
							<th>拒绝理由</th>							
							<th>操作</th>
						</tr>
					</thead>
					<tbody id="tbodyres">
                        {foreach $vstores as $item}
                            <tr class="odd gradeX">
                                <td>{$item.name}</td>
                                <td>{$item->store->name}</td>
                                <td>{if $item.member->staff}员工{else}非员工{/if}</td>
                                <td>{$item.member.real_name}</td>
                                <td>{$item.member.mobile}</td>
                                <td>V{$item.level}</td>
                                <td>{$item.created_at}</td>
                                <td><span class="badge badge-warning">{trans('vstore.status.'|cat:$item.status)}</span></td>
                                <td>{$item.enterprise_reject_reason}</td>
                                <td>
                                   <a href="{route('VstoreEdit', ['id'=>$item.id] )}" class="btn mini purple"><i class="icon-edit"></i> 查看/审核 </a>
                                </td>
                            </tr>
                        {foreachelse}
                            <tr>
                                <td colspan="10" style="text-align: center;">没有相关指店信息！</td>
                            </tr>
                        {/foreach}
					</tbody>
				</table>
				{if $vstores}
				<div class="row-fluid">
					<div class="span6">
						<div class="dataTables_info">显示 {$vstores->getFrom()} 到 {$vstores->getTo()} 项，共 {$vstores->getTotal()} 项。</div>
					</div>
					<div class="span6">
						<div class="dataTables_paginate">{$vstores->links()}</div>
					</div>
				</div>
				{/if}
			</div> 
				</div>
			</div>
	</div>
</div>
</div>
{/block}

{block script}
<script>

		//省市区下拉
		 
		$("#province").change(function() {
		    getCity();
		});
		
		getCity();
		
		function getCity() {
		    var province_id = $("#province").val();
		    var city_id = "{$smarty.get.city_id}";
			if( province_id > 0){
				$.ajax({
			        url: '{action("GlobalController@getCity")}',
			        data: { province_id : province_id },
			        success: function(data) {
			            var html = "";
			            for (var i in data) {
			            	if(data[i]['id'] == city_id){
			            		html += "<option value='"+data[i]['id']+"' selected >"+data[i]['name']+"</option>"
			            	}else{
			            		html += "<option value='"+data[i]['id']+"'>"+data[i]['name']+"</option>"
			            	}
			                
			            }
			            $("#city option").not(":first").remove();
			            $("#city").append(html);
			            
			            getDistrict();
			        }
			    });
			}else{
				$("#city option").not(":first").remove();
			}
		}
		
		
		
		$("#city").change(function() {
			getDistrict();
		});
		
		
		function getDistrict() {
		    var city_id = $("#city").val();
		    var district_id = "{$smarty.get.district_id}";
			if( city_id > 0){
				$.ajax({
			        url: '{action("GlobalController@getDistrict")}',
			        data: { city_id : city_id },
			        success: function(data) {
			            var html = "";
			            for (var i in data) {
			            	if(data[i]['id'] == district_id){
			            		html += "<option value='"+data[i]['id']+"' selected >"+data[i]['name']+"</option>"
			            	}else{
			            		html += "<option value='"+data[i]['id']+"'>"+data[i]['name']+"</option>"
			            	}
			                
			            }
			            $("#district option").not(":first").remove();
			            $("#district").append(html);
			        }
			    });
			}else{
				$("#district option").not(":first").remove();
			}
		}
		
		$(document).on('change', "[name='group_id[]']", function() {
	        var group_id = $(this).val();
	        var obj = $(this);
	        obj.nextAll().remove();
	        if (group_id != '') {
	            $.getJSON("{route("GetSubGroups")}", { group_id: group_id }, function (data) {
	                if (data.length > 0) {
	                    var select = '<select class="sub_category" name="group_id[]"><option value="">--请选择--</option>';
	                    $(data).each(function (i, e) {
	                        select += "<option value='" + e.id + "'>" + e.name + "</option> ";
	                    });
	                    select += "</select>";
	                    obj.parent().append(select);
	                }
	            });
	        }
	    });
</script>
{/block}
