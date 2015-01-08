{extends file='layout/main.tpl'}

{block title}角色管理{/block}

{block breadcrumb}
    <li>权限管理 <span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetRoleList')}">角色管理</a><span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetRolePurview', ['role_id' => $info.id])}">角色授权</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-body">
                    <div style="margin-left: 5px; font-size: 16px;font-weight: bold;margin-bottom: 15px;border-bottom: 1px dotted #ccc;color: #333;padding-bottom: 10px;">角色：{$info.name}</div>
                    <form id="purview_form">
                        {$html}
                        <input type="hidden" name="role_id" value="{$info.id}"/>
                    </form>
                    <input type="button" class="btn" onclick="javascript:window.location.href = '{URL::previous()}';" value="返 回">
                    <input type="button" class="btn btn-primary" id="submitForm" value="确 定"/>
                </div>
            </div>
        </div>
    </div>
{/block}

{block script}
<script type="text/javascript" src="{asset('assets/bootstrap/js/bootstrap-tooltip.js')}"></script>
<script type="text/javascript">
    $('.node').tooltip();

    $('.node').click(function(e) {
        e.stopPropagation();
        e.preventDefault();
        var checkbox = $(this).find(':checkbox');
        if (checkbox.is(":checked")) {
            checkbox.removeAttr('checked').parent().removeClass('checked');
        } else {
            checkbox.attr('checked', 'checked').parent().addClass('checked');
            var obj = checkbox.closest('.sub_rule_module').prev('div');
            obj.find(':checkbox').attr('checked', 'checked').parent().addClass('checked');
            recursiveCheck(obj);
        }
        return false;
    });

    function recursiveCheck(obj)
    {
        var module = obj.closest('.rule_module').parent('.rule_module');
        if (module.size() > 0) {
            var checkbox = module.children('div').eq(0).find(':checkbox');
            checkbox.attr('checked', 'checked').parent().addClass('checked');
            recursiveCheck(checkbox);
        }
    }

    $('.parent_node').click(function(e) {
        e.stopPropagation();
        e.preventDefault();
        var checkbox = $(this).find(':checkbox');
        if (checkbox.is(":checked")) {
            checkbox.removeAttr('checked').parent().removeClass('checked');
            $(this).closest('.rule_module').find(':checkbox').removeAttr('checked').parent().removeClass('checked');
        } else {
            checkbox.attr('checked', 'checked').parent().addClass('checked');
            $(this).closest('.rule_module').find(':checkbox').attr('checked', 'checked').parent().addClass('checked');
            var obj = $(this).closest('.rule_module');
            recursiveCheck(obj);
        }
        return false;
    });

    $("#submitForm").click(function() {
        var action = $(this).attr('data-action');
        if (action == 1) {
            return false;
        }
        var obj = $(this);
        $(this).attr('data-action', 1);
        $.ajax({
            type:"POST",
            url: '{route("SaveRolePurview")}',
            data:$("#purview_form").serialize(),
            dataType:'text',
            success: function(data) {
                window.location.href = "{URL::previous()}";
            },
            error:function(xhq) {
                obj.attr('data-action', 0);
                ialert(xhq.responseText);
            }
        });
    });

</script>
{/block}