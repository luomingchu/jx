{extends file='layout/main.tpl'}

{block title}问卷调查{/block}

{block breadcrumb}
	<li>问卷调查 <span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetQuestionnaireList')}">问卷调查列表</a> <span class="divider">&nbsp;</span></li>
    <li><a href="{route('ViewQuestionnaireInfo',['questionnaire_id'=>$info.questionnaire.id])}">统计结果</a> <span class="divider">&nbsp;</span></li>
    <li><a href="javascript:void(0);">查看结果</a> <span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget">
                <div class="widget-body">
                           	<h4>问卷内容 <br><small>常规内容</small></h4>
                           	<table class="table table-borderless">
                                  	<tbody>
                                    <tr>
                                        <td class="span2">问卷标题 :</td>
                                        <td>{$info.questionnaire.name}</td>
                                    </tr>
                                    <tr>
                                        <td class="span2">有效日期 :</td>
                                        <td>{$info.questionnaire.start_time|date_format:"%Y-%m-%d"} 至 {$info.questionnaire.end_time|date_format:"%Y-%m-%d"}</td>
                                    </tr>
                                    <tr>
                                        <td class="span2">问卷描述 :</td>
                                        <td>{$info.questionnaire.description}</td>
                                    </tr>
                                    <tr>
                                        <td class="span2">问卷状态 :</td>
                                        <td>{if $info.questionnaire.status eq Questionnaire::STATUS_OPEN}<span class="badge badge-important">进行中</span>
			                                {elseif $info.questionnaire.status eq Questionnaire::STATUS_CLOSE}<span class="badge">已结束</span>
			                                {elseif $info.questionnaire.status eq Questionnaire::STATUS_UNOPENED}<span class="badge badge-success">未开放</span>
			                                {else}未知状态{/if}
			                            </td>
                                    </tr>
                                    {if $info.questionnaire.picture_hash}
                                   	<tr>
                                        <td class="span2">问卷配图 :</td>
                                        <td><img src="{route('FilePull',['hash'=>$info.questionnaire.picture_hash,'width'=>200,'width'=>150])}"/></td>
                                    </tr>
                                    {/if}
                                  	</tbody>
                              	</table>
                              	<h4>问卷问题 <br><small>问题内容</small></h4>
			                <div style="padding-left: 30px;padding-bottom: 50px;">
			                	{if $info.advice}
			                	<div style="clear: left;margin-top: 10px;">
			                		<div style="color: #000;font-size: 16px;font-weight: bolder;">TA的建议：</div>
			                		<div style="color: #000;margin: 5px 0;">{$info.advice}</div>
			                	</div><br>
			                	{/if}
			                    {foreach $info.questionnaire.issues as $k=>$question}
			                        <div style="clear: left;margin-top: 10px;">
			                            <div style="color: #000;font-size: 16px;font-weight: bolder;">{$k+1}、{$question.content}</div>
			                            <div style="color: #000;margin: 5px 0;">
			                                {foreach $question.answers as $ak=>$answer}
			                                    <span style="margin-right: 15px;">{chr($ak+65)}、{$answer.content}</span>
			                                    {if $answer.id eq $res[$k]}
			                                    	{assign daan chr($ak+65)}
			                                    {/if}
			                                {/foreach}
			                            </div>
			                            <div>结果：{$daan}</div>
			                        </div>
			                    {/foreach}
			                </div>
                 </div>           
            </div>
            <!-- END EXAMPLE TABLE widget-->
        </div>
    </div>
    <!-- END ADVANCED TABLE widget-->
{/block}