<?php

/**
 * 问答模块
 */
class IssueController extends BaseController
{

    /**
     * 获取问题详情
     */
    public function getQuestion()
    {
        $question = Question::with('member', 'pictures')->find(Input::get('question_id'));
        if (is_null($question)) {
            return Response::make('问题不存在。', 402);
        }
        return $question;
    }

    /**
     * 获取问题的回答列表
     */
    public function getAnswerList()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'question_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.questions,id,deleted_at,NULL'
            ],
            'limit' => [
                'integer',
                'between:1,200'
            ],
            'page' => [
                'integer',
                'min:1'
            ]
        ], [
            'question_id.required' => '问题不能为空',
            'question_id.exists' => '问题不存在',
            'limit.integer' => '每页记录数必须是一个整数',
            'limit.between' => '每页记录数必须在1-200之间',
            'page.integer' => '页数必须是一个整数',
            'page.min' => '页数必须大于0'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得数据模型。
        $answers = Answer::with('member')->where('question_id', Input::get('question_id'))
            ->orderBy('accept', 'desc')
            ->orderBy('like_count', 'desc')
            ->orderBy('created_at', 'desc');

        // 取得单页数据。
        return $answers->paginate(Input::get('limit', 15))->getCollection();
    }

    /**
     * 发布问题
     */
    public function postQuestion()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'title' => [
                'required'
            ],
            'kind' => [
                'required',
                'in:' . Question::KIND_QUESTION . ',' . Question::KIND_PRATTLE . ',' . Question::KIND_RESOURCE
            ],
            'content' => [
                'required'
            ],
            'picture_id' => [
                'array',
                'exists:user_files,id',
                'user_file_mime:/^image\//i'
            ],
            'reward' => [
                'numeric'
            ]
        ], [
            'title.required' => '标题不能为空',
            'kind.required' => '问题类型不能为空',
            'kind.in' => '问题类型必须是提问、闲聊或者资源',
            'content.required' => '问题内容不存在',
            'picture_id.array' => '图片ID必须是一个数组参数',
            'picture_id.exists' => '图片ID不存在',
            'picture_id.user_file_mime' => '图片格式不正确',
            'reward.numeric' => '奖赏分必须是一个数字'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 判断图片个数
        if (count(Input::get('picture_id')) > 3) {
            return Response::make('问题图片只能最多只能三张', 402);
        }

        // 当前登录用户。
        $user = Auth::user();

        // 检测用户输入的奖励指币是否足够
        if ($user->info->coin < Input::get('reward', 0)) {
            return Response::make('你的指币不够了，当前只有' . $user->info->coin . '，请重新输入', 402);
        }

        // 创建问题。
        $question = new Question();
        $question->member()->associate($user);
        $question->reward = Input::get('reward', 0);
        $question->title = Input::get('title');
        $question->kind = ucfirst(Input::get('kind'));
        $question->content = Input::get('content', '');
        $question->save();
        if (Input::has('picture_id')) {
            $question->pictures()->sync((array) Input::get('picture_id'));
        }

        // 发布问题的任务奖励
        // $res = Event::fire('task.reward.bykey', [
        // 'release_question'
        // ]);

        // $data['task'] = $res[0];
        // $data['question'] = Question::with('member', 'pictures')->find($question->id);
        // 返回创建后的问题。
        return Question::with('member', 'pictures')->find($question->id);
    }

    /**
     * 修改问题
     */
    public function postEditQuestion()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'question_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.questions,id,deleted_at,NULL,member_id,' . Auth::id()
            ],
            'title' => [
                'required'
            ],
            'kind' => [
                'required',
                'in:' . Question::KIND_QUESTION . ',' . Question::KIND_PRATTLE . ',' . Question::KIND_RESOURCE
            ],
            'content' => [
                'required'
            ],
            'picture_id' => [
                'array',
                'exists:user_files,id',
                'user_file_mime:/^image\//i'
            ],
            'reward' => [
                'numeric'
            ]
        ], [
            'question_id.required' => '问题不能为空',
            'question_id.exists' => '问题不存在',
            'title.required' => '标题不能为空',
            'kind.required' => '问题类型不能为空',
            'kind.in' => '问题类型必须是提问、闲聊或者资源',
            'content.required' => '问题内容不存在',
            'picture_id.array' => '图片ID必须是一个数组参数',
            'picture_id.exists' => '图片ID不存在',
            'picture_id.user_file_mime' => '图片格式不正确',
            'reward.numeric' => '奖赏分必须是一个数字'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 判断图片个数
        if (count(Input::get('picture_id')) > 3) {
            return Response::make('问题图片只能最多只能三张', 402);
        }

        // 当前登录用户。
        $user = Auth::user();

        // 检测用户输入的奖励指币是否足够
        if ($user->info->coin < Input::get('reward', 0)) {
            return Response::make('你的指币不够了，当前只有' . $user->info->coin . '，请重新输入', 402);
        }

        // 判断是否已经有回复了
        $question = Question::find(Input::get('question_id'));
        foreach ($question->answers()->get() as $answer) {
            if ($answer->accept == Answer::ACCEPT_YES) {
                return Response::make('该问题已采纳回答，不能被编辑', 402);
            }
        }

        // 创建问题。
        $question->reward = Input::get('reward', 0);
        $question->title = Input::get('title');
        $question->kind = ucfirst(Input::get('kind'));
        $question->content = Input::get('content', '');
        $question->save();
        if (Input::has('picture_id')) {
            $question->pictures()->sync((array) Input::get('picture_id'));
        } else {
            $question->pictures()->delete();
        }

        // 返回创建后的问题。
        return Question::with('member', 'pictures')->find($question->id);
    }

    /**
     * 删除问题
     */
    public function deleteQuestion()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'question_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.questions,id,deleted_at,NULL,member_id,' . Auth::id()
            ]
        ], [
            'question_id.required' => '问题不能为空',
            'question_id.exists' => '问题不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $question = Question::find(Input::get('question_id'));
        if (is_null($question)) {
            return Response::make('问题已被删除', 402);
        }
        if ($question->answers->count() > 0) {
            return Response::make('问题已被回复，不能删除', 402);
        }

        // 删除
        Question::find(Input::get('question_id'))->delete();

        return 'success';
    }

    /**
     * 发布问题的回答
     */
    public function postAnswer()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'question_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.questions,id,deleted_at,NULL'
            ],
            'be_answered_id' => [
                'exists:' . Config::get('database.connections.own.database') . '.answers,id,deleted_at,NULL,question_id,' . Input::get('question_id')
            ],
            'content' => [
                'required'
            ],
            'picture_id' => [
                'array',
                'exists:user_files,id',
                'user_file_mime:/^image\//i'
            ]
        ], [
            'question_id.required' => '问题不能为空',
            'question_id.exists' => '问题不存在',
            'be_answered_id.exists' => '该问题的该回答不存在，所以您对回答的回复失败',
            'content.required' => '回答内容不能为空',
            'picture_id.array' => '图片ID必须是一个数组参数',
            'picture_id.exists' => '图片ID不存在',
            'picture_id.user_file_mime' => '图片格式不正确'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 当前登录用户。
        $user = Auth::user();

        // 取得要回答的问题。
        $question = Question::find(Input::get('question_id'));

        // 回答问题后不能再进行回答
        // if ($question->answered) {
        // return Response::make('不能对问题重复回答。', 402);
        // }

        if ($question->close == Question::CLOSE_YES) {
            return Response::make('问题已关闭。', 402);
        }

        // 创建回答。
        $answer = new Answer();
        $answer->member()->associate($user);
        $answer->question()->associate($question);
        if (Input::has('be_answered_id')) {
            $answer->beAnswered()->associate(Answer::find(Input::get('be_answered_id')));
        }
        $answer->content = Input::get('content');
        $answer->save();
        if (Input::has('picture_id')) {
            $answer->pictures()->sync((array) Input::get('picture_id'));
        }

        $answer = Answer::with('question')->find($answer->id);

        // 发送消息给提问人
        Event::fire('messages.answer_question', [
            $answer
        ]);

        // 回答问题的任务奖励
        // $res = Event::fire('task.reward.bykey', [
        // 'answer_question'
        // ]);
        // $data['task'] = $res[0];
        // $data['answer'] = $answer;
        // 返回创建后的问题。
        return $answer;
    }

    /**
     * 采纳回答
     *
     * @param integer $answer_id
     */
    public function postAccept()
    {
        // 取得要采纳的回答。
        $answer = Answer::find(Input::get('answer_id'));

        // 验证数据。
        if (is_null($answer)) {
            return Response::make('回答不存在。', 402);
        }
        // 限制权限。
        if ($answer->question->member->id != Auth::user()->id) {
            return Response::make('只有问题的发布者才可以采纳该问题的回答。', 403);
        }

        // 检查问题是否已有采纳
        if ($answer->question->close == Question::CLOSE_YES) {
            return Response::make('此问题已有采纳的回答了，请不要重复采纳回答', 402);
        }
        // 修改此回答为已采纳。
        $answer->accept = Answer::ACCEPT_YES;
        $answer->save();
        // 对回答者增加问题奖励数
        if (! empty($answer->question->reward)) {
            $coin = new Coin();
            $coin->member()->associate($answer->member);
            $coin->amount = $answer->question->reward;
            $coin->source()->associate(Source::find('accept_answer'));
            $coin->save();
        }

        // 发送消息给回答者
        Event::fire('messages.accept_answer', [
            $answer
        ]);

        return 'success';
    }

    /**
     * 按类型获取好友的问题列表
     */
    public function getFriendQuestionList()
    {
        $validator = Validator::make(Input::all(), [
            'friend_id' => [
                'exists:members,id,deleted_at,NULL'
            ],
            'kind' => [
                'in:' . Question::KIND_QUESTION . ',' . Question::KIND_PRATTLE . ',' . Question::KIND_RESOURCE
            ],
            'time_range' => [
                'in:Day,Week,Month'
            ],
            'limit' => [
                'integer',
                'between:1,200;'
            ],
            'page' => [
                'integer',
                'min:1'
            ]
        ], [
            'friend_id.exists' => '好友不存在',
            'kind.in' => '问题类型必须是提问、闲聊或者资源',
            'time_range.in' => '时间范围必须是Day,Week或Month',
            'limit.integer' => '每页记录数必须是一个整数',
            'limit.between' => '每页记录数必须在1-200之间',
            'page.integer' => '页数必须是一个整数',
            'page.min' => '页数必须大于0'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }
        // 获取数据模型。
        $question = Question::with('pictures', 'member')->latest();
        // 如果有指定查看的用户则只显示当前用户的问题列表
        if (Input::has('friend_id')) {
            $question->where('member_id', Input::get('friend_id'));
        } else {
            // 获取用户关注的所有用户
            $attentions = Auth::user()->attentions()
                ->where('relationship', Attention::RELATIONSHIP_MUTUAL)
                ->get();
            $user_ids = [
                Auth::user()->id
            ];
            if (! $attentions->isEmpty()) {
                foreach ($attentions as $friend) {
                    if ($friend->friend) {
                        $user_ids[] = $friend->friend->id;
                    }
                }
            }
            // 处理赛选条件。
            $question->whereIn('member_id', $user_ids);
        }
        if (Input::has('kind')) {
            $question->where('kind', Input::get('kind'));
        }
        // 如果有指定范围
        if (Input::has('time_range')) {
            $time = date('Y-m-d H:i:s', strtotime('-1' . strtolower(Input::get('time_range')), time()));
            $question->where('created_at', '>', $time);
        }
        // 获取单页数据。
        return $question->paginate(Input::get('limit', 15))->getCollection();
    }

    /**
     * 查看指定用户其好友的问题列表
     */
    public function getUserFriendQuestionList()
    {
        $validator = Validator::make(Input::all(), [
            'friend_id' => [
                'required',
                'exists:members,id,deleted_at,NULL'
            ],
            'kind' => [
                'in:' . Question::KIND_QUESTION . ',' . Question::KIND_PRATTLE . ',' . Question::KIND_RESOURCE
            ],
            'time_range' => [
                'in:Day,Week,Month'
            ],
            'limit' => [
                'integer',
                'between:1,200;'
            ],
            'page' => [
                'integer',
                'min:1'
            ]
        ], [
            'friend_id.required' => '用户不能为空',
            'friend_id.exists' => '用户不存在',
            'kind.in' => '问题类型必须在提问、资源及闲聊中选择',
            'time_range.in' => '时间范围必须是Day,Week或Month',
            'limit.integer' => '每页记录数必须是一个整数',
            'limit.between' => '每页记录数必须在1-200之间',
            'page.integer' => '页数必须是一个整数',
            'page.min' => '页数必须大于0'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 获取数据模型。
        $question = Question::with('pictures', 'member')->latest();

        if (Input::has('kind')) {
            $question->where('kind', Input::get('kind'));
        }

        // 如果有指定范围
        if (Input::has('time_range')) {
            $time = date('Y-m-d H:i:s', strtotime('-1' . strtolower(Input::get('time_range')), time()));
            $question->where('created_at', '>', $time);
        }

        // 如果指定查看的用户其好友的问题列表
        $attentions = Member::find(Input::get('friend_id'))->attentions()
            ->where('relationship', Attention::RELATIONSHIP_MUTUAL)
            ->get();

        if (! $attentions->isEmpty()) {
            $question->whereIn('member_id', $attentions->fetch('friend.id')
                ->toArray());
        } else {
            return [];
        }

        // 获取单页数据。
        return $question->paginate(Input::get('limit', 15))->getCollection();
    }

    /**
     * 显示&关闭的指帮【问+资+告+聊】开关
     */
    public function zbondShowOper()
    {
        // 查看是否互相关注
        $attention = Attention::whereMemberId(Auth::id())->whereFriendId(Input::get('friend_id'))
            ->whereRelationship(Attention::RELATIONSHIP_MUTUAL)
            ->first();
        if (! is_null($attention)) {
            if (in_array(Input::get('zbond_show'), [
                Attention::ZBOND_SHOW_YES,
                Attention::ZBOND_SHOW_NO
            ])) {
                $attention->zbond_show = Input::get('zbond_show');
                $attention->save();
                return $attention;
            }
            return Response::make('取消指帮关注失败', 402);
        }
        return Response::make('非互相关注的好友，取消指帮关注失败', 402);
    }

    /**
     * 获取用户问题的总数
     */
    public function getQuestionNum()
    {
        $validator = Validator::make(Input::all(), [
            'friend_id' => [
                'required',
                'exists:members,id,deleted_at,NULL'
            ],
            'kind' => [
                'in:' . Question::KIND_RESOURCE . ',' . Question::KIND_PRATTLE . ',' . Question::KIND_QUESTION
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }
        // 查看指定用户发布的问题数
        $num = Question::where('member_id', Input::get('friend_id'));
        // 筛选指定的问题类型
        if (Input::has('kind')) {
            $num->where('kind', Input::get('kind'));
        }
        return $num->count();
    }
}
