<?php

/**
 * 收藏记录
 *
 * @SWG\Model(id="Favorite",description="收藏记录")
 * @SWG\Property(name="id",type="integer",description="主键索引")
 * @SWG\Property(name="member",type="Member",description="收藏者")
 * @SWG\Property(name="favorites",type="morph",description="所收藏的对象")
 * @SWG\Property(name="vstore",type="Vstore",description="对应指店")
 * @SWG\Property(name="created_at",type="date-format",description="收藏时间")
 */
class Favorite extends Eloquent
{



    protected $table = 'favorites';

    protected $visible = [
        'id',
        'member',
        'favorites',
        'vstore',
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
     * 所属指店
     */
    public function vstore()
    {
        return $this->belongsTo('Vstore');
    }

    /**
     * 所属商品
     */
    public function goods()
    {
        return $this->belongsTo('Goods');
    }

    /**
     * 多态关联
     */
    public function favorites()
    {
        return $this->morphTo();
    }
}