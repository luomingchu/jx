{extends file='layout/main.tpl'}

{block title}账户管理{/block}

{block breadcrumb}
    <li>企业信息 <span class="divider">&nbsp;</span></li>
    <li><a href="{route('AccountManage')}">账户管理</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block head}
<style type="text/css">
    .required { color: red;font-size: 16px;padding-right: 5px; }
</style>
{/block}

{block main}
    {*<div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-title">
                    <h4>
                        <i class="icon-reorder"></i> 企业账户信息
                    </h4>
				    <span class="tools">
                        <a href="javascript:;" class="icon-chevron-down"></a>
                    </span>
                </div>

                <div class="widget-body">
                    {if empty($info)}
                        <a href="javascript:;" id="addAccount" class="btn btn-primary">添加账户</a>
                    {else}
                    
                        <div style="margin-bottom: 6px;;"><span style="width: 100px;display: inline-block;text-align: right;margin-right: 5px;">开户银行：</span>{$info.bank.name}</div>
                        <div style="margin-bottom: 6px;;"><span style="width: 100px;display: inline-block;text-align: right;margin-right: 5px;">银行账户：</span>{$info.number}</div>
                        <div style="margin-bottom: 6px;;"><span style="width: 100px;display: inline-block;text-align: right;margin-right: 5px;">账号名称：</span>{$info.name}</div>
                        <div style="margin-bottom: 6px;;"><span style="width: 100px;display: inline-block;text-align: right;margin-right: 5px;">分行网点：</span>{$info.branch_name}</div>
                        <div style="margin-bottom: 6px;;"><span style="width: 100px;display: inline-block;text-align: right;margin-right: 5px;">分行机构号：</span>{$info.branch_code}</div>
                        <div style="margin-left: 20px;margin-top: 10px;;">
                        	<a href="javascript:;" id="editAccount" class="btn btn-primary" data-bank_id="{$info.bank.id}" data-name="{$info.name}" data-number="{$info.number}" data-branch_code="{$info.branch_code}" data-branch_name="{$info.branch_name}"  >修改</a>
                    	</div>
                    {/if}
                </div>
            </div>
        </div>
    </div>*}

    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-title">
                    <h4>
                        <i class="icon-reorder"></i> 门店账户信息
                    </h4>
				<span class="tools"> <a href="javascript:;"
                                        class="icon-chevron-down"></a>
				</span>
                </div>

                <div class="widget-body">
                    <div class="row-fluid">
                        <div class="span12 booking-search" style="padding-bottom:5px;">
                            <form method="get">
                            <div class="pull-left">
                                <div class="controls">
                                    <select name="province_id" id="province_id" style="width: 150px;">
                                        <option value="">--请选择省份--</option>
                                        {foreach $provinces as $province}
                                        <option value="{$province.id}" {if $smarty.get.province_id eq $province.id}selected="selected" {/if}>{$province.name}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="pull-left">
                                <div class="controls">
                                    <select name="city_id" id="city_id" style="width: 150px;">
                                        <option value="">--请选择城市--</option>
                                        {foreach $citys as $city}
                                        <option value="{$city.id}" {if $smarty.get.province_id eq $province.id}selected="selected" {/if}>{$city.name}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="pull-left" style="margin-right: 20px;">
                                <div class="controls">
                                    <select name="district_id" id="district_id" style="width: 150px;">
                                        <option value="">--请选择区/县--</option>
                                        {foreach $districts as $district}
                                        <option value="{$district.id}" {if $smarty.get.province_id eq $province.id}selected="selected" {/if}>{$district.name}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="pull-left margin-right-20">
                                <div class="controls">
                                    门店名称：
                                    <input type="text" name="name" value="{$smarty.get.name}" style="width: 150px;"/>
                                </div>
                            </div>
                            <div class="pull-left margin-right-20">
                                <label>
                                    <button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i> 查询</button>
                                    <a href="{route('ExportStoreAccount')}" class="btn btn-success"><i class="icon-download-alt icon-white"></i> 批量导出模板</a>
                                    <button type="button" class="btn btn-success" id="multiSaveStoreAccount"><i class="icon-upload-alt icon-white"></i> 批量导入修改</button>
                                </label>
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
                            <th>银行网点</th>
                            <th>银行账户</th>
                            <th>账户名称</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyres">
                        {foreach $store_account as $store}
                            <tr>
                                <td>{$store.name}</td>
                                <td>{trans('store.type.'|cat:$store.type)}</td>
                                <td>{$store.group.name}</td>
                                <td>{$store.province.name}{$store.city.name}{$store.district.name}</td>
                                <td>{$store.account.branch_name}</td>
                                <td>{$store.account.number}</td>
                                <td>{$store.account.name}</td>
                                <td>
                                    <a href="javascript:;" class="btn btn-primary editStoreAccount" data-bank_id="{$store.account.bank_id}" data-branch_code="{$store.account.branch_code}" data-branch_name="{$store.account.branch_name}" data-name="{$store.account.name}" data-number="{$store.account.number}" data-id="{$store.id}">编辑</a>
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>

                    <div class="row-fluid">
                        <div class="span6">
                        </div>
                        <div class="span6">
                            <div class="dataTables_paginate"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addEnterpriseAccountModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="modalTitle">门店账户编辑</h4>
                </div>
                <div class="modal-body">
                    <form id="account_form" class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label"><span class="required">*</span>开户银行：</label>
                            <div class="controls">
                                <select name="bank_id" id="bank_id">
                                    {foreach $banks as $bank}
                                        <option value="{$bank.id}">{$bank.name}</option>
                                    {/foreach}
                                </select>
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><span class="required">*</span>银行网点：</label>
                            <div class="controls">
                                <input type="text" name="branch_name" id="branch_name"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><span class="required">*</span>银行账户：</label>
                            <div class="controls">
                                <input type="text" name="number" required="required" id="number"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><span class="required">*</span>账号名称：</label>
                            <div class="controls">
                                <input type="text" name="name" required="required" id="name"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><span class="required">*</span>分行机构号：</label>
                            <div class="controls">
                                <input type="text" name="branch_code" id="branch_code" required="required"/>
                            </div>
                        </div>
                        <input type="hidden" id="store_id" name="store_id"/>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="SaveAction">确定</button>
                    <button type="button" class="btn" data-dismiss="modal">取消</button>
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
            <h3 id="myModalLabel4">Excel批量导入门店账户信息</h3>
        </div>
        <form enctype="multipart/form-data" method="post" action="{route('MultiImportStoreAccount')}" id="ImportStoreAccountExcelForm">
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
    $("#addAccount").on('click',function(){
    	$("#modalTitle").html("企业账户编辑");
        $("#addEnterpriseAccountModal").modal('show');
    });

    $("#editAccount").on('click', function() {
        $("#branch_code").val($(this).attr('data-branch_code'));
        $("#number").val($(this).attr('data-number'));
        $("#name").val($(this).attr('data-name'));
        $("#bank_id").val($(this).attr('data-bank_id'));
        $("#branch_name").val($(this).attr('data-branch_name'));
        $("#modalTitle").html("企业账户编辑");
        $("#addEnterpriseAccountModal").modal('show');
    });

    $("#SaveAction").click(function() {
        if ($("#bank_id").val() == '') {
            ialert('所属银行不能为空');
            return false;
        }
        if ($("#branch_name").val() == '') {
            ialert('开户所在银行网点不能为空');
            return false;
        }
        if ($("#branch_code").val() == '') {
            ialert('分行机构号不能为空');
            return false;
        }
        if ($("#number").val() == '') {
            ialert('银行账户不能为空');
            return false;
        }
        if ($("#name").val() == '') {
            ialert('账号名称不能为空');
            return false;
        }
        if ($("#store_id").val() != '') {
            $.post('{route("SaveStoreAccountInfo")}', $("#account_form").serialize(), function(data) {
                window.location.reload();
            });
        } else {
            $.post('{route("SaveAccountInfo")}', $("#account_form").serialize(), function(data) {
                window.location.reload();
            });
        }
    });

    $('.editStoreAccount').click(function() {
        $("#branch_code").val($(this).attr('data-branch_code'));
        $("#number").val($(this).attr('data-number'));
        $("#name").val($(this).attr('data-name'));
        $("#bank_id").val($(this).attr('data-bank_id'));
        $("#branch_name").val($(this).attr('data-branch_name'));
        $("#store_id").val($(this).attr('data-id'));
        $("#modalTitle").html("门店账户编辑");
        $("#addEnterpriseAccountModal").modal('show');
    });

    $("#multiSaveStoreAccount").click(function() {
        $("#myModal1").modal('show');
    });

    //省市区下拉
    $("#province_id").change(function() {
        getCity();
    });

    getCity();

    function getCity() {
        var province_id = $("#province_id").val();
        var city_id = "{$smarty.get.city_id}";
        $("#city_id option").not(":first").remove();
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
                    $("#city_id").append(html);
                    getDistrict();
                }
            });
        }
    }

    $("#city_id").change(function() {
        getDistrict();
    });

    function getDistrict() {
        var city_id = $("#city_id").val();
        var district_id = "{$smarty.get.district_id}";
        $("#district_id option").not(":first").remove();
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
                    $("#district_id").append(html);
                }
            });
        }
    }
</script>
{/block}
