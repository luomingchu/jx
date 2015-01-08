{extends file='layout/main.tpl'}

{block title}反馈列表{/block}

{block breadcrumb}
    <li>反馈管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('SuggestList')}">反馈列表</a><span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid">
        <div class="span12">
            <!-- begin recent orders portlet-->
            <div class="widget">
                <div class="widget-body">
                    <div class="row-fluid">
                        <div class="span12 booking-search" style="padding-bottom:5px;">
                            <FORM action="{Route('SuggestList')}" method="get" id="suggest_form">
                                <div class="pull-left margin-right-20">
                                    <div class="controls">
                                        <input placeholder="关键字" class="input-large" name="name" value="{$smarty.get.name}" type="text">&nbsp;&nbsp;
                                    </div>
                                </div>
                                <div class="pull-left margin-right-20">
                                    <label><a href="javascript:void(0)" onclick="select()" class="btn btn-primary"><i class="icon-search icon-white"></i> 查询</a></label>
                                </div>
                            </FORM>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered dataTable" id="goods_item_list">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>提建议者</th>
                            <th>建议内容</th>
                            <th>建议日期</th>
                            <th>备注</th>
                            <th>备注日期</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyres">
                        {foreach $data as $item}
                            <tr class="odd gradeX">
                                <td>{$item.id}</td>
                                <td>{$item.member.username}</td>
                                <td>{$item.content|truncate:120}</td>
                                <td>{$item.created_at|date_format:"%Y-%m-%d"}</td>
                                <td>{$item.remark|truncate:120}</td>
                                <td>{$item.remark_time|date_format:"%Y-%m-%d"}</td>
                                <td>
                                    <a class="btn btn-default" href="{route('SuggestEdit', $item.id)}"><i class="icon-edit"></i>编辑</a>
                                </td>
                            </tr>
                            {foreachelse}
                            <tr>
                                <td colspan="7" style="text-align: center;">没有相关建议信息 ！</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                    {if $data}
                        <div class="row-fluid">
                        	<div class="span6">
								<div class="dataTables_info">显示 {$data->getFrom()} 到 {$data->getTo()} 项，共 {$data->getTotal()} 项。</div>
							</div>
                            <div class="span6">
                                <div class="dataTables_paginate">{$data->appends(['name' => $smarty.get.name])->links()}</div>
                            </div>
                        </div>
                    {/if}
                </div>
            </div>
            <!-- end recent orders portlet-->
        </div>
    </div>
{/block}

{block script}
<script>
    //提交查询
    function select(){
        $("#suggest_form").submit();
    }
</script>
{/block}
