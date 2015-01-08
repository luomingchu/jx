{extends file='layout/main.tpl'}

{block title}门店列表{/block}

{block breadcrumb}
<li>门店管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('StoreList')}">门店列表</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> 门店列表
				</h4>
				<span class="tools"> <a href="javascript:;"
					class="icon-chevron-down"></a>
				</span>
			</div>
			
			
			<div class="widget-body">
				<div class="row-fluid">
					<div class="span12">
						<label>
							<a href="{route('StoreEdit')}" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加门店</a>
							<a href="javascript:;" id="ImportStore" class="btn btn-success"><i class="icon-upload icon-white"></i> 批量导入</a>
						</label>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12 booking-search" style="padding-bottom:5px;">
						<FORM action="{Route('StoreList')}" method="get" id="form">
						<div class="pull-left margin-right-10">
							<div class="controls">
								
								<select class="input-large m-wrap" id="province" tabindex="1" name="province_id">
								<option value="">--请选择省份--</option>
								{foreach $provinces as $item}
									<option value="{$item.id}" {if $smarty.get.province_id eq $item.id}selected{/if}>{$item.name}</option>
								{/foreach}
                                </select>
							</div>
						</div>
						<div class="pull-left margin-right-10">
							<div class="controls">
								
								<select class="input-large m-wrap" id="city" tabindex="1" name="city_id">
									<option value="">--请选择城市--</option>
                                </select>
							</div>
						</div>
						<div class="pull-left margin-right-20">
							<div class="controls">
								
								<select class="input-large m-wrap" id="district" tabindex="1" name="district_id">
									<option value="">--请选择区/县--</option>
                                </select>
							</div>
						</div>
						<div class="pull-left margin-right-20">
							<div class="controls">
								<span style="font-size: 14px">门店名称:</span>								
                                <input type="text" placeholder="门店名称" name="name"  value="{$smarty.get.name}" >
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
							<th>门店名称</th>
							<th>门店类型</th>							
                            <th>所属区域组织</th>
							<th>所在地</th>
							<th>联系人姓名</th>	
							<th>联系人电话</th>							
							<th>店铺评分</th>							
							<th>操作</th>
						</tr>
					</thead>
					<tbody id="tbodyres">
						{if $data}
							{foreach $data as $item}
								<tr class="odd gradeX">
									<td>{$item.name}</td>
									<td>{if $item.type eq Store::MAIN }总店{elseif $item.type eq Store::DIRECT}直营店{elseif $item.type eq Store::BRANCH}加盟店{/if}</td>
									<td>{$item.group->name}</td>
									<td>{$item.province->name} {$item.city->name} {$item.district->name}</td>
									<td>{$item.contacts}</td>
									<td>{$item.phone}</td>
									<td>{$item.score}</td>
									<td>
									   <a href="{route('StoreEdit', ['id'=>$item.id] )}" class="btn mini purple"><i class="icon-edit"></i> 编辑</a>
									   <button class="btn mini black" onclick="deleteConfirm({$item.id}, '{$item.name}')"><i class="icon-trash"></i> 删除</button>
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
						<div class="dataTables_paginate">{$data->links()}</div>
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
      	<form method="post" action="{route('StoreDelete')}">
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

<div id="import_store_modal" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel4">Excel批量导入门店信息</h3>
    </div>
    <form enctype="multipart/form-data" method="post" action="{route('ImportStore')}" id="ImportStoreForm">
        <div class="modal-body" style="padding: 0; max-height: 480px;">
            <div id="upload_resources">
                <div class="div-table">
                    <div class="div-tr">
                        <div class="div-td td-label">
                            <div class="div-cell" style="width: 100px;">选择文件：</div>
                        </div>
                        <div class="div-td td-field" style="margin: 30px 0;">
                            <div class="div-cell">
                                <div class="fileupload fileupload-new" data-provides="fileupload" id="upload_file_modify">
                                    <input type="hidden" name="file_id" id="input_file">
                                <span class="btn btn-file">
                                    <span class="fileupload-new">选择文件</span>
                                    <span class="fileupload-exists">更改文件</span>
                                    <input type="file" class="default" name="file" />
                                </span>
                                    <span class="fileupload-preview"></span>
                                    <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
                                </div>
                            </div>
                            <hr>
                            <div class="div-tr">
                                <div class="div-td td-label">
                                    <div class="div-cell">模板文件</div>
                                </div>
                                <div class="div-td td-field">
                                    <div class="div-cell">
                                        <a href="{asset('excel/import_store.xls')}" target="_blank">模板文件下载</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true" type="button">关闭</button>
            <button class="btn btn-primary" id="submitForm" type="submit">提交</button>
        </div>
    </form>
</div>

<div id="shade" style="width: 100%;background: #eee;height: 1200px;position: absolute;top: 0;left: 0;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5;display: none;"></div>
<div style="z-index: 100;position:absolute;width: 100%;margin: 0 auto;top:260px;left: 0;display: none;" id="loading_img"><span style="font-weight: bolder;color: #000;font-size: 16px;">文件上传并导入中，请稍后</span><img src="{asset("assets/pre-loader/Fading squares.gif")}"/></div>
{/block}

{block script}
<script>
    var width = $(document).width();
    $(window).scroll(function() {
        scrollImg();
    });

    function scrollImg() {
        var posY;
        if (window.innerHeight) {
            posY = window.pageYOffset;
        }
        else if (document.documentElement && document.documentElement.scrollTop) {
            posY = document.documentElement.scrollTop;
        }
        else if (document.body) {
            posY = document.body.scrollTop;
        }

        $("#loading_img").css('padding-left', width/2+'px');

        var ad=document.getElementById("loading_img");
        ad.style.top=(posY+260)+"px";
    }

    $('#ImportStore').click(function() {
        $("#import_store_modal").modal('show');
    });

    $("#submitForm").click(function() {
        $("#import_store_modal").modal('hide');
        $("#shade").show();
        $("#loading_img").show();
        $("#loading_img").css('padding-left', width/2+'px');
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
