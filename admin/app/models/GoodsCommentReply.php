<?php
/**
 * 商品评价回复模型
 *
 * @SWG\Model(id="GoodsCommentReply", description="商品评价回复模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="content",type="string", description="回复内容")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class GoodsCommentReply extends Eloquent
{



    protected $table = 'goods_comment_reply';

    protected $visible = [
        'id',
        'content',
        'created_at'
    ];

    /**
     * 属于哪个订单商品
     */
    public function goodsComment()
    {
        return $this->belongsTo('GoodsComment', 'goods_comment_id');
    }

    /**
     * 所属商品
     */
    public function store()
    {
        return $this->belongsTo('Store');
    }
}