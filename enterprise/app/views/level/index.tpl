{extends file='layout/main.tpl'}

{block title}会员等级管理{/block}

{block breadcrumb}
    <li><a href="javascript:;">会员管理</a> <span class="divider">&nbsp;</span></li>
    <li><a href="{route('ManageMemberLevel')}">会员等级管理</a> <span class="divider-last">&nbsp;</span></li>
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
                    <h4><i class="icon-reorder"></i>会员等级设置</h4>
                    <span class="tools">
                        <a href="javascript:;" id="editLevel" class="btn btn-primary btn-mini" style="position:relative;top:-3px;color: #fff;">编辑</a>
                    </span>
                </div>
                <div class="widget-body">
                    <div id="DataView"></div>
                    <form id="level_form" method="get">
                        <table class="table table-striped table-bordered" id="level_form">
                            <thead>
                            <tr>
                                <th></th>
                                <th>普通会员（VIP1）</th>
                                <th>高级会员（VIP2）</th>
                                <th>钻石会员（VIP3）</th>
                                <th>至尊会员（VIP4）</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>升级模式</td>
                                {for $i=1 to 4}
                                    <td style="text-align: center;">
                                        {if array_key_exists($i, $list) || $i == 1}
                                            自动升级
                                        {else}
                                            <a href="{route('OpenMemberLevel', ['level' => $i])}">启用该等级</a>
                                        {/if}
                                    </td>
                                {/for}
                            </tr>
                            <tr>
                                <td>满足条件</td>
                                {for $i=1 to 4}
                                    <td>
                                        {if array_key_exists($i, $list)}
                                            <div class="review">
                                                <div><span  style="text-align: right;width: 75px;display: inline-block;">交易额￥</span> {$list[$i].turnover|default:0}</div>
                                                <div><span  style="text-align: right;width: 75px;display: inline-block;">或交易次数</span> {$list[$i].trade_count|default:0}</div>
                                            </div>
                                            <div class="setup" style="display: none;">
                                                <div><span  style="text-align: right;width: 75px;display: inline-block;">交易额￥</span> <input type="text" value="{$list[$i].turnover|default:0}" class="text turnover" style="width: 50px;" name="turnover[{$i}]" {if $i == 1}readonly="readonly" {/if}/></div>
                                                <div><span  style="text-align: right;width: 75px;display: inline-block;">或交易次数</span> <input type="text" value="{$list[$i].trade_count|default:0}" class="text trade_count" style="width: 50px;" name="trade_count[{$i}]" {if $i == 1}readonly="readonly" {/if}/></div>
                                            </div>
                                        {/if}
                                    </td>
                                {/for}
                            </tr>
                            <tr>
                                <td>会员权益</td>
                                {for $i=1 to 4}
                                    <td>
                                        {if array_key_exists($i, $list)}
                                            <div class="review">
                                                <div><span  style="text-align: right;width: 75px;display: inline-block;">指币</span> {$list[$i].coin|default:0}</div>
                                                <div><span  style="text-align: right;width: 75px;display: inline-block;">内购额</span> {$list[$i].insource|default:0}</div>
                                            </div>
                                            <div class="setup" style="display: none;">
                                                <div><span  style="text-align: right;width: 75px;display: inline-block;">指币</span> <input type="text" value="{$list[$i].coin|default:0}" class="text icon" style="width: 50px;" name="icon[{$i}]"/></div>
                                                <div><span  style="text-align: right;width: 75px;display: inline-block;">内购额</span> <input type="text" value="{$list[$i].insource|default:0}" class="text insource" style="width: 50px;" name="insource[{$i}]"/></div>
                                            </div>
                                        {/if}
                                    </td>
                                {/for}
                            </tr>
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
            $.post('{route('SaveMemberLevel')}', $("#level_form").serialize(), function(data) {
                window.location.reload();
            }, 'text');
        });

        $(".turnover,.insource").keyup(function() {
            if (isNaN($(this).val())) {
                $(this).val('');
            }
        });

        $('.trade_count,.icon').keyup(function() {
            if ($(this).val() != '' && ! /^[\d]+$/.test($(this).val())) {
                $(this).val('');
            }
        });

        $("#editLevel").click(function() {
            $(".setup").show();
            $(".review").hide();
            $("#action_bar").show();
        });

        $("#cancelEdit").click(function() {
            $(".setup").hide();
            $(".review").show();
            $("#action_bar").hide();
        });
    </script>
{/block}
