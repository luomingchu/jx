{extends file='layout/main.tpl'}

{block title}广告管理{/block}

{block breadcrumb}
    <li>活动管理<span class="divider">&nbsp;</span></li>
    <li>广告管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetAdvertiseSpaceList')}">广告位列表</a><span class="divider">&nbsp;</span></li>
    <li><a href="{route('EditAdvertise', ['space_id' => $smarty.get.space_id, 'advertise_id' => $smarty.get.advertise_id])}">广告编辑</a><span class="divider-last">&nbsp;</span></li>
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
            <i class="icon-reorder"></i> {if $info.id gt 0}修改{else}添加{/if}广告
        </h4>
    </div>
    <div class="widget-body form">
    <form class="form-horizontal" role="form" id="AdvertiseSpaceForm" method="POST" action="{route('SaveAdvertiseSpace')}">
    <input type="hidden" name="id" value="{$info.id}">
    <div class="control-group">
        <label class="control-label"><font style="color:red">*</font>所属广告位：</label>
        <div class="controls">
            <select name="space_id">
                {foreach $spaceList as $space}
                    <option value="{$space.id}" {if $space.id eq $smarty.get.space_id}selected="selected" {/if}>{$space.name}</option>
                {/foreach}
            </select>
            <span class="help-inline" id="tingxing_number" style="color:#999"></span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"><font style="color:red">*</font>标题：</label>
        <div class="controls">
            <input type="text" class="text span6" placeholder="标题" name="title" value="{$info.title}" required>
            <span class="help-inline" id="tingxing_number" style="color:#999"></span>
        </div>
    </div>
    <div class="control-group" id="image_div">
        <label class="control-label"><font style="color:red">*</font>图片：</label>
        <div class="controls">
            <div>
                <div class="control-group">
                    <div style="float: left;margin-right: 10px;">
                        <div class="fileupload {if $info.picture_id}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                <img src="{asset('img/no+image.gif')}" alt="" />
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                {if $info.picture_id}
                                    <img src="{route('FilePull',['id'=>$info.picture_id])}"/>
                                {/if}
                            </div>
                            <div class="actions">
                                                   <span class="btn btn-file">
                                                       <span class="fileupload-new">选择</span>
                                                       <span class="fileupload-exists">修改</span>
                                                       <input type="file" class="default upload_pic" data-id="picture_id"/>
                                                   </span>
                                <a href="#" class="btn delete_upload" style="display: none;">删除</a>
                            </div>
                            <input type="hidden"  id="picture_id" name="picture_id" value="{$info.picture_id}"/>
                        </div>
                    </div>

                    <div style="clear: both;"></div>
                    <span class="label label-important">NOTE!</span>
                    <span>图片大小1125*352px,格式支持jpg、gif、png，。请用最新版火狐、谷歌或IE10及以上浏览器上传，360浏览器请切换到极速模式</span>
                </div>
            </div>
        </div>
    </div>


    <div class="control-group">
        <label class="control-label">类型：</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="kind" {if $info.kind|default:Advertise::KIND_CUSTOM eq Advertise::KIND_CUSTOM }checked{/if} value="{Advertise::KIND_CUSTOM}" /> 自定义广告
            </label>
            <label class="radio">
                <input type="radio" name="kind" {if $info.kind eq Advertise::KIND_GOODS }checked{/if} value="{Advertise::KIND_GOODS}" /> 商品类广告
            </label>
        </div>
    </div>

    <div id="custom_kind" {if $info.kind|default:Advertise::KIND_CUSTOM neq Advertise::KIND_CUSTOM}style="display: none;" {/if}>
        <div class="control-group" id="ad_content" >
            <label class="control-label">广告内容:</label>
            <div class="controls">
                <textarea class="span12 ckeditor" name="content" rows="6">{$info.content}</textarea>
                <script>
                    CKEDITOR.replace( 'content',
                            {
                                filebrowserBrowseUrl : '/assets/ckfinder_php_2.4.1/ckfinder.html',
                                filebrowserImageBrowseUrl : '/assets/ckfinder_php_2.4.1/ckfinder.html?Type=Images',
                                filebrowserFlashBrowseUrl : '/assets/ckfinder_php_2.4.1/ckfinder.html?Type=Flash',
                                filebrowserUploadUrl : '/assets/ckfinder_php_2.4.1/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                filebrowserImageUploadUrl : '{route("CKFileUpload")}',
                                filebrowserFlashUploadUrl : '/assets/ckfinder_php_2.4.1/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                            });
                </script>
            </div>
        </div>

        <div class="control-group" id="ad_url">
            <label class="control-label">广告链接：</label>
            <div class="controls">
                <input type="text" class="text span6" placeholder="广告链接" name="url" value="{$info.url}">
                <span class="help-inline" style="color:#999">外部页面链接</span>
            </div>
        </div>
    </div>

    <div id="goods_kind" {if $info.kind neq Advertise::KIND_GOODS}style="display: none;" {/if}>
        <div class="control-group">
            <label class="control-label">模板名称：</label>
            <div class="controls">
                <select name="template_name">
                    <option value="single_goods" {if $info.template_name eq 'single_goods'}selected="selected" {/if}>单商品模板</option>
                    <option value="multi_goods" {if $info.template_name eq 'multi_goods'}selected="selected" {/if}>多商品模板</option>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><font style="color:red">*</font>模板图片：</label>
            <div class="controls">
                <div>
                    <div class="control-group">
                        <div style="float: left;margin-right: 10px;">
                            <div class="fileupload {if $info.template_picture_id}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="{asset('img/no+image.gif')}" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                    {if $info.template_picture_id}
                                        <img src="{route('FilePull',['id'=>$info.template_picture_id])}"/>
                                    {/if}
                                </div>
                                <div class="actions">
                                                       <span class="btn btn-file">
                                                           <span class="fileupload-new">选择</span>
                                                           <span class="fileupload-exists">修改</span>
                                                           <input type="file" class="default upload_pic" data-id="template_picture_id"/>
                                                       </span>
                                    <a href="#" class="btn delete_upload" style="display: none;">删除</a>
                                </div>
                                <input type="hidden"  id="template_picture_id" name="template_picture_id" value="{$info.template_picture_id}"/>
                            </div>
                        </div>

                        <div style="clear: both;"></div>
                        <span class="label label-important">NOTE!</span>
                        <span>图片大小1125*352px,格式支持jpg、gif、png，。请用最新版火狐、谷歌或IE10及以上浏览器上传，360浏览器请切换到极速模式</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">推广商品：</label>
            <div class="controls">
                <table class="table table-bordered table-advance table-hover" id="choose_goods_list" {if count($goods_list) < 1 }style="display: none;"{/if}>
                    <thead>
                    <tr>
                        <th>商品名称</th>
                        <th>货号</th>
                        <th>市场价</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody id="GoodsContainer">
                    {foreach $goods_list as $goods}
                        <tr id="GoodsItem_{$goods.id}" data-id="{$goods.id}">
                            <td>
                                <a href="{$goods.pictures[0].url}" target="_blank">
                                    <img src="{$goods.pictures[0].url}&width=25&height=25" width="25" height="25">
                                </a>
                                {$goods.name}
                            </td>
                            <td>{$goods.number}</td>
                            <td>{$goods.market_price}</td>
                            <td>
                                <button type="button" data-id="{$goods.id}" class="remove_goods btn btn-small btn-info">取 消</button>
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
                <input type="button" value="添加商品" id="addGoods" style="margin-top: 10px;" class="btn btn-primary"/>
            </div>
        </div>
    </div>

    <div class="control-group" style="margin-top:15px;">
        <label class="control-label">排序号：</label>
        <div class="controls">
            <input name="sort_order" id="sort_order"  value="{$info.sort|default:'100'}" type="text"/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">状态：</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="status" {if $info.status eq Notice::STATUS_OPEN }checked{/if} value="{Notice::STATUS_OPEN}" /> 开启
            </label>
            <label class="radio">
                <input type="radio" name="status" {if $info.status eq Notice::STATUS_CLOSE }checked{/if} value="{Notice::STATUS_CLOSE}" /> 关闭
            </label>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">备注：</label>
        <div class="controls">
            <div class="input-prepend input-append">
                <textarea name="remark" style="width: 700px;height: 60px;">{$info.remark}</textarea>
            </div>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">app消息推送：</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="push" value="1" /> 推送
            </label>
            <label class="radio">
                <input type="radio" name="push" value="0" checked="checked"/> 不推送
            </label>
        </div>
    </div>

    <div class="control-group" id="push_msg_content" style="display: none;">
        <label class="control-label">推送消息内容：</label>
        <div class="controls">
            <input type="text" class="text span6" placeholder="消息内容" id="push_msg" name="push_msg">
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <input type="hidden" value="" id="popularize_goods" name="popularize_goods"/>
            <button type="button" class="btn btn-success" id="submit_form">保存</button>
            <button type="button" class="btn" onclick="history.go(-1);">取消</button>
        </div>
    </div>

    </form>
    </div>
    </div>
    <!-- end recent orders portlet-->
    </div>
    </div>



    <div id="goodsModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" style="width: 750px;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">推广商品选择</h3>
        </div>
        <div class="modal-body">
            <form id="goods_search_form">
                <div class="row-fluid">
                        <span id="goods_category">
                            <select name="category_id[]" class="sub_category" data-placeholder="选择一级分类" style="width: 100px;">
                                <option value="">全部分类</option>
                                {foreach $category as $item}
                                    <option value="{$item.id}">{$item.name}</option>
                                {/foreach}
                            </select>
                        </span>
                    <input type="text" id="search_goods_name" name="name" placeholder="宝贝名称关键字" style="width: 150px;"/>
                    <input type="text" id="search_goods_number" name="number" placeholder="商品货号" style="width: 100px;"/>
                    <button type="button" class="btn btn-primary" id="GoodsFind"><i class="icon-search icon-white"></i> 查询</button>
                </div>
            </form>
            <div class="clearfix"></div>
            <div id="goods_list">
                <table class="table table-bordered table-advance table-hover">
                    <thead>
                    <tr>
                        <th>商品名称</th>
                        <th>货号</th>
                        <th>市场价</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody id="goods_item_list">
                    <tr>
                        <td colspan="5" style="text-align:center">没有任何商品</td>
                    </tr>
                    </tbody>
                    <tbody id="GoodsList"></tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal" id="confirmAction">确定</button>
            <button type="button" class="btn" data-dismiss="modal" id="confirmCancelAction">取消</button>
        </div>
    </div>

{/block}

{block script}
    <script type="text/javascript">

        $("#GoodsFind").click(function() {
            $.get('{route("SearchGoods")}', $("#goods_search_form").serialize(), function(data) {
                $("#goods_list").html(data);
                markGoods();
            },'html');
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            $("#goods_item_list").html("<tr><td colspan='5' style='text-align: center;'>商品获取中，请稍后...</td></tr> ");
            $.get($(this).attr('href'), function(html) {
                $("#goods_list").html(html);
                markGoods();
            }, 'html');
        });

        $("#addGoods").click(function() {
            $("#goodsModal").modal('show');
        });

        function showPushMsg()
        {
            if ($("[name='push']:checked").val() == 1) {
                $("#push_msg_content").show();
            } else {
                $("#push_msg_content").hide();
            }
        }

        showPushMsg();

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

        $("[name='push']").click(function() {
            showPushMsg();
        });

        $("[name='kind']").click(function() {
            if ($("[name='kind']:checked").val() == '{Advertise::KIND_GOODS}') {
                $("#custom_kind").hide();
                $("#goods_kind").show();
            } else if ($("[name='kind']:checked").val() == '{Advertise::KIND_CUSTOM}') {
                $("#custom_kind").show();
                $("#goods_kind").hide();
            }
        });

        $("#submit_form").click(function() {
            $("[name='content']").val(CKEDITOR.instances.content.getData());
            if ($("[name='push']:checked").val() == 1) {
                if ($("#push_msg").val() == '') {
                    ialert('请输入要推送给app的消息内容！');
                    return false;
                }
            }

            var goods_id = new Array();
            $(".remove_goods").each(function() {
                goods_id.push($(this).attr('data-id'));
            });
            $("#popularize_goods").val(goods_id.join(','));

            if ($("[name='kind']:checked").val() == 'Goods') {
                if (goods_id.length < 1) {
                    ialert('请先选择要推广的商品！');
                    return false;
                }
            }

            $.post('{route('SaveAdvertise')}', $("#AdvertiseSpaceForm").serialize(), function(data) {
                window.location.href = "{URL::previous()}";
            });
        });


        $(".upload_pic").change(function() {
            var id = $(this).attr('data-id');
            if ($(this).val() != '') {
                var formData = new FormData();
                formData.append('file', $(this)[0].files[0]);
                uploadPicture(formData, $(this), id);
            }
        });

        function uploadPicture(data, dom, id) {
            var dom = dom.closest('.fileupload');
//        dom.find('.actions').find('.delete_upload').show();
            $.ajax({
                type:"POST",
                url: "{route('FileUpload')}",
                data: data,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    dom.find('#'+id).val(data.id);
                    dom.removeClass('fileupload-new').addClass('fileupload-exists');
                },
                error: function(xhq) {
                    dom.removeClass('fileupload-exists').addClass('fileupload-new');
                    dom.find('.actions').find('.delete_upload').hide();
                    ialert(xhq.responseText);
                }
            });
        }

        $(document).on('click', '.choose', function() {
            if ($(this).attr("disabled") != 'disabled') {
                if ($("[name='template_name']").val() == 'single_goods' && $(".remove_goods").size() > 0) {
                    ialert('您选择了单商品模板，只能选择一个商品！');
                    return false;
                }
                var tr = $(this).closest('tr').clone();
                var goods_id = $(this).attr('data-id');
                tr.attr('id', 'GoodsItem_'+goods_id);
                tr.find('td:last').find('.choose').remove();
                tr.find('td:last').html('<button type="button" data-id="'+goods_id+'" class="remove_goods btn btn-small btn-info">取 消</button>');
                $("#choose_goods_list").show();
                $("#GoodsContainer").append(tr);
                markGoods();
            }
        });

        $(document).on('click', '.remove_goods', function() {
            $(this).closest('tr').remove();
            if ($('.remove_goods').size() < 1) {
                $("#choose_goods_list").hide();
            }
            markGoods();
        });

        function markGoods()
        {
            var choosed = { };
            $(".remove_goods").each(function() {
                choosed[$(this).attr('data-id')] = $(this).attr('data-id');
            });

            $(".choose").each(function() {
                if (typeof choosed[$(this).attr('data-id')] != 'undefined') {
                    $(this).addClass('btn-inverse').removeClass('btn-info');
                    $(this).attr('disabled', 'disabled');
                } else {
                    $(this).addClass('btn-info').removeClass('btn-inverse');
                    $(this).removeAttr('disabled');
                }
            });
        }
    </script>
{/block}
