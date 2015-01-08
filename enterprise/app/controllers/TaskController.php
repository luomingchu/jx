<?php

/**
 * 企业后台-任务控制器
 *
 * @author jois
 */
class TaskController extends BaseController
{

    /**
     * 企业设置任务视图
     */
    public function getList()
    {
        // 得到任务数据
        $data = Task::with('source')->get();
        !$data->isEmpty() && $data = $data->keyBy('key');
        // 返回视图
        return View::make('task.list')->withData($data);
    }

    /**
     * 修改企业任务
     */
    public function getEdit($task_key)
    {
        // 获取指定的任务信息
        $info = Task::with('source')->find($task_key);
        return View::make('task.edit')->withData($info);
    }

    /**
     * 保存任务设置
     */
    public function save()
    {
        // 验证输入
        $validator = Validator::make(Input::all(), array(
            'cycle_' . Input::get('key') => 'required|in:' . Task::CYCLE_EVERYDAY . ',' . Task::CYCLE_NOCYCLE . ',' . Task::CYCLE_ONCE,
            'reward_times' => 'integer|min:0',
            'reward_coin' => 'required|integer|min:0',
            'reward_insource' => 'required|numeric|min:0',
            'remark' => 'required|max:255',
            'status' => 'in:' . Task::STATUS_CLOSE . ',' . Task::STATUS_OPEN,
            'key' => 'required|exists:tasks,key'
        ), array(
            'cycle_' . Input::get('key') . 'required' => '任务周期不能为空！',
            'cycle_' . Input::get('key') . 'in' => '任务周期只能在一次性、每人每天及不限周期中选择！',
            'reward_times.integer' => '奖励次数只能为整数！',
            'reward_times.min' => '奖励次数不能小于零！',
            'reward_coin.required' => '奖励指币数不能为空！',
            'reward_coin.integer' => '奖励指币数只能为整数！',
            'reward_coin.min' => '奖励指币数不能小于零！',
            'reward_insource.required' => '奖励内购额不能为空！',
            'reward_insource.numeric' => '奖励内购额只能为数字！',
            'reward_insource.min' => '奖励内购额不能小于零！',
            'remark.required' => '任务备注不能为空！',
            'remark.max' => '任务备注不能大于255个字符！',
            'status.in' => '是否启用状态错误！',
            'key.required' => '任务key不能为空！',
            'key.exists' => '任务key不存在！'
        ));

        if ($validator->fails()) {
            // 验证失败，返回错误信息。
            Input::flash();
            return Redirect::back()->withMessageError($validator->messages()
                ->first());
        }

        $task = Task::find(Input::get('key'));
        $task->cycle = Input::get('cycle_' . Input::get('key'));
        $task->reward_coin = Input::get('reward_coin', 0);
        $task->reward_insource = Input::get('reward_insource', 0);
        if (Input::get('cycle_' . Input::get('key')) == Task::CYCLE_ONCE) {
            $task->reward_times = 1;
        } else {
            $task->reward_times = Input::get('reward_times', 0);
        }
        $task->remark = trim(Input::get('remark'));
        $task->status = Input::get('status', Task::STATUS_CLOSE);
        $task->save();

        return Redirect::route('TaskList')->withMessageSuccess('保存成功');
    }
}
