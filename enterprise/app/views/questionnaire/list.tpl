{extends file='layout/main.tpl'}

{block title}问卷调查{/block}

{block breadcrumb}
    <li>问卷调查<span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetQuestionnaireList')}">问卷调查列表</a> <span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i> 问卷调查列表</h4>
                </div>
                <div class="widget-body">
                    <div class="row-fluid">
                        <div class="span12">
                            <a href="{route('AddQuestionnaire')}" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加问卷调查</a>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered dataTable">
                        <thead>
                        <tr>
                            <th>创建时间</th>
                            <th>标题</th>
                            <th>开始时间</th>
                            <th>结束时间</th>
                            <th>状态</th>
                            <th>查看人数</th>
                            <th>参与调查人数</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach $list as $item}
                            <tr class="odd gradeX" data-id="{$item.id}">
                                <td>{$item.created_at|date_format:"%Y-%m-%d %H:%M"}</td>
                                <td>{$item.name}</td>
                                <td>{if $item.start_time}{$item.start_time|date_format:"%Y-%m-%d"}{else}{/if}</td>
                                <td>{if $item.end_time}{$item.end_time|date_format:"%Y-%m-%d"}{else}{/if}</td>
                                <td>{if $item.status eq Questionnaire::STATUS_OPEN}<span class="badge badge-important">进行中</span>
                                {elseif $item.status eq Questionnaire::STATUS_CLOSE}<span class="badge">已结束</span>
                                {elseif $item.status eq Questionnaire::STATUS_UNOPENED}<span class="badge badge-success">未开放</span>
                                {else}未知状态{/if}</td>
                                <td>{$item.view_count}</td>
                                <td>{$item.join_count}</td>
                                <td>{if $item.status eq Questionnaire::STATUS_OPEN}
                                	<a href="{route('ViewQuestionnaireInfo', ['questionnaire_id' => $item.id])}" class="btn mini btn" style="font-size:15px;"><i class="icon-eye-open"></i> 查看</a>
                                {elseif $item.status eq Questionnaire::STATUS_CLOSE}
                                	<a href="{route('ViewQuestionnaireInfo', ['questionnaire_id' => $item.id])}" class="btn mini btn" style="font-size:15px;"><i class="icon-eye-open"></i> 查看</a>
                                	<button class="btn mini black deleteQuestionnaire btn-danger" data-id="{$item.id}"><i class="icon-trash"></i> 删除</button>
                                {elseif $item.status eq Questionnaire::STATUS_UNOPENED}
                                	<a href="{route('AddQuestionnaire', ['questionnaire_id' => $item.id])}" class="btn mini btn-primary" style="font-size:15px;"><i class="icon-edit"></i> 修改</a>
                                	<button class="btn mini btn-success close_issue"><i class="icon-ok"></i> 开放</button>
                                	<button class="btn mini black deleteQuestionnaire btn-danger" data-id="{$item.id}"><i class="icon-trash"></i> 删除</button>
                                {else}{/if}
                                </td>
                            </tr>
                        {foreachelse}
                            <tr>
                                <td colspan="5" style="text-align: center;">您暂时没有相关问卷调查信息</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="dataTables_paginate">{$list->links()}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE widget-->
        </div>
    </div>
    <!-- END ADVANCED TABLE widget-->

    <div class="modal fade" id="DeleteConfirmModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">开放确认</h4>
                </div>
                <div class="modal-body">
                    <p>您确定要开放“<strong id="questionnaire_name"></strong>”吗？</p>
                </div>
                <div class="modal-footer">
                    <form method="post" action="{route('ToggleQuestionnaireStatus')}">
                        <input type="hidden" name="questionnaire_id" value="{$item.id}" id="questionnaire_id" >
                        <input type="hidden" name="status" value="{Questionnaire::STATUS_OPEN}"/>
                        <button class="btn" type="button" data-dismiss="modal" aria-hidden="true">取消</button>
                        <button class="btn btn-danger" type="submit">确定</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
{/block}

{block script}
<script>
    $(".close_issue").click(function()
    {
        var tr = $(this).closest('tr');
        var id = tr.attr('data-id');
        var name = tr.find('td:first').next().text();
        $("#questionnaire_id").val(id);
        $("#questionnaire_name").text(name);
        $("#DeleteConfirmModal").modal('show');
    });
    
    $(".deleteQuestionnaire").click(function() {
        var id = $(this).attr('data-id');
        iconfirm('确定要删除此问卷调查吗？', function() {
            $.post('{route("DeleteQuestionnaire")}', { id: id }, function(data) {
                window.location.reload();
            }, 'text');
        });
    });
</script>
{/block}
