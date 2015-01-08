<?php

/**
 * 会员信息模型

 * @SWG\Model(id="MemberInfo",description="会员信息模型")
 * @SWG\Property(name="id",type="integer",description="主键")
 * @SWG\Property(name="member",type="Member",description="所属用户")
 * @SWG\Property(name="level",type="integer",description="用户等级")
 * @SWG\Property(name="kind",type="string",enum="['Seller', 'Buyer']",description="会员类型，Seller:卖家，Buyer:买家")
 * @SWG\Property(name="coin_amount",type="integer",description="指币总额")
 * @SWG\Property(name="coin",type="integer",description="指币余额")
 * @SWG\Property(name="insource_amount",type="integer",description="内购额总收益")
 * @SWG\Property(name="insource",type="integer",description="内购额余额")
 * @SWG\Property(name="attention_vstore",type="integer",description="关注的指店模型")
 * @SWG\Property(name="friends_quantity",type="integer",description="指友数")
 * @SWG\Property(name="brokerage_amount",type="float",description="总收益佣金金额")
 * @SWG\Property(name="remain_brokerage",type="float",description="未结算佣金金额")
 * @SWG\Property(name="sale_goods",type="integer",description="成交商品数")
 * @SWG\Property(name="sale_amount",type="integer",description="成交总金额")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class MemberInfo extends Eloquent
{
    use SoftDeletingTrait;

    // 会员类别：买家
    const KIND_BUYER = 'Buyer';
    // 会员类别：卖家
    const KIND_SELLER = 'Seller';

    protected $table = 'member_info';

    protected $visible = [
        'id',
        'member',
        'coin_amount',
        'coin',
        'insource_amount',
        'insource',
        'attentionVstore',
        'friends_quantity',
        'brokerage_amount',
        'remain_brokerage',
        'sale_goods',
        'sale_amount',
        'level',
        'kind',
        'created_at'
    ];

    protected $appends = [
        'sale_goods',
        'sale_amount',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model)
        {
            // 禁止对账户金额进行修改。
            if ($model->isDirty('coin') || $model->isDirty('coin_amount') || $model->isDirty('insource') || $model->isDirty('insource_amount') || $model->isDirty('brokerage_amount') || $model->isDirty('remain_brokerage')) {
                return false;
            }
        });
    }

    /**
     * 所属用户
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }

    /**
     * 用户所关注的指店
     */
    public function attentionVstore()
    {
        return $this->belongsTo('Vstore', 'attention_vstore_id');
    }

    /**
     * 用户上传的文件列表
     */
    public function files()
    {
        return $this->morphMany('UserFile', 'user');
    }

    /**
     * 发布的问题列表
     */
    public function questions()
    {
        return $this->morphMany('Question', 'user');
    }

    /**
     * 发布的回答列表
     */
    public function answers()
    {
        return $this->hasMany('Answer');
    }

    /**
     * 用户关注列表
     */
    public function attentions()
    {
        return $this->hasMany('Attention');
    }

    /**
     * 用户的好友
     */
    public function friends()
    {
        return $this->hasMany('Attention');
    }

    /**
     * 用户的订单
     */
    public function orders()
    {
        return $this->hasMany('Order');
    }

    /**
     * 购物车商品数
     */
    public function cart()
    {
        return $this->hasMany('Cart');
    }

    /**
     * 收发货地址
     */
    public function address()
    {
        return $this->hasMany('Address');
    }

    /**
     * 获取指定的成交商品数
     */
    public function getSaleGoodsAttribute()
    {
        if (empty($this->attributes['member_id'])) {
            return 0;
        }
        $member = Member::find($this->attributes['member_id']);
        $vstore = $member->vstore;
        if (! empty($vstore)) {
            return Order::where('vstore_id', $vstore->id)->where('status', Order::STATUS_FINISH)->sum('goods_count');
        }
        return 0;
    }

    /**
     * 获取指定的成交总金额
     */
    public function getSaleAmountAttribute()
    {
        if (empty($this->attributes['member_id'])) {
            return 0;
        }
        $member = Member::find($this->attributes['member_id']);
        $vstore = $member->vstore;
        if (! empty($vstore)) {
            return Order::where('vstore_id', $vstore->id)->where('status', Order::STATUS_FINISH)->sum('amount');
        }
        return 0;
    }

    /**
     * 获取会员年龄
     */
    public function getAgeAttribute()
    {
        if (empty($this->attribites['birthday'])) {
            return 0;
        } else {
            $birthday = strtotime($this->attributes['birthday']);
            $range = time() - $birthday;
            return floor($range / 31536000);
        }
    }

    /**
     * 获取已结算佣金
     */
    public function getBrokerageAmountAttribute()
    {
        if (Auth::check()) {
            // 获取其所开指店
            $vstore = Vstore::where('member_id', Auth::user()->id)->first();
            if (! empty($vstore)) {
                return round(Order::where('vstore_id', $vstore->id)->where('status', Order::STATUS_FINISH)
                    ->where('brokerage_settlement_id', '!=', 0)
                    ->sum('brokerage'), 2);
            }
        }
        return 0;
    }

    /**
     * 获取未结算佣金
     */
    public function getRemainBrokerageAttribute()
    {
        if (Auth::check()) {
            // 获取其所开指店
            $vstore = Vstore::where('member_id', Auth::user()->id)->first();
            if (! empty($vstore)) {
                return round(Order::where('vstore_id', $vstore->id)->where('status', Order::STATUS_FINISH)
                    ->where('brokerage_settlement_id', 0)
                    ->sum('brokerage'), 2);
            }
        }
        return 0;
    }
}
