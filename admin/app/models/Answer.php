<?php

/**
 * 问题的回答
 *
 * @SWG\Model(id="Answer",description="问题的回答")
 * @SWG\Property(name="id",type="integer",description="回答ID")
 * @SWG\Property(name="question",type="Question",description="所回答的问题")
 * @SWG\Property(name="member",type="Member",description="发布回答的用户")
 * @SWG\Property(name="be_answered_id",type="integer",description="被回答的回答ID")
 * @SWG\Property(name="content",type="string",description="描述")
 * @SWG\Property(name="pictures",type="array",items="$ref:UserFile",description="配图")
 * @SWG\Property(name="accept",type="string",enum="{'No':'否','Yes':'是'}",description="被采纳")
 * @SWG\Property(name="like_count",type="integer",description="被赞数")
 * @SWG\Property(name="liked",type="boolean",description="当前用户是否赞过该回答")
 * @SWG\Property(name="created_at",type="date-format",description="发布时间")
 */
class Answer extends Eloquent
{
    use SoftDeletingTrait;

    /**
     * 被采纳：是
     */
    const ACCEPT_YES = 'Yes';

    /**
     * 被采纳：否
     */
    const ACCEPT_NO = 'No';



    protected $table = 'answers';

    protected $visible = [
        'id',
        'question',
        'member',
        'be_answered_id',
        'content',
        'pictures',
        'accept',
        'like_count',
        'created_at',
        'liked'
    ];

    protected $appends = [
        'liked'
    ];

    protected $with = [
        'member',
        'pictures'
    ];

    protected $likeds = [];

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->question()->increment('answer_count');
        });

        static::saved(function ($model) {
            // 如果回答被采纳，则关闭问题。
            if ($model->isDirty('accept') && $model->accept == Answer::ACCEPT_YES) {
                $question = $model->question()->first();
                $question->close = Question::CLOSE_YES;
                $question->save();
            }
        });
    }

    /**
     * 所回答的问题
     */
    public function question()
    {
        return $this->belongsTo('Question');
    }

    /**
     * 回答问题的用户
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }

    /**
     * 被回答的回答
     */
    public function beAnswered()
    {
        return $this->belongsTo('Answer', 'be_answered_id');
    }

    /**
     * 配图
     */
    public function pictures()
    {
        return $this->belongsToMany('UserFile', 'answer_pictures', 'answer_id', 'picture_id');
    }

    /**
     * 赞列表
     */
    public function likes()
    {
        return $this->morphMany('Like', 'target');
    }

    /**
     * 是否赞过
     */
    public function getLikedAttribute()
    {
        if (Auth::guest()) {
            return false;
        }
        if (!isset($this->likeds[$this->id])) {
            $this->likeds[$this->id] = !is_null($this->likes()
                ->where('member_id', Auth::user()->id)
                ->first());
        }
        return $this->likeds[$this->id];
    }

    /**
     * 获取回答的内容
     */
    public function getContentAttribute()
    {
        if (!isset($this->attributes['be_answered_id'])) {
            return '';
        }
        if ($this->attributes['be_answered_id'] > 0) {
            $username = Member::find(Answer::find($this->attributes['be_answered_id'])->member_id)->username;
            return "对{$username}的回复：{$this->attributes['content']}";
        }
        $question = Question::where('id', $this->attributes['question_id'])->first();
        if (empty($question)) {
            return "回复：{$this->attributes['content']}";
        } else {
            $username = Question::find($this->attributes['question_id'])->member->username;
            return "对{$username}的回复：{$this->attributes['content']}";
        }
    }
}
