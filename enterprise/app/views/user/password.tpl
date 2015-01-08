{extends file='layout/main.tpl'}

{block title}修改密码{/block}

{block breadcrumb}
<li>系统管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('GetModifyPassword')}">修改密码</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<!-- begin recent orders portlet-->
		<div class="widget">
			<div class="widget-title">
				<h4>
					<i class="icon-reorder"></i> 修改密码
				</h4>
			</div>
			<div class="widget-body form">
				<form id="pw_form" class="form-horizontal">
					<div class="control-group">
			            <label class="control-label">旧密码：</label>
			            <div class="controls">
			                <input type="password" class="span5" name="password" value="" placeholder="填写旧密码"/>
			                <span class="help-inline"></span>
			            </div>
			        </div>
			        <div class="control-group">
			            <label class="control-label">新密码：</label>
			            <div class="controls">
			                <input type="password" class="span5" name="new_password" value="" placeholder="填写新密码"/>
			                <span class="help-inline">密码为6~16位任意字符</span>
			            </div>
			        </div>
			        <div class="control-group">
			            <label class="control-label">确认新密码：</label>
			            <div class="controls">
			                <input type="password" class="span5" name="new_password_confirmation" value="" placeholder="确认新密码"/>
			                <span class="help-inline"></span>
			            </div>
			        </div>
			        <div class="control-group">
			        	<div class="controls">
				            <button type="button" class="btn btn-success" id="submit_form">保存</button>
				            <button type="button" class="btn" onclick="history.go(-1);">取消</button>
				        </div>
			        </div>
				</form>
				<!-- end form-->
			</div>
		</div>
		<!-- end recent orders portlet-->
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
function ialert(msg)
{
    $('#MessageModal').find('.modal-body p').text(msg).end().one('hidden.bs.modal', function(){
    }).modal();
}
var action_url = '{route("Login")}';
$("#submit_form").click(function() {
    var action = $(this).attr('data-action');
    if (action == 1) {
        return false;
    }
    $(this).attr('data-action', 1);
    var data = $("#pw_form").serialize();
    var obj = $(this);
    $.ajax({
        type: "POST",
        url: "{route('PostModifyPassword')}",
        dataType: 'json',
        data: data,
        success: function(data) {
        	ialert("修改成功，建议您重新登录");
            window.location.href = action_url;
        },
        error : function(xhq) {
            obj.attr('data-action', 0);
            ialert(xhq.responseText);
        }
    });
});
</script>
{/block}


