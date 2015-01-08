{extends file='layout/layout.tpl'}

{block title}商品详情{/block}

{block head}
<div class="site-map"><em>商品详情</em>
{/block}

{block css}
<style type="text/css">
    #op_ov_cd .cont .con_cs div .hover {
        border-color: #E15304;
        color: #E55200;
    }
</style>
{/block}
{block main}
    <div class="container marketing main">
        <div class="top-block"></div>
        <div class="row">
            <div class="shop_details">
                <div class="mainPic">
                    <div class="proinfo-slides pro-slides">
                        {foreach $info.pictures as $picture}
                        <a class="example1" title="产品图片" href="javascript:(0);">
                            <p><img alt="example1" src="{$picture.url}"/></p>
                        </a>
                        {/foreach}
                    </div>
                    <script>
                        $('.pro-slides').slidesjs({
                            //width: 100%,
                            //height: 210,
                            navigation: false,
                            start: 1,
                            play: {
                                auto: false
                            }
                        });
                    </script>
                </div>
                <!--.mainPic end//-->

                <div class="pro_info">
                    {if $info.activity}
                    <div class="countdown">
                        <i></i>
                        <b>距内购结束</b>
                        <span class="day">-</span>天
                        <span class="hour">-</span>时
                        <span class="minute">-</span>分
                        <span class="second">-</span>秒
                    </div>
                    {/if}
                    <!--.countdown end//-->

                    <div class="titleBox">
                        {$info.name}
                        {*<h1>{$info.name}</h1>
                        <div class="fxTsM1"><i></i><span>收藏</span></div>*}
                    </div>
                    <div class="price">
                        <span>
                            {if $info.activity}
                                <em>内购价：</em>￥<b>{sprintf('%.2f',$info.activity.discount_price)}</b>
                            {else}
                                <em>门店价：</em>￥<b>{sprintf('%.2f', $info.price)}</b>
                            {/if}
                        </span>
                        <div class="cls"></div>
                        {if $info.activity.coin_max_use_ratio}
                        <span>指币抵{$info.activity.coin_max_use_ratio}%</span>
                        {/if}
                    </div>
                    <div class="price_old">原价：<span>￥{$info.market_price}</span></div>
                    <div class="bott_con"><span>快递 包邮</span><span>销量 {$info.stock}</span><span>{$vstore.name}</span></div>
                </div>
                <!--.pro_info end//-->

                <div class="select_color"><a href="javascript:;" class="check_buy"><span>选择</span><span>{$info.goods_type_attributes}</span></a>
                </div>

                <div class="user_t more">
                    <a href="{$vstore_url}">
                        <div class="head_img"><img src="{if $vstore.member.avatar.url}{$vstore.member.avatar.url}{else}{asset('temp/q_z05.jpg')}{/if}"></div>
                        <div class="mzh_con">
                            <div class="h_na"><strong>{$vstore.name}</strong><div class="stars fl"><i style="width:80%;"></i></div></div>
                            <div class="ssdp">{$vstore.store.name}{sprintf('%04d', $vstore.id)}号连锁店</div>
                        </div>
                    </a>
                </div>

                <section class="tabbtn">
                    <ul class="Fadetab">
                        <li class="current"><a href="javascript:void(0)">图文详情</a></li>
                        <li><a href="javascript:void(0)">产品参数</a></li>
                        <li><a href="javascript:void(0)">猜你喜欢</a></li>
                    </ul>
                </section>
                <div class="Fadecon">
                    <div class="imgText">
                        {$info.description}
                    </div>
                    <!--图文详情 end//-->

                    <div class="shop_description">
                        {$info.parameter}
                    </div>
                    <!--产品参数 end//-->

                    <ul class="shop_prod_list fxTsM5" style="margin-top:-10px;">
                        {foreach $recommendation as $goods}
                        <li>
                            <a href="{route('ViewGoodsInfo', ['goods_id' => $goods.id, 'vstore_id' => $vstore.id])}">
                                <span><img src="{$goods.pictures[0].url}&width=360&height=360"></span>
                                <span><b>{$goods.name}</b></span>
                                <span><b>￥</b>{if $goods.activity}{$goods.activity.discount_price}{else}{$goods.price}{/if}<del>￥{$goods.market_price}</del></span>
                                <span>库存：<b>{$goods.stock}</b>已售：<b>{$goods.trade_quantity}</b></span>
                            </a>
                        </li>
                        {/foreach}
                    </ul>
                    <!--猜你喜欢 end//-->
                </div>
                <!--.Fadecon end//-->
                <!--<dl class="shop_buts">
                  <dt><a class="download" href="javascript:(0);"><i>电话</i></a><a class="download" href="javascript:(0);"><i>购物车</i></a></dt>
                  <dd><a class="download" href="javascript:(0);">立即购买</a><a class="download" href="javascript:(0);">到店体验</a></dd>
                </dl>-->
                <div class="shop_buts"><a href="javascript:;" class="check_buy">立即购买</a></div>
                <!--.shop_buts end//-->

            </div>
        </div>
        <div class="foot-block"></div>

    </div>
{/block}

