{extends file='layout/main.tpl'}

{block title}区域负责人{/block}

{block breadcrumb}
<li>区域/门店管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('AreaStoreManagerList')}">区域负责人列表</a><span class="divider">&nbsp;</span></li>
<li><a href="javascript:;">{if $data.id gt 0}编辑{else}添加{/if}区域负责人</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<!-- BEGIN ADVANCED TABLE widget-->
<div class="row-fluid">
    <div class="span12">
    <!-- BEGIN widget-->
    <div class="widget">
        <div class="widget-title">
        <h4><i class="icon-reorder"> {if $data.id gt 0}编辑{else}新增{/if}区域负责人信息</i></h4>
    </div>
    <div class="widget-body form">
    <!-- BEGIN FORM-->
    <form id="form" class="form-horizontal" method="post" action="{route('AreaStoreManagerSave')}">        
        <div class="control-group">
            <label class="control-label">用户名：</label>
            <div class="controls">
                <input type="text" class="span6" id="username" name="username" value="{Input::old('username')|default:$data.username}" placeholder=""/>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">密码：</label>
            <div class="controls">
                <input type="password" class="span6" id="password" name="password" value="" placeholder=""/>
                <span class="help-inline">不修改请留空，新增帐号时密码不能为空（密码为6~16位任意字符）</span>
            </div>
        </div> 
        <div class="control-group local_channel">
            <label class="control-label">所管辖区域：</label>
            <div class="controls">
                <div id="linkSelecter" style="margin-bottom: 10px;display: none;">
                    <select class="span6 sub_group" data-placeholder="请选择一级" tabindex="1" style="width: 150px;" name="group[]">
                        <option value="0">--请选择--</option>
                        {foreach $group as $item}
                            <option value="{$item->id}">{$item->name}</option>
                        {/foreach}
                    </select>
                    <button type="button" class="btn btn-primary addSelecter">增加</button>
                    <button type="button" class="btn btn-danger removeSelecter">删除</button>
                </div>
                <div id="link_list">
                    {if $group_data}
                        {foreach $group_data as $key1=>$group1}
                            <div id="linkSelecter" style="margin-bottom: 10px;">
                                {foreach $group1 as $key2=>$group2}
                                    <select class="span6 sub_group" data-placeholder="请选择一级分类" tabindex="1" style="width: 150px;" name="group[]">
                                        {foreach $group2 as $key3=>$group3}
                                            <option value="{$group3.id}" {if $group_id.$key1.$key2 eq $group3.id}selected{/if}>{$group3.name}</option>
                                        {/foreach}
                                    </select>
                                {/foreach}
                                <button type="button" class="btn btn-primary addSelecter">增加</button>
                                <button type="button" class="btn btn-danger removeSelecter">删除</button>
                            </div>
                        {/foreach}
                    {else}
                        <div style="margin-bottom: 10px;">
                            <select class="span6 sub_group" data-placeholder="请选择一级分类" tabindex="1" style="width: 150px;" name="group[]">
                                <option value="0">--请选择--</option>
                                {foreach $group as $item}
                                    <option value="{$item->id}">{$item->name}</option>
                                {/foreach}
                            </select>
                            <button type="button" class="btn btn-primary addSelecter">增加</button>
                            <button type="button" class="btn btn-danger removeSelecter">删除</button>
                        </div>
                    {/if}
                </div>
            </div>
        </div>    
     
        <div class="control-group">
        	<div class="controls">
        		<input type="hidden" name="id" id="id"  value="{$data.id}"/>
	            <button type="submit" class="btn btn-success">保存</button>
	            <button type="button" class="btn" onclick="history.go(-1);">取消</button>
	        </div>
        </div>
    </form>
    <!-- END FORM-->
</div>
<!-- END ADVANCED TABLE widget-->
</div>
</div>


    <div class="modal fade" id="MessageModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Message</h4>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
{/block}

{block script}
<script type="text/javascript">
//产生下级分类
$(document).on('change', ".sub_group", function() {
    var obj=$(this);
    var parent_id = $(this).val();
    $.getJSON("{route("GroupSub")}", { parent_id:parent_id }, function(data) {
        if (data.length > 0) {
            var select = '<select class="span6 sub_category" style="width:150px;" name="group[]" tabindex="1"><option value="0">--请选择--</option>';
            $(data).each(function(i, e) {
                select += "<option value='"+ e.id+"'>"+ e.name+"</option> ";
            });
            select += "</select>";
            obj.after(select);
        }
    });
});

//增加一行
$(document).on('click', '.addSelecter', function(){
    addLinkSelecter();
});

//删除一行
$(document).on('click', '.removeSelecter', function()
{
    var parent = $(this).parent();
    var del = false;
    if (parent.find('[name="category[]"]').val() != '') {
        if (confirm('确定要删除吗？')) {
            del = true;
        }
    } else {
        del = true;
    }
    if (del) {
        $(this).parent().remove();
        $("#link_list .addSelecter:last").show();
    }
});

//克隆函数
function addLinkSelecter()
{
    $("#link_list .addSelecter").hide();
    var link = $("#linkSelecter").clone().show();
    $("#link_list").append(link);
}

$("#link_list .addSelecter:not(':last')").hide();

$(document).on('click', '.add-item', function() {
    var obj = $(this).closest('div').clone();
    obj.find('.sku_span .sku_input').val('');
    $(".add-item").hide();
    $("#sku_list").append(obj);
    $(".minus-item").show();
    refreshSkuInputIndex();
});

function ialert(msg)
{
    $('#MessageModal').find('.modal-body p').text(msg).end().one('hidden.bs.modal', function(){
    }).modal();
}
</script>
{/block}