{extends file='layout/main.tpl'}

{block title}发布公告{/block}

{block breadcrumb}
    <li>公告管理 <span class="divider">&nbsp;</span></li>
    <li><a href="{route('EditNotice')}">发布公告</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<script src="{asset('assets/ckeditor_4.4.5_full/ckeditor.js')}"></script>
<script src="{asset('assets/ckfinder_php_2.4.1/ckfinder.js')}"></script>
<!-- BEGIN ADVANCED TABLE widget-->
<div class="row-fluid">
<div class="span12">
    <!-- BEGIN widget-->
    <div class="widget">
        <div class="widget-body form">
            <!-- BEGIN FORM-->
            <form id="form" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label"><font style="color:red">*</font>公告标题：</label>
                    <div class="controls">
                        <input type="hidden" name="kind" value="{Notice::KIND_TEXT}"/>
                        <input type="text" class="span6" id="title" name="title" value="{$info.title}" placeholder="" required/>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="control-group" id="image_div" style="{if $info and $info.kind eq Notice::KIND_PIC}display:block;{else}display:none;{/if}">
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
                                           <input type="file" class="default upload_pic" />
                                       </span>
                                            <a href="#" class="btn delete_upload" style="display: none;">删除</a>
                                        </div>
                                        <input type="hidden"  id="picture_id" name="picture_id" value="{$info.picture_id}"/>
                                    </div>
                                </div>

                                <div style="clear: both;"></div>
                                <span class="label label-important">NOTE!</span>
                                <span>图片格式支持jpg、gif、png，。请用最新版火狐、谷歌或IE10及以上浏览器上传，360浏览器请切换到极速模式</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">公告内容:</label>
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
                    <label class="control-label">排序号：</label>
                    <div class="controls">
                        <div class="input-prepend input-append">
                            <input name="sort_order" id="sort_order"  value="{$info.sort_order|default:'100'}" type="text"/>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <input type="hidden" name="notice_id" id="notice_id"  value="{$info.id}"/>
                        <button type="button" class="btn btn-success" id="submit_form">保存</button>
                        <button type="button" class="btn" onclick="history.go(-1);">取消</button>
                    </div>
                </div>
            </form>
            <!-- END FORM-->
        </div>
        <!-- END ADVANCED TABLE widget-->
    	</div>
	</div>
</div>
{/block}

{block script}
<script type="text/javascript">

    $("#submit_form").click(function() {
        $("[name='content']").val(CKEDITOR.instances.content.getData());
        $.post('{route('SaveNotice')}', $("#form").serialize(), function(data) {
            window.location.href = "{route('GetNoticeList')}";
        });
    });

    $("#kind").change(function() {
        var kind = $(this).val();
        if (kind == '{Notice::KIND_TEXT}') {
            $("#image_div").hide();
        } else {
            $("#image_div").show();
        }
    });

    $(".upload_pic").change(function() {
        if ($(this).val() != '') {
            var formData = new FormData();
            formData.append('file', $(this)[0].files[0]);
            uploadPicture(formData, $(this));
        }
    });

    function uploadPicture(data, dom) {
        var dom = dom.closest('.fileupload');
        dom.find('.actions').find('.delete_upload').show();
        $.ajax({
            type:"POST",
            url: "{route('FileUpload')}",
            data: data,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {
                dom.find('#picture_id').val(data.id);
                dom.removeClass('fileupload-new').addClass('fileupload-exists');
            },
            error: function(xhq) {
                dom.removeClass('fileupload-exists').addClass('fileupload-new');
                dom.find('.actions').find('.delete_upload').hide();
                ialert(xhq.responseText);
            }
        });
    }
</script>
{/block}