{block additional}
    <!--购买参数选择 begin-->
    <div id="op_ov_bg"></div>
    <div id="op_ov_cd">
        <div class="cont">
            <div class="contBox">
                <img class="pic fxTsM6" src="{$info.pictures[0].url}" />
                <div class="fxTsM6"><b>￥<span id="goods_price">{if $info.activity}{$info.activity.discount_price}{else}{$info.price}{/if}</span></b>(库存<span id="goods_stock">{$info.stock}</span>)<br/>请选择 {$info.goods_type_attributes}</div>
                <p>取消</p>
            </div>

            {foreach $attributes as $attribute}
            <div class="con_cs fxTsM6">
                <div>{$attribute.name}</div>
                <div>
                    {foreach $attribute.items as $item}
                        <span class="attribute_item attribute_{$item.attribute_index}" data-index="{$item.attribute_index}" data-id="{$item.id}" style="cursor: pointer;">{$item.name}</span>
                    {/foreach}
                </div>
            </div>
            {/foreach}

            <div class="buy_sl fxTsM6">购买数量<div><span id="minus">-</span><span id="quantity" data-activity-quota="{if $info.activity}{$info.activity.quota}{else}0{/if}" data-quota="{if $info.activity}{min($info.stock, $info.activity.quota)}{else}{$info.stock}{/if}">1</span><span id="plus">+</span></div></div>

            <ul class="shop_buts">
                <input type="hidden" id="sku_id" />
                <li><a href="javascript:;;" id="buy_goods" data-logined="{$logined}">立即购买</a></li>
            </ul>

        </div>
    </div>
    <!--购买参数选择 end-->
{/block}

{block script}
<script type="text/javascript">
    var skus = {$info.stocks|default:''};

    $(document).ready(function(){
        bindListener2();
        if ("{$info.activity.activity.end_datetime}" != '') {
            countDown("{$info.activity.activity.end_datetime}",".countdown .day",".countdown .hour",".countdown .minute",".countdown .second");
        }

        $(".check_buy").click(function() {
            if (isWeiXin()) {
                $('.fade').show();
                $('.fade').css('opacity', 1);
                $('.fade').click(function(){
                    $(this).fadeOut(300);
                });

            } else {
                open_ov_cdd();
            }
        });


        $(".Fadetab").tabso({
            cntSelect:".Fadecon",
            tabEvent:"click",
            tabStyle:"fade"
        });//end

        $(".attribute_item").click(function() {
            var index = $(this).attr('data-index');
            $(".attribute_"+index).removeClass('hover');
            $(this).addClass('hover');
            selectSku();
        });

        $("#minus").click(function() {
            var quantity = parseInt($("#quantity").text());
            quantity--;
            if (quantity < 1) {
                quantity = 1;
            }
            $("#quantity").text(quantity);
        });

        $("#plus").click(function() {
            var quantity = parseInt($("#quantity").text());
            quantity++;
            var quota = $("#quantity").attr('data-quota');
            if (quantity > quota) {
                alert('此商品每个用户最多只能购买'+quota+'件！');
                quantity = quota;
            }
            $("#quantity").text(quantity);
        });

        $("#buy_goods").click(function(e) {
            e.preventDefault();
            var action = $(this).attr('data-action');
            if (action == 1) {
                return false;
            }
            if ($(this).attr('data-logined') == 0) {
                if (! confirm('您还未登录，现在进行登录？')) {
                    return false;
                }
                window.location.href = "{route('Login')}";
                return false;
            }
            $(this).attr('data-action', 1);
            var quantity = $("#quantity").val();
            var sku_id = $("#sku_id").val();
            var goods_id = "{$info.id}";
            if (quantity > 0 && sku_id > 0) {
                $.ajax({
                    type: "POST",
                    url: '{route('AddGoodsToCart')}',
                    dataType: 'text',
                    data: { quantity: quantity, goods_sku : sku_id, goods_id : goods_id, vstore_id : {$vstore.id} },
                    success: function(data) {
                        window.location.href = "{route('ConfirmCart')}?cart_id="+data;
                    },
                    error: function(xhq) {
                        $("#buy_goods").attr('data-action', 0);
                        alert(xhq.responseText);
                    }
                });
            }
        });
    });

    function selectSku()
    {
        var discount = "{$info.activity.discount|default:10}";
        var attr = new Array();
        $(".attribute_item").filter('.hover').each(function() {
            attr.push($(this).attr('data-id'));
        });
        var sku = attr.join(':');
        var activity_quota = $("#quantity").attr('data-activity-quota');
        if (activity_quota < 1) {
            activity_quota = 9999999999;
        }
        for (var i in skus) {
           if (skus[i]['sku_index'] == sku) {
               $("#goods_price").text(skus[i]['price']);
               $("#goods_stock").text(skus[i]['stock']);
               if (skus[i]['price'] < 1) {
                   $("#buy_goods").css('background', '#ccc');
                   if (activity_quota < skus[i]['stock']) {
                       $("#quantity").val(0).attr('data-quota', activity_quota);
                   } else {
                       $("#quantity").val(0).attr('data-quota', skus[i]['stock']);
                   }
               } else {
                   $("#buy_goods").css('background', '#FF9300');
                   if (activity_quota < skus[i]['stock']) {
                       $("#quantity").val(1).attr('data-quota', activity_quota);
                   } else {
                       $("#quantity").val(1).attr('data-quota', skus[i]['stock']);
                   }
               }
               $("#goods_price").text(Math.round((skus[i]['price'] * discount/10)*100)/100);
               $("#sku_id").val(skus[i]['id']);
           }
        }
    }


    function open_ov_cdd(){
        $("html").addClass("find_openhtml");
        $("body").addClass("find_openhtml");
        $("#op_ov_bg").css("display","block").animate({ "opacity":"0.5" },300);
        $("#op_ov_cd").css("display","block").animate({ "bottom":"0" },400);
        bindListener2();
    }

    function bindListener2(){
        $("#op_ov_cd p").unbind().click(function(){
            $("html").removeClass("find_openhtml");
            $("body").removeClass("find_openhtml");
            $("#op_ov_bg").animate({ "opacity":"0" },400, function(){
                $(this).css("display","none");
            });
            $("#op_ov_cd").animate({ "bottom":"-400px" },300, function(){
                $(this).css("display","none");
            });
        });
    }
</script>
{/block}