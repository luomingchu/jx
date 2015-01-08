{extends file='layout/main.tpl'}

{block title}任务设置{/block}

{block breadcrumb}
    <li>任务管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('TaskList')}">任务列表</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">
            <!-- begin recent orders portlet-->
            <div class="widget">
            	<div class="widget-title">
                    <h4><i class="icon-reorder"></i>任务列表</h4>
                    <span class="tools">
                    <a href="javascript:;" class="icon-chevron-down"></a>
                    <a class="icon-remove" href="javascript:;"></a>
                    </span>
                 </div>
                <div class="widget-body">
                	<table class="table table-striped table-bordered dataTable">
                        <thead>
                        <tr style="background: #ccc;color: #333;">
                            <th>项目</th>
                            <th>奖励周期</th>
                            <th>奖励次数</th>
                            <th>奖励指币数</th>
                            <th>奖励内购额</th>
                            <th>备注</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach $data as $item}
                            <tr class="odd gradeX" data-id="{$item.id}">
                                <td>{$item.source.name}</td>
                                <td>{if $item.cycle eq Task::CYCLE_ONCE}一次性{elseif $item.cycle eq Task::CYCLE_EVERYDAY}每人每天{elseif $item.cycle eq Task::CYCLE_NOCYCLE}不限周期{else}未知{/if}</td>
                                <td>{if empty($item.reward_times)}无限制{else}{$item.reward_times}{/if}</td>
                                <td>{$item.reward_coin}</td>
                                <td>{$item.reward_insource}</td>
                                <td>{$item.remark}</td>
                                <td>
                                    {if $item.status eq Task::STATUS_OPEN}<span class="badge badge-info">开启中</span>{else}<span class="badge badge-important">已关闭</span>{/if}
                                </td>
                                <td>
                                    <a href="{route('EditTask', ['task_key'=>$item.key])}" class="btn btn-primary">编 辑</a>
                                </td>
                            </tr>
                        {foreachelse}
                            <tr>
                                <td colspan="6" style="text-align: center;">您暂时没有相关任务信息</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end recent orders portlet-->
        </div>
    </div>
{/block}