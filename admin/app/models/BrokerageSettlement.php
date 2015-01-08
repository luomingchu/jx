<?php

/**
 * 佣金结算记录
 */
class BrokerageSettlement extends Eloquent
{



    protected $table = "brokerage_settlement";

    public static function boot()
    {
        parent::boot();

        static::updating(function ($model)
        {
            // 禁止修改记录。
            return false;
        });

        static::deleting(function ($model)
        {
            // 禁止删除记录。
            return false;
        });
    }

    /**
     * 操作人
     */
    public function reckoner()
    {
        return $this->belongsTo('Manager', 'reckoner');
    }

    /**
     * 拥有的订单
     */
    public function orders()
    {
        return $this->hasMany('Order');
    }
}