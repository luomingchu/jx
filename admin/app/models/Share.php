<?php

/**
 * 分享记录
 *
 * @SWG\Model(id="Share",description="分享记录")
 * @SWG\Property(name="id",type="integer",description="主键索引")
 * @SWG\Property(name="member",type="Member",description="分享者")
 * @SWG\Property(name="item",type="morph",description="所分享的对象")
 * @SWG\Property(name="vstore_id",type="integer",description="对应指店")
 * @SWG\Property(name="created_at",type="date-format",description="分享时间")
 */
class Share extends Eloquent
{



    protected $table = 'shares';

    protected $visible = [
        'id',
        'member',
        'item',
        'vstore_id',
        'created_at'
    ];

    /**
     * 所属用户
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }

    /**
     * 多态关联
     */
    public function item()
    {
        return $this->morphTo();
    }
}