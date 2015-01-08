{extends file='layout/main.tpl'}

{block title}会员列表{/block}

{block breadcrumb}
	<li>系统管理 <span class="divider">&nbsp;</span></li>
    <li><a href="{route('ManageMember')}">会员管理</a><span class="divider">&nbsp;</span></li>
    <li><a href="{route('EditMemberInfo', ['member_id' => $smarty.get.member_id])}">{if $member_info}编辑{else}添加{/if}会员信息</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
<div class="row-fluid">
    <div class="span12">
        <!-- BEGIN widget-->
        <div class="widget">
            <div class="widget-title">
                <h4><i class="icon-reorder"> 添加/编辑会员信息</i></h4>
            </div>
            <div class="widget-body form">
                <!-- BEGIN FORM-->
                <form id="form" class="form-horizontal">

                    <div class="control-group">
                        <label class="control-label">会员姓名：</label>

                        <div class="controls">
                            <input type="text" class="" id="real_name" name="real_name" value="{$member_info.real_name}" placeholder=""/>
                            <span class="help-inline"></span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">会员编号：</label>

                        <div class="controls">
                            <input type="text" class="" id="member_sn" name="member_sn" value="{$member_info.member_sn}" placeholder=""/>
                            <span class="help-inline"></span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">出生年月：</label>
                        <div class="controls">
                            <input type="text" class="" id="birthday" name="birthday" readonly value="{$member_info.birthday}"/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">性别：</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="gender" {if $member_info.gender eq Member::GENDER_MAN || $member_info.gender eq '' }checked{/if} value="{Member::GENDER_MAN}" />
                                男
                            </label>
                            <label class="radio">
                                <input type="radio" name="gender" {if $member_info.gender eq  Member::GENDER_FEMALE }checked{/if} value="{Member::GENDER_FEMALE}" />
                                女
                            </label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">手机号：</label>
                        <div class="controls">
                            <div class="input-prepend input-append">
                                <input name="mobile" id="mobile"  value="{$member_info.mobile}" type="text"/>
                            </div>
                        </div>
                    </div>

                    <div class="control-group" {if !$member_info}style="display: none;"{/if}>
                        <label class="control-label">来&nbsp;&nbsp;&nbsp;&nbsp;源：</label>
                        <div class="controls">
                            {if $member_info.kind eq MemberInfo::KIND_OFFLINE}
                                线下会员
                            {elseif $member_info.kind eq MemberInfo::KIND_ONLINE}
                                APP新注册会员
                            {else}
                                员工
                            {/if}
                        </div>
                    </div>

                    <div class="control-group" {if !$member_info}style="display: none;" {/if}>
                        <label class="control-label">注册状态：</label>
                        <div class="controls">
                            {if $member_info.member_id}
                                已注册
                            {else}
                                未注册
                            {/if}
                        </div>
                    </div>

                    <div class="control-group" {if !$member_info}style="display: none;" {/if}>
                        <label class="control-label">等&nbsp;&nbsp;&nbsp;&nbsp;级：</label>
                        <div class="controls">
                            V{$member_info.level}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">备&nbsp;&nbsp;&nbsp;&nbsp;注：</label>
                        <div class="controls">
                            <textarea name="remark" style="width: 500px;height: 100px;">{$member_info.remark}</textarea>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <input type="hidden" name="id" id="id"  value="{$member_info.id}"/>
                            <button type="button" class="btn btn-success" id="submit_form">保存</button>
                            <button type="button" class="btn" onclick="history.go(-1);">取消</button>
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

    $(function() {
        $('#birthday').datetimepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            minView: 2,
            language: 'zh-CN'
        });
    });

    $("#submit_form").click(function() {
        var action = $(this).attr('data-action');
        if (action == 1) {
            return false;
        }
        $(this).attr('data-action', 1);
        var data = $("#form").serialize();
        var obj = $(this);
        $.ajax({
            type: "POST",
            url: "{route('SaveMemberInfo')}",
            data: data,
            success: function(data) {
                window.location.href = '{URL::previous()}';
            },
            error : function(xhq) {
                obj.attr('data-action', 0);
                ialert(xhq.responseText);
            }
        });
    });
</script>
{/block}