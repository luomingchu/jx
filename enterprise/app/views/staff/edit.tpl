{extends file='layout/main.tpl'}

{block title}员工管理 {/block}

{block breadcrumb}
<li>系统管理 <span class="divider">&nbsp;</span></li>
<li><a href="{route('StaffList')}">员工列表</a><span class="divider">&nbsp;</span></li>
<li><a href="javascript:;">{if $data.id gt 0}编辑{else}添加{/if}员工</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<!-- BEGIN ADVANCED TABLE widget-->
<div class="row-fluid">
    <div class="span12">
    <!-- BEGIN widget-->
    <div class="widget">
        <div class="widget-title">
        <h4><i class="icon-reorder"> 添加/编辑员工信息</i></h4>
    </div>
    <div class="widget-body form">
    <!-- BEGIN FORM-->
    <form id="form" class="form-horizontal">
        
        
        <div class="control-group">
            <label class="control-label">真实姓名：</label>

            <div class="controls">
                <input type="text" class="span6" id="real_name" name="real_name" value="{Input::old('real_name')|default:$data.real_name}" placeholder=""/>
                <span class="help-inline"></span>
            </div>
        </div>      
        
        <div class="control-group">
            <label class="control-label">工号：</label>

            <div class="controls">
                <input type="text" class="span6" id="staff_no" name="staff_no" value="{Input::old('staff_no')|default:$data.staff_no}" placeholder=""/>
                <span class="help-inline"></span>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">所属门店：</label>
            <div class="controls">
                <select class="span6 chosen"  name="store_id" data-placeholder="选择归属门店" tabindex="1">
                    {foreach $stores as $item}
                    	<option value="{$item.id}"  {if $item.id eq $data.store_id}selected{/if}>{$item.name}</option>
					{/foreach}
                </select>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">性别：</label>

            <div class="controls">
                  <label class="radio">
                        <input type="radio" name="gender" {if $data.gender eq Member::GENDER_MAN || $data.gender eq '' }checked{/if} value="{Member::GENDER_MAN}" />
                                 男
                        </label>
                   <label class="radio">
                        <input type="radio" name="gender" {if $data.gender eq  Member::GENDER_FEMALE }checked{/if} value="{Member::GENDER_FEMALE}" />
                                 女
                   </label>
                   
            </div>
        </div>
         <div class="control-group">
            <label class="control-label">手机号：</label>
            <div class="controls">
                <div class="input-prepend input-append">
                    <input name="mobile" id="mobile"  value="{Input::old('mobile')|default:$data.mobile}" type="text"/> 
                </div>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">在职状态：</label>
             <div class="controls">
                  <label class="radio">
                        <input type="radio" name="status" {if $data.status eq Staff::STATUS_VALID || $data.status eq '' }checked{/if} value="{Staff::STATUS_VALID}" />
                                 在职
                        </label>
                   <label class="radio">
                        <input type="radio" name="status" {if $data.status eq  Staff::STATUS_INVALID }checked{/if} value="{Staff::STATUS_INVALID}" />
                                 离职
                   </label>
                   
            </div>
        </div>
        
        <div class="control-group">
        	<div class="controls">
        		<input type="hidden" name="id" id="id"  value="{$data.id}"/>
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

    var action_url = '{route("StaffList")}';
        

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
                url: "{route('StaffSave')}",
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