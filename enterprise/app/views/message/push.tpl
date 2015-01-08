{extends file='layout/main.tpl'}

{block title}消息推送{/block}

{block breadcrumb}
    <li>系统管理 <span class="divider">&nbsp;</span></li>
    <li><a href="{route('EditPushMessage')}">发布推送消息</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN widget-->
            <div class="widget">
                <div class="widget-title">
                    <h4>
                        <i class="icon-reorder"></i> 消息推送
                    </h4>
                </div>
                <div class="widget-body form">
                    <!-- BEGIN FORM-->
                    <form id="form" class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label">选择组别：</label>
                            <div class="controls">
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
                                </label>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label">消息内容:</label>
                            <div class="controls">
                                <textarea class="span12" name="content" id="content" rows="6"></textarea>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls">
                                <button type="button" class="btn btn-success" id="submit_form">发 送</button>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
                <!-- END ADVANCED TABLE widget-->
            </div>
        </div>
    </div>
{/block}

{block script}
<script type="text/javascript">

    $("#submit_form").click(function() {
        if ($("#content").val() == '') {
            ialert('请输入要推送的消息内容！');
            return false;
        }
        $.post('{route('PushMessage')}', $("#form").serialize(), function(data) {
            ialert('消息推送成功');
        }, 'text');
    });

</script>
{/block}