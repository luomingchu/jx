<?php

/**
 * 问卷之问题模型
 *
 * @SWG\Model(id="QuestionnaireIssue",description="问卷问题模型")
 * @SWG\Property(name="id",type="integer",description="主键索引")
 * @SWG\Property(name="questionnaire",type="Questionnaire",description="所属的问卷")
 * @SWG\Property(name="content",type="string",description="问题内容")
 * @SWG\Property(name="join_count",type="integer",description="参与人数")
 * @SWG\Property(name="created_at",type="date-format",description="发布时间")
 */
class QuestionnaireIssue extends Eloquent
{



    protected $table = 'questionnaire_issue';

    protected $visible = [
        'id',
        'questionnaire',
        'content',
        'join_count',
        'created_at'
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($model)
        {
            Questionnaire::find($model->questionnaire_id)->increment('issue_count');
        });
    }

    /**
     * 问题所属的问卷
     */
    public function questionnaire()
    {
        return $this->belongsTo('Questionnaire', 'questionnaire_id');
    }

    /**
     * 问题的回答列表
     */
    public function answers()
    {
        return $this->hasMany('QuestionnaireAnswer');
    }

    /**
     * 设置问题的答案列表
     */
    public function setAnswerListAttribute($answers)
    {
        if (! empty($answers)) {
            foreach ($answers as $answer) {
                $questionnaire_answer = new QuestionnaireAnswer();
                $questionnaire_answer->questionnaire_issue_id = $this->attributes['id'];
                $questionnaire_answer->content = $answer;
                $questionnaire_answer->save();
            }
        }
    }
}
