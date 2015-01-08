<?php

/**
 * 调查问卷
 */
class QuestionnaireController extends BaseController
{

    /**
     * m版url
     */
    public function getMurl()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'questionnaire_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.questionnaire,id,status,' . Questionnaire::STATUS_OPEN
            ]
        ], [
            'questionnaire_id.required' => '问卷ID不能为空',
            'questionnaire_id.exists' => '问卷不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        return URL::route('Questionnaire', array(
            'questionnaire_id' => Input::get('questionnaire_id')
        ));
    }

    /**
     * 获取调查问卷列表
     */
    public function getList()
    {
        $validator = Validator::make(Input::all(), [
            'limit' => [
                'integer',
                'between:1,200'
            ],
            'page' => [
                'integer'
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 获取问题列表
        return Questionnaire::whereStatus(Questionnaire::STATUS_OPEN)->where(function ($q)
        {
            $q->where('end_time', '>=', \Carbon\Carbon::now())
                ->orWhere('end_time', null);
        })
            ->latest()
            ->paginate(Input::get('limit', 10))
            ->getCollection();
    }

    /**
     * 获取调查问卷详细信息
     */
    public function getInfo()
    {
        $validator = Validator::make(Input::all(), [
            'questionnaire_id' => [
                'required'
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }
        $info = Questionnaire::find(Input::get('questionnaire_id'));
        if (empty($info)) {
            return Response::make('没有相关问卷调查', 402);
        }

        // 浏览数加1
        $info->increment('view_count');

        return $info;
    }

    /**
     * 获取问卷调查的问题列表
     */
    public function getQuestionList()
    {
        $validator = Validator::make(Input::all(), [
            'questionnaire_id' => [
                'required'
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }
        return QuestionnaireQuestion::where('questionnaire_id', Input::get('questionnaire_id'))->get();
    }

    /**
     * 提交问卷调查
     */
    public function postJoin()
    {
        $validator = Validator::make(Input::all(), [
            'questionnaire_id' => [
                'required',
                'exists:questionnaires,id'
            ],
            'question' => [
                'required'
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 所属调查问卷
        $questionnaire_info = Questionnaire::find(Input::get('questionnaire_id'));

        // 判断是否已经参与过此问卷调查
        if ($questionnaire_info->joined) {
            return Response::make('您已经参与过此问卷调查了，请不要重复参与', 402);
        }

        $question_list = Input::get('question');
        foreach ($question_list as $q => $a) {
            $answer = QuestionnaireAnswer::find($a);
            $answer->choose_count = $answer->choose_count + 1;
            $answer->save();
        }

        // 记录用户的投票记录
        $questionnaire_info->join()->attach(Auth::user()->id, [
            'result' => serialize($question_list),
            'advice' => Input::get('advice', '')
        ]);
        $questionnaire_info->increment('join_count');

        // TODO 添加用户积分

        return 'success';
    }

    /**
     * 获取参加的调查问卷列表
     */
    public function getJoinList()
    {
        $validator = Validator::make(Input::all(), [
            'limit' => [
                'integer',
                'between:1,200'
            ],
            'page' => [
                'integer'
            ]
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 获取参加的测试列表
        return QuestionnaireMember::where('member_id', Auth::user()->id)->latest()
            ->paginate(Input::get('limit', 10))
            ->getCollection();
    }

    /**
     * 获取参加的问卷调查详情
     */
    public function getJoinInfo()
    {
        $validator = Validator::make(Input::all(), [
            'member_questionnaire_id' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        return QuestionnaireMember::find(Input::get('member_questionnaire_id'));
    }
}