{extends file='layout/main.tpl'}

{block title}商品管理{/block}

{block breadcrumb}
    <li>商品管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetSaleEnterpriseGoodsList')}">上架商品列表</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">
            <!-- begin recent orders portlet-->
            <div class="widget">
                <div class="widget-body">
                    <div class="row-fluid">
                        <div class="span12 booking-search" style="padding-bottom:5px;">
                            <FORM action="{Route('GetSaleEnterpriseGoodsList')}" method="get" id="category_form">
                                <div class="pull-left margin-right-20">
                                    <div class="controls">
                                        <input placeholder="宝贝名称/货号" class="input-large" name="name" value="{$smarty.get.name}" type="text">&nbsp;&nbsp;
                                        <span style="font-size: 14px">分类:</span>
                                        <select name="category_id[]" class="sub_category" data-placeholder="选择一级分类" style="width: 100px;">
                                            <option value="0">全部分类</option>
                                            {foreach $category as $item}
                                                <option value="{$item.id}" {if $item.id eq $smarty.get.category_id.0}selected{/if}>{$item.name}</option>
                                            {/foreach}
                                        </select>&nbsp;&nbsp;
                                        <input type="hidden" id="selected_cate" value="{if $smarty.get.category_id}{implode(',', $smarty.get.category_id)}{/if}"/>
                                    </div>
                                </div>
                                <div class="pull-left margin-right-20">
                                    <label>
                                        <a href="javascript:void(0)" onclick="select()" class="btn btn-primary"><i class="icon-search icon-white"></i> 查询</a>
                                        <a href="{route('EnterpriseGoodsEdit')}" class="btn btn-success"><i class="icon-plus icon-white"></i> 添加商品</a>
                                    </label>
                                </div>
                            </FORM>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered dataTable" id="goods_item_list">
                        <thead>
                        <tr>
                            <th style="width: 20px;"><input type="checkbox" class="group-checkable" data-set="#goods_item_list .checkboxes" id="checkAll" /></th>
                            <th>宝贝名称</th>
                            <th style="width: 350px;">价格</th>
                            <th style="width: 100px;">佣金比%</th>
                            <th style="width: 80px;">总销量 <span data-val="{$smarty.get.quantity}" data-sort="quantity" class="quantity_sort {if $smarty.get.quantity eq 'desc'}icon-chevron-down{elseif $smarty.get.quantity eq 'asc'}icon-chevron-up{else}icon-minus{/if}" style="cursor: pointer;" title="点击进行排序"></span> </th>
                            <th style="width: 135px;">创建时间 <span data-val="{$smarty.get.create}" data-sort="create" class="create_sort {if $smarty.get.create eq 'desc'}icon-chevron-down{elseif $smarty.get.create eq 'asc'}icon-chevron-up{else}icon-minus{/if}" style="cursor: pointer;" title="点击进行排序"></span></th>
                            <th style="width: 135px;">操作</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyres">
                        {foreach $data as $item}
                            <tr class="odd gradeX">
                                <td style="width: 20px;"><input type="checkbox" class="checkboxes" value="{$item.id}" /></td>
                                <td>
                                    <img src="{$item.pictures[0].url}" style="width: 80px;float: left;margin-right: 10px;"/>
                                    <p>{$item.name}</p>
                                    <p>商家编码：{$item.number}</p>
                                </td>
                                <td style="width: 350px;">
                                    ￥{$item.market_price} <a href="javascript:;" class="show_price">详细</a>
                                    <div class="detail_price" style="border-top: 1px solid #ccc;margin-top: 8px;padding-top: 5px;display: none;">
                                        {foreach $item.sku as $stock}
                                            {$stock.sku_string}；价格：{$stock.price}；库存：{$stock.stock}<br/>
                                        {/foreach}
                                    </div>
                                </td>
                                <td>{$item.brokerage_ratio}%</td>
                                <td style="width: 80px;">{$item.trade_quantity}</td>
                                <td style="width: 135px;">{date('Y-m-d H:i', strtotime($item.created_at))}</td>
                                <td style="width: 135px;">
                                    <a class="btn btn-default" href="{route('EnterpriseGoodsEdit', $item.id)}">编辑</a>
                                    <a class="btn btn-danger soldout-goods" href="javascript:;" data-id="{$item.id}">下架</a>
                                </td>
                            </tr>
                            {foreachelse}
                            <tr>
                                <td colspan="12" style="text-align: center;">没有相关商品数据 ！</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                    {if $data}
                        <div class="row-fluid">
                            {if $data->getTotal() > 0}
                                <div class="span6" style="margin-top: 10px;">
                                    <input type="checkbox" id="checkAll2"/> 全选
                                    <input type="button" id="multiSaleOut" class="btn btn-danger" value="批量下架"/>
                                    <div class="dataTables_info">显示 {$data->getFrom()} 到 {$data->getTo()} 项，共 {$data->getTotal()} 项。</div>
                                </div>
                            {/if}
                            <div class="span6">
                                <div class="dataTables_paginate">{$data->appends(['name' => $smarty.get.name, 'create'=> $smarty.get.create, 'quantity' => $smarty.get.quantity ,'channel' => $smarty.get.goods_channel_id,'status' => $smarty.get.status, 'category_id' => $smarty.get.category_id])->links()}</div>
                            </div>
                        </div>
                    {/if}
                </div>
            </div>
            <!-- end recent orders portlet-->
        </div>
    </div>
{/block}

