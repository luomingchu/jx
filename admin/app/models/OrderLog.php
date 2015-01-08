<?php

/**
 * 订单记录模型
 *
 * @SWG\Model(id="OrderLog", description="订单操作记录模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="order", type="Order",description="所属订单")
 * @SWG\Property(name="content", type="string",description="日志内容")
 * @SWG\Property(name="original_status",type="string",description="原始状态")
 * @SWG\Property(name="current_status",type="string",description="当前状态")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class OrderLog extends Eloquent
{



    protected $table = 'order_logs';

    /**
     * 所属订单
     */
    public function order()
    {
        return $this->belongsTo('Order');
    }
}