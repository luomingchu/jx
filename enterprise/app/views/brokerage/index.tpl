{extends file='layout/main.tpl'}

{block title}佣金管理{/block}

{block breadcrumb}
    <li>佣金管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('BrokerageManage')}">佣金列表</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">
            <!-- begin recent orders portlet-->
            <div class="widget">
                <div class="widget-body">
                    <div class="row-fluid">
                        <div class="span12 booking-search" style="padding-bottom:5px;">
                            <FORM method="get" id="order_form">
                                <div class="pull-left margin-right-20" style="width: 100%">
                                    <div class="controls" >
                                        <div>
                                            <span style="font-size: 14px;margin-left: 8px;">交易状态：</span>
                                            <select name="status" id="status" class="span1">
                                                <option value="">全部</option>
                                                <option value="{Brokerage::STATUS_UNSETTLED}">未结算</option>
                                                <option value="{Brokerage::STATUS_SETTLED}">已结算</option>
                                            </select>
                                            <span style="font-size: 14px;margin-left: 8px;">销售门店：</span>
                                            <select name="store_id" id="store">
                                                <option value="">全部</option>
                                                {foreach $stores as $store}
                                                    <option value="{$store.id}">{$store.name}</option>
                                                {/foreach}
                                            </select>
                                            <span style="font-size: 14px;margin-left: 8px;">销售指店：</span>
                                            <select name="vstore_id" id="vstore">
                                                <option value="">全部</option>
                                            </select>
                                            时间：
                                            <input type="text" class="input span1" name="start_time"  readonly="readonly"/> -
                                            <input type="text" class="input span1" name="end_time"   readonly="readonly"/>
                                            <input type="button" class="btn btn-primary" value="查 询" id="searchOrder" style="position: relative;top: -5px;"/>
                                        </div>
                                    </div>
                                </div>
                            </FORM>
                        </div>
                    </div>
                    <div id="brokerage_items">
                        <table class="table table-bordered dataTable" id="order_item_list">
                            <thead>
                            <tr style="background: #E8E8E8;">
                                <th><span style="margin-left: 15px;">商品</span></th>
                                <th style="width: 200px;">商品价格（元）</th>
                                <th style="width: 120px;">实付款（元）</th>
                                <th style="width: 100px;">佣金比</th>
                                <th style="width: 120px;">佣金（元）</th>
                                <th style="width: 120px;">结账状态</th>
                                <th style="width: 120px;">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="8" style="text-align: center;" id="loading"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end recent orders portlet-->
        </div>
    </div>
{/block}

{block script}
<script type="text/javascript">

    $(function() {
        $('[name="start_time"],[name="end_time"]').datetimepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            minView: 2,
            language: 'zh-CN'
        });
    });

    $("#store").change(function() {
        var store_id = $(this).val();
        $("#vstore option:not(:first)").remove();
        getVstoreList();
    });

    getVstoreList();

    function getVstoreList() {
        $("#loading").html('<img src="{asset("assets/pre-loader/Fading squares.gif")}"/>');
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

    $("#searchOrder").click(function() {
        getBrokerageList();
        $("#page").val(1);
    });

    getBrokerageList();

    function getBrokerageList()
    {
        var limit = $("#limit").val();
        if (typeof limit == 'undefined') {
            limit = 10;
        }
        var page = $("#page").val();
        if (typeof page == 'undefined') {
            page = 1;
        }
        $("#brokerage_items").html('<table class="table table-bordered dataTable" id="order_item_list"><thead><tr style="background: #E8E8E8;"><th><span style="margin-left: 15px;">商品</span></th><th style="width: 200px;">商品价格（元）</th><th style="width: 120px;">实付款（元）</th><th style="width: 100px;">佣金比</th><th style="width: 120px;">佣金（元）</th><th style="width: 120px;">结账状态</th><th style="width: 120px;">操作</th></tr></thead><tbody><tr><td colspan="8" style="text-align: center;" id="loading"></td></tr></tbody></table>');
        $("#loading").html('<img src="{asset("assets/pre-loader/Fading squares.gif")}"/>');
        $.ajax({
            type:"GET",
            data: $("#order_form").serialize()+'&limit='+limit+'&page='+page,
            dataType: 'html',
            url: "{route('GetBrokerageItems')}",
            success: function(data) {
                $("#brokerage_items").html(data);
            }
        });
    }

    $(document).on('click', '#paginate a', function(e)
    {
        e.preventDefault();
        $("#brokerage_items").html('<table class="table table-bordered dataTable" id="order_item_list"><thead><tr style="background: #E8E8E8;"><th><span style="margin-left: 15px;">商品</span></th><th style="width: 200px;">商品价格（元）</th><th style="width: 120px;">实付款（元）</th><th style="width: 100px;">佣金比</th><th style="width: 120px;">佣金（元）</th><th style="width: 120px;">结账状态</th><th style="width: 120px;">操作</th></tr></thead><tbody><tr><td colspan="8" style="text-align: center;" id="loading"></td></tr></tbody></table>');
        $("#loading").html('<img src="{asset("assets/pre-loader/Fading squares.gif")}"/>');
        var url = $(this).attr('href');
        $.ajax({
            type: "GET",
            dataType: 'html',
            url : url,
            success: function(data) {
                $("#brokerage_items").html(data);
            }
        });
    });

    $(document).on('click', '#jumpPage', function() {
        getBrokerageList();
    });

    $(document).on('click', '#checkAll,#checkAll2', function() {
        if ($(this).is(":checked")) {
            $(".items:not(:disabled)").attr('checked', 'checked');
        } else {
            $(".items").removeAttr('checked');
        }
    });

    $(document).on('click', '#multiSettle', function() {
        var brokerage = new Array();
        $(".items:checked").each(function() {
            brokerage.push($(this).val());
        });
        if (brokerage.length > 0) {
            settleBrokerage(brokerage);
        }
    });

    $(document).on('click', '.settlement', function() {
        settleBrokerage($(this).attr('data-id'));
    });

    /**
     * 结算佣金
     */
    function settleBrokerage(ids)
    {
        $.ajax({
            type:"POST",
            data: { brokerage_id : ids },
            dataType: 'json',
            url: "{route('ConfirmSettlementBrokerage')}",
            success: function(data) {
                var html = "<table class='table'><tr><td>指店</td><td>总佣金</td></tr>";
                for (var i in data['vstore']) {
                    html += "<tr><td>"+data['vstore'][i]['info']['name']+"</td><td>"+data['vstore'][i]['amount']+"</td></tr>";
                }
                html += "</table><input type='hidden' id='selected_brokerage' value='"+data['brokerages']+"'/> ";
                iconfirm(html, function() {
                    $.ajax({
                        type: "POST",
                        data: { brokerage_id : $("#selected_brokerage").val() },
                        dataType: 'text',
                        url: "{route('SettlementBrokerage')}",
                        success: function(data) {
                            window.location.reload();
                        }
                    });
                });
            }
        });
    }
</script>
{/block}