{extends file='layout/main.tpl'}

{block title}指店管理{/block}

{block breadcrumb}
    <li>指店管理 <span class="divider">&nbsp;</span></li>
    <li><a href="{route('VstoreList')}">指店列表</a><span class="divider">&nbsp;</span></li>
    <li>查看/审核指店<span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
<div class="row-fluid">
    <div class="span12">
        <!-- BEGIN widget-->
        <div class="widget">
            <div class="widget-title">
                <h4><i class="icon-reorder"> 查看/审核指店信息</i></h4>
            </div>
            <div class="widget-body form">
                <!-- BEGIN FORM-->
                <form id="form" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">指店名称：</label>
                        <label class="control-label">{$data.name}</label>
                    </div>

                    <div class="control-group">
                        <label class="control-label">指店主姓名：</label>
                        <label class="control-label">{$data.member.real_name}</label>
                    </div>

                    <div class="control-group">
                        <label class="control-label">指店主身份证：</label>
                        <label class="control-label">{$data.member.id_number}</label>
                    </div>

                    <div class="control-group">
                        <label class="control-label">指店主认证照片：</label>
                        <div class="controls">
                       		{if $data.member.id_picture}
                                <a href="{$data.member.id_picture.url}" target="_blank">
                                    <img src="{$data.member.id_picture.url}" style="width:160px;height:160px"/>
                                </a>
                            {/if}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">所属门店：</label>
                        <label class="control-label">{$data.store.name}</label>
                    </div>

                    <div class="control-group">
                        <label class="control-label">指店状态：</label>
                        <!-- 只有需门店审核的状态门店选择状态 -->
                        {if $data.status eq Vstore::STATUS_ENTERPRISE_AUDITING}
                            <label>
                                <label class="radio">
                                    <input type="radio" name="status" value="{Vstore::STATUS_ENTERPRISE_AUDITED}"/> 通过
                                </label>
                                <label class="radio">
                                    <input type="radio" name="status" id="status_ng"
                                           value="{Vstore::STATUS_ENTERPRISE_AUDITERROR}"/> 不通过
                                </label>
                            </label>
                        {else}
                            <!-- 只有需门店审核的状态门店选择状态 -->
                            <label>{trans('vstore.status.'|cat:$data.status)}</label>
                        {/if}
                    </div>

                    {if $data.status eq Vstore::STATUS_ENTERPRISE_AUDITING}
                        <div class="control-group" id="enterprise_reject_reason">
                            <label class="control-label">不通过理由:</label>
                            <div class="controls">
                                <input type="text" placeholder="请输入拒绝理由" class="input-large text span5" name="enterprise_reject_reason"
                                       value="{Input::old('enterprise_reject_reason')}"/>
                                <span class="help-inline"></span>
                            </div>
                        </div>
                    {else}
                        {if $data.enterprise_reject_reason}
                            <div class="control-group" id="enterprise_reject_reason">
                                <label class="control-label">不通过理由:</label>
                                <label>{$data.enterprise_reject_reason}</label>
                            </div>
                        {/if}
                    {/if}
                    <div class="control-group">
                        <div class="controls">
                            <input type="hidden" name="id" id="id" value="{$data.id}"/>
                            {if $data.status eq Vstore::STATUS_ENTERPRISE_AUDITING}
                                <button type="button" class="btn btn-success" id="submit_form">保存</button>
                            {/if}
                            <button type="button" class="btn" onclick="history.go(-1);">返回</button>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
            <!-- END ADVANCED TABLE widget-->
        </div>
    </div>
{/block}

{block script}
<script type="text/javascript">
    var open = "{Vstore::STATUS_OPEN}";
    var status = "{$data.status}";
    if (status == open) {
        $("#enterprise_reject_reason").hide();
    } else {
        $("#enterprise_reject_reason").show();
    }
    $(function () {
        $("input[name='status']").click(function () {
            var id = $(this).attr("id");
            if (id == "status_ng") {
                $("#enterprise_reject_reason").show();
            } else {
                $("#enterprise_reject_reason").hide();
            }

        });
    });

    $("#submit_form").click(function () {
        var action = $(this).attr('data-action');
        if (action == 1) {
            return false;
        }
        $(this).attr('data-action', 1);
        var data = $("#form").serialize();
        var obj = $(this);
        $.ajax({
            type: "POST",
            url: "{route('VstoreSave')}",
            dataType: 'json',
            data: data,
            success: function (data) {
                window.location.href = "{URL::previous()}";
            },
            error: function (xhq) {
                obj.attr('data-action', 0);
                ialert(xhq.responseText);
            }
        });
    });
</script>
{/block}