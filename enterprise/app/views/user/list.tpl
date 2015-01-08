{extends file='layout/main.tpl'}

{block title}会员列表{/block}

{block breadcrumb}
    <li>系统管理 <span class="divider">&nbsp;</span></li>
    <li><a href="{route('ManageMember')}">会员管理</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block head}
    <style type="text/css">
        .required { color: red;font-size: 16px;padding-right: 5px; }
    </style>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-title">
                    <h4>
                        <i class="icon-reorder"></i> 会员列表
                    </h4>
				<span class="tools"> <a href="javascript:;"
                                        class="icon-chevron-down"></a>
				</span>
                </div>

                <div class="widget-body">
                    <div class="row-fluid">
                        <div class="span12 booking-search" style="padding-bottom:5px;">
                            <form method="get" id="form">
                                <div class="pull-left">
                                    <div class="controls">
                                        会员名称：<input type="text" name="real_name" value="{$smarty.get.real_name}" style="width: 160px;margin-right: 15px;"/>
                                    </div>
                                </div>
                                <div class="pull-left">
                                    <div class="controls">
                                        手机号：<input type="text" name="mobile" value="{$smarty.get.mobile}" style="width: 160px;margin-right: 15px;"/>
                                    </div>
                                </div>
                                <div class="pull-left" style="margin-right: 20px;">
                                    <div class="controls">
                                        <select name="status" id="district_id" style="width: 150px;">
                                            <option value="">注册状态</option>
                                            <option value="yes" {if $smarty.get.status eq 'yes'}selected="selected" {/if}>已注册</option>
                                            <option value="no" {if $smarty.get.status eq 'no'}selected="selected" {/if}>未注册</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="pull-left margin-right-20">
                                    <label>
                                        <button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i> 查询</button>
                                        <a href="{route('EditMemberInfo')}" class="btn btn-primary"><i class="icon-plus"></i> 添加新会员</a>
                                        <a href="javascript:;" class="btn btn-success" id="multiImportMember"><i class="icon-upload-alt icon-white"></i> EXCEL批量导入会员 </a>
                                    </label>
                                </div>
                            </FORM>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered dataTable">
                        <thead>
                        <tr>
                            <th>用户</th>
                            <th>会员姓名</th>
                            <th>会员编号</th>
                            <th>手机号</th>
                            <th>性别</th>
                            <th>年龄</th>
                            <th>来源</th>
                            <th>等级</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyres">
                        {foreach $list as $member}
                            <tr>
                                <td>{$member.member.username}</td>
                                <td>{$member.real_name|default:'-'}</td>
                                <td>{$member.member_sn|default:'-'}</td>
                                <td>{$member.mobile}</td>
                                <td>{if $member.gender eq 'Man'}男{else}女{/if}</td>
                                <td>{$member.age}</td>
                                <td>{if $member.kind eq MemberInfo::KIND_ONLINE}APP{elseif $member.kind eq MemberInfo::KIND_OFFLINE}线下会员{else}员工{/if}</td>
                                <td>V{$member.level}</td>
                                <td>
                                    {if $member.member_id}
                                        <span class="badge badge-success">已注册</span>
                                    {else}
                                        <span class="badge badge-important">未注册</span>
                                    {/if}
                                </td>
                                <td>
                                    <a href="{route('EditMemberInfo', ['member_id' => $member.id])}" class="btn btn-info">编辑</a>
                                    <a href="javascript:;" class="btn btn-danger delete_member" data-id="{$member.id}">删除</a>
                                </td>
                            </tr>
                        {foreachelse}
                            <tr>
                                <td colspan="10" style="text-align: center;">暂时没有相关会员信息！</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>

                    <div style="text-align: right;">{$list->links()}</div>
                </div>
            </div>
        </div>
    </div>


    <!-- start Modal Excel批量导入员工 -->
    <div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel4">Excel批量导入会员</h3>
        </div>
        <form enctype="multipart/form-data" method="post" action="{route('MultiImportMember')}" id="ImportMemberExcelForm">
            <div class="modal-body" >
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
										<input type="file" class="default" name="file" />
									</span>
                                        <span class="fileupload-preview"></span>
                                        <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="div-table">
                        <div class="div-tr">
                            <div class="div-td td-label">
                                <div class="div-cell">下载范本</div>
                            </div>
                            <div class="div-td td-field">
                                <a href="{asset('excel/import_member.xls')}">下载Excel范本</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true" type="button">关闭</button>
                <button class="btn btn-primary" type="submit">提交</button>
            </div>
        </form>
    </div>
    <!-- end Modal -->
{/block}

{block script}
<script>
    $(".delete_member").click(function() {
        var member_id = $(this).attr('data-id');
        var obj = $(this);
        if (member_id) {
            iconfirm('确认要删除此会员吗？', function() {
                $.post('{route('DeleteMember')}', { member_id : member_id }, function(data) {
                    obj.closest('tr').slideUp('slow');
                }, 'text');
            });
        }
    });

    $("#multiImportMember").click(function() {
        $("#myModal1").modal('show');
    });

</script>
{/block}
