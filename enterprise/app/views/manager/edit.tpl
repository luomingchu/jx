{extends file='layout/main.tpl'}

{block title}管理员列表{/block}

{block breadcrumb}
    <li>权限管理 <span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetManagerList')}">管理员列表</a><span class="divider">&nbsp;</span></li>
    <li><a href="{route('EditManagerInfo', ['id' => $info.id])}">编辑管理员</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
<div class="row-fluid">
    <div class="span12">
        <!-- BEGIN widget-->
        <div class="widget">
            <div class="widget-title">
                <h4><i class="icon-reorder"> 编辑管理员信息</i></h4>
            </div>
            <div class="widget-body form" style="padding-left: 50px;">
                <!-- BEGIN FORM-->
                <form id="form" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">登录用户名：</label>
                        <div class="controls">
                            <input type="text" class="span2" id="username" name="username" required="required" value="{Input::old('username')|default:$info.username}" placeholder=""/>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">登录密码：</label>
                        <div class="controls">
                            <input type="text" class="span2" id="password" name="password" required="required" value="{Input::old('password')}" placeholder=""/>
                            <span class="help-inline">密码至少为六位字符{if $info}，留空为不修改{/if}</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">真实姓名：</label>

                        <div class="controls">
                            <input type="text" class="span2" id="real_name" name="real_name" value="{Input::old('real_name')|default:$info.real_name}" placeholder=""/>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">手机号：</label>
                        <div class="controls">
                            <input type="text" class="span2" id="mobile" name="mobile" value="{Input::old('mobile')|default:$info.mobile}" placeholder=""/>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">邮箱：</label>
                        <div class="controls">
                            <input type="text" class="span2" id="email" name="email" value="{Input::old('email')|default:$info.email}" placeholder=""/>
                            <span class="help-inline"></span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">性别：</label>

                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="gender" {if $info.gender eq Manager::GENDER_MAN || $info.gender eq '' }checked{/if} value="{Manager::GENDER_MAN}" />
                                男
                            </label>
                            <label class="radio">
                                <input type="radio" name="gender" {if $info.gender eq  Manager::GENDER_FEMALE }checked{/if} value="{Manager::GENDER_FEMALE}" />
                                女
                            </label>

                        </div>
                    </div>
					{if $info.is_super eq Manager::SUPER_INVALID }
                    <div class="control-group">
                        <label class="control-label">状态：</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="status" {if $info.status eq Manager::STATUS_VALID || $info.status eq '' }checked{/if} value="{Manager::STATUS_VALID}" />
                                启用
                            </label>
                            <label class="radio">
                                <input type="radio" name="status" {if $info.status eq  Manager::STATUS_INVALID }checked{/if} value="{Manager::STATUS_INVALID}" />
                                禁用
                            </label>

                        </div>
                    </div>
					{/if}
                    <div class="control-group">
                        <div class="controls">
                            <input type="hidden" name="id" id="id"  value="{$info.id}"/>
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

    $("#submit_form").click(function() {
        var action = $(this).attr('info-action');
        if (action == 1) {
            return false;
        }
        $(this).attr('info-action', 1);
        var obj = $(this);
        $.ajax({
            type: "POST",
            url: "{route('SaveManagerInfo')}",
            dataType: 'json',
            data: $("#form").serialize(),
            success: function(info) {
                window.location.href = '{route("GetManagerList")}';
            },
            error : function(xhq) {
                obj.attr('info-action', 0);
                ialert(xhq.responseText);
            }
        });
    });
</script>
{/block}