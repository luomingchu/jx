<?php

/**
 * 问卷用户关联模型
 *
 * @SWG\Model(id="QuestionnaireIssue",description="问卷用户关联模型")
 * @SWG\Property(name="id",type="integer",description="主键索引")
 * @SWG\Property(name="member",type="Member",description="所属用户")
 * @SWG\Property(name="questionnaire",type="Questionnaire",description="所属问卷")
 * @SWG\Property(name="result",type="string",description="答案列表")
 * @SWG\Property(name="advice",type="string",description="用户建议")
 * @SWG\Property(name="created_at",type="date-format",description="发布时间")
 */
class QuestionnaireMember extends Eloquent
{



    protected $table = 'questionnaire_member';

    protected $visible = [
        'id',
        'questionnaire',
        'member',
        'result',
        'advice',
        'created_at'
    ];

    /**
     * 所属问卷
     */
    public function questionnaire()
    {
        return $this->belongsTo('Questionnaire');
    }

    /**
     * 所属用户
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }
}
