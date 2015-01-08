{extends file='layout/main.tpl'}

{block title}区域列表{/block}

{block breadcrumb}
    <li>区域/门店管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('GroupList')}">区域列表</a><span class="divider">&nbsp;</span></li>
    {if Route::input('group_id') gt 0}
    	<li><a href="{route('EditGroup', ['group_id' => Route::input('group_id')])}">修改区域</a><span class="divider-last">&nbsp;</span></li>
    {else}
    	<li><a href="{route('EditGroup')}">添加区域</a><span class="divider-last">&nbsp;</span></li>
    {/if}
    </li>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">
            <!-- begin recent orders portlet-->
            <div class="widget">
                <div class="widget-title">
                    <h4>
                        <i class="icon-reorder"></i> {if $info}修改{else}添加{/if}区域
                    </h4>
                </div>
                <div class="widget-body">
                    <form method="post" action="{route('SaveGroupInfo')}" class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label">组织名称：</label>
                            <div class="controls">
                                <input type="text" placeholder="请输入组织名称" class="input-large" name="name" value="{Input::old('name')|default:$info.name}" required/>
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">上级组织：</label>
                            <div class="controls">
                                {if $info}
                                    <div style="margin-bottom: 10px;">{if $parent_info}{$parent_info.name}{else}顶级分类{/if} [<a href="javascript:;" id="editBelongGroup">修改</a>]</div>
                                    <input id="ori_parent_id" type="hidden" name="ori_parent_id" value="{$parent_info.id}"/>
                                    <input id="modify_group" type="hidden" name="modify_group" value="0"/>
                                {/if}
                                <select class="input-large m-wrap sub_category" name="parent_id[]" style="{if $info}display: none;{/if}">
                                    <option value="">--顶级--</option>
                                    {foreach $groups as $group}
                                        <option value="{$group.id}">{$group.name}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">排序号：</label>
                            <div class="controls">
                                <input type="text" placeholder="请输入组织排序号" class="input" name="sort" value="{Input::old('sort')|default:$info.sort}"/>
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div class="form-actions">
                            <input type="hidden" value="{$info.id}" name="group_id"/>
                            <button type="submit" class="btn blue"><i class="icon-ok"></i> 保存</button>
                            <button type="button" class="btn" id="goBack"><i class=" icon-remove"></i> 取消</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end recent orders portlet-->
        </div>
    </div>
{/block}

{block script}
<script type="text/javascript">
    $("#goBack").click(function() {
        window.history.go(-1);
    });

    $(document).on('change', ".sub_category", function () {
        var group_id = $(this).val();
        var obj = $(this);
        obj.nextAll().remove();
        if (group_id != '') {
            $.getJSON("{route("GetSubGroups")}", { group_id: group_id }, function (data) {
                if (data.length > 0) {
                    var select = '<select class="input-large m-wrap sub_category" name="parent_id[]"><option value="">--请选择--</option>';
                    $(data).each(function (i, e) {
                        select += "<option value='" + e.id + "'>" + e.name + "</option> ";
                    });
                    select += "</select>";
                    obj.parent().append(select);
                }
            });
        }
    });

    $("#editBelongGroup").click(function() {
        if ($(".sub_category:visible").size() > 0) {
            $(".sub_category").hide();
            $(this).text('修改');
            $("#modify_group").val(0);
        } else {
            $("#modify_group").val(1);
            $(this).text('取消修改');
            $(".sub_category").show();
        }
    });
</script>
{/block}