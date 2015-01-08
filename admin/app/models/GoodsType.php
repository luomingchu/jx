<?php

/**
 * 商品类别模型
 */
class GoodsType extends Eloquent
{

    /**
     * 状态：开启
     */
    const STATUS_OPEN = 'Open';

    /**
     * 状态：关闭
     */
    const STATUS_CLOSE = 'Close';

    protected $table = 'goods_type';

    protected $with = [
        'GoodsTypeAttributes'
    ];

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model)
        {
            // 当删除类目的时候，同时删除类目下的属性
            $model->GoodsTypeAttributes()->delete();

            // 当删除类目的时候，也同时删除企业定制的类目
            $model->enterpriseGoodsTypes()->delete();
        });
    }

    /**
     * 拥有的属性列表
     */
    public function GoodsTypeAttributes()
    {
        return $this->hasMany('GoodsTypeAttribute');
    }

    /**
     * 此类目被哪些企业所有使用
     */
    public function enterpriseGoodsTypes()
    {
        return $this->hasOne('EnterpriseGoodsType', 'goods_type_id', 'id');
    }
}