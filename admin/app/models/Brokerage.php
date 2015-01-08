<?php

/**
 * 佣金记录模型
 *
 * @SWG\Model(id="Brokerage",description="佣金记录模型")
 * @SWG\Property(name="id",type="integer",description="自增ID")
 * @SWG\Property(name="order_id",type="string",description="订单号")
 * @SWG\Property(name="order_amount",type="float",description="订单总金额")
 * @SWG\Property(name="ratio",type="float", description="订单佣金比率")
 * @SWG\Property(name="status",type="string",enum="['Settled','Unsettled']", description="结算状态：Unsettled：未结算，Settled：已结算")
 * @SWG\Property(name="order",type="Order",description="所属订单")
 * @SWG\Property(name="settled_at",type="date-format",description="结算时间")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class Brokerage extends Eloquent
{



    /**
     * 结算状态：已结算
     */
    const STATUS_SETTLED = 'Settled';

    /**
     * 结算状态：未结算
     */
    const STATUS_UNSETTLED = 'Unsettled';


    protected $table = 'brokerages';

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            // 创建的时候，变更用户总佣金
            $member = $model->vstore->member;
            $member = MemberInfo::where('member_id', $member->id)->first();
            // 计算订单佣金金额
            $amount = round($model->order_amount * $model->ratio / 100, 2);
            // 添加到用户总佣金金额
            $member->increment('brokerage_amount', $amount);
            // 增加到用户未结算佣金金额
            $member->increment('remain_brokerage', $amount);
        });

        static::updated(function ($model) {
            // 如是已结算则扣除指店未结算佣金数
            if ($model->isDirty('status') && $model->status == Brokerage::STATUS_SETTLED) {
                $member = $model->vstore->member;
                $member = MemberInfo::where('member_id', $member->id)->first();
                // 计算订单佣金金额
                $amount = round($model->order_amount * $model->ratio / 100, 2);
                // 扣除用户未结算佣金金额
                $member->decrement('remain_brokerage', $amount);
            }
        });

        static::deleting(function ($model) {
            // 禁止删除记录。
            return false;
        });
    }


    /**
     * 所属指店
     */
    public function vstore()
    {
        return $this->belongsTo('Vstore');
    }

    /**
     * 所属订单
     */
    public function order()
    {
        return $this->belongsTo('Order');
    }

    /**
     * 所属的结算记录
     */
    public function settlement()
    {
        return $this->belongsTo('BrokerageSettlement', 'settled_id');
    }

}