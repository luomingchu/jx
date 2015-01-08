<?php
/**
 * 商品评价模型
 *
 * @SWG\Model(id="GoodsComment", description="商品评价模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="member",type="Member", description="评价人")
 * @SWG\Property(name="evaluation",type="integer", description="评价分数，1-5分")
 * @SWG\Property(name="content",type="string", description="评价内容")
 * @SWG\Property(name="reply", type="GoodsCommentReply", description="卖家对评论的回复")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class GoodsComment extends Eloquent
{
    /**
     * 是否匿名评价：启用
     */
    const ANONYMOUS_ENABLE = 'Enable';

    /**
     * 是否匿名评价：不启用
     */
    const ANONYMOUS_UNABLE = 'Unable';



    protected $table = 'goods_comments';

    protected $visible = [
        'id',
        'member',
        'evaluation',
        'content',
        'reply',
        'created_at'
    ];

    protected $with = [
        'reply'
    ];

    /**
     * 属于哪个订单商品
     */
    public function orderGoods()
    {
        return $this->belongsTo('OrderGoods', 'order_goods_id');
    }

    /**
     * 所属商品
     */
    public function goods()
    {
        return $this->belongsTo('Goods');
    }

    /**
     * 属于哪个用户
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }

    /**
     * 评论回复
     */
    public function reply()
    {
        return $this->hasMany('GoodsCommentReply', 'goods_comment_id');
    }

}