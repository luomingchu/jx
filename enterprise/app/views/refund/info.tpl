{extends file='layout/main.tpl'}

{block title}退款/退货列表{/block}

{block breadcrumb}
    <li>订单管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('RefundManage')}">退款/退货列表</a><span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetRefundInfo', ['refund_id' => $info.id])}">申请详情</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">
            <div class="widget box blue" id="form_wizard">
                <div class="widget-title">
                    <h4>
                        <i class="icon-reorder"></i> 退款、退货申请详情
                    </h4>
                        <span class="tools">
                           <a href="javascript:;" class="icon-chevron-down"></a>
                           <a href="javascript:;" class="icon-remove"></a>
                        </span>
                </div>
                <div class="widget-body form">
                    <form action="#" class="form-horizontal">
                        <input type="hidden" id="refund_id" value="{$info.id}"/>
                        <input type="hidden" id="refund_type" value="{$info.type}"/>
                        <input type="hidden" id="refund_status" value="{$info.status}"/>
                        <div class="form-wizard">
                            <div class="navbar steps">
                                <div class="navbar-inner">
                                    <ul class="row-fluid">
                                        <li class="span3" id="status_{Refund::STATUS_WAIT_ENTERPRISE_REPAYMENT}">
                                            <a href="#tab1" data-toggle="tab" class="step">
                                                <span class="number">1</span>
                                                <span class="desc"><i class="icon-ok"></i> 等待企业退款</span>
                                            </a>
                                        </li>
                                        <li class="span3" id="status_{Refund::STATUS_SUCCESS}">
                                            <a href="#tab2" data-toggle="tab" class="step">
                                                <span class="number">2</span>
                                                <span class="desc"><i class="icon-ok"></i> 退款成功</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="bar" class="progress progress-striped">
                                <div class="bar"></div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1" style="display: none;">
                                    <div style="width: 100%;min-width:1024px;border: 1px solid #ccc;height: 390px;">
                                        <div style="width: 500px;padding: 10px;float: left;">
                                            <div style="font-size: 16px;font-weight: bolder;color: #000;padding-bottom: 12px;border-bottom: 1px solid #ccc;margin-bottom: 10px;">退款/退货申请</div>
                                            <div style="display:inline-block;min-width: 500px;margin-bottom: 10px;">
                                                <img src="{$info.goods.pictures[0].url}" class="img-rounded" style="display:inline-block;width: 80px; height: 80px;margin-right: 10px;"/>
                                                <div style="display:inline-block;width: 400px;">
                                                {$info.goods.name}
                                                {if $info.store_activity}
                                                    <br/>
                                                    <span class="badge badge-important">{trans("order.activity."|cat:$info.store_activity.body_type)}</span> {$info.store_activity.title}
                                                {/if}
                                                </div>
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                买家要求：{if $info.type eq Refund::TYPE_GOODS}退货{else}仅退款{/if}
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                退款金额：{$info.refund_amount}
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                退款原因：{$info.reason}
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                货物状态：{if (!empty($info.order.delivery_time) && strtotime($info.order.delivery_time))}已发货{else}未发货{/if}
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                退款说明：{$info.remark}
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                退款编号：{$info.id}
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                申请时间：{$info.created_at}
                                            </div>
                                        </div>
                                        <div style="display: inline-block;border-left: 1px solid #ccc;height:390px;float: left;min-width: 200px;">
                                            <div style="margin: 39px 0 30px 30px;">
                                                {if count($info.pictures) > 0}
                                                    <p>
                                                        退款凭证：
                                                    </p>
                                                    <p>
                                                        {foreach $info.pictures as $picture}
                                                            <a href="{$picture.url}" target="_blank" style="margin-right: 20px;">
                                                                <img src="{$picture.url}" style="width: 120px; height: 120px;"/>
                                                            </a>
                                                        {/foreach}
                                                    </p>
                                                {/if}
                                                <p style="font-size: 16px;font-weight: bolder;">收款人信息：</p>
                                                <div style="padding-left: 20px">
                                                    {if $info.account_type eq 'Bankcard'}
                                                    <p>开户行：{$info.account.open_account_bank}</p>
                                                    <p>收款账户：{$info.account.number}</p>
                                                    {else}
                                                    <p>账号类型：支付宝</p>
                                                    <p>收款账户：{$info.account.alipay_account}</p>
                                                    {/if}
                                                </div>
                                                <div style="margin-top: 30px;">
                                                    <a href="javascript:;" class="btn btn-large btn-danger" id="agree_payment">同意退款</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="clear: both;">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab2" style="display: none;">
                                    <div style="width: 100%;min-width:1024px;border: 1px solid #ccc;height: 390px;">
                                        <div style="width: 500px;padding: 10px;float: left;">
                                            <div style="font-size: 16px;font-weight: bolder;color: #000;padding-bottom: 12px;border-bottom: 1px solid #ccc;margin-bottom: 10px;">退款/退货申请</div>
                                            <div style="display:inline-block;min-width: 500px;margin-bottom: 10px;">
                                                <img src="{$info.goods.pictures[0].url}" class="img-rounded" style="display:inline-block;width: 80px; height: 80px;margin-right: 10px;"/>
                                                <div style="display:inline-block;width: 400px;">
                                                    {$info.goods.name}
                                                    {if $info.store_activity}
                                                        <br/>
                                                        <span class="badge badge-important">{trans("order.activity."|cat:$info.store_activity.body_type)}</span> {$info.store_activity.title}
                                                    {/if}
                                                </div>
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                买家要求：{if $info.type eq Refund::TYPE_GOODS}退货{else}仅退款{/if}
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                退款金额：{$info.refund_amount}
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                退款原因：{$info.reason}
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                货物状态：{if (!empty($info.order.delivery_time) && strtotime($info.order.delivery_time))}已发货{else}未发货{/if}
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                退款说明：{$info.remark}
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                退款编号：{$info.id}
                                            </div>
                                            <div style="margin-bottom: 10px;">
                                                申请时间：{$info.created_at}
                                            </div>
                                        </div>
                                        <div style="display: inline-block;border-left: 1px solid #ccc;height:390px;float: left;min-width: 200px;">
                                            <div style="margin: 39px 0 30px 30px;">
                                                <h2>退款成功！</h2>
                                                <div style="font-size: 14px;font-weight: bolder">退款金额：{$info.refund_amount} 元；退款转账交易单号：{$info.out_trade_no}</div>
                                                <p style="font-size: 16px;font-weight: bolder;margin-top: 30px;">收款人信息：</p>
                                                <div style="padding-left: 20px">
                                                    {if $info.account_type eq 'Bankcard'}
                                                        <p>开户行：{$info.account.open_account_bank}</p>
                                                        <p>收款账户：{$info.account.number}</p>
                                                    {else}
                                                        <p>账号类型：支付宝</p>
                                                        <p>收款账户：{$info.account.alipay_account}</p>
                                                    {/if}
                                                </div>
                                                {if count($info.pictures) > 0}
                                                    <p>
                                                        退款凭证：
                                                    </p>
                                                    <p>
                                                        {foreach $info.pictures as $picture}
                                                            <a href="{$picture.url}" target="_blank" style="margin-right: 20px;">
                                                                <img src="{$picture.url}" style="width: 120px; height: 120px;"/>
                                                            </a>
                                                        {/foreach}
                                                    </p>
                                                {/if}
                                            </div>
                                        </div>
                                        <div style="clear: both;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
{/block}

