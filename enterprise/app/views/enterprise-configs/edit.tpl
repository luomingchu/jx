{extends file='layout/main.tpl'}

{block title}系统皮肤设置 {/block}

{block breadcrumb}
<li>系统管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('EnterpriseConfigEdit')}">系统皮肤设置</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<!-- BEGIN ADVANCED TABLE widget-->
<div class="row-fluid">
    <div class="span12">
    <!-- BEGIN widget-->
    <div class="widget">
        <div class="widget-title">
        <h4><i class="icon-reorder"> 系统皮肤设置</i></h4>
    </div>
    <div class="widget-body form">
    <!-- BEGIN FORM-->
    <form id="config_form" method="post" enctype="multipart/form-data" action="{route('EnterpriseConfigSave')}" class="form-horizontal">
        <!-- <div class="control-group">
            <label class="control-label">企业logo图片：</label>
            <div class="controls">
                <div>
                    <div class="control-group">
                        <div style="float: left;margin-right: 10px;">
                            <div class="fileupload {if $data.info_logo_hash}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="{asset('img/no+image.gif')}" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                    {if $data.info_logo_hash}
                                        <img src="{route('FilePull',['hash'=>$data.info_logo_hash,'width'=>200,'width'=>150])}"/>
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
                                <input type="hidden"  id="info_logo_hash" name="info_logo_hash" value="{$data.info_logo_hash}"/>
                            </div>
                        </div>
                        
                        <div style="clear: both;"></div>
                        <span class="label label-important">NOTE!</span>
                        <span>图片格式必须为 png 透明，尺寸223*71。请用最新版火狐、谷歌或IE10及以上浏览器上传，360浏览器请切换到极速模式</span>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="control-group">
            <label class="control-label">企业logo图片：</label>
            <div class="controls">
                <div>
                    <div class="control-group">
                        <div style="float: left;margin-right: 10px;">
                            <div class="fileupload {if $data.admin_logo_hash}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="{asset('img/no+image.gif')}" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="background:{$data.login_color|default:"0f0"}; max-width: 200px; max-height: 150px; line-height: 20px;">
                                    {if $data.admin_logo_hash}
                                        <img src="{route('FilePull',['hash'=>$data.admin_logo_hash,'width'=>200,'width'=>150])}"/>
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
                                <input type="hidden"  id="admin_logo_hash" name="admin_logo_hash" value="{$data.admin_logo_hash}"/>
                            </div>
                        </div>

                        <div style="clear: both;"></div>
                        <span class="label label-important">NOTE!</span>
                        <span>图片格式必须为 png 透明，尺寸223*71。请用最新版火狐、谷歌或IE10及以上浏览器上传，360浏览器请切换到极速模式</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">APP Logo：</label>
            <div class="controls">
                <div>
                    <div class="control-group">
                        <div style="float: left;margin-right: 10px;">
                            <div class="fileupload {if $data.admin_logo_hash}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="{asset('img/no+image.gif')}" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style=" max-width: 200px; max-height: 150px; line-height: 20px;">
                                    {if $data.admin_logo_hash2}
                                        <img src="{route('FilePull',['hash'=>$data.admin_logo_hash2,'width'=>200,'width'=>150])}"/>
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
                                <input type="hidden"  id="admin_logo_hash2" name="admin_logo_hash2" value="{$data.admin_logo_hash2}"/>
                            </div>
                        </div>

                        <div style="clear: both;"></div>
                        <span class="label label-important">NOTE!</span>
                        <span>图片尺寸223*71。请用最新版火狐、谷歌或IE10及以上浏览器上传，360浏览器请切换到极速模式</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">后台登录页Logo图片：</label>
            <div class="controls">
                <div>
                    <div class="control-group">
                        <div style="float: left;margin-right: 10px;">
                            <div class="fileupload {if $data.login_logo_hash}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="{asset('img/no+image.gif')}" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="background:{$data.login_color|default:"0f0"}; max-width: 200px; max-height: 150px; line-height: 20px;">
                                    {if $data.login_logo_hash}
                                        <img src="{route('FilePull',['hash'=>$data.login_logo_hash,'width'=>200,'width'=>150])}"/>
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
                                <input type="hidden"  id="login_logo_hash" name="login_logo_hash" value="{$data.login_logo_hash}"/>
                            </div>
                        </div>
                        
                        <div style="clear: both;"></div>
                        <span class="label label-important">NOTE!</span>
                        <span>图片格式必须为 png 透明，建议图片尺寸320*80的图片。请用最新版火狐、谷歌或IE10及以上浏览器上传，360浏览器请切换到极速模式</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">后台登录页右边大图：</label>
            <div class="controls">
                <div>
                    <div class="control-group">
                        <div style="float: left;margin-right: 10px;">
                            <div class="fileupload {if $data.login_big_hash}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="{asset('img/no+image.gif')}" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                    {if $data.login_big_hash}
                                        <img src="{route('FilePull',['hash'=>$data.login_big_hash,'width'=>200,'width'=>150])}"/>
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
                                <input type="hidden"  id="login_big_hash" name="login_big_hash" value="{$data.login_big_hash}"/>
                            </div>
                        </div>
                        
                        <div style="clear: both;"></div>
                        <span class="label label-important">NOTE!</span>
                        <span>图片格式支持jpg、gif、png，建议图片尺寸1920*1080的图片。请用最新版火狐、谷歌或IE10及以上浏览器上传，360浏览器请切换到极速模式</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">登录页颜色值：</label>
            <div class="controls">
            	<label >
                  	<label class="radio">
                        <input type="radio" name="login_color" {if $data.login_color eq "#26C6DA"}checked{/if} value="#26C6DA" />  
                        <IMG alt="" src="{asset('img/skin/ec1.png')}">
				  	</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 	<label class="radio">
                        <input type="radio" name="login_color" {if $data.login_color eq "#72D572"}checked{/if} value="#72D572" />  
                        <IMG alt="" src="{asset('img/skin/ec2.png')}">
				  	</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  	<label class="radio">
                        <input type="radio" name="login_color" {if $data.login_color eq "#5677FC"}checked{/if} value="#5677FC" />  
                        <IMG alt="" src="{asset('img/skin/ec3.png')}">
				  	</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 	<label class="radio">
                        <input type="radio" name="login_color" {if $data.login_color eq "#F06292"}checked{/if} value="#F06292" />  
                        <IMG alt="" src="{asset('img/skin/ec4.png')}">
				  	</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  	<label class="radio">
                        <input type="radio" name="login_color" {if $data.login_color eq "#AB47BC"}checked{/if} value="#AB47BC" />  
                        <IMG alt="" src="{asset('img/skin/ec5.png')}">
				  	</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  	<label class="radio">
                        <input type="radio" name="login_color" {if $data.login_color eq "#FFC107"}checked{/if} value="#FFC107" />  
                        <IMG alt="" src="{asset('img/skin/ec6.png')}">
				  	</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 	<label class="radio">
                        <input type="radio" name="login_color" {if $data.login_color eq "#FF6E40"}checked{/if} value="#FF6E40" />  
                        <IMG alt="" src="{asset('img/skin/ec7.png')}">
				  	</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  	<label class="radio">
                        <input type="radio" name="login_color" {if $data.login_color eq "#B39DDB"}checked{/if} value="#B39DDB" />  
                        <IMG alt="" src="{asset('img/skin/ec8.png')}">
				  	</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 	<label class="radio">
                        <input type="radio" name="login_color" {if $data.login_color eq "#29B6F6"}checked{/if} value="#29B6F6" />  
                        <IMG alt="" src="{asset('img/skin/ec9.png')}">
				  	</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           		</label>
            </div>
        </div>
        <div class="control-group">
        	<div class="controls">
        		<input type="hidden" name="longitude" id="longitude"  value="{$data.longitude}"/>
        		<input type="hidden" name="latitude"  id="latitude"  value="{$data.latitude}"/>
	            <button type="submit" class="btn btn-success">保存</button>
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
                <h4 class="modal-title">提示</h4>
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

