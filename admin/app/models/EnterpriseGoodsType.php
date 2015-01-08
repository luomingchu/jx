<?php

/**
 * 企业定制的商品类目模型
 */
class EnterpriseGoodsType extends Eloquent
{

    protected $table = 'enterprise_goods_type';

    public $timestamps = false;

    protected $with = [
        'attributes'
    ];

    /**
     * 拥有的属性列表
     */
    public function attributes()
    {
        return $this->hasMany('GoodsTypeAttribute', 'goods_type_id', 'id');
    }

    /**
     * 所属商品类目
     */
    public function goodsType()
    {
        return $this->belongsTo('GoodsType');
    }
}