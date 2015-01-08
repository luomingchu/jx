<?php

/**
 * 总店商品分类模型
 *
 * @SWG\Model(id="CategoryGoods", description="总店商品分类模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="goods", type="Goods",description="所属总店商品")
 * @SWG\Property(name="category", type="GoodsCategory",description="所属商品分类")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class CategoryGoods extends Eloquent
{


    protected $table = 'category_goods';

    protected $visible = [
        'id',
        'goods',
        'category',
        'created_at'
    ];

    /**
     * 所属总店商品
     */
    public function goods()
    {
        return $this->belongsTo('Goods');
    }

    /**
     * 所属商品分类
     */
    public function category()
    {
        return $this->belongsTo('GoodsCategory');
    }
}