<?php

/**
 * 关注关系模型
 *
 * @SWG\Model(id="Attention",description="关注关系模型")
 * @SWG\Property(name="id",type="integer",description="自增ID")
 * @SWG\Property(name="member_id",type="integer",description="当前用户ID")
 * @SWG\Property(name="friend",type="Member",description="好友信息")
 * @SWG\Property(name="zbond_show",type="string",enum="['Yes','No']", description="好友信息")
 * @SWG\Property(name="relationship",type="string",description="关注关系，Unilateral:单向关注，Mutual:双向关注")
 * @SWG\Property(name="created_at",type="date-format",description="关注时间")
 */
class Attention extends Eloquent
{

    // 关注关系：单向关注
    const RELATIONSHIP_UNILATERAL = 'Unilateral';
    // 关注关系：双向关注
    const RELATIONSHIP_MUTUAL = 'Mutual';

    // 关注指帮信息：是
    const ZBOND_SHOW_YES = 'Yes';
    // 关注指帮信息：否
    const ZBOND_SHOW_NO = 'No';



    protected $table = 'attentions';

    protected $visible = [
        'id',
        'member_id',
        'friend',
        'zbond_show',
        'relationship',
        'created_at'
    ];

    protected $with = [
        'friend'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model)
        {
            // 查找是否已经有被关注过
            $attention = Attention::where('friend_id', $model->member_id)->where('member_id', $model->friend_id)->first();
            if (! empty($attention)) {
                $attention->relationship = Static::RELATIONSHIP_MUTUAL;
                $attention->save();
                // 对方好友数加1
                MemberInfo::whereMemberId($model->friend_id)->first()->increment('friends_quantity');
                $model->relationship = Static::RELATIONSHIP_MUTUAL;
            } else {
                $model->relationship = Static::RELATIONSHIP_UNILATERAL;
            }
        });

        static::created(function ($model)
        {
            if ($model->relationship == Static::RELATIONSHIP_MUTUAL) {
                MemberInfo::whereMemberId($model->member_id)->first()->increment('friends_quantity');
            }
        });

        static::deleted(function ($model)
        {
            // 查看是否已经有被关注过
            $attention = Attention::where('friend_id', $model->member_id)->where('member_id', $model->friend_id)->first();
            if (! empty($attention)) {
                $attention->relationship = Static::RELATIONSHIP_UNILATERAL;
                $attention->save();
                // 对方好友数减1
                MemberInfo::whereMemberId($model->friend_id)->first()->decrement('friends_quantity');
                MemberInfo::whereMemberId($model->member_id)->first()->decrement('friends_quantity');
            }
        });
    }

    /**
     * 关注人
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }

    /**
     * 被关注人
     */
    public function friend()
    {
        return $this->belongsTo('Member', 'friend_id');
    }
}