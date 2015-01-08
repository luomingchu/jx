{extends file='layout/main.tpl'}

{block title}系统参数{/block}

{block breadcrumb}
    <li>系统管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('ImageUpload')}">上传图片</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<link rel="stylesheet" type="text/css" href="{asset('assets/uploadify/uploadify.css')}" /> 
<link rel="stylesheet" type="text/css" href="{asset('assets/jcrop/jquery.Jcrop.css')}" /> 

<div class="row-fluid">
    <div class="span12">
    <!-- BEGIN widget-->
	    <div class="widget">
	    	<div class="widget-title"><h4><i class="icon-reorder"> 修改头像</i></h4></div>
		    <div class="widget-body form">
		    <!-- BEGIN FORM-->
		    <form id="form" action="{route('ConfigsSave')}" class="form-horizontal" method="post">
		        <div class="control-group">
		            <label class="control-label">选择图片：</label>
		            <div class="controls">
		                <input type="file" name="file" id="pic_upload"/><br/>
		                 <a id='uploadLink' href="javascript:$('#pic_upload').uploadifyUpload();">上传图片 </a><div id="uploadInfo"></div> 
		                <span class="help-inline"></span>
		            </div>
		        </div>
		        <div class="control-group">
                    <label class="control-label">图片预览:</label>
                    <div class="controls img_v" id='oriImage'>
                    
                    </div>
                </div>
		        <div class="control-group">
		        	<div class="controls">
		        		<input type="hidden" name="key" id="key"  value="{$data.key}"/>
			            <button type="submit" class="btn btn-success">保存</button>
			            <button type="button" class="btn" onclick="history.go(-1);">取消</button>
			        </div>
		        </div>
		    </form>
		    <!-- END FORM-->
			</div>
		</div>
	</div>
</div>
{/block}

{block script}

{/block}