<?php

/**
 * 总店商品图片模型
 *
 * @SWG\Model(id="GoodsPicture", description="总店商品图片模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="goods", type="Goods",description="所属总店商品")
 * @SWG\Property(name="picture", type="UserFile",description="所属商品图片")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class GoodsPicture extends Eloquent
{



    protected $table = 'goods_pictures';

    protected $visible = [
        'id',
        'goods',
        'picture',
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
     * 头像
     */
    public function picture()
    {
        return $this->belongsTo('UserFile', 'picture_id');
    }
}