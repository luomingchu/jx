{extends file='layout/main.tpl'}

{block title}问卷调查{/block}

{block breadcrumb}
    <li>问卷调查 <span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetQuestionnaireList')}">问卷调查列表</a> <span class="divider">&nbsp;</span></li>
    <li><a href="javascript:;">{if $info}修改{else}添加{/if}问卷调查</a> <span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
<div class="row-fluid">
	<div class="span12">
		<div class="widget">
			<div class="widget-title">
    			<h4><i class="icon-reorder"> {if $info}修改{else}添加{/if}问卷调查</i></h4>
			</div>
			<div class="widget-body form">
			<!-- BEGIN FORM-->
				<form id="questionnaire_form" class="form-horizontal">
					<div class="control-group">
					    <label class="control-label">标题：</label>
					    <div class="controls">
					        <input type="text" class="span6" id="name" name="name" value="{$info.name}" placeholder="请输入标题"/>
					        <span class="help-inline"></span>
					    </div>
					</div>
					<div class="control-group">
					    <label class="control-label">问卷配图：</label>
					    <div class="controls"><div>
		                    <div class="control-group">
		                        <div style="float: left;margin-right: 10px;">
		                            <div class="fileupload {if $data.picture_hash}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
		                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
		                                    <img src="{asset('img/no+image.gif')}" alt="" />
		                                </div>
		                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
		                                    {if $data.picture_hash}
		                                        <img src="{route('FilePull',['hash'=>$data.picture_hash,'width'=>200,'width'=>150])}"/>
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
		                                <input type="hidden"  id="picture_hash" name="picture_hash" value="{$data.picture_hash}"/>
		                            </div>
		                        </div>
		                        
		                        <div style="clear: both;"></div>
		                        <span class="label label-important">NOTE!</span>
		                        <span>图片格式支持jpg、gif、png，建议图片尺寸430*430的图片。请用最新版火狐、谷歌或IE10及以上浏览器上传，360浏览器请切换到极速模式</span>
		                    </div></div>
		            	</div>
					</div>
					<div class="control-group">
					    <label class="control-label">有效时间：</label>
					    <div class="controls">
					        <input name="start_time" class="datetimepicker" id="start_time" value="{$info.start_time}" type="text" data-date-format="yyyy-mm-dd"/> 至
					        <input name="end_time" class="datetimepicker" id="end_time" value="{$info.end_time}" type="text" data-date-format="yyyy-mm-dd"/>
					    </div>
					</div>
					<div class="control-group">
					    <label class="control-label">问卷描述：</label>
					    <div class="controls">
					        <textarea class="span6 " rows="5" name="description">{$info.description}</textarea>
					    </div>
					</div>
					<div class="control-group">
					    <label class="control-label">问题列表：</label>
					    <div class="controls" >
					        <div id="question_list">
					        	{if $info.id gt 0}
					        		{foreach $info.issues as $k=>$question}
					        			<div class="question_item" style="margin-bottom: 35px;">
							                <span class="item_index">{$k+1}</span>、
							                <input type="text" class="span6 qc" name="questions[{$k}][content]" value="{$question.content}" placeholder="请输入问题">
							                <input type="button" class="btn btn-danger delete_question" value="删除问题"/>
							                <div style="margin-left: 30px;" class="answer_list">
							                	{foreach $question.answers as $ak=>$answer}
							                		<div style="margin-top: 15px;">
								                        <span class="answer_index">{chr($ak+65)}</span>、
								                        <input type="text" class="span5 qa" name="questions[{$k}][answer][]" value="{$answer.content}" placeholder="请输入答案">
								                        <input type="button" class="btn btn-danger delete_answer" value="删除答案"/>
								                        <input type="button" class="btn btn-primary add_answer" value="添加答案" style="display: none;"/>
								                    </div>
				                                {/foreach}
							                </div>
							            </div>
					        		{/foreach}
					        	{else}
					            <div class="question_item" style="margin-bottom: 35px;">
					                <span class="item_index">1</span>、
					                <input type="text" class="span6 qc" name="questions[0][content]" placeholder="请输入问题">
					                <input type="button" class="btn btn-danger delete_question" value="删除问题"/>
					                <div style="margin-left: 30px;" class="answer_list">
					                    <div style="margin-top: 15px;">
					                        <span class="answer_index">A</span>、
					                        <input type="text" class="span5 qa" name="questions[0][answer][]" placeholder="请输入答案">
					                        <input type="button" class="btn btn-danger delete_answer" value="删除答案"/>
					                        <input type="button" class="btn btn-primary add_answer" value="添加答案" style="display: none;"/>
					                    </div>
					                    <div style="margin-top: 15px;">
					                        <span class="answer_index">B</span>、
					                        <input type="text" class="span5 qa" name="questions[0][answer][]" placeholder="请输入答案">
					                        <input type="button" class="btn btn-danger delete_answer" value="删除答案"/>
					                        <input type="button" class="btn btn-primary add_answer" value="添加答案" style="display: none;"/>
					                    </div>
					                    <div style="margin-top: 15px;">
					                        <span class="answer_index">C</span>、
					                        <input type="text" class="span5 qa" name="questions[0][answer][]" placeholder="请输入答案">
					                        <input type="button" class="btn btn-danger delete_answer" value="删除答案"/>
					                        <input type="button" class="btn btn-primary add_answer" value="添加答案" style="display: none;"/>
					                    </div>
					                    <div style="margin-top: 15px;">
					                        <span class="answer_index">D</span>、
					                        <input type="text" class="span5 qa" name="questions[0][answer][]" placeholder="请输入答案">
					                        <input type="button" class="btn btn-danger delete_answer" value="删除答案"/>
					                        <input type="button" class="btn btn-primary add_answer" value="添加答案"/>
					                    </div>
					                </div>
					            </div>
					            {/if}
					        </div>
					        <input type="button" id="addNewQuestion" value="添加问题" class="btn btn-primary" style="margin-top: 50px;"/>
					    </div>
					</div>
					{if $info.status eq Questionnaire::STATUS_UNOPENED || !$info}
					<div class="control-group">
			            <label class="control-label">状态：</label>
			            <div class="controls">
			            	<label >
			                  	<label class="radio">
			                        <input type="radio" name="status" {if $info.status eq Questionnaire::STATUS_OPEN}checked{/if} value="{Questionnaire::STATUS_OPEN}" />  开放
							  	</label>
							 	<label class="radio">
			                        <input type="radio" name="status" {if $info.status eq Questionnaire::STATUS_UNOPENED}checked{/if} value="{Questionnaire::STATUS_UNOPENED}" />  不开放
							  	</label>
			           		</label>
                            <span>请确认您的问卷是否已完善，如果状态为开放时，发布后该问卷将不可编辑</span>
			            </div>
			        </div>
			        {/if}
					<div class="form-actions">
					    <input type="hidden" name="questionnaire_id" value="{$info.id}"/>
					    <button type="button" class="btn btn-success" id="submit_form">发布问卷调查</button>
					    <button type="button" class="btn" onclick="history.go(-1);">取消</button>
					</div>
				</form>

			    <div style="margin-top: 15px;display: none;" id="atmp">
			        <span class="answer_index"></span>、
			        <input type="text" class="span5 qa" name="questions[][answer][]" placeholder="请输入答案">
			        <input type="button" class="btn btn-danger delete_answer" value="删除答案"/>
			        <input type="button" class="btn btn-primary add_answer" value="添加答案"/>
			    </div>
			    <div id="tmp" class="question_item" style="margin-bottom: 35px;display: none;">
			        <span class="item_index">1</span>、
			        <input type="text" class="span6 qc" name="questions[][content]" placeholder="请输入问题">
			        <input type="button" class="btn btn-danger delete_question" value="删除问题"/>
			        <div style="margin-left: 30px;" class="answer_list">
			            <div style="margin-top: 15px;">
			                <span class="answer_index">A</span>、
			                <input type="text" class="span5 qa" name="questions[][answer][]" placeholder="请输入答案">
			                <input type="button" class="btn btn-danger delete_answer" value="删除答案"/>
			                <input type="button" class="btn btn-primary add_answer" value="添加答案" style="display: none;"/>
			            </div>
			            <div style="margin-top: 15px;">
			                <span class="answer_index">B</span>、
			                <input type="text" class="span5 qa" name="questions[][answer][]" placeholder="请输入答案">
			                <input type="button" class="btn btn-danger delete_answer" value="删除答案"/>
			                <input type="button" class="btn btn-primary add_answer" value="添加答案" style="display: none;"/>
			            </div>
			            <div style="margin-top: 15px;">
			                <span class="answer_index">C</span>、
			                <input type="text" class="span5 qa" name="questions[][answer][]" placeholder="请输入答案">
			                <input type="button" class="btn btn-danger delete_answer" value="删除答案"/>
			                <input type="button" class="btn btn-primary add_answer" value="添加答案" style="display: none;"/>
			            </div>
			            <div style="margin-top: 15px;">
			                <span class="answer_index">D</span>、
			                <input type="text" class="span5 qa" name="questions[][answer][]" placeholder="请输入答案">
			                <input type="button" class="btn btn-danger delete_answer" value="删除答案"/>
			                <input type="button" class="btn btn-primary add_answer" value="添加答案"/>
			            </div>
			        </div>
			    </div>
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
</div>
{/block}

