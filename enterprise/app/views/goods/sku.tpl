<div id="sku_attr_list">
    {foreach $attributes as $attr}
    <span class="sku_span">{$attr.name}</span>
    {/foreach}
    <span class="sku_span">门市价</span>
    <span class="sku_span">库存</span>
</div>
{foreach $sku_info as $k=>$item}
    <div style="clear: both;" class="sku_item">
        {foreach $attributes as $ak=>$attr}
            <span class="sku_span"><input type="text" name="sku_attr[{$k}][{$attr.id}]" class="text sku_input sku_attr" data-id="{$attr.id}" value="{$item.sku_key[$ak]}"/> </span>
        {/foreach}
        <span class="sku_span"><input type="text" name="sku_price[{$k}]" class="text sku_input sku_price" value="{$item.price}"/> </span>
        <span class="sku_span"><input type="text" name="sku_stock[{$k}]" class="text sku_input sku_stock" value="{$item.stock}"/> </span>
        <span class="badge badge-info add-item" title="添加" {if $k lt count($sku_info)-1}style="display: none;"{/if}>+</span>
        <span class="badge badge-important minus-item"  title="删除">-</span>
    </div>
{foreachelse}
    <div style="clear: both;" class="sku_item">
        {foreach $attributes as $attr}
            <span class="sku_span"><input type="text" name="sku_attr[0][{$attr.id}]" class="text sku_input sku_attr" data-id="{$attr.id}"/> </span>
        {/foreach}
        <span class="sku_span"><input type="text" name="sku_price[0]" class="text sku_input sku_price"/> </span>
        <span class="sku_span"><input type="text" name="sku_stock[0]" class="text sku_input sku_stock"/> </span>
        <span class="badge badge-info add-item" title="添加">+</span>
        <span class="badge badge-important minus-item"  title="删除" style="display: none;">-</span>
    </div>
{/foreach}