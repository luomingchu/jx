{extends file='layout/main.tpl'}

{block title}问卷调查{/block}

{block breadcrumb}
	<li>问卷调查 <span class="divider">&nbsp;</span></li>
    <li><a href="{route('GetQuestionnaireList')}">问卷调查列表</a> <span class="divider">&nbsp;</span></li>
    <li><a href="javascript:;">统计结果</a> <span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <!-- BEGIN ADVANCED TABLE widget-->
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget">
                <div class="widget-body">
	                <div class="span12">
	                	<div class="tabbable tabbable-custom">
                        	<ul class="nav nav-tabs">
                               <li class="active"><a href="#tab_1_1" data-toggle="tab">问卷答案统计</a></li>
                               <li><a href="#tab_1_2" data-toggle="tab">问卷参与人员</a></li>
                            </ul>
                            <div class="tab-content">
	                            <div class="tab-pane active" id="tab_1_1">
	                            	<h4>问卷内容 <br><small>常规内容</small></h4>
	                            	<table class="table table-borderless">
                                    	<tbody>
		                                    <tr>
		                                        <td class="span2">问卷标题 :</td>
		                                        <td>{$info.name}</td>
		                                    </tr>
		                                    <tr>
		                                        <td class="span2">有效日期 :</td>
		                                        <td>{$info.start_time|date_format:"%Y-%m-%d"} 至 {$info.end_time|date_format:"%Y-%m-%d"}</td>
		                                    </tr>
		                                    <tr>
		                                        <td class="span2">问卷描述 :</td>
		                                        <td>{$info.description}</td>
		                                    </tr>
		                                    <tr>
		                                        <td class="span2">问卷状态 :</td>
		                                        <td>{if $info.status eq Questionnaire::STATUS_OPEN}<span class="badge badge-important">进行中</span>
					                                {elseif $info.status eq Questionnaire::STATUS_CLOSE}<span class="badge">已结束</span>
					                                {elseif $info.status eq Questionnaire::STATUS_UNOPENED}<span class="badge badge-success">未开放</span>
					                                {else}未知状态{/if}
					                            </td>
		                                    </tr>
		                                    {if $info.picture_hash}
	                                    	<tr>
		                                        <td class="span2">问卷配图 :</td>
		                                        <td><img src="{route('FilePull',['hash'=>$info.picture_hash,'width'=>200,'width'=>150])}"/></td>
		                                    </tr>
		                                    {/if}
                                    	</tbody>
                                	</table>
                                	<h4>问卷问题 <br><small>问题内容</small></h4>
					                <div style="padding-left: 30px;padding-bottom: 50px;">
					                    {foreach $info.issues as $k=>$question}
					                        <div style="clear: left;margin-top: 10px;">
					                            <div style="color: #000;font-size: 16px;font-weight: bolder;">{$k+1}、{$question.content}</div>
					                            <div style="color: #000;margin: 5px 0;">
					                                {foreach $question.answers as $ak=>$answer}
					                                    <span style="margin-right: 15px;">{chr($ak+65)}、{$answer.content}</span>
					                                {/foreach}
					                            </div>
					                            <div>此项调查结果：</div>
					                            <div>
					                                {foreach $question.answers as $answer}
					                                <div style="clear: left;">
					                                    <div style="color: #000;">{$answer.content}</div>
					                                    <div class="progress progress-success" style="width: 500px;float: left;margin-right: 10px;">
					                                        <div style="width: {$answer.percent|default:'0'}%;" class="bar"></div>
					                                    </div>
					                                    <span>{$answer.choose_count|default:'0'} 人 {$answer.percent|default:'0'}%</span>
					                                </div>
					                                {/foreach}
					                            </div>
					                        </div>
					                    {/foreach}
					                </div>
	                            </div>
	                            <div class="tab-pane" id="tab_1_2">
	                            	<table class="table table-striped table-bordered dataTable">
				                        <thead>
				                        <tr>
				                            <th>用户ID</th>
				                            <th>用户名</th>
				                            <th>参与问卷时间</th>
				                            <th>操作</th>
				                        </thead>
				                        <tbody>
				                        {foreach $members as $member}
				                            <tr class="odd gradeX" data-id="{$item.id}">
				                                <td>{$member.id}</td>
				                                <td>{$member.member.username}</td>
				                                <td>{$member.created_at|date_format:"%Y-%m-%d %H:%M:%S"}</td>
				                                <td><a class="btn btn-default" href="{route('MemberQuestionnaireAnswer', ['id' => $member.id])}"><i class="icon-eye-open"></i> 查看</a></td>
				                            </tr>
				                        {foreachelse}
				                            <tr>
				                                <td colspan="5" style="text-align: center;">暂时没有用户做此问卷调查</td>
				                            </tr>
				                        {/foreach}
				                        </tbody>
				                    </table>
				                    <div class="row-fluid">
				                        <div class="span6">
				                            <div class="dataTables_paginate">{$members->links()}</div>
				                        </div>
				                    </div>	
	                            </div>
                            </div>
                        </div>
	                </div><div style="clear:both"></div>
                 </div>           
            </div>
            <!-- END EXAMPLE TABLE widget-->
        </div>
    </div>
    <!-- END ADVANCED TABLE widget-->
{/block}