{block script}
<link rel="stylesheet" type="text/css" href="{asset('assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}"/>
<script type="text/javascript" src="{asset('assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}"></script>
<script type="text/javascript"  src="{asset('assets/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js')}"></script>
<script type="text/javascript">

    $(document).on('click', '.delete_question', function() {
        if (confirm('确认要删除此问题吗？')) {
            var obj = $(this).closest('.question_list');
            $(this).parent().remove();
            resetQuestionIndex();
        }
    });

    $("#addNewQuestion").click(function() {
        $("#tmp .qa,#tmp .qc").val('');
        var question = $("#tmp").clone().show().removeAttr('id', 'tmp');
        $("#question_list").append(question);
        resetQuestionIndex();
    });

    function resetQuestionIndex() {
        $("#question_list .item_index").each(function (i, e) {
            $(e).text(i+1);
        });
        resetInputName();
    }


    $(document).on('click', '.delete_answer', function()
    {
        var del = false;
        if ($(this).prev(':input').val() != '') {
            if (confirm('确定要删除吗？')) {
                del = true;
            }
        } else {
            del = true;
        }
        if (del) {
            var obj = $(this).closest('.answer_list');
            $(this).parent().remove();
            resetAnswerIndex(obj);
        }
    });

    $(document).on('click', '.add_answer', function() {
        var answer = $("#atmp").clone().show().removeAttr('id', 'atmp');
        var answer_list = $(this).closest('.answer_list');
        answer_list.append(answer);
        resetAnswerIndex(answer_list);
    });

    function resetAnswerIndex(obj) {
        var index = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        var div = obj.find('div');
        var size = div.size();
        if (size > 0) {
            div.each(function(i, e) {
                $(e).find('.answer_index').text(index[i]);
                if (i == size - 1) {
                    $(e).find('.add_answer').show();
                } else {
                    $(e).find('.add_answer').hide();
                }
            });
        } else {
            obj.parent().remove();
        }
        resetInputName();
    }

    function resetInputName()
    {
        $("#question_list .qc").each(function(i, e) {
            $(this).attr('name', 'questions['+i+'][content]').attr('data-index', i);
        });
        $("#question_list .qa").each(function(i, e) {
            i = $(e).closest('.answer_list').closest('.question_item').find('.qc').attr('data-index');
            $(this).attr('name', 'questions['+i+'][answer][]');
        });
    }

	//提交表单，保存问卷
    $("#submit_form").click(function() {
        if (confirm("提交发布后不能再进行修改，您确认现在进行提交？")) {
            var data = $("#questionnaire_form").serialize();
            $.ajax({
                type: "POST",
                url: "{route('SaveQuestionnaire')}",
                dataType: 'json',
                data: data,
                success: function(data) {
                    window.location.href = "{route('GetQuestionnaireList')}";
                },
                error : function(xhq) {
                    ialert(xhq.responseText);
                }
            });
        }
    });

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

	//删除图片，即隐藏图片
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

    //日期插件设置
    $('.datetimepicker').datetimepicker({
        language:  'zh-CN',
        startView: 2,
        minView: 2,
        maxView: 3,
        forceParse: 1,
        autoclose: 1
    });
</script>
{/block}