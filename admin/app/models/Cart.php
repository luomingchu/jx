<?php

/**
 * 购物车模型
 *
 * @SWG\Model(id="Cart", description="购物车模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="goods", type="Goods",description="所属商品")
 * @SWG\Property(name="quantity", type="integer",description="商品数量")
 * @SWG\Property(name="goodsSku", type="GoodsSku",description="商品规格库存")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class Cart extends Eloquent
{

    /**
     * 立即购买状态：是
     */
    const ONCE_VALID = 'Valid';

    /**
     * 立即购买状态：否
     */
    const ONCE_INVALID = 'Invalid';



    protected $table = 'carts';

    protected $visible = [
        'id',
        'goods',
        'quantity',
        'goodsSku',
        'activity_info',
        'vstore',
        'created_at'
    ];

    protected $with = [
        'goods',
        'goodsSku'
    ];

//    protected $appends = [
//        'activity_info'
//    ];

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
     * 商品库存
     */
    public function goodsSku()
    {
        return $this->belongsTo('GoodsSku', 'sku_id');
    }


    /**
     * 获取此商品的活动信息
     */
//    public function getActivityInfoAttribute()
//    {
//        // 获取当前的内购活动信息
//        $activity_info = StoreActivity::where('status', StoreActivity::STATUS_OPEN)->where('start_datetime', '<=', date('Y-m-d H:i:s'))->where('end_datetime', '>', date('Y-m-d H:i:s'))->where('store_id', $this->vstore->store->id)->first();
//        $activity_goods = null;
//        if (! empty($activity_info)) {
//            // 判断当前商品在此指店中是否有做内购活动
//            $activity_goods = StoreActivitiesGoods::with('activity')->where('store_activity_id', $activity_info->id)->where('goods_id', $this->attributes['goods_id'])->first();
//        }
//        return $activity_goods;
//    }
}