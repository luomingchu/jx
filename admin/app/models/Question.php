<?php

/**
 * 求助的问题
 *
 * @SWG\Model(id="Question",description="求助的问题")
 * @SWG\Property(name="id",type="integer",description="主键索引")
 * @SWG\Property(name="member",type="Member",description="所属的用户")
 * @SWG\Property(name="title",type="string",description="问题的标题")
 * @SWG\Property(name="content",type="string",description="描述")
 * @SWG\Property(name="reward",type="integer",description="问题的奖励数")
 * @SWG\Property(name="kind",type="string",enum="['Question','Resource','Prattle']",description="问题的类型，Question：提问，Resource：资源，Prattle：闲聊")
 * @SWG\Property(name="pictures",type="array",items="$ref:UserFile",description="配图")
 * @SWG\Property(name="close",type="string",enum="['No','Yes']",description="是否已关闭")
 * @SWG\Property(name="answer_count",type="integer",description="回答数")
 * @SWG\Property(name="like_count",type="integer",description="被赞数")
 * @SWG\Property(name="answered",type="integer",description="当前用户是否已回答，0：用户未回答，大于0：为用户的回答ID")
 * @SWG\Property(name="liked",type="boolean",description="当前用户是否赞过该问题")
 * @SWG\Property(name="favorited",type="boolean",description="当前用户是否已收藏")
 * @SWG\Property(name="created_at",type="date-format",description="发布时间")
 */
class Question extends Eloquent
{
    use SoftDeletingTrait;

    /**
     * 已关闭：是
     */
    const CLOSE_YES = 'Yes';

    /**
     * 已关闭：否
     */
    const CLOSE_NO = 'No';

    /**
     * 问题类型：提问
     */
    const KIND_QUESTION = 'Question';

    /**
     * 问题类型：资源
     */
    const KIND_RESOURCE = 'Resource';

    /**
     * 问题类型：闲聊
     */
    const KIND_PRATTLE = 'Prattle';



    protected $table = 'questions';

    protected $visible = [
        'id',
        'member',
        'title',
        'kind',
        'reward',
        'content',
        'pictures',
        'close',
        'answer_count',
        'like_count',
        'created_at',
        'answered',
        'liked',
        'favorited'
    ];

    protected $appends = [
        'answered',
        'liked',
        'favorited'
    ];
    /*
     * protected $with = [ 'member', 'pictures' ];
     */
    protected $likeds = [];

    protected $favoriteds = [];

    protected $answereds = [];

    public static function boot()
    {
        parent::boot();

        static::created(function ($model)
        {
            if (Auth::check() && $model->reward > 0) {
                Auth::user()->info->decrement('coin', $model->reward);
            }
        });
    }

    /**
     * 发布问题的用户
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }

    /**
     * 配图
     */
    public function pictures()
    {
        return $this->belongsToMany('UserFile', 'question_pictures', 'question_id', 'picture_id');
    }

    /**
     * 回答列表
     */
    public function answers()
    {
        return $this->hasMany('Answer');
    }

    /**
     * 被收藏的列表
     */
    public function favorites()
    {
        return $this->morphMany('Favorite', 'favorites');
    }

    /**
     * 赞列表
     */
    public function likes()
    {
        return $this->morphMany('Like', 'target');
    }

    /**
     * 分享列表
     */
    public function shares()
    {
        return $this->morphMany('Share', 'item');
    }

    /**
     * 是否赞过
     */
    public function getLikedAttribute()
    {
        if (Auth::guest()) {
            return false;
        }
        if (! isset($this->likeds[$this->id])) {
            $this->likeds[$this->id] = ! is_null($this->likes()
                ->where('member_id', Auth::user()->id)
                ->first());
        }
        return $this->likeds[$this->id];
    }

    /**
     * 当前用户是否已收藏
     */
    public function getFavoritedAttribute()
    {
        if (Auth::guest()) {
            return false;
        }
        if (! isset($this->favoriteds[$this->id])) {
            $this->favoriteds[$this->id] = ! is_null($this->favorites()
                ->where('member_id', Auth::user()->id)
                ->first());
        }
        return $this->favoriteds[$this->id];
    }

    /**
     * 当前用户是否已回答
     */
    public function getAnsweredAttribute()
    {
        if (Auth::guest()) {
            return false;
        }
        if (! isset($this->answereds[$this->attributes['id']])) {
            $this->answereds[$this->attributes['id']] = ! is_null(Auth::user()->answers()
                ->where('question_id', $this->attributes['id'])
                ->first());
        }
        return $this->answereds[$this->attributes['id']];
    }
}