{block script}
<script type="text/javascript">

    $(function() {
        var status = $("#refund_status").val();
        $("#status_"+status+ ' a').trigger('click').attr('data-arrive', 1);
        var tab = $("#status_"+status+ ' a').attr('href').substring(1);
        $("#"+tab).show();
        if (status == '{Refund::STATUS_WAIT_BUYER_RETURN_GOODS}') {
            $("#status_{Refund::STATUS_WAIT_STORE_CONFIRM_GOODS} a").trigger('click').attr('data-arrive', 1);
            $("#status_{Refund::STATUS_WAIT_STORE_CONFIRM_GOODS}").prevAll().removeClass('active').addClass('done');
        }

        $("#status_"+status).prevAll().removeClass('active').addClass('done');

        $("#form_wizard").bootstrapWizard({
            onTabClick: function(tab, navigation, index) {
                return false;
            },
            onTabShow: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index+1;
                var $percent = ($current/$total) * 100;
                $('#form_wizard').find('.bar').css({ width:$percent+'%' });
            }
        });
    });

    $("#agree_payment").click(function()
    {
        var url = '{route("AgreeRefundApply")}';
        var html = "<form id='agree_form'><h4>确认您已返款到 {if $info.account_type eq 'Bankcard'}{$info.account.open_account_bank}：{$info.account.number}{else}支付宝：{$info.account.alipay_account}{/if}</h4><p>退款转账交易单号：<input type='text' name='out_trade_no' required /></p><input type='hidden' name='refund_id' value='"+$("#refund_id").val()+"'/></form>";
        iconfirm(html, function() {
            $.post(url, $("#agree_form").serialize(), function() {
                window.location.reload();
            });
        });
    });

</script>
{/block}
