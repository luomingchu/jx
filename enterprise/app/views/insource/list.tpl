{extends file='layout/main.tpl'}

{block title}内购额列表{/block}

{block breadcrumb}
    <li>系统管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetInsourceLogList')}">内购额列表</a><span class="divider-last">&nbsp;</span></li>
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
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1_1" style="padding-left: 20px;">
                                    <form id="insouce_form" method="get">
                                        <div class="control-group">
                                            <div class="controls">
                                                <span style="display: inline-block;">类型：</span>
                                                <select name="key" style="width: 120px;">
                                                    <option value="all" {$smarty.get.key eq 'all'}>所属类型</option>
                                                    {foreach $sources as $source}
                                                        <option value="{$source.key}" {if $smarty.get.key eq $source.key || (empty($smarty.get.key) && $source.key eq 'enterprise_grant')}selected="selected" {/if}>{$source.name}</option>
                                                    {/foreach}
                                                </select>
                                                <span style="display: inline-block;">类别：</span>
                                                <select name="type" style="width: 100px;">
                                                    <option value="">所有类别</option>
                                                    <option value="{Insource::TYPE_INCOME}" {if $smarty.get.type eq Insource::TYPE_INCOME}selected="selected" {/if}>收入</option>
                                                    <option value="{Insource::TYPE_EXPENSE}" {if $smarty.get.type eq Insource::TYPE_EXPENSE}selected="selected" {/if}>支出</option>
                                                </select>
                                                <span style="width: 80px;display: inline-block;">用户名：</span>
                                                <input type="text" name="username" value="{$smarty.get.username}" style="width: 150px;" placeholder="请输入要查找的用户名"/>
                                                <span style="width: 80px;display: inline-block;">所属门店：</span>
                                                <select name="store" id="store">
                                                    <option value="">所有门店</option>
                                                    {foreach $stores as $store}
                                                    <option value="{$store.id}" {if $store.id eq $smarty.get.store}selected="selected" {/if}>{$store.name}</option>
                                                    {/foreach}
                                                </select>

                                                <input type="submit" value="搜索" class="btn btn-primary" style="position: relative;top: -5px;"/>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--END TABS-->
                    </div>
                    <table class="table table-striped table-bordered table-hover" id="goods_item_list">
                        <thead>
                        <tr>
                            <th>用户</th>
                            <th>类型</th>
                            <th>类别</th>
                            <th>数量</th>
                            <th>备注</th>
                            <th>更改时间</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyres">
                        {foreach $list as $item}
                            <tr>
                                <td>{$item.member.username}{if $item.member.real_name}（{$item.member.real_name}）{/if}</td>
                                <td>{$sources[$item.key]['name']}</td>
                                <td>{if $item.type eq Insource::TYPE_INCOME}<span style="color: green;">收入{else}<span style="color: red;">支出{/if}</span></td>
                                <td>{$item.amount}</td>
                                <td>{$item.remark}</td>
                                <td>{$item.created_at}</td>
                            </tr>
                        {foreachelse}
                            <tr>
                                <td colspan="6" style="text-align: center;">暂时没有相关记录信息！</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                    <div style="text-align: right;">
                        {if !empty($list)}
                            {$list->links()}
                        {/if}
                    </div>
                </div>
            </div>
            <!-- END INLINE TABS PORTLET-->
        </div>
    </div>

{/block}

{block script}
<script type="text/javascript">
    $("#store").change(function() {
        getVstore();
    });

    function getVstore() {
        var vstore = "{$smarty.get.vstore}";
        $("#vstore").remove();
        var store_id = $("#store").val();
        if (store_id) {
            $.get('{Route("GetVstoreList")}', { store_id : store_id }, function(data) {
                if (data.length > 0) {
                    var html = "&nbsp;&nbsp;<select name='vstore' id='vstore'><option value=''>所属指店</option> ";
                    var selected = '';
                    for (var i in data) {
                        if (vstore == data[i]['id']) {
                            selected = 'selected="selected"';
                        }
                        html += "<option "+selected+" value='"+data[i]['id']+"'>"+data[i]['name']+"</option>";
                    }
                    $("#store").after(html);
                }
            });
        }
    }

    getVstore();
</script>
{/block}