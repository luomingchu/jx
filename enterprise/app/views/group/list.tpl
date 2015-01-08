{extends file='layout/main.tpl'}

{block title}区域列表{/block}

{block breadcrumb}
    <li>区域/门店管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('GroupList')}">区域列表</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">
            <!-- begin recent orders portlet-->
            <div class="widget">
                <div class="widget-body">
                    <div class="row-fluid">
                        <div class="span12 booking-search" style="padding-bottom:5px;">
                            <FORM action="{Route('GroupList')}" method="get" id="group_form">
                                <div class="pull-left margin-right-20">
                                    <div class="controls" id="group_list">
                                        <span style="font-size: 14px">门店区域：</span>
                                        <select name="group_id[]">
                                            <option value="">--全部--</option>
                                            {foreach $groups as $item}
                                                <option value="{$item.id}" {if $item.id eq $smarty.get.group_id.0}selected{/if}>{$item.name}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                                <div class="pull-left margin-right-20">
                                    <a href="javascript:$('#group_form').submit();" class="btn btn-primary"><i class="icon-search icon-white"></i> 查询</a>
                                    <a href="{route('EditGroup', ['group_id' => ''])}" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加门店区域</a>
                                </div>
                                <input type="hidden" id="select_group" value="{if $smarty.get.group_id}{implode(',', array_filter($smarty.get.group_id))}{/if}"/>
                            </FORM>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered dataTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>区域名称</th>
                            <th>上级分类名称</th>
                            <th>排序号</th>
                            <th>创建日期</th>
                            <th>修改日期</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyres">
                        {foreach $list as $group}
                            <tr class="odd gradeX" data-id="{$group.id}">
                                <td>{$group.id}</td>
                                <td>{$group.name}</td>
                                <td>{$group->parentNode()->first()->name|default:"一级"}</td>
                                <td>{$group.sort}</td>
                                <td>{$group.created_at|date_format:"%Y-%m-%d"}</td>
                                <td>{$group.updated_at|date_format:"%Y-%m-%d"}</td>
                                <td>
                                    <a class="btn btn-sm btn-default" href="{route('EditGroup', ['group_id' => $group.id])}"><i class="icon-edit"></i>编辑</a>
                                    <button class="btn mini black deleteGroup" data-id="{$group.id}"><i class="icon-trash"></i> 删除</button>
                                </td>
                            </tr>
                        {foreachelse}
                            <tr class="odd gradeX"><td colspan="8" style="text-align: center;">没有相关门店区域信息</td></tr>
                        {/foreach}
                    </table>
                    {if $list}
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="dataTables_info">显示 {$list->getFrom()} 到 {$list->getTo()} 项，共 {$list->getTotal()} 项。</div>
                            </div>
                            <div class="span6">
                                <div class="dataTables_paginate">{$list->appends(['group_id' => $smarty.get.group_id])->links()}</div>
                            </div>
                        </div>
                    {/if}
                </div>
            </div>
            <!-- end recent orders portlet-->
        </div>
    </div>

{/block}

{block script}
<script type="text/javascript">

    $(".deleteGroup").click(function() {
        var group_id = $(this).attr('data-id');
        iconfirm('确定要删除此区域吗？', function() {
            $.post('{route("DeleteGroup")}', { group_id: group_id }, function(data) {
                window.location.reload();
            }, 'text');
        });
    });

    //产生下级分类
    $(document).on('change', "[name='group_id[]']", function() {
        var parent_id = $(this).val();
        var obj = $(this);
        obj.nextAll().remove();
        if (parent_id != '') {
            getGroup(parent_id);
        }
    });

    function getGroup(group_id)
    {
        var select_group = arguments[1];

        $.getJSON("{route("GetSubGroups")}", { group_id: group_id }, function(data) {
            if (data.length > 0) {
                var select = '<select name="group_id[]"><option value="">--请选择--</option>';
                $(data).each(function(i, e) {
                    var selected = "";
                    if (select_group && select_group == e.id) {
                        selected = "selected='selected'";
                    }
                    select += "<option "+selected+" value='"+ e.id+"'>"+ e.name+"</option> ";
                });
                select += "</select>";
                $("#group_list").append(select);
            }
        });
    }

    function getGroupSeries(groupArr, index)
    {
        var select_group = groupArr[index+1];

        $.getJSON("{route("GetSubGroups")}", { group_id: groupArr[index] }, function(data) {
            if (data.length > 0) {
                var select = '<select name="group_id[]"><option value="">--请选择--</option>';
                $(data).each(function(i, e) {
                    var selected = "";
                    if (select_group && select_group == e.id) {
                        selected = "selected='selected'";
                    }
                    select += "<option "+selected+" value='"+ e.id+"'>"+ e.name+"</option> ";
                });
                select += "</select>";
                $("#group_list").append(select);
                if (groupArr.length > index+1) {
                    getGroupSeries(groupArr, index+1);
                }
            }
        });
    }

    if ($("#select_group").val() != '') {
        var groupArr = $("#select_group").val().split(',');
        if (groupArr.length > 0) {
            getGroupSeries(groupArr, 0);
        }
    }
</script>
{/block}
