{extends file='layout/main.tpl'}

{block title prepend}编辑账户信息  {/block}

{block breadcrumb}
    <li>账户管理 <span class="divider">&nbsp;</span></li>
    <li><a href="{route('EditAccountInfo')}">账户信息</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
<div class="row-fluid">
<div class="span12">
    <!-- BEGIN widget-->
    <div class="widget">
        <div class="widget-title">
            <h4><i class="icon-reorder"> 编辑账户信息</i></h4>
        </div>
        <div class="widget-body form">
            <!-- BEGIN FORM-->
            <form id="form" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label"><font style="color:red">*</font>开户银行：</label>
                    <div class="controls">
                        <select name="bank_id" class="span3">
                            <option value="">请选择银行</option>
                            {foreach $banks as $bank}
                                <option value="{$bank.id}" {if $data.bank_id eq $bank.id}selected="selected" {/if}>{$bank.name}</option>
                            {/foreach}
                        </select>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><font style="color:red">*</font>银行网点：</label>
                    <div class="controls">
                        <input type="text" class="span3" id="branch_name" name="branch_name" value="{$data.branch_name}" placeholder=""/>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><font style="color:red">*</font>银行账户：</label>
                    <div class="controls">
                        <input type="text" class="span3" id="number" name="number" value="{$data.number}" placeholder=""/>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><font style="color:red">*</font>账户名称：</label>
                    <div class="controls">
                        <input type="text" class="span3" id="name" name="name" value="{$data.name}" placeholder=""/>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><font style="color:red">*</font>分行机构号：</label>
                    <div class="controls">
                        <input type="text" class="span3" id="branch_code" name="branch_code" value="{$data.branch_code}" placeholder=""/>
                        <span class="help-inline"></span>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <button type="button" class="btn btn-success" id="submit_form">保 存</button>
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
        var action = $(this).attr('data-action');
        if (action == 1) {
            return false;
        }
        $(this).attr('data-action', 1);
        var data = $("#form").serialize();
        var obj = $(this);
        $.ajax({
            type: "POST",
            url: "{route('SaveAccountInfo')}",
            dataType: 'text',
            data: data,
            success: function(data) {
                obj.attr('data-action', 0);
                ialert('保存账户信息成功！');
            },
            error : function(xhq) {
                obj.attr('data-action', 0);
                ialert(xhq.responseText);
            }
        });
    });
</script>
{/block}