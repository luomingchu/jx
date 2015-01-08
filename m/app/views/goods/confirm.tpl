{extends file='layout/layout.tpl'}

{block title}商品详情{/block}

{block head}
    <div class="site-map"><a href="javascript:history.go(-1);"><span class="icon-arrow-left"></span></a><em>确认订单</em></div>
{/block}

{block main}
    <div class="container marketing main">
        <div class="top-block"></div>
        <div class="row">
            <div class="order-check">
                <form id="order_form">
                <ul>
                    {if empty($address)}
                        <li class="address">
                            <a href="{route('EditAddress')}">添加收货地址</a>
                        </li>
                    {else}
                    <li class="address">
                        <a href="{route('AddressList')}" >
                        <h6><i>{$address.mobile} {$address.phone}</i>收货人：{$address.consignee}</h6>
                        <p><i class="icon-uniE60B"></i>收货地址：{$address.region_name}{$address.address}</p>
                        </a>
                    </li>
                    {/if}
                    <li>
                        <h5><span class="icon-shop"></span>{$cart_goods.info.name}</h5>
                    </li>
                    <li>
                        {foreach $cart_goods.goods_list as $goods}
                        <dl>
                            <dt><img src="{$goods.goods.pictures[0].url}&width=80&height=80" /></dt>
                            <dd><i>￥{sprintf('%.2f', $goods.goods_sku.price)}</i><em>{$goods.goods.name}</em></dd>
                            <dd class="gray"><i>x{$goods.quantity}</i><em>{$goods.goods_sku.sku_string}</em></dd>
                        </dl>
                        {/foreach}
                        <dl>
                            <dt>配送方式：</dt>
                            <dd>
                                <select name="delivery">
                                    <option value="Electronic">快递发货</option>
                                    <option value="Pickup">到店自提</option>
                                </select>
                            </dd>
                        </dl>
                        <dl>
                            <dt>付款方式：</dt>
                            <dd>
                                <select name="payment_kind">
                                    <option value="alipay">支付宝付款</option>
                                    {*<option value="unionpay">银联卡支付</option>*}
                                </select>
                            </dd>
                        </dl>
                        <div>
                            <input type="text" name="memo" placeholder="给卖家留言：" />
                        </div>
                    </li>
                    <li class="result">
                        <i>共计{$cart_goods.goods_count}件商品&nbsp;&nbsp;合计：<b>￥{sprintf('%.2f', $cart_goods.goods_amount)}</b></i>
                        <input type="hidden" id="address_id" name="address_id" value="{$address.id}"/>
                        <input type="hidden" id="cart_id" name="cart_id" value="{$cart_goods.goods_list[0]['id']}"
                    </li>
                    <li class="submit">
                        <i>￥{sprintf('%.2f', $cart_goods.goods_amount)}
                            <input type="button" id="create_order" value="确认" />
                        </i>
                    </li>
                </ul>
                </form>
            </div>
        </div>
        <div class="foot-block"></div>
    </div>
{/block}

{block script}
<script type="text/javascript">
    $("#create_order").click(function() {
        var action = $(this).attr('data-action');
        if (action == 1) {
            return false;
        }
        $(this).attr('data-action', 1);
        $.ajax({
            type: 'POST',
            data: $("#order_form").serialize(),
            dataType: 'json',
            url: '{route("CreateOrder")}',
            success: function(data) {
                window.location.href = "{route('PaymentOrder')}?order_id="+data['order_id']+'&payment_kind='+data['payment_kind'];
                $("#create_order").attr('data-action', 0);
            },
            error: function(xhq) {
                alert(xhq.responseText);
                $("#create_order").attr('data-action', 0);
            }
        });
    });
</script>
{/block}