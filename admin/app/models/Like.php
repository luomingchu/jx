<?php

/**
 * 赞记录
 *
 * @SWG\Model(id="Like",description="赞记录")
 * @SWG\Property(name="id",type="integer",description="主键索引")
 * @SWG\Property(name="member",type="Member",description="发出赞的人")
 * @SWG\Property(name="target",type="morph",description="所赞的对象")
 * @SWG\Property(name="created_at",type="date-format",description="赞的时间")
 */
class Like extends Eloquent
{



    protected $table = 'likes';

    protected $visible = [
        'id',
        'member',
        'target',
        'created_at'
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($model)
        {
            // 赞的时候，增加被赞对象的赞数。
            $model->target()->increment('like_count');
        });

        static::deleted(function ($model)
        {
            // 取消赞的时候，较少被赞对象的赞数。
            $model->target()->decrement('like_count');
        });
    }

    /**
     * 发出赞的人
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }

    /**
     * 所赞的对象
     */
    public function target()
    {
        return $this->morphTo();
    }
}