{extends file='layout/main.tpl'}

{block title}系统参数 {/block}

{block breadcrumb}
    <li>系统管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('ConfigsList')}">系统参数</a><span class="divider">&nbsp;</span></li>
    <li>修改设置<span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<!-- BEGIN ADVANCED TABLE widget-->
<div class="row-fluid">
    <div class="span12">
    <!-- BEGIN widget-->
    <div class="widget">
        <div class="widget-title">
        <h4><i class="icon-reorder"> 修改设置</i></h4>
    </div>
    <div class="widget-body form">
    <!-- BEGIN FORM-->
    <form id="form" action="{route('ConfigsSave')}" class="form-horizontal" method="post">
        <div class="control-group">
            <label class="control-label">参数名：</label>
            <div class="controls">
                <input type="text" class="span6" name="name" value="{$data.name}" readonly/>
                <input type="hidden" class="span6" name="key" value="{$data.key}"/>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">键值：</label>
            <div class="controls">
                <input type="text" class="span6" name="keyvalue" value="{Input::old('keyvalue')|default:$data.keyvalue}" placeholder=""/>
                <span class="help-inline"></span>
            </div>
        </div>      
        <div class="control-group">
            <label class="control-label">备注：</label>
            <div class="controls">
                <input type="text" class="span6" id="remark" name="remark" value="{Input::old('remark')|default:$data.remark}" placeholder=""/>
                <span class="help-inline"></span>
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