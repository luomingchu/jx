<?php

/**
 * 内购活动
 *
 * @SWG\Model(id="InnerPurchase", description="内购活动")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="discount", type="float",description="折扣")
 * @SWG\Property(name="restriction", type="integer",description="每人限购")
 * @SWG\Property(name="coin_max_use_ratio", type="float",description="指币抵用最高比例")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class InnerPurchase extends Eloquent
{



    protected $table = 'inner_purchase';

    protected $visible = [
        'id',
        'created_at',
        'discount',
        'restriction',
        'coin_max_use_ratio'
    ];

    /**
     * 所属活动
     */
    public function activity()
    {
        return $this->morphMany('Activity', 'body');
    }
}