<div id="shade" style="width: 100%;background: #eee;height: 1200px;position: absolute;top: 0;left: 0;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5;display: none;"></div>
<div style="z-index: 100;position:absolute;width: 100%;margin: 0 auto;top:260px;left: 0;display: none;" id="loading_img"><span style="font-weight: bolder;color: #000;">图片上传中，请稍后</span><img src="{asset("assets/pre-loader/Fading squares.gif")}"/></div>
{/block}

{block script}
 <script type="text/javascript">
    var action_url = '{route("EnterpriseInfo")}';
    var width = $(document).width();
    $(window).scroll(function() {
        scrollImg();
    });

     function scrollImg() {
         var posX,posY;
         if (window.innerHeight) {
             posX = window.pageXOffset;
             posY = window.pageYOffset;
         }
         else if (document.documentElement && document.documentElement.scrollTop) {
             posX = document.documentElement.scrollLeft;
             posY = document.documentElement.scrollTop;
         }
         else if (document.body) {
             posX = document.body.scrollLeft;
             posY = document.body.scrollTop;
         }

         $("#loading_img").css('padding-left', width/2+'px');

         var ad=document.getElementById("loading_img");
         ad.style.top=(posY+260)+"px";
     }

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
        $("#shade").show();
        $("#loading_img").show();
        scrollImg();
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
                $("#shade").hide();
                $("#loading_img").hide();
            },
            error: function(xhq) {
                dom.removeClass('fileupload-exists').addClass('fileupload-new');
                dom.find('.actions').find('.delete_upload').hide();
                $("#shade").hide();
                $("#loading_img").hide();
                ialert(xhq.responseText);
            }
        });
    }

    $(".delete_upload").click(function() {
        if (confirm('确认要删除吗')) {
            var parent = $(this).closest('.fileupload');
            parent.find('#logo_id').val('');
            parent.removeClass('fileupload-exists').addClass('fileupload-new');
            $(this).hide();
        }
        return false;
    });

    function ialert(msg)
    {
        $('#MessageModal').find('.modal-body p').text(msg).end().one('hidden.bs.modal', function(){
        }).modal();
    }
</script>
{/block}