{extends file='layout/main.tpl'}

{block title}指店等级设置{/block}

{block breadcrumb}
    <li>指店管理 <span class="divider">&nbsp;</span></li>
    <li><a href="{route('VstoreLevelManage')}">指店等级设置</a> <span class="divider-last">&nbsp;</span></li>
{/block}

{block head}
<style type="text/css">
    .modify { display: none; }
</style>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">
            <!-- begin recent orders portlet-->
            <div class="widget">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i>指店等级设置</h4>
                    <span class="tools">
                        <a href="javascript:;" id="editLevel" class="btn btn-primary btn-mini" style="position:relative;top:-3px;color: #fff;">编辑</a>
                    </span>
                </div>
                <div class="widget-body">
                    <div id="DataView"></div>
                    <form id="level_form" method="get">
                    <table class="table table-striped table-bordered" id="DataViewTable">
                        <thead>
                        <tr>
                            <th>等级</th>
                            <th>对应星级</th>
                            <th>条件</th>
                            <th>指店佣金比</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach range(0.5, 5, 0.5) as $level}
                            {if $level-floor($level) == 0}
                                {$level="$level.0"}
                            {/if}
                            <tr>
                                <td style="text-align: center;vertical-align: middle;">{$level}</td>
                                <td style="text-align: center;vertical-align: middle;">
                                    {str_repeat("<i class='icon-star' style='width:100px;'></i>", floor($level))}{if $level-floor($level) > 0}<i class="icon-star-half"></i>{/if}
                                </td>
                                <td>
                                    {if $list["$level"]}
                                        <div class="normal">
                                            成交量≥ {$list["$level"]['trade_count']} 笔
                                            <br/>
                                            成交额≥ {$list["$level"]['turnover']} 元
                                        </div>
                                        <div class="modify">
                                            成交量≥ <input type="text" name="trade_count[{$level}]" class="trade_count" data-value="{$list["$level"]['trade_count']}" value="{$list["$level"]['trade_count']}" style="width: 70px;"/> 笔
                                            <br/>
                                            成交额≥ <input type="text" name="turnover[{$level}]" class="turnover" data-value="{$list["$level"]['turnover']}" value="{$list["$level"]['turnover']}"  style="width: 70px;"/> 元
                                        </div>
                                    {else}
                                        <div class="normal">
                                            暂无设置
                                        </div>
                                        <div class="modify">
                                            成交量≥ <input type="text" name="trade_count[{$level}]" data-value="" value="" style="width: 70px;"/> 笔
                                            <br/>
                                            成交额≥ <input type="text" name="turnover[{$level}]" value="" style="width: 70px;"/> 元
                                        </div>
                                    {/if}
                                </td>
                                <td style="text-align: center;vertical-align: middle;">
                                    {if $list["$level"]}
                                    <div class="normal">
                                        {$list["$level"]['brokerage_ratio']}%
                                    </div>
                                    <div class="modify">
                                        <input type="text" name="brokerage_ratio[{$level}]" class="brokerage_ratio" value="{$list["$level"]['brokerage_ratio']}" style="width: 60px;"/> %
                                    </div>
                                    {else}
                                    <div class="normal">
                                        暂无设置
                                    </div>
                                    <div class="modify">
                                        <input type="text" name="brokerage_ratio[{$level}]" value="" style="width: 60px;"/> %
                                    </div>
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                    </form>
                    <div id="action_bar" style="text-align: right;margin-top: 20px;margin-right: 10px;border-top: 1px dotted #ccc;padding-top: 10px;display: none;">
                        <input type="button" value="确认修改" id="submitForm" class="btn btn-primary"/>
                        <input type="button" value="取消" id="cancelEdit" class="btn"/>
                    </div>
                </div>
            </div>
            <!-- end recent orders portlet-->
        </div>
    </div>
{/block}

{block script}
<script type="text/javascript">
    $("#submitForm").click(function() {
        $.post('{route('SetupVstoreLevel')}', $("#level_form").serialize(), function(data) {
            window.location.reload();
        }, 'text');
    });

    $(".turnover,.brokerage_ratio").keyup(function() {
        if (isNaN($(this).val())) {
            $(this).val('');
        }
    });

    $('.trade_count').keyup(function() {
        if ($(this).val() != '' && ! /^[\d]+$/.test($(this).val())) {
            $(this).val('');
        }
    });

    $("#editLevel").click(function() {
        $(".modify").show();
        $(".normal").hide();
        $("#action_bar").show();
    });

    $("#cancelEdit").click(function() {
        $(".modify").hide();
        $(".normal").show();
        $("#action_bar").hide();
    });
</script>
{/block}
