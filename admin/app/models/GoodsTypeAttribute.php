<?php

/**
 * 商品类型属性表
 */
class GoodsTypeAttribute extends Eloquent
{

    protected $table = 'goods_type_attributes';

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::created(function ($model)
        {
            $model->goodsType()->increment('attr_count');
        });

        static::deleted(function ($model)
        {
            $model->goodsType()->decrement('attr_count');
        });
    }

    /**
     * 属于哪个商品类别
     */
    public function goodsType()
    {
        return $this->belongsTo('GoodsType');
    }
}