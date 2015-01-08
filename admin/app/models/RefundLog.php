<?php
/**
 * 退款退货记录模型
 *
 * @SWG\Model(id="RefundLog", description="退款退货记录模型")
 * @SWG\Property(name="id", type="string",description="主键索引")
 * @SWG\Property(name="refund", type="Refund",description="所属退货退款")
 * @SWG\Property(name="user",type="morph",description="记录所属用户或指店")
 * @SWG\Property(name="title",type="string",description="标题")
 * @SWG\Property(name="content",type="string",description="内容")
 * @SWG\Property(name="original_status",type="string",description="原始状态")
 * @SWG\Property(name="current_status",type="string",description="当前状态")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */

class RefundLog extends Eloquent
{

    /**
     * 申请状态：退款/退货申请等待卖家确认中
     */
    const STATUS_WAIT_STORE_AGREE = 'wait_store_agree';

    /**
     * 申请状态：卖家不同意协议，拒绝退款/退货申请
     */
    const STATUS_STORE_REFUSE_BUYER = 'store_refuse_buyer';

    /**
     * 申请状态：退货申请达成，等待买家发货
     */
    const STATUS_WAIT_BUYER_RETURN_GOODS = 'wait_buyer_return_goods';

    /**
     * 申请状态：买家已退货,等待门店确认收货
     */
    const STATUS_WAIT_STORE_CONFIRM_GOODS = 'wait_store_confirm_goods';

    /**
     * 申请状态：等待企业还款
     */
    const STATUS_WAIT_ENTERPRISE_REPAYMENT = 'wait_enterprise_repayment';

    /**
     * 申请状态：申请完成
     */
    const STATUS_SUCCESS = 'success';

    /**
     * 申请状态：开始申请
     */
    const STATUS_APPLY = 'apply';



    protected $table = 'refund_log';

    /**
     * 所属申请单号
     */
    public function refund()
    {
        return $this->belongsTo('Refund');
    }

    /**
     * 所属申请单号
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }

    /**
     * 所属用户
     */
    public function user()
    {
        return $this->morphTo();
    }

}