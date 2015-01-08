{extends file='layout/main.tpl'}

{block title prepend}编辑企业信息  {/block}

{block breadcrumb}
<li>银行管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('GetBankList')}">银行列表</a><span class="divider">&nbsp;</span></li>
<li>{if $data.id gt 0}编辑{else}添加{/if}银行<span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<!-- BEGIN ADVANCED TABLE widget-->
<div class="row-fluid">
    <div class="span12">
    <!-- BEGIN widget-->
    <div class="widget">
        <div class="widget-title">
        <h4><i class="icon-reorder"> 添加/编辑银行信息</i></h4>
    </div>
    <div class="widget-body form">
    <!-- BEGIN FORM-->
    <form id="form" class="form-horizontal">
        <div class="control-group">
            <label class="control-label">银行名称：</label>
            <div class="controls">
                <input type="text" class="span6" id="name" name="name" value="{Input::old('name')|default:$data.name}" required placeholder=""/>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
		    <label class="control-label">logo图片：</label>
		    <div class="controls"><div>
                   <div class="control-group">
                       <div style="float: left;margin-right: 10px;">
                           <div class="fileupload {if $data.logo_hash}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
                               <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                   <img src="{asset('img/no+image.gif')}" alt="" />
                               </div>
                               <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                   {if $data.logo_hash}
                                       <img src="{route('FilePull',['hash'=>$data.logo_hash,'width'=>200,'width'=>150])}"/>
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
                               <input type="hidden"  id="logo_hash" name="logo_hash" value="{$data.logo_hash}"/>
                           </div>
                       </div>
                       
                       <div style="clear: both;"></div>
                       <span class="label label-important">NOTE!</span>
                       <span>图片格式支持jpg、gif、png，建议图片尺寸430*430的图片。请用最新版火狐、谷歌或IE10及以上浏览器上传，360浏览器请切换到极速模式</span>
                   </div></div>
           	</div>
		</div>
        <div class="control-group">
            <label class="control-label">服务热线：</label>
            <div class="controls">
                <div class="input-prepend input-append">
                    <input name="hotline" value="{Input::old('hotline')|default:$data.hotline}" type="text"/> 
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">排序值：</label>
            <div class="controls">
                <div class="input-prepend input-append">
                    <input name="sort" id="sort"  value="{Input::old('sort')|default:$data.sort}" type="text"/>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">备注：</label>
            <div class="controls">
                <div class="input-prepend input-append">
                    <input name="remark" id="remark"  value="{Input::old('remark')|default:$data.remark}" type="text"/>
                </div>
            </div>
        </div>
        <div class="control-group">
        	<div class="controls">
        		<input type="hidden" name="bank_id" id="bank_id"  value="{$data.id}"/>
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

<div class="modal fade" id="MessageModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Message</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{/block}

{block script}
<script type="text/javascript">
    var action_url = '{route("GetBankList")}';

    //上传图片
    $(".upload_pic").change(function() {
        if ($(this).val() != '') {
            var formData = new FormData();
            formData.append('file', $(this)[0].files[0]);
            var element=$(this).parent().parent().next();
            uploadPicture(formData, $(this),element);
        }
    });
	
	function uploadPicture(data, dom,element) {
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
                element.val(data.storage.hash);
                dom.removeClass('fileupload-new').addClass('fileupload-exists');
            },
            error: function(xhq) {
                dom.removeClass('fileupload-exists').addClass('fileupload-new');
                dom.find('.actions').find('.delete_upload').hide();
                ialert(xhq.responseText);
            }
        });
    }

    $("#submit_form").click(function() {
        var action = $(this).attr('data-action');
        if (action == 1) {
            return false;
        }
        $(this).attr('data-action', 1);
        var data = $("#form").serialize();
        var obj = $(this);
        $.ajax({
            type: "POST",
            url: "{route('SaveBank')}",
            dataType: 'json',
            data: data,
            success: function(data) {
                window.location.href = action_url;
            },
            error : function(xhq) {
                obj.attr('data-action', 0);
                ialert(xhq.responseText);
            }
        });
    });


    function ialert(msg)
    {
        $('#MessageModal').find('.modal-body p').text(msg).end().one('hidden.bs.modal', function(){
        }).modal();
    }
</script>
{/block}