{extends file='layout/main.tpl'}

{block title}广告位管理{/block}

{block breadcrumb}
    <li>活动管理<span class="divider">&nbsp;</span></li>
    <li>广告管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetAdvertiseSpaceList')}">广告位列表</a><span class="divider">&nbsp;</span></li>
    <li>{if $data.id gt 0}修改{else}添加{/if}广告位<span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">
            <!-- begin recent orders portlet-->
            <div class="widget">
                <div class="widget-title">
                    <h4>
                        <i class="icon-reorder"></i> {if $data.id gt 0}修改{else}添加{/if}广告位
                    </h4>
                </div>
                <div class="widget-body form">
                    <form class="form-horizontal" role="form" id="AdvertiseSpaceForm" method="POST" action="{route('SaveAdvertiseSpace')}">
                        <input type="hidden" name="id" value="{$data.id}">
                        <div class="control-group">
                            <label class="control-label">名称：</label>
                            <div class="controls">
                                <input type="text" class="form-control" placeholder="广告位名称" name="name" value="{$data.name}">
                                <span class="help-inline" id="tingxing_number" style="color:#999"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">标识符：</label>
                            <div class="controls">
                                <input type="text" class="form-control" placeholder="广告位标识符" name="key_code" readonly="true" value="{$data.key_code}">
                                <span class="help-inline" style="color:#999">字母、数字和下划线组合，用来标识一个广告位</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">宽度：</label>
                            <div class="controls">
                                <input type="text" class="form-control" placeholder="宽度" name="width" value="{$data.width}">
                                <span class="help-inline" style="color:#999">为数字字符</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">高度：</label>
                            <div class="controls">
                                <input type="text" class="form-control" placeholder="高度" name="height" value="{$data.height}">
                                <span class="help-inline" style="color:#999">为数字字符</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">容量：</label>
                            <div class="controls">
                                <input type="text" class="form-control" placeholder="可显示的广告数量" name="limit" value="{$data.limit|default:0}">
                                <span class="help-inline" style="color:#999">为数字字符，0为不限制</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">备注：</label>
                            <div class="controls">
                                <input type="text" class="form-control" placeholder="不会在前台显示的备注信息" name="remark" value="{$data.remark}">
                                <span class="help-inline" style="color:#999"></span>
                            </div>
                        </div>
                        <div class="form-actions">
                            <a href="javascript:window.history.go(-1);"><button type="button" class="btn"><i class=" icon-remove"></i> 取消</button></a>
                            <button type="button" id="submitForm" class="btn btn-primary"><i class="icon-ok"></i> 保存</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end recent orders portlet-->
        </div>
    </div>
{/block}

{block script}
<script type="text/javascript">
    $("#submitForm").click(function() {
        var action = $(this).attr('data-action');
        if (action == 1) {
            return false;
        }
        $(this).attr('data-action', 1);
        var obj = $(this);
        $.ajax({
            type: 'POST',
            url: "{route('SaveAdvertiseSpace')}",
            data: $("#AdvertiseSpaceForm").serialize(),
            success: function(data) {
                window.location.href = "{URL::previous()}";
            },
            error: function(xhq) {
                ialert(xhq.responseText);
                obj.attr('data-action', 0);
            }
        });
    });
</script>
{/block}