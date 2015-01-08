<?php

/**
 * 活动商品模型
 *
 * @SWG\Model(id="ActivitiesGoods", description="活动商品模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="enterprise_goods", type="EnterpriseGoods",description="企业商品")
 * @SWG\Property(name="discount", type="float",description="商品折扣")
 * @SWG\Property(name="quota", type="string",description="商品限购数")
 * @SWG\Property(name="coin_max_use_ratio", type="morphs",description="指币最高抵用比率")
 * @SWG\Property(name="discount_price", type="float",description="折后价")
 * @SWG\Property(name="deposit", type="string",description="商品订金")
 */
class ActivitiesGoods extends Eloquent
{


    protected $table = 'activities_goods';

    public $timestamps = false;

    protected $with = [
        'enterpriseGoods'
    ];

    /**
     * 所属企业商品
     */
    public function enterpriseGoods()
    {
        return $this->belongsTo('EnterpriseGoods');
    }

    /**
     * 所属活动
     */
    public function activity()
    {
        return $this->belongsTo('Activity', 'activity_id');
    }
}