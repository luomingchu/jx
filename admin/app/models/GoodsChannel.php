<?php

/**
 * 商品频道模型
 *
 * @SWG\Model(id="GoodsChannel", description="商品频道模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="name",type="string", description="商品频道名称")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class GoodsChannel extends Eloquent
{



    protected $table = 'goods_channel';

    protected $visible = [
        'id',
        'name',
        'created_at'
    ];
}