{extends file='layout/layout.tpl'}

{block title}消息提示{/block}

{block head}
    <div class="site-map"><a href="javascript:history.go(-1);"><span class="icon-arrow-left"></span></a><em>支付成功</em></div>
{/block}

{block main}
<div class="container marketing main">
    <div class="top-block"></div>
    <div class="row">
        <div class="reg-box message-title">
            <ul>
                <li><h3>交易成功！</h3></li>
                <li><input type="button" id="download" value="更多体验，请下载应用" /></li>
            </ul>
        </div>
        <div class="another-more">
            <h6>看看其他人买了什么：</h6>
            <ul class="shop_prod_list">
                {foreach $recommendation as $goods}
                <li>
                    <a href="{route('ViewGoodsInfo', ['goods_id' => $goods.id, 'vstore_id' => $order->vstore_id])}">
                        <span><img src="{$goods.pictures[0].url}&width=335&height=335"></span>
                        <span><b>{$goods.name}</b></span>
                    </a>
                </li>
                {/foreach}
            </ul>
        </div>
    </div>
    <div class="foot-block"></div>
</div>
{/block}

{block script}
<script type="text/javascript">
    $("#download").click(function() {
        window.location.href = url;
    });
</script>
{/block}