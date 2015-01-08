{extends file='layout/main.tpl'}

{block title}员工管理{/block}

{block breadcrumb}
<li>系统管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('StaffList')}">员工列表</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> 员工列表
				</h4>
				<span class="tools"> <a href="javascript:;"
					class="icon-chevron-down"></a>
				</span>
			</div>
			
			<div class="widget-body">
				<div class="row-fluid">
					<div class="span12">
						<label>
							<a href="{route('StaffEdit')}" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加员工</a>
							<a href="javascript:;" class="alertModal btn btn-success"><i class="icon-plus icon-white"></i> Excel批量导入员工</a>
						</label>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12 booking-search" style="padding-bottom:5px;">
						<FORM action="{Route('StaffList')}" method="get" id="form">
						
						<div class="pull-left margin-right-20">
							<div class="controls">
								<span style="font-size: 14px">员工姓名:</span>								
                                <input type="text" placeholder="员工姓名" name="real_name"  value="{$smarty.get.real_name}" >
							</div>							
						</div>
						<div class="pull-left margin-right-20">
							<div class="controls">
									<span style="font-size: 14px">工号:</span>								
	                                <input type="text" placeholder="工号" name="staff_no"  value="{$smarty.get.staff_no}" >
							</div>
						</div>
						<div class="pull-left margin-right-20">
							<div class="controls">								
								<select class="input-large m-wrap" id="bind" tabindex="1" name="bind">
									<option value="">--注册状态--</option>
									<option value="Y" {if $smarty.get.bind eq 'Y'}selected{/if}>已注册</option>
									<option value="N" {if $smarty.get.bind eq 'N'}selected{/if}>未注册</option>
								</select>
							</div>
						</div>
						
						<div class="pull-left margin-right-20">
							<div class="controls">								
								<select class="input-large m-wrap" id="status" tabindex="1" name="status">
									<option value="">--在职状态--</option>
									<option value="{Staff::STATUS_VALID}" {if $smarty.get.status eq Staff::STATUS_VALID}selected{/if}>在职</option>
									<option value="{Staff::STATUS_INVALID}" {if $smarty.get.status eq Staff::STATUS_INVALID}selected{/if}>离职</option>
								</select>
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
							<th>员工姓名</th>									
							<th>工号</th>
							<th>手机号</th>	
							<th>性别</th>	
							<th>年龄</th>											
							<th>所属门店</th>							
							<th>注册状态</th>
							<th>在职状态</th>							
							<th>操作</th>
						</tr>
					</thead>
					<tbody id="tbodyres">
						{if $data}
							{foreach $data as $item}
								<tr class="odd gradeX">
									<td>{$item.real_name}</td>									
									<td>{$item.staff_no}</td>
									<td>{$item.mobile}</td>
									<td>{if $item.gender eq Member::GENDER_MAN }男{else}女{/if}</td>
									<td>{$item.age|default:0}</td>
									<td>{$item->store->name}</td>
									<td>{if $item.member_id}<font color="green">已注册</font>{else}<font color="red">未注册</font>{/if}</td>
									<td>{if $item.status eq Staff::STATUS_VALID}<font color="green">在职</font>{else}<font color="red">离职</font>{/if}</td>
									<td>
									   <a href="{route('StaffEdit', ['id'=>$item.id] )}" class="btn mini purple"><i class="icon-edit"></i> 编辑</a>
									   <button class="btn mini black" onclick="deleteConfirm({$item.id}, '{$item.real_name}')"><i class="icon-trash"></i> 删除</button>
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
							'real_name' => $smarty.get.real_name,
							'staff_no' => $smarty.get.staff_no,
							'bind' => $smarty.get.bind,
							'status' => $smarty.get.status
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
      	<form method="post" action="{route('StaffDelete')}">
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

<!-- start Modal Excel批量导入员工 -->
 	<div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel4">Excel批量导入员工信息</h3>
        </div>
        <form enctype="multipart/form-data" method="post" action="{route('ImportExcelStaff')}" id="ImportExcelStaffForm">
            <div class="modal-body" style="padding: 0; max-height: 480px;">
                <div id="upload_resources">
                    <div class="div-table">
                        <div class="div-tr">
                            <div class="div-td td-label">
                                <div class="div-cell">选择文件</div>
                            </div>
                            <div class="div-td td-field">
                                <div class="div-cell">
                                    <div class="fileupload fileupload-new" data-provides="fileupload" id="upload_file_modify">
                                        <input type="hidden" name="file_id" id="input_file">
									<span class="btn btn-file">
										<span class="fileupload-new">选择文件</span>
										<span class="fileupload-exists">更改文件</span>
										<input type="file" class="default" name="report" />
									</span>
                                        <span class="fileupload-preview"></span>
                                        <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="div-tr">
                            <div class="div-td td-label">
                                <div class="div-cell">下载范本</div>
                            </div>
                            <div class="div-td td-field">
                                <div class="div-cell">
                                    <a href="{asset('excel/importStaffDemo.csv')}" target="_blank">下载Excel范本</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true" type="button">关闭</button>
                <input type="hidden" id="modify_id" name="id"/>
                <button class="btn btn-primary" type="submit">提交</button>
            </div>
        </form>
    </div>
<!-- end Modal -->
{/block}

{block script}
<script>
//by czj add on 20141029 Excel批量导入员工
$(".alertModal").on('click',function(){
	$("#myModal1").modal('show');
});

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
</script>

<script>
	function deleteConfirm(id, name){
		$('#DeleteConfirmModal').find('.modal-body strong').text(name).end().find('form [name="id"]').val(id).end().modal();
	}
</script>

{/block}
