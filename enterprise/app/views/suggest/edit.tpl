{extends file='layout/main.tpl'}

{block title}反馈管理{/block}

{block breadcrumb}
    <li>反馈管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('SuggestList')}">反馈列表</a><span class="divider">&nbsp;</span></li>
    <li>添加备注<span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid">
    <div class="span12">
        <!-- begin recent orders portlet-->
        <div class="widget">
            <div class="widget-title">
                <h4>
                    <i class="icon-reorder"></i> 添加备注
                </h4>
            </div>
            <div class="widget-body form">
                <form method="post" action="{route('SuggestSave')}" id="goods_form" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">建议者:</label>
                        <div class="controls">
                        	<input type="text" placeholder="" class="span6" name="username" value="{{$data.member.username}}" disabled />
                            <span class="help-inline" id="tingxing_number" style="color:#FF0000"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">建议内容:</label>
                        <div class="controls">
                            <textarea class="input-xxlarge" name="content" rows="4" disabled>{$data.content}</textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">备注:</label>
                        <div class="controls">
                            <textarea class="input-xxlarge" name="remark" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" value="{$data.id}" name="id"/>
                        <button type="submit" class="btn blue"><i class="icon-ok"></i> 保存</button>
                        <a href="javascript:window.history.go(-1);"><button type="button" class="btn"><i class=" icon-remove"></i> 取消</button></a>
                    </div>
                </form>
            </div>
        </div>
        <!-- end recent orders portlet-->
    </div>
    </div>
{/block}