{block script}
    <script>
        //提交查询
        function select(){
            $("#category_form").submit();
        }

        //批量选中
        $("#checkAll,#checkAll2").click(function()
        {
            if ($(this).parent().hasClass('checked')) {
                $(".checkboxes").parent().removeClass('checked');
            } else {
                $(".checkboxes").parent().addClass('checked');
            }
        });


        $("#multiSaleOut").click(function() {
            var goods_id = new Array();
            $(".checkboxes").each(function() {
                if ($(this).parent().hasClass('checked')) {
                    goods_id.push($(this).val());
                }
            });
            if (goods_id.length < 1) {
                return;
            }
            iconfirm('确认要下架这'+goods_id.length+'个商品吗？', function() {
                $.ajax({
                    type:'POST',
                    data: { goods_id: goods_id , status:"{Goods::STATUS_CLOSE}" },
                    url: '{route("ToggleEnterpriseGoodsStatus")}',
                    dataType: 'text',
                    success:function(data) {
                        window.location.reload();
                    }
                });
            });
        });

        $('.soldout-goods').click(function() {
            var goods_id = $(this).attr('data-id');
            var obj = $(this);
            if (goods_id) {
                iconfirm('确认要下架此商品吗？', function() {
                    $.ajax({
                        type:'POST',
                        data: { goods_id: goods_id , status:"{Goods::STATUS_CLOSE}" },
                        url: '{route("ToggleEnterpriseGoodsStatus")}',
                        dataType: 'text',
                        success:function(data) {
                            if (obj.closest('#goods_item_list').find('tr').size() <= 2) {
                                window.location.reload();
                            } else {
                                obj.closest('tr').remove();
                            }
                        }
                    });
                });
            }
        });

        //产生下级分类
        $(document).on('change', ".sub_category", function() {
            var parent_id = $(this).val();
            var obj = $(this);
            obj.nextAll().remove();
            $.getJSON("{route("GoodsCategorySub")}", { parent_id:parent_id }, function(data) {
                if (data.length > 0) {
                    var select = '<select class="sub_category" name="category_id[]" style="width: 100px;"><option value="">请选择</option>';
                    $(data).each(function(i, e) {
                        select += "<option value='"+ e.id+"'>"+ e.name+"</option> ";
                    });
                    select += "</select>";
                    obj.parent().append(select);
                }
            });
        });

        function getCategory(cateArr, index)
        {
            var cate = cateArr[index+1];
            $.getJSON("{route("GoodsCategorySub")}", { parent_id:cateArr[index] }, function(data) {
                if (data.length > 0) {
                    var select = '<select class="sub_category" name="category_id[]" style="width: 100px;"><option value="">请选择</option>';
                    $(data).each(function(i, e) {
                        var selected = "";
                        if (cate && cate == e.id) {
                            selected = "selected='selected'";
                        }
                        select +=  "<option "+selected+" value='"+ e.id+"'>"+ e.name+"</option> ";
                    });
                    select += "</select>";
                    $(".sub_category").parent().append(select);
                    if (cateArr.length > index+1) {
                        getCategory(cateArr, index+1);
                    }
                }
            });
        }

        if ($("#selected_cate").val() != '') {
            var cateArr = $("#selected_cate").val().split(',');
            if (cateArr.length > 1) {
                getCategory(cateArr, 0);
            }
        }

        $(".show_price").click(function() {
            if ($(this).next('.detail_price').is(":visible")) {
                $(this).next('.detail_price').slideUp('slow');
            } else {
                $(this).next('.detail_price').slideDown('slow');
            }
        });

        $(".create_sort,.quantity_sort").click(function() {
            var url = "{route('GetSaleEnterpriseGoodsList', ['page' => $smarty.get.page, 'name' => $smarty.get.name, 'category_id' => $smarty.get.category_id])}";
            var val = $(this).attr('data-val');
            var sort = $(this).attr('data-sort');
            if (val != 'desc') {
                url += '&'+sort+'=desc';
            } else {
                url += '&'+sort+'=asc';
            }
            window.location.href = url;
        });

    </script>
{/block}
