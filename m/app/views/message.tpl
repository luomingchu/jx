{extends file='layout/layout.tpl'}

{block title}消息提示{/block}

{block head}
    <div class="site-map"><a href="javascript:history.go(-1);"><span class="icon-arrow-left"></span></a><em>消息提示</em></div>
{/block}

{block main}
    <div class="container marketing main">
        <div class="top-block"></div>
        <div class="row">
            <div class="reg-box message-title">
                <ul>
                    <li><h3 style="color: red;">{$error_message}</h3></li>
                </ul>
            </div>
            {if $recommendation}
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
            {/if}
        </div>
        <div class="foot-block"></div>
    </div>
{/block}