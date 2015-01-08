<?php

/**
 * 问卷调查
 *
 * @SWG\Model(id="Questionnaire",description="问卷调查模型")
 * @SWG\Property(name="id",type="integer",description="主键索引")
 * @SWG\Property(name="name",type="string",description="问卷调查标题")
 * @SWG\Property(name="issue_count",type="string",description="问题数")
 * @SWG\Property(name="view_count",type="string",description="访问量")
 * @SWG\Property(name="picture_hash",type="integer",description="图片")
 * @SWG\Property(name="description",type="string",description="描述")
 * @SWG\Property(name="start_time",type="date-format",description="开始时间")
 * @SWG\Property(name="end_time",type="date-format",description="结束时间")
 * @SWG\Property(name="joined",type="string",description="是否参与问卷")
 * @SWG\Property(name="status",type="string",enum="['Open','Close']",description="状态，Open：开启，Close：关闭")
 * @SWG\Property(name="created_at",type="date-format",description="发布时间")
 */
class Questionnaire extends Eloquent
{

    // 状态：启用
    const STATUS_OPEN = 'Open';
    // 状态：关闭
    const STATUS_CLOSE = 'Close';
    // 状态：未开放
    const STATUS_UNOPENED = 'Unopened';



    protected $table = 'questionnaire';

    protected $appends = [
        'joined'
    ];

    /**
     * 投放测试图片
     */
    public function picture()
    {
        // return $this->belongsTo('UserFile', 'picture_id');
        return $this->belongsTo('Storage');
    }

    /**
     * 拥有的问题列表
     */
    public function issues()
    {
        return $this->hasMany('QuestionnaireIssue');
    }

    /**
     * 问题回答用户
     */
    public function member()
    {
        return $this->belongsToMany('Member', 'questionnaire_member', 'questionnaire_id', 'member_id')
            ->withTimestamps()
            ->withPivot('result', 'advice');
    }

    /**
     * 设置投放测试的问题
     */
    public function setIssueListAttribute($issues)
    {
        foreach ($issues as $q) {
            $answer_list = array_filter($q['answer']);
            if (! empty($q['content']) && ! empty($answer_list)) {
                $questionnaire_issue = new QuestionnaireIssue();
                $questionnaire_issue->questionnaire_id = $this->attributes['id'];
                $questionnaire_issue->content = $q['content'];
                $questionnaire_issue->save();
                // 增加问题答案列表
                $questionnaire_issue->answer_list = $answer_list;
            }
        }
    }

    /**
     * 设置开始时间null的时候为空字符串
     */
    public function getStartTimeAttribute()
    {
        if ($this->attributes['start_time'] === null) {
            return '';
        } else {
            return (string) $this->attributes['start_time'];
        }
    }

    /**
     * 设置结束时间null的时候为空字符串
     */
    public function getEndTimeAttribute()
    {
        if ($this->attributes['end_time'] === null) {
            return '';
        } else {
            return (string) $this->attributes['end_time'];
        }
    }

    /**
     * 是否参加
     */
    public function getJoinedAttribute()
    {
        if (! Auth::check()) {
            return false;
        }

        $temp = QuestionnaireMember::whereQuestionnaireId($this->attributes['id'])->whereMemberId(Auth::id())->first();
        if (! is_null($temp)) {
            return 'Yes';
        }
        return 'No';
    }
}