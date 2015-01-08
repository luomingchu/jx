<?php
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Event;

/**
 * 任务控制器
 *
 * @author jois
 */
class TaskController extends BaseController
{

    /**
     * 任务列表【只返回未完成的任务】
     */
    public function getTaskList()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'limit' => [
                'integer',
                'between:1,200'
            ],
            'page' => [
                'integer',
                'min:1'
            ]
        ], [
            'limit.integer' => '每页记录数必须是一个整数',
            'limit.between' => '每页记录数必须在1-200之间',
            'page.integer' => '页数必须是一个整数',
            'page.min' => '页数必须大于0'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 遍历所有任务，查看登录者是否已经完成几个任务
        $task_keys = [];
        foreach (Task::whereStatus(Task::STATUS_OPEN)->get() as $task) {
            if ($task->cycle == Task::CYCLE_ONCE) {
                $coin = Coin::whereMemberId(Auth::id())->whereKey($task->key)->first();
                if (! is_null($coin)) {
                    array_push($task_keys, $task->key);
                }
            } elseif ($task->cycle == Task::CYCLE_EVERYDAY) {
                $today = date('Y-m-d');
                $count = Coin::whereMemberId(Auth::id())->whereKey($task->key)
                    ->where('created_at', 'like', "{$today}%")
                    ->count();
                if ($task->reward_times <= $count) {
                    array_push($task_keys, $task->key);
                }
            } elseif ($task->cycle == Task::CYCLE_NOCYCLE) {
                $count = Coin::whereMemberId(Auth::id())->whereKey($task->key)->count();
                if ($task->reward_times == 0) {
                    continue;
                }
                if ($task->reward_times <= $count) {
                    array_push($task_keys, $task->key);
                }
            }
        }

        $task = Task::with('source')->whereStatus(Task::STATUS_OPEN);
        if (! empty($task_keys)) {
            $task = $task->whereNotIn('key', $task_keys);
        }
        return $task->latest()
            ->paginate(Input::get('limit', 15))
            ->getCollection();
    }

    /**
     * 对软件本身的问题反馈
     */
    public function sysSuggestion()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'content' => 'required'
        ], [
            'content.required' => '反馈内容不能为空'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 保存反馈
        $suggestion = new Suggestion();
        $suggestion->member()->associate(Auth::user());
        $suggestion->content = Input::get('content');
        $suggestion->ip = Request::getClientIp();
        $suggestion->save();

        // 反馈后，进行奖励
        // $res = Event::fire('task.reward.bykey', [
        // 'questionnaires'
        // ]);
        // $data['task'] = $res[0];
        // $data['suggestion'] = $suggestion;
        return $suggestion;
    }

    /**
     * 对企业[商品等]的意见反馈
     */
    public function suggest()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'content' => 'required'
        ], [
            'content.required' => '反馈内容不能为空'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $suggest = new Suggest();
        $suggest->member()->associate(Auth::user());
        $suggest->content = Input::get('content');
        $suggest->ip = Request::getClientIp();
        $suggest->save();

        // 反馈后，进行奖励
        // $res = Event::fire('task.reward.bykey', [
        // 'questionnaires'
        // ]);
        // $data['task'] = $res[0];
        // $data['suggest'] = $suggest;
        return $suggest;
    }

    /**
     * 任务奖励，返回结果
     */
    public function reward()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'key' => 'required|exists:' . Config::get('database.connections.own.database') . '.tasks,key',
            'member_id' => 'exists:members,id'
        ], [
            'key.required' => 'key不能为空',
            'key.exists' => 'key不在任务中不存在',
            'member_id.exists' => '用户不存在不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 查询系统是否有这个任务
        $member_id = Input::has('member_id') ? Input::get('member_id') : Auth::id();
        $member = Member::find($member_id);
        $key = Input::get('key');
        $task = Task::whereStatus(Task::STATUS_OPEN)->find($key);
        $source = Source::find($key);
        if (is_null($task) || is_null($source)) {
            return Response::make('没有此项任务，奖励失败', 402);
        }
        // 根据任务规则判断，是否可以奖励
        if ($this->checkReward(Input::get('key'), $member_id) === false) {
            return Response::make('任务已做完，没有相关奖励', 402);
        }

        $data = '';
        $coin = null;
        $insource = null;
        if ($task->cycle == Task::CYCLE_ONCE) {
            // 周期：一次性奖励
            // 查询之前是否已经做了此任务的指币记录
            $temp = Coin::whereMemberId($member_id)->whereKey($task->key)->first();
            if (is_null($temp)) {
                // 添加指币记录
                if ($task->reward_coin > 0) {
                    $coin = new Coin();
                    $coin->member()->associate($member);
                    $coin->amount = $task->reward_coin;
                    $coin->source()->associate($source);
                    $coin->save();
                }
            }
            // 查询之前是否已经做了此任务的内购额记录
            $temp = Insource::whereMemberId($member_id)->whereKey($task->key)->first();
            if (is_null($temp)) {
                // 添加内购额记录
                if ($task->reward_insource > 0) {
                    $insource = new Insource();
                    $insource->member()->associate($member);
                    $insource->amount = $task->reward_insource;
                    $insource->source()->associate($source);
                    $insource->save();
                }
            }
        } elseif ($task->cycle == Task::CYCLE_EVERYDAY) {
            // 周期：每人每天
            // 今天此人此任务已经奖励指币多少次了
            $rewarded_times = Coin::whereMemberId($member_id)->whereKey($task->key)
                ->where('created_at', 'like', date('Y-m-d') . '%')
                ->count();
            if ($task->reward_times > $rewarded_times) {
                // 添加指币记录
                if ($task->reward_coin > 0) {
                    $coin = new Coin();
                    $coin->member()->associate($member);
                    $coin->amount = $task->reward_coin;
                    $coin->source()->associate($source);
                    $coin->save();
                }
            }
            // 今天此人此任务已经奖励内购额多少次了
            $rewarded_times = Insource::whereMemberId($member_id)->whereKey($task->key)
                ->where('created_at', 'like', date('Y-m-d') . '%')
                ->count();
            if ($task->reward_times > $rewarded_times) {
                // 添加指币记录
                if ($task->reward_insource > 0) {
                    $insource = new Insource();
                    $insource->member()->associate($member);
                    $insource->amount = $task->reward_insource;
                    $insource->source()->associate($source);
                    $insource->save();
                }
            }
        } elseif ($task->cycle == Task::CYCLE_NOCYCLE) {
            // 周期：不限制周期
            // 此任务已经奖励指币多少次了
            $rewarded_times = Coin::whereMemberId($member_id)->whereKey($task->key)->count();
            if ($task->reward_times > $rewarded_times) {
                // 添加指币记录
                if ($task->reward_coin > 0) {
                    $coin = new Coin();
                    $coin->member()->associate($member);
                    $coin->amount = $task->reward_coin;
                    $coin->source()->associate($source);
                    $coin->save();
                }
            }
            // 此任务已经奖励内购额多少次了
            $rewarded_times = Insource::whereMemberId($member_id)->whereKey($task->key)->count();
            if ($task->reward_times > $rewarded_times) {
                // 添加指币记录
                if ($task->reward_insource > 0) {
                    $insource = new Insource();
                    $insource->member()->associate($member);
                    $insource->amount = $task->reward_insource;
                    $insource->source()->associate($source);
                    $insource->save();
                }
            }
        }
        if (! is_null($coin) && ! is_null($insource)) {
            $data = "恭喜你获得了<font color='#FF6600'>" . $coin->amount . "</font>指币，<font color='#FF6600'>" . $insource->amount . '</font>内购额';
        } elseif (! is_null($coin) && is_null($insource)) {
            $data = "恭喜你获得了<font color='#FF6600'>" . $coin->amount . '</font>指币';
        } elseif (! is_null($insource) && is_null($coin)) {
            $data = "恭喜你获得了<font color='#FF6600'>" . $insource->amount . '</font>内购额';
        }
        if (empty($data)) {
            return Response::make('任务已做完，没有相关奖励', 402);
        }
        return Response::make($data, 200);
    }

    /**
     * 检测是否满足奖励条件
     */
    protected function checkReward($key, $member_id)
    {
        if (empty($key) || empty($member_id)) {
            return false;
        }

        $member = Member::find($member_id);
        switch ($key) {
            case 'perfect_own_data':
                if (! empty($member->age) && ! empty($member->avatar_id) && ! empty($member->real_name) && ! empty($member->gender)) {
                    return true;
                }
                return false;
            default:
                return true;
        }
    }
}