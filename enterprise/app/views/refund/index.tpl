{extends file='layout/main.tpl'}

{block title}退款/退货列表{/block}

{block breadcrumb}
    <li>订单管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('RefundManage')}">退款/退货列表</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">
            <!-- begin recent orders portlet-->
            <div class="widget">
                <div class="widget-body">
                    <div class="row-fluid">
                        <div class="span12 booking-search" style="padding-bottom:5px;">
                            <FORM method="get" id="refund_form">
                                <div class="pull-left margin-right-20" style="width: 100%">
                                    <div class="controls" >
                                        <div>
                                            <span style="font-size: 14px;margin-left: 8px;">退款号：</span>
                                            <input placeholder="退款号精确搜索" class="input" name="refund_id" value="{$smarty.get.id}" type="text" style="width: 130px;">
                                            <span style="font-size: 14px;margin-left: 8px;">订单号：</span>
                                            <input placeholder="订单号精确搜索" class="input" name="order_id" value="{$smarty.get.order_id}" type="text" style="width: 130px;">
                                            <span style="font-size: 14px;margin-left: 8px;">宝贝名称：</span>
                                            <input placeholder="宝贝名称" class="input" name="goods_name" value="{$smarty.get.goods_name}" type="text" style="width: 150px;">
                                            <span style="font-size: 14px;margin-left: 8px;">成交时间：</span>
                                            <input type="text" class="input span1" name="start_date" value="{$smarty.get.start_date}" readonly="readonly"/> -
                                            <input type="text" class="input span1" name="end_date" value="{$smarty.get.end_date}" readonly="readonly"/>
                                        </div>
                                        <div>
                                            <span style="font-size: 14px;margin-left: 8px;">交易状态：</span>
                                            <select name="status">
                                                <option value="">全部</option>
                                                {foreach [
                                                    Refund::STATUS_WAIT_ENTERPRISE_REPAYMENT,
                                                    Refund::STATUS_SUCCESS
                                                ] as $item}
                                                    <option value="{$item}" {if $smarty.get.status eq $item}selected="selected"{/if}>{trans('refund.status.'|cat:$item)}</option>
                                                {/foreach}
                                            </select>
                                            <span style="font-size: 14px;margin-left: 8px;">销售区域：</span>
                                            <select name="group_id[]" id="group" class="group">
                                                <option value="">全部</option>
                                                {foreach $groups as $group}
                                                    <option value="{$group.id}">{$group.name}</option>
                                                {/foreach}
                                            </select>
                                            <br/>
                                            <span style="font-size: 14px;margin-left: 8px;">销售门店：</span>
                                            <select name="store_id" id="store">
                                                <option value="">全部</option>
                                            </select>
                                            <span style="font-size: 14px;margin-left: 8px;">销售指店：</span>
                                            <select name="vstore_id" id="vstore">
                                                <option value="">全部</option>
                                            </select>
                                            <input type="button" class="btn btn-primary" value="查 询" id="searchOrder" style="position: relative;top: -5px;"/>
                                        </div>
                                    </div>
                                </div>
                            </FORM>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end recent orders portlet-->
        </div>
    </div>

    <div id="refund_items">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>退款编号</th>
                <th>订单编号</th>
                <th>宝贝名称</th>
                <th>买家名称</th>
                <th>收款账户类型</th>
                <th>收款账户</th>
                <th>退款金额</th>
                <th>申请时间</th>
                <th>退款状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="10" style="text-align: center;">
                    <span id="message">暂时没有相关退款申请信息！</span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

{/block}

{block script}
<script type="text/javascript">
    $('[name="start_date"],[name="end_date"]').datetimepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        minView: 2,
        language: 'zh-CN'
    });

    $("#searchOrder").click(function() {
        getItems();
    });

    function getItems() {
        var html = '<td colspan="11" style="text-align: center;"><img id="loading" src="{asset("assets/pre-loader/Fading squares.gif")}"/></td>';
        $("#refund_items tr").eq(1).html(html);
        $.ajax({
            type: 'GET',
            data: $("#refund_form").serialize(),
            url: '{route('GetRefundItems')}',
            dataType: 'html',
            success:function(data) {
                $("#refund_items").html(data);
            }
        });
    }

    getItems();

    $(document).on('click', '#paginate a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        if (url != '') {
            var html = '<td colspan="10" style="text-align: center;"><img id="loading" src="{asset("assets/pre-loader/Fading squares.gif")}"/></td>';
            $("#refund_items tr").eq(1).html(html);
            $.ajax({
                type: 'GET',
                url: $(this).attr('href'),
                dataType: 'html',
                success:function(data) {
                    $("#refund_items").html(data);
                }
            });
        }
    });

    $("#store").change(function() {
        var store_id = $(this).val();
        $("#vstore option:not(:first)").remove();
        getVstoreList();
    });

    $(document).on('change', '.group', function() {
        var group_id = $(this).val();
        if (group_id) {
            var obj = $(this);
            obj.nextAll('.group').remove();
            $.get('{route("GroupSub")}', { parent_id : group_id }, function(data) {
                if (data.length > 0) {
                    var html = ' <select name="group_id[]" class="group"><option value="">选择所属区域</option> ';
                    for (var i in data) {
                        html += "<option value='"+data[i]['id']+"'>"+data[i]['name']+"</option>";
                    }
                    html += '</select>';
                }
                obj.after(html);
            });
        }
        if (group_id == '') {
            group_id = $(this).prev('.group').val();
        }
        $.get('{route("GetGroupStores")}', { group_id : group_id }, function(data) {
            var html = "<option value=''>全部</option>";
            if (data.length > 0) {
                for (var i in data) {
                    html += '<option value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
                }
            }
            $("#store").html(html);
        });
    });

    getVstoreList();

    function getVstoreList() {
        var store_id = $("#store").val();
        if (store_id) {
            $.get("{route('GetVstoreList')}", { store_id : store_id }, function(data) {
                var html = "";
                var vstore = "{$smarty.get.vstore}";
                for (var i in data) {
                    var selected = "";
                    if (vstore == data[i]['id']) {
                        selected = "selected='selected'";
                    }
                    html += "<option value='"+data[i]['id']+"' "+selected+">"+data[i]['name']+"</option>";
                }
                $("#vstore").append(html);
            } );
        }
    }

    $(document).on('click', '.agree_payment', function() {
        var url = '{route("AgreeRefundApply")}';
        var account_type = $(this).attr('data-account_type');
        var account_number = $(this).attr('data-account_number');
        var refund_id = $(this).attr('data-id');
        var html = "<form id='agree_form'><h4>确认您已返款到 "+account_type+"："+account_number+"</h4><p>退款转账交易单号：<input type='text' name='out_trade_no' required /></p><input type='hidden' name='refund_id' value='"+refund_id+"'/></form>";
        iconfirm(html, function() {
            $.post(url, $("#agree_form").serialize(), function() {
                window.location.reload();
            });
        });
    });

</script>
{/block}
