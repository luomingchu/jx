{extends file='layout/main.tpl'}

{block title}内购额发放{/block}

{block breadcrumb}
    <li>系统管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('EditMemberInsource')}">内购额发放</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid ">
        <div class="span12">
            <!-- BEGIN INLINE TABS PORTLET-->
            <div class="widget">
                <div class="widget-body">
                    <div class="row-fluid">
                        <!--BEGIN TABS-->
                        <div class="tabbable tabbable-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1_1" data-toggle="tab">按组别</a></li>
                                <li><a href="#tab_1_2" data-toggle="tab">按用户</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1_1" style="padding-left: 20px;">
                                    <form id="group_form">
                                        <div class="control-group">
                                            <div class="controls">
                                                <span style="width: 80px;display: inline-block;">选择组别：</span>
                                                <label class="radio">
                                                    <input type="radio" name="group" value="All" checked/>
                                                    全部
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" name="group" value="Staff"  />
                                                    员工用户
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" name="group" value="Vstore" />
                                                    指店店主
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" name="group" value="Member" />
                                                    会员
                                                    <span id="level_check" style="display:none;padding-left: 10px;">
                                                        <input type="checkbox" name="level" value="1"> V1
                                                        <input type="checkbox" name="level" value="2"> V2
                                                        <input type="checkbox" name="level" value="3"> V3
                                                        <input type="checkbox" name="level" value="4"> V4
                                                    </span>
                                                </label>

                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <span style="width: 80px;display: inline-block;">内购额：</span>
                                                <input type="text" placeholder="请输入要发放的内购额" class="input" id="group_amount" value=""/>
                                                <span class="help-inline"></span>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="button" class="btn" id="goBack"><i class=" icon-remove"></i> 取消</button>
                                            <button type="button" id="grantByGroup" class="btn btn-primary"><i class="icon-ok"></i> 保存</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="tab_1_2" style="padding-left: 20px;">
                                    <form id="member_form">
                                        <div class="control-group">
                                            <div class="controls">
                                                <span style="width: 80px;display: inline-block;">用户搜索：</span>
                                                <input type="text" name="username" id="username" placeholder="用户登录名/电话号码"/>
                                                <input type="button" id="searchUser" class="btn btn-primary" value="搜索" style="position:relative;top: -5px;"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <span style="width: 80px;display: inline-block;">用户列表：</span>
                                                <span id="member_list">请先搜索</span>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <span style="width: 80px;display: inline-block;">内购额：</span>
                                                <input type="text" placeholder="请输入要发放的内购额" class="input" name="amount" id="member_amount" value=""/>
                                                <span class="help-inline"></span>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="button" class="btn" id="goBack"><i class=" icon-remove"></i> 取消</button>
                                            <button type="button" id="grantByMember" class="btn btn-primary"><i class="icon-ok"></i> 保存</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--END TABS-->
                    </div>
                </div>
            </div>
            <!-- END INLINE TABS PORTLET-->
        </div>
    </div>

    <div id="MessageModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <h3 id="myModalLabel1">提示</h3>
        </div>
        <div class="modal-body">
            <p id="MessageContent">

            </p>
        </div>
    </div>
{/block}

{block script}
<script type="text/javascript">

    $("#grantByGroup").click(function() {
        var amount = $.trim($("#group_amount").val());
        if (amount == '' || ! (/^[0-9]+$/.test(amount))) {
            ialert('发放的内购额不能为空，请只能是整数的数字字符');
            return false;
        }
        $("#MessageModal").modal({
            keyboard: false,
            backdrop: 'static'
        });
        $("#MessageContent").html('内购额发放中，请稍后 <img src="{asset("assets/pre-loader/Fading squares.gif")}"/>');
        $("#MessageModal").modal('show');
        var level = new Array();
        $("[name='level']:checked").each(function() {
            level.push($(this).val());
        });
        $.ajax({
            type: 'POST',
            url: '{route("GrantByGroup")}',
            dataType: 'text',
            data: { amount : amount, group: $("[name='group']:checked").val(), level: level },
            success: function(data) {
                $("#MessageModal").modal('hide');
                ialert('内购额发放成功');
            },
            error: function(xhq) {
                $("#MessageModal").modal('hide');
                ialert(xhq.responseText);
            }
        });
    });

    $("#searchUser").click(function() {
        var username = $.trim($("#username").val());
        if (username != '') {
            $("#MessageModal").modal({
                keyboard: false,
                backdrop: 'static'
            });
            $("#MessageContent").html('用户搜索中，请稍后 <img src="{asset("assets/pre-loader/Fading squares.gif")}"/>');
            $("#MessageModal").modal('show');
            $.ajax({
                type: 'GET',
                url: '{route("SearchMember")}',
                data: { username : username },
                dataType: 'json',
                success: function(data) {
                    $("#MessageModal").modal('hide');
                    var html = "";
                    for (var i in data) {
                        html += '<span style="margin-right: 10px;"><input type="checkbox" name="member_id[]" value="'+data[i]['member']['id']+'" />  '+data[i]['member']['username']+'</span>';
                    }
                    $("#member_list").html(html);
                },
                error: function(xhq) {
                    $("#MessageModal").modal('hide');
                    ialert(xhq.responseText);
                }
            });
        }
    });

    $("#grantByMember").click(function()
    {
        if ($("#member_amount").val() != '' && $("[name='member_id[]']:checked").size() > 0) {
            $.ajax({
                type: 'POST',
                url: '{route("GrantByMember")}',
                data: $("#member_form").serialize(),
                dataType: 'text',
                success: function(data) {
                    ialert('内购额发放成功');
                },
                error: function(xhq) {
                    $("#MessageModal").modal('hide');
                    ialert(xhq.responseText);
                }
            });
        }
    });

    $("[name='group']").click(function() {
        if ($(this).val() == 'Member') {
            $("#level_check").show();
        } else {
            $("#level_check").hide();
        }
    });

</script>
{/block}