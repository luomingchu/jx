<?php

/**
 * 问卷之回答模型
 *
 * @SWG\Model(id="QuestionnaireAnswer",description="问卷回答模型")
 * @SWG\Property(name="id",type="integer",description="主键索引")
 * @SWG\Property(name="issue",type="QuestionnaireIssue",description="所属的问卷问题")
 * @SWG\Property(name="content",type="string",description="选项内容")
 * @SWG\Property(name="choose_count",type="integer",description="选择人数")
 * @SWG\Property(name="created_at",type="date-format",description="发布时间")
 */
class QuestionnaireAnswer extends Eloquent
{



    protected $table = 'questionnaire_answer';

    protected $visible = [
        'id',
        'issue',
        'content',
        'choose_count',
        'created_at'
    ];

    public static function boot()
    {
        parent::boot();

        static::updated(function ($model)
        {
            if ($model->isDirty('choose_count')) {
                $model->issue->increment('join_count');
            }
        });
    }

    /**
     * 获取是否已经选择过来
     */
    public function getHasChooseAttribute()
    {
        if (Auth::check() && ! empty($this->users) && in_array(Auth::user()->id, $this->user->lists('id'))) {
            return true;
        }
        return false;
    }

    /**
     * 获取选择此项的百分比
     */
    public function getPercentAttribute()
    {
        $questionnaire = $this->issue->questionnaire;
        if (empty($questionnaire->join_count)) {
            return 0;
        }
        return round((($this->attributes['choose_count'] * 100) / $questionnaire->join_count), 2);
    }

    /**
     * 选项所属问题
     */
    public function issue()
    {
        return $this->belongsTo('QuestionnaireIssue', 'questionnaire_issue_id');
    }
}
