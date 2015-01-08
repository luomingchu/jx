{extends file='layout/layout.tpl'}

{block title}收货地址{/block}

{block head}
    <div class="site-map"><a href="javascript:history.go(-1);"><span class="icon-arrow-left"></span></a><em>收货地址</em></div>
{/block}

{block main}
    <div class="container marketing main">
        <div class="top-block"></div>
        <div class="row">
            <div class="address-list">
                <ul>
                    {foreach $list as $address}
                    <li>
                        <a href="{route('EditAddress', ['address_id' => $address.id])}" class="edit">修改</a>
                        <a href="{route('ConfirmCart', ['address_id' => $address.id, 'cart_id' => Session::get('cart_id')])}">
                            <h6>{$address.consignee} {$address.mobile} {$address.phone}</h6>
                            <p>{$address.region_name}{$address.address}</p>
                        </a>
                    </li>
                    {/foreach}
                </ul>
            </div>
        </div>
        <div class="foot-block"></div>
    </div>
{/block}

{block footer}
    <div class="foot-btn"><a href="{route('EditAddress')}">添加新地址</a></div>
{/block}