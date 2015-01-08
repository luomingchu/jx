{extends file='layout/main.tpl'}

{block title}任务设置{/block}

{block breadcrumb}
    <li>任务管理<span class="divider">&nbsp;</span></li>
    <li><a href="{route('TaskList')}">任务列表</a><span class="divider">&nbsp;</span></li>
    <li>修改任务列表<span class="divider-last">&nbsp;</span></li>
{/block}

{block main}
    <div class="row-fluid">
    <div class="span12">
    <!-- begin recent orders portlet-->
    <div class="widget">
        <div class="widget-title">
            <h4><i class="icon-reorder"></i>{$data.source.name}任务奖励设置</h4>
            <span class="tools">
            </span>
        </div>
        <div class="widget-body">
            <div class="row-fulid">
                <div class="span12">
                <!--BEGIN TABS-->
                    <div class="tabbable tabbable-custom">
                        <div class="tab-content">
                        {if $data.key == 'perfect_own_data'}
                            <div class="tab-pane active" id="tab_1_1">
                                <p>完善个人资料[头像、性别、年龄、真实姓名]</p><br />
                                <p>
                                <form method="post" action="{route('TaskSave')}" class="form-horizontal">
                                    <div class="control-group cycle_div">
                                        <label class="control-label"> 奖励周期:</label>
                                        <div class="controls">
                                            <label>
                                                <label class="radio">
                                                    <input type="radio" name="cycle_perfect_own_data" class="once" {if $data.cycle eq Task::CYCLE_ONCE}checked{/if} value="{Task::CYCLE_ONCE}" />
                                                    一次性
                                                </label>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="control-group times_div" {if $data.cycle eq Task::CYCLE_ONCE}style="display:none"{/if}>
                                        <label class="control-label"> 奖励次数:</label>
                                        <div class="controls">
                                            <input type="text" placeholder="请输入奖励次数" class="input-large" name="reward_times" value="{$data.reward_times}" required />
                                            <span class="help-inline">如果周期为一次性，则此栏则会默认为1，无需设置，如果为不限周期，则默认为为0，表示不做限制</span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label"> 奖励指币数:</label>
                                        <div class="controls">
                                            <input type="text" placeholder="请输入奖励指币数" class="input-large" name="reward_coin" value="{$data.reward_coin}" required />
                                            <span class="help-inline"></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label"> 奖励内购额:</label>
                                        <div class="controls">
                                            <input type="text" placeholder="请输入奖励内购额" class="input-large" name="reward_insource" value="{$data.reward_insource}" required />
                                            <span class="help-inline"></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label"> 任务备注:</label>
                                        <div class="controls">
                                            <textarea class="input-xxlarge" name="remark" rows="3">{$data.remark}</textarea>
                                            <span class="help-inline"></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label"> 是否启用:</label>
                                        <div class="controls">
                                            <label class="checkbox"><input value="{Task::STATUS_OPEN}" name="status" type="checkbox" {if $data.status eq Task::STATUS_OPEN}checked{/if}> 启用</label>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <input type="hidden" value="perfect_own_data" name="key" />
                                        <button type="submit" class="btn blue"><i class="icon-ok"></i> 保存</button>
                                        <a href="{route('TaskList')}"><button type="button" class="btn"><i class=" icon-remove"></i> 取消</button></a>
                                    </div>
                                </form>
                            </p>
                        </div>
                        {elseif $data.key == 'attention_vstore'}
                            <div  id="tab_1_2">
        <p>关注指店</p><br />
        <p>
        <form method="post" action="{route('TaskSave')}" class="form-horizontal">
            <div class="control-group cycle_div">
                <label class="control-label"> 奖励周期:</label>
                <div class="controls">
                    <label>
                        <label class="radio">
                            <input type="radio" name="cycle_attention_vstore" class="once" {if $data.cycle eq Task::CYCLE_ONCE}checked{/if} value="{Task::CYCLE_ONCE}" />
                            一次性
                        </label>
                    </label>
                </div>
            </div>
            <div class="control-group times_div" {if $data.cycle eq Task::CYCLE_ONCE}style="display:none"{/if}>
                <label class="control-label"> 奖励次数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励次数" class="input-large" name="reward_times" value="{$data.reward_times}" required />
                    <span class="help-inline">如果周期为一次性，则此栏则会默认为1，无需设置，如果为不限周期，则默认为为0，表示不做限制</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励指币数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励指币数" class="input-large" name="reward_coin" value="{$data.reward_coin}" required />
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励内购额:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励内购额" class="input-large" name="reward_insource" value="{$data.reward_insource}" required />
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 任务备注:</label>
                <div class="controls">
                    <textarea class="input-xxlarge" name="remark" rows="3">{$data.remark}</textarea>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 是否启用:</label>
                <div class="controls">
                    <label class="checkbox"><input value="{Task::STATUS_OPEN}" name="status" type="checkbox" {if $data.status eq Task::STATUS_OPEN}checked{/if}> 启用</label>
                </div>
            </div>
            <div class="form-actions">
                <input type="hidden" value="attention_vstore" name="key" />
                <button type="submit" class="btn blue"><i class="icon-ok"></i> 保存</button>
                <a href="{route('TaskList')}"><button type="button" class="btn"><i class=" icon-remove"></i> 取消</button></a>
            </div>
        </form>
        </p>
    </div>
                        {elseif $data.key == 'everyday_sign'}
                            <div  id="tab_1_3">
        <p>每日签到</p><br />
        <p>
        <form method="post" action="{route('TaskSave')}" class="form-horizontal">
            <div class="control-group cycle_div">
                <label class="control-label"> 奖励周期:</label>
                <div class="controls">
                    <label>
                        <!-- <label class="radio">
									                        <input type="radio" name="cycle_everyday_sign" class="once" {if $data.cycle eq Task::CYCLE_ONCE}checked{/if} value="{Task::CYCLE_ONCE}" />
									                       		 一次性
													  	</label> -->
                        <label class="radio">
                            <input type="radio" name="cycle_everyday_sign" {if $data.cycle eq Task::CYCLE_EVERYDAY}checked{/if} value="{Task::CYCLE_EVERYDAY}" />
                            每人每天
                        </label>
                        <!-- <label class="radio">
									                        <input type="radio" name="cycle_everyday_sign" {if $data.cycle eq Task::CYCLE_NOCYCLE}checked{/if} value="{Task::CYCLE_NOCYCLE}" />
									                        	不限周期
													  	</label> -->
                    </label>
                </div>
            </div>
            <div class="control-group times_div" {if $data.cycle eq Task::CYCLE_ONCE}style="display:none"{/if}>
                <label class="control-label"> 奖励次数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励次数" class="input-large" name="reward_times" value="{$data.reward_times}" required />
                    <span class="help-inline">如果周期为一次性，则此栏则会默认为1，无需设置，如果为不限周期，则默认为为0，表示不做限制</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励指币数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励指币数" class="input-large" name="reward_coin" value="{$data.reward_coin}" required />
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励内购额:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励内购额" class="input-large" name="reward_insource" value="{$data.reward_insource}" required />
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 任务备注:</label>
                <div class="controls">
                    <textarea class="input-xxlarge" name="remark" rows="3">{$data.remark}</textarea>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 是否启用:</label>
                <div class="controls">
                    <label class="checkbox"><input value="{Task::STATUS_OPEN}" name="status" type="checkbox" {if $data.status eq Task::STATUS_OPEN}checked{/if}> 启用</label>
                </div>
            </div>
            <div class="form-actions">
                <input type="hidden" value="everyday_sign" name="key" />
                <button type="submit" class="btn blue"><i class="icon-ok"></i> 保存</button>
                <a href="{route('TaskList')}"><button type="button" class="btn"><i class=" icon-remove"></i> 取消</button></a>
            </div>
        </form>
        </p>
    </div>
                        {elseif $data.key == 'share'}
                            <div  id="tab_1_4">
        <p>分享</p><br />
        <p>
        <form method="post" action="{route('TaskSave')}" class="form-horizontal">
            <div class="control-group cycle_div">
                <label class="control-label"> 奖励周期:</label>
                <div class="controls">
                    <label>
                        <label class="radio">
                            <input type="radio" name="cycle_share" class="once" {if $data.cycle eq Task::CYCLE_ONCE}checked{/if} value="{Task::CYCLE_ONCE}" />
                            一次性
                        </label>
                        <label class="radio">
                            <input type="radio" name="cycle_share" {if $data.cycle eq Task::CYCLE_EVERYDAY}checked{/if} value="{Task::CYCLE_EVERYDAY}" />
                            每人每天
                        </label>
                        <label class="radio">
                            <input type="radio" name="cycle_share" {if $data.cycle eq Task::CYCLE_NOCYCLE}checked{/if} value="{Task::CYCLE_NOCYCLE}" />
                            不限周期
                        </label>
                    </label>
                </div>
            </div>
            <div class="control-group times_div" {if $data.cycle eq Task::CYCLE_ONCE}style="display:none"{/if}>
                <label class="control-label"> 奖励次数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励次数" class="input-large" name="reward_times" value="{$data.reward_times}" required />
                    <span class="help-inline">如果周期为一次性，则此栏则会默认为1，无需设置，如果为不限周期，则默认为为0，表示不做限制</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励指币数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励指币数" class="input-large" name="reward_coin" value="{$data.reward_coin}" required />
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励内购额:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励内购额" class="input-large" name="reward_insource" value="{$data.reward_insource}" required />
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 任务备注:</label>
                <div class="controls">
                    <textarea class="input-xxlarge" name="remark" rows="3">{$data.remark}</textarea>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 是否启用:</label>
                <div class="controls">
                    <label class="checkbox"><input value="{Task::STATUS_OPEN}" name="status" type="checkbox" {if $data.status eq Task::STATUS_OPEN}checked{/if}> 启用</label>
                </div>
            </div>
            <div class="form-actions">
                <input type="hidden" value="share" name="key" />
                <button type="submit" class="btn blue"><i class="icon-ok"></i> 保存</button>
                <a href="{route('TaskList')}"><button type="button" class="btn"><i class=" icon-remove"></i> 取消</button></a>
            </div>
        </form>
        </p>
    </div>
                        {elseif $data.key == 'release_question'}
                            <div  id="tab_1_5">
        <p>发布指帮问题</p><br />
        <p>
        <form method="post" action="{route('TaskSave')}" class="form-horizontal">
            <div class="control-group cycle_div">
                <label class="control-label"> 奖励周期:</label>
                <div class="controls">
                    <label>
                        <label class="radio">
                            <input type="radio" name="cycle_release_question" class="once" {if $data.cycle eq Task::CYCLE_ONCE}checked{/if} value="{Task::CYCLE_ONCE}" />
                            一次性
                        </label>
                        <label class="radio">
                            <input type="radio" name="cycle_release_question" {if $data.cycle eq Task::CYCLE_EVERYDAY}checked{/if} value="{Task::CYCLE_EVERYDAY}" />
                            每人每天
                        </label>
                        <label class="radio">
                            <input type="radio" name="cycle_release_question" {if $data.cycle eq Task::CYCLE_NOCYCLE}checked{/if} value="{Task::CYCLE_NOCYCLE}" />
                            不限周期
                        </label>
                    </label>
                </div>
            </div>
            <div class="control-group times_div" {if $data.cycle eq Task::CYCLE_ONCE}style="display:none"{/if}>
                <label class="control-label"> 奖励次数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励次数" class="input-large" name="reward_times" value="{$data.reward_times}" required />
                    <span class="help-inline">如果周期为一次性，则此栏则会默认为1，无需设置，如果为不限周期，则默认为为0，表示不做限制</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励指币数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励指币数" class="input-large" name="reward_coin" value="{$data.reward_coin}" required />
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励内购额:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励内购额" class="input-large" name="reward_insource" value="{$data.reward_insource}" required />
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 任务备注:</label>
                <div class="controls">
                    <textarea class="input-xxlarge" name="remark" rows="3">{$data.remark}</textarea>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 是否启用:</label>
                <div class="controls">
                    <label class="checkbox"><input value="{Task::STATUS_OPEN}" name="status" type="checkbox" {if $data.status eq Task::STATUS_OPEN}checked{/if}> 启用</label>
                </div>
            </div>
            <div class="form-actions">
                <input type="hidden" value="release_question" name="key" />
                <button type="submit" class="btn blue"><i class="icon-ok"></i> 保存</button>
                <a href="{route('TaskList')}"><button type="button" class="btn"><i class=" icon-remove"></i> 取消</button></a>
            </div>
        </form>
        </p>
    </div>
                        {elseif $data.key == 'answer_question'}
                            <div  id="tab_1_6">
        <p>参与指帮回答</p><br />
        <p>
        <form method="post" action="{route('TaskSave')}" class="form-horizontal">
            <div class="control-group cycle_div">
                <label class="control-label"> 奖励周期:</label>
                <div class="controls">
                    <label>
                        <label class="radio">
                            <input type="radio" name="cycle_answer_question" class="once" {if $data.cycle eq Task::CYCLE_ONCE}checked{/if} value="{Task::CYCLE_ONCE}" />
                            一次性
                        </label>
                        <label class="radio">
                            <input type="radio" name="cycle_answer_question" {if $data.cycle eq Task::CYCLE_EVERYDAY}checked{/if} value="{Task::CYCLE_EVERYDAY}" />
                            每人每天
                        </label>
                        <label class="radio">
                            <input type="radio" name="cycle_answer_question" {if $data.cycle eq Task::CYCLE_NOCYCLE}checked{/if} value="{Task::CYCLE_NOCYCLE}" />
                            不限周期
                        </label>
                    </label>
                </div>
            </div>
            <div class="control-group times_div" {if $data.cycle eq Task::CYCLE_ONCE}style="display:none"{/if}>
                <label class="control-label"> 奖励次数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励次数" class="input-large" name="reward_times" value="{$data.reward_times}" required />
                    <span class="help-inline">如果周期为一次性，则此栏则会默认为1，无需设置，如果为不限周期，则默认为为0，表示不做限制</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励指币数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励指币数" class="input-large" name="reward_coin" value="{$data.reward_coin}" required />
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励内购额:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励内购额" class="input-large" name="reward_insource" value="{$data.reward_insource}" required />
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 任务备注:</label>
                <div class="controls">
                    <textarea class="input-xxlarge" name="remark" rows="3">{$data.remark}</textarea>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 是否启用:</label>
                <div class="controls">
                    <label class="checkbox"><input value="{Task::STATUS_OPEN}" name="status" type="checkbox" {if $data.status eq Task::STATUS_OPEN}checked{/if}> 启用</label>
                </div>
            </div>
            <div class="form-actions">
                <input type="hidden" value="answer_question" name="key" />
                <button type="submit" class="btn blue"><i class="icon-ok"></i> 保存</button>
                <a href="{route('TaskList')}"><button type="button" class="btn"><i class=" icon-remove"></i> 取消</button></a>
            </div>
        </form>
        </p>
    </div>
                        {elseif $data.key == 'invite_friend'}
                            <div  id="tab_1_7">
        <p>邀请好友注册指帮</p><br />
        <p>
        <form method="post" action="{route('TaskSave')}" class="form-horizontal">
            <div class="control-group cycle_div">
                <label class="control-label"> 奖励周期:</label>
                <div class="controls">
                    <label>
                        <label class="radio">
                            <input type="radio" name="cycle_invite_friend" class="once" {if $data.cycle eq Task::CYCLE_ONCE}checked{/if} value="{Task::CYCLE_ONCE}" />
                            一次性
                        </label>
                        <label class="radio">
                            <input type="radio" name="cycle_invite_friend" {if $data.cycle eq Task::CYCLE_EVERYDAY}checked{/if} value="{Task::CYCLE_EVERYDAY}" />
                            每人每天
                        </label>
                        <label class="radio">
                            <input type="radio" name="cycle_invite_friend" {if $data.cycle eq Task::CYCLE_NOCYCLE}checked{/if} value="{Task::CYCLE_NOCYCLE}" />
                            不限周期
                        </label>
                    </label>
                </div>
            </div>
            <div class="control-group times_div" {if $data.cycle eq Task::CYCLE_ONCE}style="display:none"{/if}>
                <label class="control-label"> 奖励次数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励次数" class="input-large" name="reward_times" value="{$data.reward_times}" required />
                    <span class="help-inline">如果周期为一次性，则此栏则会默认为1，无需设置，如果为不限周期，则默认为为0，表示不做限制</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励指币数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励指币数" class="input-large" name="reward_coin" value="{$data.reward_coin}" required />
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励内购额:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励内购额" class="input-large" name="reward_insource" value="{$data.reward_insource}" required />
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 任务备注:</label>
                <div class="controls">
                    <textarea class="input-xxlarge" name="remark" rows="3">{$data.remark}</textarea>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 是否启用:</label>
                <div class="controls">
                    <label class="checkbox"><input value="{Task::STATUS_OPEN}" name="status" type="checkbox" {if $data.status eq Task::STATUS_OPEN}checked{/if}> 启用</label>
                </div>
            </div>
            <div class="form-actions">
                <input type="hidden" value="invite_friend" name="key" />
                <button type="submit" class="btn blue"><i class="icon-ok"></i> 保存</button>
                <a href="{route('TaskList')}"><button type="button" class="btn"><i class=" icon-remove"></i> 取消</button></a>
            </div>
        </form>
        </p>
    </div>
                        {elseif $data.key == 'buy_goods'}
                            <div  id="tab_1_8">
        <p>成功购买并付款商品</p><br />
        <p>
        <form method="post" action="{route('TaskSave')}" class="form-horizontal">
            <div class="control-group cycle_div">
                <label class="control-label"> 奖励周期:</label>
                <div class="controls">
                    <label>
                        <label class="radio">
                            <input type="radio" name="cycle_buy_goods" class="once" {if $data.cycle eq Task::CYCLE_ONCE}checked{/if} value="{Task::CYCLE_ONCE}" />
                            一次性
                        </label>
                        <label class="radio">
                            <input type="radio" name="cycle_buy_goods" {if $data.cycle eq Task::CYCLE_EVERYDAY}checked{/if} value="{Task::CYCLE_EVERYDAY}" />
                            每人每天
                        </label>
                        <label class="radio">
                            <input type="radio" name="cycle_buy_goods" {if $data.cycle eq Task::CYCLE_NOCYCLE}checked{/if} value="{Task::CYCLE_NOCYCLE}" />
                            不限周期
                        </label>
                    </label>
                </div>
            </div>
            <div class="control-group times_div" {if $data.cycle eq Task::CYCLE_ONCE}style="display:none"{/if}>
                <label class="control-label"> 奖励次数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励次数" class="input-large" name="reward_times" value="{$data.reward_times}" required />
                    <span class="help-inline">如果周期为一次性，则此栏则会默认为1，无需设置，如果为不限周期，则默认为为0，表示不做限制次数</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励指币数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励指币数" class="input-large" name="reward_coin" value="{$data.reward_coin}" required />
                    <span class="help-inline">为空或为0，则默认每笔交易可获得等额的指币，有设置表示最高不超过这个值</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励内购额:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励内购额" class="input-large" name="reward_insource" value="{$data.reward_insource}" required />
                    <span class="help-inline">为空或为0，则默认每笔交易可获得等额的内购额，有设置表示最高不超过这个值</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 任务备注:</label>
                <div class="controls">
                    <textarea class="input-xxlarge" name="remark" rows="3">{$data.remark}</textarea>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 是否启用:</label>
                <div class="controls">
                    <label class="checkbox"><input value="{Task::STATUS_OPEN}" name="status" type="checkbox" {if $data.status eq Task::STATUS_OPEN}checked{/if}> 启用</label>
                </div>
            </div>
            <div class="form-actions">
                <input type="hidden" value="buy_goods" name="key" />
                <button type="submit" class="btn blue"><i class="icon-ok"></i> 保存</button>
                <a href="{route('TaskList')}"><button type="button" class="btn"><i class=" icon-remove"></i> 取消</button></a>
            </div>
        </form>
        </p>
    </div>
                        {elseif $data.key == 'feedback'}
                            <div  id="tab_1_9">
        <p>参与反馈意见</p><br />
        <p>
        <form method="post" action="{route('TaskSave')}" class="form-horizontal">
            <div class="control-group cycle_div">
                <label class="control-label"> 奖励周期:</label>
                <div class="controls">
                    <label>
                        <label class="radio">
                            <input type="radio" name="cycle_feedback" class="once" {if $data.cycle eq Task::CYCLE_ONCE}checked{/if} value="{Task::CYCLE_ONCE}" />
                            一次性
                        </label>
                        <label class="radio">
                            <input type="radio" name="cycle_feedback" {if $data.cycle eq Task::CYCLE_EVERYDAY}checked{/if} value="{Task::CYCLE_EVERYDAY}" />
                            每人每天
                        </label>
                        <label class="radio">
                            <input type="radio" name="cycle_feedback" {if $data.cycle eq Task::CYCLE_NOCYCLE}checked{/if} value="{Task::CYCLE_NOCYCLE}" />
                            不限周期
                        </label>
                    </label>
                </div>
            </div>
            <div class="control-group times_div" {if $data.cycle eq Task::CYCLE_ONCE}style="display:none"{/if}>
                <label class="control-label"> 奖励次数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励次数" class="input-large" name="reward_times" value="{$data.reward_times}" required />
                    <span class="help-inline">如果周期为一次性，则此栏则会默认为1，无需设置，如果为不限周期，则默认为为0，表示不做限制</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励指币数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励指币数" class="input-large" name="reward_coin" value="{$data.reward_coin}" required />
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励内购额:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励内购额" class="input-large" name="reward_insource" value="{$data.reward_insource}" required />
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 任务备注:</label>
                <div class="controls">
                    <textarea class="input-xxlarge" name="remark" rows="3">{$data.remark}</textarea>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 是否启用:</label>
                <div class="controls">
                    <label class="checkbox"><input value="{Task::STATUS_OPEN}" name="status" type="checkbox" {if $data.status eq Task::STATUS_OPEN}checked{/if}> 启用</label>
                </div>
            </div>
            <div class="form-actions">
                <input type="hidden" value="feedback" name="key" />
                <button type="submit" class="btn blue"><i class="icon-ok"></i> 保存</button>
                <a href="{route('TaskList')}"><button type="button" class="btn"><i class=" icon-remove"></i> 取消</button></a>
            </div>
        </form>
        </p>
    </div>
                        {elseif $data.key == 'questionnaires'}
                            <div  id="tab_1_10">
        <p>参与问卷调查</p><br />
        <p>
        <form method="post" action="{route('TaskSave')}" class="form-horizontal">
            <div class="control-group cycle_div">
                <label class="control-label"> 奖励周期:</label>
                <div class="controls">
                    <label>
                        <label class="radio">
                            <input type="radio" name="cycle_questionnaires" class="once" {if $data.cycle eq Task::CYCLE_ONCE}checked{/if} value="{Task::CYCLE_ONCE}" />
                            一次性
                        </label>
                        <label class="radio">
                            <input type="radio" name="cycle_questionnaires" {if $data.cycle eq Task::CYCLE_EVERYDAY}checked{/if} value="{Task::CYCLE_EVERYDAY}" />
                            每人每天
                        </label>
                        <label class="radio">
                            <input type="radio" name="cycle_questionnaires" {if $data.cycle eq Task::CYCLE_NOCYCLE}checked{/if} value="{Task::CYCLE_NOCYCLE}" />
                            不限周期
                        </label>
                    </label>
                </div>
            </div>
            <div class="control-group times_div" {if $data.cycle eq Task::CYCLE_ONCE}style="display:none"{/if}>
                <label class="control-label"> 奖励次数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励次数" class="input-large" name="reward_times" value="{$data.reward_times}" required />
                    <span class="help-inline">如果周期为一次性，则此栏则会默认为1，无需设置，如果为不限周期，则默认为为0，表示不做限制</span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励指币数:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励指币数" class="input-large" name="reward_coin" value="{$data.reward_coin}" required />
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 奖励内购额:</label>
                <div class="controls">
                    <input type="text" placeholder="请输入奖励内购额" class="input-large" name="reward_insource" value="{$data.reward_insource}" required />
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 任务备注:</label>
                <div class="controls">
                    <textarea class="input-xxlarge" name="remark" rows="3">{$data.remark}</textarea>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> 是否启用:</label>
                <div class="controls">
                    <label class="checkbox"><input value="{Task::STATUS_OPEN}" name="status" type="checkbox" {if $data.status eq Task::STATUS_OPEN}checked{/if}> 启用</label>
                </div>
            </div>
            <div class="form-actions">
                <input type="hidden" value="questionnaires" name="key" />
                <button type="submit" class="btn blue"><i class="icon-ok"></i> 保存</button>
                <a href="{route('TaskList')}"><button type="button" class="btn"><i class=" icon-remove"></i> 取消</button></a>
            </div>
        </form>
        </p>
    </div>
                        {/if}
                        </div>
                    </div>
                <!--END TABS-->
                </DIV>
            <div style="clear:both"></div>
        </div>
    </div>
    </div>
    <!-- end recent orders portlet-->
    </div>
    </div>
{/block}

{block script}
    <script>
        $('input[type="radio"]').click(function() {
            if ($(this).attr('class') == 'once') {
                $(this).parents(".cycle_div").next(".times_div").hide();
            } else {
                $(this).parents(".cycle_div").next(".times_div").show();
            }
        });
    </script>
{/block}
