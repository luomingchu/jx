<?php

/**
 * 订单商品模型
 *
 * @SWG\Model(id="OrderGoods", description="订单商品模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="goods", type="Goods",description="所属商品")
 * @SWG\Property(name="goods_sku", type="string",description="商品规格")
 * @SWG\Property(name="price", type="decimal",description="商品价格")
 * @SWG\Property(name="total_price", type="decimal",description="商品总价")
 * @SWG\Property(name="quantity", type="integer",description="商品数量")
 * @SWG\Property(name="comment",type="GoodsComment", description="买家评价")
 * @SWG\Property(name="store_activity",type="StoreActivity", description="买家评价")
 * @SWG\Property(name="brokerage", type="float", description="商品佣金")
 * @SWG\Property(name="brokerage_ratio", type="float", description="商品佣金比率")
 * @SWG\Property(name="level_brokerage_ratio", type="float", description="指店等级佣金比率")
 * @SWG\Property(name="refund", type="Refund", description="订单商品申请退款信息")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class OrderGoods extends Eloquent
{



    protected $table = 'order_goods';

    protected $visible = [
        'id',
        'goods',
        'goods_sku',
        'price',
        'total_price',
        'quantity',
        'comment',
        'storeActivity',
        'brokerage_ratio',
        'level_brokerage_ratio',
        'brokerage',
        'refund',
        'created_at'
    ];

    protected $with = [
        'storeActivity',
        'refund'
    ];

    protected $appends = [
        'total_price',
        'brokerage'
    ];

    protected $totals = [];

    /**
     * 所属订单
     */
    public function order()
    {
        return $this->belongsTo('Order');
    }

    /**
     * 所属商品
     */
    public function goods()
    {
        return $this->belongsTo('Goods');
    }

    /**
     * 买家评价
     */
    public function comment()
    {
        return $this->hasOne('GoodsComment', 'order_goods_id');
    }

    /**
     * 所属的活动
     */
    public function storeActivity()
    {
        return $this->belongsTo('StoreActivity');
    }

    /**
     * 退款/退货信息
     */
    public function refund()
    {
        return $this->hasOne('Refund');
    }

    /**
     * 商品总价
     *
     * @return string
     */
    public function getTotalPriceAttribute()
    {
        if (! isset($this->totals[$this->id])) {
            $total_price = floatval($this->attributes['price']) * $this->attributes['quantity'];
            if (strpos($total_price, '.')) {
                $total_price = sprintf('%.2f', $total_price);
            }
            $this->totals[$this->id] = $total_price;
        }
        return $this->totals[$this->id];
    }

    /**
     * 商品佣金
     */
    public function getBrokerageAttribute()
    {
        return $this->attributes['price'] * $this->attributes['quantity'] * ( $this->attributes['brokerage_ratio'] * ( 1 + $this->attributes['level_brokerage_ratio'])) / 100;
    }
}