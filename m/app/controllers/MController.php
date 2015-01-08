<?php
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;

/**
 * M版相关的控制器
 *
 * @author jois
 */
class MController extends BaseController
{

    /**
     * 获取分享的商品列表
     */
    public function getGoodsList()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'goods_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.goods,id,status,' . Goods::STATUS_OPEN
            ]
        ], [
            'goods_id.required' => '商品ID不能为空',
            'goods_id.exists' => '商品不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 猜你喜欢
        $cai = Goods::where('id', '<>', Input::get('goods_id'))->latest()
            ->take(6)
            ->get();

        $data = Goods::with('pictures', 'store')->find(Input::get('goods_id'));

        $store_activity_ids = StoreActivity::where('store_id', $data->store_id)->where('body_type', StoreActivity::TYPE_INNER_PURCHASE)
            ->where('deleted', null)
            ->where('start_datetime', '<=', new \Carbon\Carbon(date('Y-m-d') . '00:00:00'))
            ->where('end_datetime', '>=', new \Carbon\Carbon(date('Y-m-d') . '23:59:59'))
            ->lists('id');
        if (! empty($store_activity_ids)) {
            $temp = StoreActivitiesGoods::whereIn('store_activity_id', $store_activity_ids)->whereGoodsId(Input::get('goods_id'))->first();
            if (! is_null($temp)) {
                $store_activity = StoreActivity::find($temp->store_activity_id);
                $end_time = $store_activity->end_datetime;
                $end_time = str_replace('-', '/', $end_time);
                // 抵用指币
                // $coin_max_use = round($data->price * ($temp->coin_max_use_ratio / 100), 2);
                $coin_max_use = $temp->coin_max_use_ratio;
                // 内购价
                $discount_price = $temp->discount_price;
            }
        }

        return View::make('goods.list')->with(compact('data', 'cai', 'end_time', 'coin_max_use', 'discount_price'));
    }

    /**
     * 获取分享的指帮列表
     */
    public function getQuestionList()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'question_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.questions,id,deleted_at,NULL'
            ]
        ], [
            'question_id.required' => '问题ID不能为空',
            'question_id.exists' => '问题不存在'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 问题及问题的回答
        $data = Question::with('member.avatar', 'pictures')->find(Input::get('question_id'));
        $answers = Answer::with('member.avatar', 'pictures')->whereQuestionId(Input::get('question_id'))
            ->latest()
            ->take(6)
            ->get();

        // 查看是否被回答
        $answered = Answer::whereQuestionId(Input::get('question_id'))->whereAccept(Answer::ACCEPT_YES)->first();
        if (is_null($answered)) {
            $answered = 0;
        } else {
            $answered = 1;
        }
        return View::make('question.list')->withData($data)
            ->withAnswers($answers)
            ->withAnswered($answered);
    }

    /**
     * 获取分享的指店列表
     */
    public function getVstoreList()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'vstore_id' => 'required|exists:' . Config::get('database.connections.own.database') . '.vstore,id,status,' . Vstore::STATUS_OPEN
        ], [
            'vstore_id.required' => '指店ID不能为空',
            'vstore_id.exists' => '指店不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 完全没有原型和页面，所以就抓该企业的所有指店
        $data = Vstore::with('member', 'store')->find(Input::get('vstore_id'));

        $store_activity = StoreActivity::where('store_id', $data->store_id)->where('body_type', StoreActivity::TYPE_INNER_PURCHASE)
            ->where('deleted', null)
            ->where('start_datetime', '<=', new \Carbon\Carbon(date('Y-m-d') . '00:00:00'))
            ->where('end_datetime', '>=', new \Carbon\Carbon(date('Y-m-d') . '23:59:59'))
            ->first();
        if (is_null($store_activity)) {
            $inner = null;
        } else {
            $end_time = $store_activity->end_datetime;
            $end_time = str_replace('-', '/', $end_time);
            $goods_ids = StoreActivitiesGoods::where('store_activity_id', $store_activity->id)->lists('goods_id');
            if (empty($goods_ids)) {
                $inner = null;
            }
            // 限量内购
            $inner = Goods::whereStoreId($data->store_id)->whereIn('id', $goods_ids)->whereStatus(Goods::STATUS_OPEN);

            $inner = $inner->take(12)->get();
        }

        return View::make('vstore.list')->with(compact('data', 'inner', 'end_time'));
    }

    /**
     * 问卷调查m版视图
     */
    public function questionnaire()
    {
        $validator = Validator::make(Input::all(), [
            'questionnaire_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.questionnaire,id,status,' . Questionnaire::STATUS_OPEN
            ]
        ], [
            'questionnaire_id.required' => '问卷ID不能为空',
            'questionnaire_id.exists' => '此问卷不存在'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $info = Questionnaire::with('issues.answers')->find(Input::get('questionnaire_id'));

        // 问卷访问量加一
        $info->increment('view_count');
        return View::make('questionnaire.info')->with(compact('info'));
    }

    /**
     * 保存问卷调查
     */
    public function questionnaireSave()
    {
        $validator = Validator::make(Input::all(), [
            'questionnaire_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.questionnaire,id,status,' . Questionnaire::STATUS_OPEN
            ]
        ], [
            'questionnaire_id.required' => '问卷ID不能为空',
            'questionnaire_id.exists' => '此问卷不存在'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 判断是否已经参与过了，一个问卷调查一个用户只能参与一次
        $temp = QuestionnaireMember::whereQuestionnaire_id(Input::get('questionnaire_id'))->whereMemberId(Auth::id())->first();
        if (! is_null($temp)) {
            return Response::make('您已经参与过此问卷调查，不能重复参加', 402);
        }

        // 判断回答
        $answer_ids = explode(',', Input::get('answer_ids'));

        $answer_ids = array_filter($answer_ids);

        if (empty($answer_ids)) {
            return Response::make('请填写答案', 402);
        }

        foreach ($answer_ids as $k => $item) {
            $answer = QuestionnaireAnswer::find($item);
            if ($answer->issue->questionnaire->id != Input::get('questionnaire_id')) {
                return Response::make('回答失败', 402);
            }
        }

        // 保存回答数据
        foreach ($answer_ids as $k => $item) {
            $answer = QuestionnaireAnswer::find($item);
            $answer->increment('choose_count');
            $answer->save();

            // 该回答所属的问题，参与数量+1
            // $issue = $answer->issue;
            // $issue->increment('join_count');
            // $issue->save();
        }

        // 所属问卷调查
        $questionnaire = Questionnaire::with('issues.answers')->find(Input::get('questionnaire_id'));

        // 记录用户的投票记录
        $questionnaire->member()->attach(Auth::id(), [
            'result' => serialize($answer_ids),
            'advice' => trim(Input::get('advice', ''))
        ]);
        $questionnaire->increment('join_count');

        // 进行任务奖励
        $member_info_old = MemberInfo::whereMemberId(Auth::id())->first();

        // 查询系统是否有这个任务
        $member = Auth::user();
        $member_id = $member->id;
        $task = Task::whereStatus(Task::STATUS_OPEN)->find('questionnaires');
        $source = Source::find('questionnaires');
        if (is_null($task) || is_null($source)) {
            return ['coin' => 0, 'insource' => 0];
        }

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

        $member_info_new = MemberInfo::whereMemberId(Auth::id())->first();

        $url = URL::route('Questionnaire', [
            'questionnaire_id' => Input::get('questionnaire_id'),
            'res' => $answer_ids,
            'coin' => $member_info_new->coin - $member_info_old->coin,
            'insource' => $member_info_new->insource - $member_info_old->insource,
            'advice' => trim(Input::get('advice', ''))
        ]);

        return Response::json($url, 200);
    }

    /**
     * 获取app下载页面
     */
    public function getAppDownLoad()
    {
        $android_download_url = "http://dl.zbond.com.cn/android/zbond_chain/" . $this->enterprise_id . "/zbond_" . $this->enterprise_id . ".apk";
        $iOS_download_url = "itms-services://?action=download-manifest&amp;url=https://dl.zbond.com.cn/iOS/zbond_chain/" . $this->enterprise_id . "/zbond_" . $this->enterprise_id . ".plist";
        $enterprise_config = EnterpriseConfig::whereEnterpriseId($this->enterprise_id)->first();

        // iOS 下载页面
        if (Input::has('type') && Input::get('type') == "iOS") {
            return View::make('appDownLoad.iOS')->with([
                "iOS_download_url" => $iOS_download_url,
                'enterprise_config' => $enterprise_config,
                'enterprise_id' => $this->enterprise_id
            ]);
        }

        // android 下载页面
        if (Input::has('type') && Input::get('type') == "android") {
            return View::make('appDownLoad.android')->with([
                "android_download_url" => $android_download_url,
                'enterprise_config' => $enterprise_config,
                'enterprise_id' => $this->enterprise_id
            ]);
        }

        // PC下载页面
        return View::make('appDownLoad.pc')->with([
            "iOS_download_url" => $iOS_download_url,
            "android_download_url" => $android_download_url,
            'enterprise_config' => $enterprise_config,
            'enterprise_id' => $this->enterprise_id
        ]);
    }

    /**
     * 分享主页
     */
    public function getShareIndex()
    {
        // 验证参数
        $validator = Validator::make(Input::all(), [
            'member_id' => 'required|exists:members,id',
            'type' => 'required|in:android,iOS'
        ], [
            'member_id.required' => '用户ID不能为空',
            'member_id.exists' => '用户不存在',
            'type.required' => 'app类型不能为空',
            'type.exists' => 'app类型只能为android或者iOS'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 个人信息
        $data = Member::with('info', 'vstore')->find(Input::get('member_id'));

        // 下载app链接(格式：下载app的url跟member_id参数，指友用app的扫一扫，它们才会去解析此url，跳到其他url去，否则其他app扫描只能是下载链接)
        $download_url = URL::route('AppDownLoad', [
            'type' => Input::get('type')
        ]);
        $download_url = $download_url . '&member_id=' . Input::get('member_id');

        return View::make('share.index')->withData($data)->withDownloadUrl($download_url);
    }

    /**
     * 获取新手帮助页面
     */
    public function getHelp()
    {
        return View::make('m.help');
    }

    /**
     * 获取玩转指帮
     */
    public function getStudyInviteFriend()
    {
        return View::make('m.study-invite-friend');
    }

    /**
     * 获取玩转指帮的问题列表
     */
    public function getStudyZbondList()
    {
        return View::make('m.study-zbond-list');
    }

    /**
     * 如何赚取指币
     */
    public function getStudyCoin()
    {
        return View::make('m.study-coin');
    }

    /**
     * 如何赚取内购额
     */
    public function getStudyInsource()
    {
        return View::make('m.study-insource');
    }

    /**
     * 获取企业介绍页面
     */
    public function getEnterpriseIntroduce()
    {
        return View::make($this->getTemplateFile('introduce'));
    }

    /**
     * 获取企业功能模板页面
     */
    protected function getTemplateFile($action)
    {
        $file = app_path()."/views/m/{$action}/{$this->enterprise_id}.tpl";
        if (! file_exists($file)) {
            return "m.{$action}.default";
        }
        return "m.{$action}.{$this->enterprise_id}";
    }
}