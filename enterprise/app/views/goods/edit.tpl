{extends file='layout/main.tpl'}

{block title}商品管理{/block}

{block breadcrumb}
    <li>商品管理 <span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetSaleEnterpriseGoodsList')}">商品列表</a><span class="divider">&nbsp;</span></li>
    <li><a href="{route('EnterpriseGoodsEdit', ['id' => $data.id])}">{if $data.id gt 0}修改{else}添加{/if}商品</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block head}
<style type="text/css">
    #sku_list .sku_span { width: 60px; margin-right: 5px; display: inline-block;}
    #sku_list .add-attr { cursor: pointer;margin-left: 10px;padding: 3px 10px;}
    #sku_list .minus-attr { cursor: pointer;margin-left: 5px;padding: 3px 12px;}
    #sku_list .add-item { cursor: pointer;margin-left: 10px;padding: 3px 10px;position: relative;top: 6px;}
    #sku_list .minus-item { cursor: pointer;margin-left: 10px;padding: 3px 12px;position: relative;top: 6px;}
    #sku_list .sku_input { width: 60px;float: left; }
</style>
{/block}

{block main}
    <script src="{asset('assets/ckeditor_4.4.5_full/ckeditor.js')}"></script>
    <script src="{asset('assets/ckfinder_php_2.4.1/ckfinder.js')}"></script>
    <div class="row-fluid">
    <div class="span12">
        <!-- begin recent orders portlet-->
        <div class="widget">
            <div class="widget-title">
                <h4>
                    <i class="icon-reorder"></i> {if $data.id gt 0}修改{else}添加{/if}商品
                </h4>
            </div>
            <div class="widget-body form">
                <form method="post" action="{route('SaveGoodsInfo')}" id="goods_form" class="form-horizontal">
                    <div class="control-group local_channel">
                        <label class="control-label">类目选择：</label>
                        <div class="controls">
                            <div>
                                <select class="span6 goods_type" id="goods_type" style="width: 150px;" name="goods_type_id">
                                    {foreach $goods_type as $type}
                                        <option value="{$type.id}" {if $data}{if $type.id eq $data.goods_type_id}selected="selected"{/if}{/if}>{$type.name}</option>
                                    {/foreach}
                                </select>
                                <a href="{route('GetGoodsTypeList')}" target="_blank" class="btn btn-info">编辑类目</a>
                            </div>
                        </div>
                    </div>
                    <div class="control-group local_channel">
                        <label class="control-label">商品分类：</label>
                        <div class="controls">
                            <div id="linkSelecter" style="margin-bottom: 10px;display: none;">
                                <select class="span6 sub_category" data-placeholder="请选择一级分类" tabindex="1" style="width: 150px;" name="category[]">
                                    <option value="0">--请选择--</option>
                                    {foreach $category as $item}
                                        <option value="{$item->id}">{$item->name}</option>
                                    {/foreach}
                                </select>
                                <button type="button" class="btn btn-primary addSelecter">增加</button>
                                <button type="button" class="btn btn-danger removeSelecter">删除</button>
                            </div>
                            <div id="link_list">
                                {if $cate_data}
                                    {foreach $cate_data as $key1=>$cate1}
                                        <div id="linkSelecter" style="margin-bottom: 10px;">
                                            {foreach $cate1 as $key2=>$cate2}
                                                <select class="span6 sub_category" data-placeholder="请选择一级分类" tabindex="1" style="width: 150px;" name="category[]">
                                                    {foreach $cate2 as $key3=>$cate3}
                                                        <option value="{$cate3.id}" {if $cate_id.$key1.$key2 eq $cate3.id}selected{/if}>{$cate3.name}</option>
                                                    {/foreach}
                                                </select>
                                            {/foreach}
                                            <button type="button" class="btn btn-primary addSelecter">增加</button>
                                            <button type="button" class="btn btn-danger removeSelecter">删除</button>
                                        </div>
                                    {/foreach}
                                {else}
                                    <div style="margin-bottom: 10px;">
                                        <select class="span6 sub_category" data-placeholder="请选择一级分类" tabindex="1" style="width: 150px;" name="category[]">
                                            <option value="0">--请选择--</option>
                                            {foreach $category as $item}
                                                <option value="{$item->id}">{$item->name}</option>
                                            {/foreach}
                                        </select>
                                        <button type="button" class="btn btn-primary addSelecter">增加</button>
                                        <button type="button" class="btn btn-danger removeSelecter">删除</button>
                                    </div>
                                {/if}
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">型号:</label>
                        <div class="controls">
                            <input type="text" placeholder="请输入商品型号" class="span6" name="number" value="{Input::old('number')|default:$data.number}" required />
                            <span class="help-inline" id="tingxing_number" style="color:#FF0000"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">名称:</label>
                        <div class="controls">
                            <input type="text" placeholder="请输入商品名称" class="span6" name="name" value="{Input::old('name')|default:$data.name}" required />
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">图片</label>
                        <div class="controls">
                            <div action="{route('FileUpload')}" class="dropzone"></div>
                            <span class="label label-important">注意</span>
                            <span>商品图片请上传800*800 px正方形图片，防止前台显示图片变形，小于2M 。 上传只支持最新的Firefox、Chrome、Opera、Safari和Internet Explorer 10 以上版本的浏览器。</span>
                        </div>
						<span id="pictures-container">
						{if count(Input::old('pictures')) gt 1}
                            {foreach Input::old('pictures') as $picture_id}
                                <input type="hidden" name="pictures[]" value="{$picture_id}">
                            {/foreach}
						{else}
							{foreach $data.pictures as $picture_id}
                            <input type="hidden" name="pictures[]" value="{$picture_id.id}">
                        {/foreach}
                        {/if}
						</span>
                    </div>

                    <div class="control-group">
                        <label class="control-label">市场价:</label>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on">￥</span><input class="" name="market_price" type="text" value="{Input::old('market_price')|default:$data.market_price}" placeholder="请输入商品市场价" required />
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">规格价格:</label>
                        <div class="controls" id="sku_list">

                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">佣金比率:</label>
                        <div class="controls">
                            <input type="text" name="brokerage_ratio" style="width: 35px;" value="{$data.brokerage_ratio}"> %
                            <span>一个月只可以修改一次</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">商品详情:</label>
                        <div class="controls">
                            <textarea class="span12 ckeditor" name="description" rows="6">{Input::old('description')|default:$data.description}</textarea>
                            <script>
                                CKEDITOR.replace( 'description',
                                        {
                                            filebrowserBrowseUrl : '/assets/ckfinder_php_2.4.1/ckfinder.html',
                                            filebrowserImageBrowseUrl : '/assets/ckfinder_php_2.4.1/ckfinder.html?Type=Images',
                                            filebrowserFlashBrowseUrl : '/assets/ckfinder_php_2.4.1/ckfinder.html?Type=Flash',
                                            filebrowserUploadUrl : '/assets/ckfinder_php_2.4.1/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                            filebrowserImageUploadUrl : '{route("CKFileUpload",["type"=>"ck"])}',
                                            filebrowserFlashUploadUrl : '/assets/ckfinder_php_2.4.1/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                                        });
                            </script>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">商品参数:</label>
                        <div class="controls">
                            <textarea class="span12 ckeditor" name="parameter" rows="6">{Input::old('parameter')|default:$data.parameter}</textarea>
                            <script>
                                CKEDITOR.replace( 'parameter',
                                        {
                                            filebrowserBrowseUrl : '/assets/ckfinder_php_2.4.1/ckfinder.html',
                                            filebrowserImageBrowseUrl : '/assets/ckfinder_php_2.4.1/ckfinder.html?Type=Images',
                                            filebrowserFlashBrowseUrl : '/assets/ckfinder_php_2.4.1/ckfinder.html?Type=Flash',
                                            filebrowserUploadUrl : '/assets/ckfinder_php_2.4.1/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                            filebrowserImageUploadUrl : '{route("CKFileUpload",["type"=>"ck"])}',
                                            filebrowserFlashUploadUrl : '/assets/ckfinder_php_2.4.1/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                                        });
                            </script>
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" value="{$data.id}" name="id" id="goods_id"/>
                        <input type="hidden" value="{$data.status|default:'Open'}" name="status" id="goods_status"/>
                        {if $data}
                            <button type="button" id="submitForm" class="btn btn-primary">保 存</button>
                        {else}
                            <button type="button" id="submitForm" class="btn btn-primary">发 布</button>
                            <button type="button" id="storeForm" class="btn btn-info">放入仓库</button>
                        {/if}
                        <a href="javascript:window.history.go(-1);"><button type="button" class="btn"> 取消</button></a>
                    </div>
                </form>
            </div>
        </div>
        <!-- end recent orders portlet-->
    </div>
    </div>
{/block}

{block script}
    <script>
    //时间
    $(".form_datetime").datetimepicker({
        format: 'yyyy-mm-dd hh:ii:ss',
        autoclose: true,
        pickerPosition: "bottom-left",
        language:"zh-CN"
    });

    $("#link_list .removeSelecter:last").hide();

    //异步提示产品型号
    $("input[name=number]").on('blur',function(){
        var number = $(this).val();
        var goods_id = "{$data.id}";
        if (number != '') {
            $.ajax({
                type: "GET",
                url: "{route('CheckGoodsNumber')}",
                dataType: 'text',
                data: { number: number, goods_id: goods_id },
                success: function(data) {
                    $("#tingxing_number").html('');
                },
                error : function(data) {
                    $("#tingxing_number").html(data.responseText);
                }
            });
        }
    });

    //上传图片
    var myDropzone = new Dropzone('.dropzone');
    myDropzone.on('addedfile', function(file) {
        $(file.previewTemplate).on('click', function() {
            iconfirm('确认要删除此图片吗？', function() {
                myDropzone.removeFile(file);
                $('#pictures-container [name="pictures[]"][value="' + file.id + '"]:first').remove();
            });
        });
    });
    myDropzone.on('success', function(file, responseText) {
        file.id = responseText.id;
        $('#pictures-container').append('<input type="hidden" name="pictures[]" value="' + file.id + '">');
    });
    var file = { };

    var old_pic="{Input::old('pictures')}";
    if(old_pic!=''){
        {foreach Input::old('pictures') as $picture}
        file = {
            url	: '{UserFile::find($picture)->url}',
            id	: '{$picture}',
            name : '{UserFile::find($picture)->filename}',
            size	: '{UserFile::find($picture)->size}',
            type	: '{UserFile::find($picture)->mime|replace:'/':'.'}'
        };
        myDropzone.emit('addedfile', file);
        myDropzone.emit('thumbnail', file, file.url);
        {/foreach}
    }else{
        {foreach $data.pictures as $picture}
        file = {
            url	: '{$picture.url}',
            id	: '{$picture.id}',
            name : '{$picture.filename}',
            size	: {$picture.storage.size},
            type	: '{$picture.storage.mime|replace:'/':'.'}'
        };
        myDropzone.emit('addedfile', file);
        myDropzone.emit('thumbnail', file, file.url);
        {/foreach}
    }

    //图片上传
    $('#mianForm').on('submit', function(){
        var id_list = { };
        $('#pictures-container [name="pictures[]"]').each(function(){
            var id = $(this).val();
            if(typeof id_list[id] == 'undefined'){
                id_list[id] = 0;
            }
            id_list[id]++;
        });
        $.each(id_list, function(id, count){
            if(count > 1){
                $('#pictures-container [name="pictures[]"][value="' + id + '"]:gt(0)').remove();
            }
        });
    });

    //产生下级分类
    $(document).on('change', ".sub_category", function() {
        var obj=$(this);
        var parent_id = $(this).val();
        $(this).nextAll(':not(button)').remove();
        $.getJSON("{route("GoodsCategorySub")}", { parent_id:parent_id }, function(data) {
            if (data.length > 0) {
                var select = '&nbsp;&nbsp;<select class="span6 sub_category" style="width:150px;" name="category[]" tabindex="1"><option value="0">--请选择--</option>';
                $(data).each(function(i, e) {
                    select += "<option value='"+ e.id+"'>"+ e.name+"</option> ";
                });
                select += "</select>";
                obj.after(select);
            }
        });
    });

    //增加一行
    $(document).on('click', '.addSelecter', function(){
        addLinkSelecter();
    });

    //删除一行
    $(document).on('click', '.removeSelecter', function()
    {
        var parent = $(this).parent();
        var del = false;
        if (parent.find('[name="category[]"]').val() != '') {
            if (confirm('确定要删除吗？')) {
                del = true;
            }
        } else {
            del = true;
        }
        if (del) {
            $(this).parent().remove();
            $("#link_list .addSelecter:last").show();
            if ($("#link_list .removeSelecter").size() <= 1 ) {
                $("#link_list .removeSelecter").hide();
            }
        }
    });

    //克隆函数
    function addLinkSelecter()
    {
        $("#link_list .addSelecter").hide();
        var link = $("#linkSelecter").clone().show();
        $("#link_list").append(link);
        $("#link_list .removeSelecter").show();
    }

    $("#link_list .addSelecter:not(':last')").hide();

    $(document).on('click', '.add-item', function() {
        var obj = $(this).closest('div').clone();
        obj.find('.sku_span .sku_input').val('');
        $(".add-item").hide();
        $("#sku_list").append(obj);
        $(".minus-item").show();
        refreshSkuInputIndex();
    });

    $(document).on('click', '.minus-item', function() {
        var obj = $(this).closest('div');
        if (obj.find('.sku_span .sku_input').filter('[value=""]').size() == obj.find('.sku_span .sku_input').size()) {
            obj.remove();
            $(".add-item:last").show();
            if ($(".minus-item").size() == 1) {
                $(".minus-item").hide();
            }
        } else {
            iconfirm('确定要删除吗？', function() {
                obj.remove();
                $(".add-item:last").show();
                if ($(".minus-item").size() == 1) {
                    $(".minus-item").hide();
                }
            });
        }
        refreshSkuInputIndex();
    });


    $(document).on('keyup', '.sku_price,[name="market_price"]', function() {
        var val = $(this).val();
        if (isNaN(val)) {
            $(this).val('');
        }
    });

    $(document).on('keyup', '.sku_stock', function() {
        var val = $(this).val();
        if (val != '' && !/^[1-9]+[\d]?$/.test(val)) {
            $(this).val('');
        }
    });

    $(document).on('keyup', '[name="brokerage_ratio"]', function() {
        if (isNaN($(this).val())) {
            $(this).val('');
        } else if ($(this).val() > 100) {
            ialert('佣金比不能大于100%！');
            $(this).val('');
        }
    });

    function refreshSkuInputIndex() {
        $(".sku_item").each(function() {
            var index = $(this).index('.sku_item');
            $(this).find('.sku_span .sku_input').each(function() {
                if ($(this).hasClass('sku_price')) {
                    $(this).attr('name', "sku_price["+index+"]");
                } else if ($(this).hasClass('sku_attr')) {
                    $(this).attr('name', "sku_attr["+index+"]["+$(this).attr('data-id')+"]");
                } else if ($(this).hasClass('sku_stock')) {
                    $(this).attr('name', "sku_stock["+index+"]");
                }
            });
        });
    }


    $("#goods_type").change(function() {
        getSKU();
    });

    getSKU();

    function getSKU()
    {
        var goods_type_id = $("#goods_type").val();
        var goods_id = $("#goods_id").val();
        $.get('{route("GetGoodsSkuView")}', { goods_type_id: goods_type_id, goods_id:goods_id }, function(data) {
            $("#sku_list").html(data);
        }, 'html');
    }

    $("#submitForm").click(function() {
        var action = $(this).attr('data-action');
        if (action == 1) {
            return false;
        }
        $(this).attr('data-action', 1);
        var obj = $(this);
        $("[name='description']").val(CKEDITOR.instances.description.getData());
        $("[name='parameter']").val(CKEDITOR.instances.parameter.getData());
        $.ajax({
            type: 'POST',
            url: '{route("SaveGoodsInfo")}',
            data: $("#goods_form").serialize(),
            dataType: 'json',
            success: function(data) {
                obj.attr('data-action', 0);
                if ($("#id").val() != '') {
                    window.location.href = "{URL::previous()}";
                } else {
                    iconfirm('商品添加成功！继续添加信息商品', function() {
                        window.location.reload()
                    }, function() {
                        window.location.href = "{URL::previous()}";
                    })
                }
            },
            error: function(xhq) {
                obj.attr('data-action', 0);
                ialert(xhq.responseText);
            }
        });
    });

    $("#storeForm").click(function() {
        $("#goods_status").val("{Goods::STATUS_CLOSE}");
        $("#submitForm").trigger('click');
    });
    </script>
{/block}