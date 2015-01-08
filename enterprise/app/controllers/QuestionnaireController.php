<?php
use Illuminate\Support\Facades\Redirect;

/**
 * 问卷调查管理
 */
class QuestionnaireController extends BaseController
{

    /**
     * 获取问卷调查列表
     */
    public function getList()
    {
        $list = Questionnaire::latest()->paginate(Input::get('limit', 15));

        return View::make('questionnaire.list')->with(compact('list'));
    }

    /**
     * 增加、修改问卷调查
     */
    public function getEdit()
    {
        $info = [];
        if (Input::has('questionnaire_id')) {
            $info = Questionnaire::with('picture', 'issues.answers')->find(Input::get('questionnaire_id'));
        }

        return View::make('questionnaire.edit')->with(compact('info'));
    }

    /**
     * 保存问卷调查信息
     */
    public function postSave()
    {
        $validator = Validator::make(Input::all(), [
            'name' => 'required|unique:questionnaire,name,' . Input::get('questionnaire_id'),
            'start_time' => 'date|required',
            'end_time' => 'date|required',
            'questions' => 'required',
            'status' => 'required_without:questionnaire_id'
        ], [
            'name.required' => '标题不能为空',
            'name.unique' => '标题已经存在',
            'start_time.required' => '开始日期不能为空',
            'start_time.date' => '开始日期格式不正确',
            'end_time.required' => '结束日期不能为空',
            'end_time.date' => '结束日期格式不正确',
            'questions.required' => '问卷的问题不能为空',
            'status.required_without' => '新增时，状态不能为空'
        ]);

        // 进行时间的排序
        $time = [
            Input::get('start_time'),
            Input::get('end_time')
        ];
        sort($time);
        list ($start_time, $end_time) = $time;

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $questionnaire = Input::has('questionnaire_id') ? Questionnaire::find(Input::get('questionnaire_id')) : new Questionnaire();
        $questionnaire->name = Input::get('name');
        $questionnaire->status = Input::get('status');
        $questionnaire->picture_hash = Input::get('picture_hash', '');
        if (! empty($start_time)) {
            $questionnaire->start_time = $start_time;
            $questionnaire->end_time = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($end_time)) - 1);
        }
        $questionnaire->description = Input::get('description', '');
        $questionnaire->save();

        // 增加问卷调查的问题
        if (Input::has('questionnaire_id')) {
            // 修改，则先删除原先问题
            QuestionnaireIssue::whereQuestionnaireId(Input::get('questionnaire_id'))->delete();
        }
        $questionnaire->issue_list = Input::get('questions');

        return $questionnaire;
    }

    /**
     * 获取问卷调查内容（查看统计结果）
     */
    public function getInfo()
    {
        $validator = Validator::make(Input::all(), [
            'questionnaire_id' => [
                'required',
                'exists:questionnaire,id'
            ]
        ], [
            'questionnaire_id.required' => '问卷调查ID不能为空',
            'questionnaire_id.exists' => '问卷调查不存在'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }
        // 问卷内容
        $info = Questionnaire::with('issues.answers')->find(Input::get('questionnaire_id'));

        // 参与人列表
        $members = QuestionnaireMember::with('member')->whereQuestionnaireId(Input::get('questionnaire_id'))
            ->latest()
            ->paginate(Input::get('limit', 15));

        return View::make('questionnaire.info')->with(compact('info', 'members'));
    }

    /**
     * 切换状态
     */
    public function postToggleStatus()
    {
        $validator = Validator::make(Input::all(), [
            'questionnaire_id' => [
                'required',
                'exists:questionnaire,id,status,' . Questionnaire::STATUS_UNOPENED
            ],
            'status' => [
                'required',
                'in:' . Questionnaire::STATUS_OPEN . ',' . Questionnaire::STATUS_CLOSE
            ]
        ], [
            'questionnaire_id.required' => '问卷调查ID不能为空',
            'questionnaire_id.exists' => '问卷调查不存在',
            'status.required' => '状态不能为空',
            'status.in' => '状态必须是开启或者关闭'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->with('message_error', $validator->messages()
                ->first());
        }
        $questionnaire = Questionnaire::find(Input::get('questionnaire_id'));
        $questionnaire->status = Input::get('status');
        $questionnaire->save();
        return Redirect::back()->with('message_success', '问卷调查“' . $questionnaire->name . '”开放成功。');
    }

    /**
     * 回答问卷调查
     */
    public function postAnswer()
    {
        $validator = Validator::make(Input::all(), [
            'questionnaire_id' => [
                'required',
                'exists:questionnaire,id,status,' . Questionnaire::STATUS_OPEN
            ],
            'answers_id' => [
                'required',
                'exists:questionnaire_answer,id'
            ]
        ], [
            'questionnaire_id.required' => '问卷调查ID不能为空',
            'questionnaire_id.exists' => '问卷调查不存在',
            'answers_id.required' => '回答不能为空',
            'answers_id.in' => '回答不存在'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        foreach ((array) Input::get('answers_id') as $answer) {
            $answer = QuestionnaireAnswer::find($answer);
            $answer->increment('choose_count');
            $answer->save();

            // 该回答所属的问题，参与数量+1
            // $issue = $answer->issue;
            // $issue->increment('join_count');
            // $issue->save();
        }

        // 所属问卷调查
        $questionnaire = Questionnaire::find(Input::get('questionnaire_id'));

        // 记录用户的投票记录
        $questionnaire->member()->attach(Auth::id());
        $questionnaire->increment('join_count');

        // TODO 添加用户积分

        return 'success';
    }

    /**
     * 删除问卷调查
     */
    public function postDelete()
    {
        // 验证ID
        $validator = Validator::make(Input::all(), [
            'id' => [
                'required',
                'exists:questionnaire,id'
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messges()->first(), 402);
        }

        // 执行删除
        $questionnaire = Questionnaire::find(Input::get('id'));

        if ($questionnaire->status == Questionnaire::STATUS_CLOSE || $questionnaire->status == Questionnaire::STATUS_UNOPENED) {
            $questionnaire->delete();
            return Redirect::route('GetQuestionnaireList')->withMessageSuccess('删除成功');
        }
        return Response::make('要执行删除，状态必须为未开放或者已经结束的问卷', 402);
    }

    /**
     * 查看某个人的问卷回答内容
     */
    public function getMemberQuestionnaireAnswer()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'id' => [
                'required',
                'exists:questionnaire_member'
            ]
        ], [
            'id.required' => '参数不能为空',
            'id.exists' => '该用户未参加此问卷'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 问卷内容
        $info = QuestionnaireMember::with('questionnaire.issues.answers')->find(Input::get('id'));

        // 选择的结果
        $res = unserialize($info->result);

        return View::make('questionnaire.member-answer')->with(compact('info', 'res'));
    }
}